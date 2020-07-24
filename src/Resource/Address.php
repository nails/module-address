<?php

namespace Nails\Address\Resource;

use Nails\Address\Constants;
use Nails\Address\Interfaces;
use Nails\Address\Service;
use Nails\Common\Exception\FactoryException;
use Nails\Common\Exception\ValidationException;
use Nails\Common\Resource\Entity;
use Nails\Common\Service\Country;
use Nails\Factory;

/**
 * Class Address
 *
 * @package Nails\Address\Resource
 */
class Address extends Entity
{
    /**
     * The formatter to use for this address
     *
     * @var Interfaces\Formatter
     */
    protected $oFormatter;

    /**
     * The validator to use for this address
     *
     * @var Interfaces\Validator
     */
    protected $oValidator;

    /**
     * The address' country component
     *
     * @var \Nails\Common\Resource\Country
     */
    public $country;

    /**
     * The address' label component
     *
     * @var string
     */
    public $label;

    /**
     * The address' line_1 component
     *
     * @var string
     */
    public $line_1;

    /**
     * The address' line_2 component
     *
     * @var string
     */
    public $line_2;

    /**
     * The address' line_3 component
     *
     * @var string
     */
    public $line_3;

    /**
     * The address' town component
     *
     * @var string
     */
    public $town;

    /**
     * The address' region component
     *
     * @var string
     */
    public $region;

    /**
     * The address' postcode component
     *
     * @var string
     */
    public $postcode;

    // --------------------------------------------------------------------------

    public function __construct($mObj = [])
    {
        parent::__construct($mObj);

        /** @var Country $oCountryService */
        $oCountryService = Factory::service('Country');
        if ($this->country) {
            $this->country = $oCountryService->getCountry($this->country);
        }
    }

    // --------------------------------------------------------------------------

    /**
     * Returns a formatter object
     *
     * @param Interfaces\Formatter|null $oFormatter A specific formatter to use (defaults to automatic)
     *
     * @return Interfaces\Formatter
     * @throws FactoryException
     */
    public function formatted(Interfaces\Formatter $oFormatter = null): Interfaces\Formatter
    {
        if ($oFormatter !== null) {

            return $oFormatter->setAddress($this);

        } elseif ($this->oFormatter === null) {

            /** @var Service\Address $oAddressService */
            $oAddressService  = Factory::service('Address', Constants::MODULE_SLUG);
            $this->oFormatter = $oAddressService::getFormatterForCountry($this->country);

            return $this->oFormatter->setAddress($this);

        } else {
            return $this->oFormatter;
        }
    }

    // --------------------------------------------------------------------------

    /**
     * Determines whether the current address is valid
     *
     * @param Interfaces\Validator|null $oValidator A specific validator to use (defaults to automatic)
     *
     * @return bool
     * @throws FactoryException
     */
    public function isValid(Interfaces\Validator $oValidator = null): bool
    {
        try {

            $this->validate($oValidator);
            return true;

        } catch (ValidationException $e) {
            return false;
        }
    }

    // --------------------------------------------------------------------------

    /**
     * Validates the address
     *
     * @param Interfaces\Validator|null $oValidator A specific validator to use (defaults to automatic)
     *
     * @return $this
     * @throws FactoryException
     * @throws ValidationException
     */
    public function validate(Interfaces\Validator $oValidator = null): self
    {
        if ($oValidator !== null) {

            $oValidator::validate($this);

        } elseif ($this->oValidator === null) {

            /** @var Service\Address $oAddressService */
            $oAddressService  = Factory::service('Address', Constants::MODULE_SLUG);
            $this->oValidator = $oAddressService::getValidatorForCountry($this->country);

            $this->oValidator::validate($this);

        } else {
            $this->oValidator::validate($this);
        }

        return $this;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns a computed hash of the address
     *
     * @return string
     * @throws FactoryException
     */
    public function hash(): string
    {
        return md5($this->formatted()->asJson());
    }

    // --------------------------------------------------------------------------

    /**
     * Saves the address to the DB
     *
     * @return $this
     * @throws FactoryException
     * @throws \Nails\Common\Exception\ModelException
     */
    public function save(): self
    {
        $oModel = Factory::model('Address', Constants::MODULE_SLUG);

        $aData = [
            'label'    => $this->label,
            'country'  => $this->country->iso ?? null,
            'line_1'   => $this->line_1,
            'line_2'   => $this->line_2,
            'line_3'   => $this->line_3,
            'town'     => $this->town,
            'region'   => $this->region,
            'postcode' => $this->postcode,
        ];

        if ($this->id) {
            $oModel->update($this->id, $aData);
        } else {
            $this->id = $oModel->create($aData);
        }

        return $this;
    }
}
