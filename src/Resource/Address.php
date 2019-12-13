<?php

namespace Nails\Address\Resource;

use Nails\Address\Constants;
use Nails\Address\Interfaces;
use Nails\Address\Service;
use Nails\Common\Exception\FactoryException;
use Nails\Common\Exception\ValidationException;
use Nails\Common\Resource\Entity;
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
     * @var string
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

            return true;

        } catch (ValidationException $e) {
            return false;
        }
    }
}
