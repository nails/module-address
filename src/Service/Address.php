<?php

namespace Nails\Address\Service;

use Nails\Address\Constants;
use Nails\Address\Exception\AddressException;
use Nails\Address\Exception\AssociatedException\InvalidAssociationObject;
use Nails\Address\Exception\Validation\InvalidArgumentException;
use Nails\Address\Interfaces;
use Nails\Address\Resource;
use Nails\Common\Exception\FactoryException;
use Nails\Common\Exception\ModelException;
use Nails\Common\Exception\ValidationException;
use Nails\Common\Helper\Model\Expand;
use Nails\Common\Service\Database;
use Nails\Factory;

/**
 * Class Address
 *
 * @package Nails\Address\Service
 */
class Address
{
    /** @var \Nails\Address\Model\Address */
    protected $oAddressModel;

    /** @var \Nails\Address\Model\Address\Associated */
    protected $oAssociatedModel;

    // --------------------------------------------------------------------------

    /**
     * Address constructor.
     *
     * @throws FactoryException
     */
    public function __construct()
    {
        $this->oAddressModel    = Factory::model('Address', Constants::MODULE_SLUG);
        $this->oAssociatedModel = Factory::model('AddressAssociated', Constants::MODULE_SLUG);
    }

    // --------------------------------------------------------------------------

    /**
     * Validates an address against a formatter
     *
     * @param Resource\Address                 $oAddress   The address to validate
     * @param Interfaces\Validator|string|null $oValidator The Validator to use, or a country code
     *
     * @throws FactoryException
     * @throws ValidationException
     * @throws AddressException
     */
    public function validate(Resource\Address $oAddress, $oValidator = null)
    {
        if (is_string($oValidator)) {
            $oValidator = static::getValidatorForCountry($oValidator);

        } elseif ($oValidator === null) {
            $oValidator = Factory::factory('ValidatorGeneric', Constants::MODULE_SLUG);

        } elseif (!$oValidator instanceof Interfaces\Validator) {
            throw new AddressException(
                sprintf('Expected %s received %s', Interfaces\Validator::class, get_class($oValidator))
            );
        }

        $oValidator::validate($oAddress);
    }

    // --------------------------------------------------------------------------

