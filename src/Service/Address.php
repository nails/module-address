<?php

namespace Nails\Address\Service;

use Nails\Address\Constants;
use Nails\Address\Interfaces;
use Nails\Address\Resource;
use Nails\Common\Exception\FactoryException;
use Nails\Common\Exception\ValidationException;
use Nails\Factory;

/**
 * Class Address
 *
 * @package Nails\Address\Service
 */
class Address
{
    /**
     * Validates an address against a formatter
     *
     * @param Resource\Address                 $oAddress   The address to validate
     * @param Interfaces\Validator|string|null $oValidator The Validator to use, or a country code
     *
     * @throws FactoryException
     * @throws ValidationException
     */
    public function validate(Resource\Address $oAddress, Interfaces\Validator $oValidator = null)
    {
        if (is_string($oValidator)) {
            $oValidator = static::getValidatorForCountry($oValidator);
        } elseif ($oValidator === null) {
            $oValidator = Factory::factory('ValidatorGeneric', Constants::MODULE_SLUG);
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
}