    /**
     * Returns a validator for a country code
     *
     * @param string $sCountry The country code
     *
     * @return Interfaces\Validator
     * @throws FactoryException
     */
    public static function getValidatorForCountry(string $sCountry): Interfaces\Validator
    {
        try {

            /** @var Interfaces\Validator $oValidator */
            $oValidator = Factory::factory('Validator' . $sCountry, Constants::MODULE_SLUG);

        } catch (FactoryException $e) {
            /** @var Interfaces\Validator $oValidator */
            $oValidator = Factory::factory('ValidatorGeneric', Constants::MODULE_SLUG);
        }

        return $oValidator;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns a formatter for a country code
     *
     * @param string $sCountry The country code
     *
     * @return Interfaces\Formatter
     * @throws FactoryException
     */
    public static function getFormatterForCountry(string $sCountry): Interfaces\Formatter
    {
        try {

            /** @var Interfaces\Formatter $oFormatter */
            $oFormatter = Factory::factory('Formatter' . $sCountry, Constants::MODULE_SLUG);

        } catch (FactoryException $e) {
            /** @var Interfaces\Formatter $oFormatter */
            $oFormatter = Factory::factory('FormatterGeneric', Constants::MODULE_SLUG);
        }

        return $oFormatter;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns all addresses for an associated item
     *
     * @param object $oAssociated The associated item
     *
     * @return Resource\Address[]
     * @throws FactoryException
     * @throws InvalidAssociationObject
     * @throws ModelException
     */
    public function associatedAddressesGet(object $oAssociated): array
    {
        return array_map(
            function (Resource\Address\Associated $oAssociation) {
                return $oAssociation->address();
            },
            $this->oAssociatedModel
                ->getAll([
                    new Expand('address'),
                    'where' => [
                        ['associated_type', $this->getAssociatedType($oAssociated)],
                        ['associated_id', $this->getAssociatedId($oAssociated)],
                    ],
                ])
        );
    }

    // --------------------------------------------------------------------------

    /**
     * Associated an array of addresses with an item
     *
     * @param object                     $oAssociated The associated item
     * @param array[]|Resource\Address[] $aAddresses  The addresses
     *
     * @return $this
     */
    public function associatedAddressesSet(object $oAssociated, array $aAddresses): self
    {
        /** @var Database $oDb */
        $oDb = Factory::service('Database');

        try {

            $oDb->transaction()->start();

            //  Save and associate each address
            foreach ($aAddresses as &$aAddress) {
                $oAddress = $aAddress = $this
                    ->extractAddress($aAddress)
                    ->save();

                $this->associatedAddressAdd($oAssociated, $oAddress);
            }

            //  Remove addresses which were not touched
            $this->oAssociatedModel->deleteWhere(
                array_filter([
                    !empty($aAddresses)
                        ? 'address_id NOT IN (' . implode(',', arrayExtractProperty($aAddresses, 'id')) . ')'
                        : null,
                    ['associated_type', $this->getAssociatedType($oAssociated)],
                    ['associated_id', $this->getAssociatedId($oAssociated)],
                ])
            );

            $oDb->transaction()->commit();

        } catch (\Exception $e) {
            $oDb->transaction()->rollback();
            throw $e;
        }

        return $this;
    }

    // --------------------------------------------------------------------------

    /**
     * Associates an address with an item
     *
     * @param object                 $oAssociated The associated item
     * @param array|Resource\Address $mAddress    The address data or object
     *
     * @return $this
     * @throws FactoryException
     * @throws InvalidAssociationObject
     * @throws ModelException
     * @throws ValidationException
     */
    public function associatedAddressAdd(object $oAssociated, $mAddress): self
    {
        $oAddress = $this
            ->extractAddress($mAddress)
            ->validate();

        //  Check for duplicate, if it exists then just return, no need to error
        foreach ($this->associatedAddressesGet($oAssociated) as $oExistingAddress) {
            if ($oExistingAddress->hash() === $oAddress->hash()) {
                return $this;
            }
        }

        /** @var Database $oDb */
        $oDb = Factory::service('Database');

        try {

            $oDb->transaction()->start();

            $oAddress->save();

            $iAssociationId = $this->oAssociatedModel
                ->create([
                    'address_id'      => $oAddress->id,
                    'associated_type' => $this->getAssociatedType($oAssociated),
                    'associated_id'   => $this->getAssociatedId($oAssociated),
                ]);

            if (empty($iAssociationId)) {
                throw new AddressException();
            }

            $oDb->transaction()->commit();

        } catch (\Exception $e) {
            $oDb->transaction()->rollback();
            throw $e;
        }

        return $this;
    }

    // --------------------------------------------------------------------------

    /**
     * Deletes an address belonging to an item
     *
     * @param object           $oAssociated The associated item
     * @param Resource\Address $oAddress    The address to delete
     *
     * @return $this
     * @throws AddressException
     * @throws FactoryException
     * @throws InvalidAssociationObject
     * @throws ModelException
     */
    public function associatedAddressDelete(object $oAssociated, Resource\Address $oAddress): self
    {
        $iNumDeleted = 0;
        foreach ($this->associatedAddressesGet($oAssociated) as $oExistingAddress) {
            if ($oExistingAddress->hash() === $oAddress->hash()) {
                $this->oAssociatedModel->deleteWhere([
                    ['address_id', $oAddress->id],
                    ['associated_type', $this->getAssociatedType($oAssociated)],
                    ['associated_id', $this->getAssociatedId($oAssociated)],
                ]);
                $iNumDeleted++;
            }
        }

        if (empty($iNumDeleted)) {
            throw new AddressException(
                'Address does not exist, or does not belong to entity'
            );
        }

        return $this;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns the type of associated item
     *
     * @param object $oAssociated The associated item
     *
     * @return string
     */
    protected function getAssociatedType(object $oAssociated): string
    {
        return get_class($oAssociated);
    }

    // --------------------------------------------------------------------------

    /**
     * Returns the ID component of the associated item
     *
     * @param object $oAssociated The Associated item
     *
     * @return string
     * @throws InvalidAssociationObject
     */
    protected function getAssociatedId(object $oAssociated): string
    {
        if (property_exists($oAssociated, 'id')) {
            return $oAssociated->id;

        } elseif (method_exists($oAssociated, 'getId')) {
            return $oAssociated->getId();
        }

        throw new InvalidAssociationObject(
            'Associated object must have a public "id" property or "getId" method'
        );
    }

    // --------------------------------------------------------------------------

    /**
     * Converts the supplied data to an address resource
     *
     * @param array|Resource\Address $mAddress The address data
     *
     * @return Resource\Address
     * @throws FactoryException
     */
    public function extractAddress($mAddress): Resource\Address
    {
        if ($mAddress instanceof Resource\Address) {
            return $mAddress;

        } elseif (is_array($mAddress)) {
            return \Nails\Address\Helper\Address::extractAddressFromArray($mAddress);
        }
    }
}
