<?php

namespace Nails\Address\Service;

use Nails\Address\Constants;
use Nails\Address\Interfaces\Formatter;
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
     * @param Resource\Address      $oAddress   The address to validate
     * @param Formatter|string|null $oFormatter The Formatter to use, or a country code
     *
     * @throws FactoryException
     * @throws ValidationException
     */
    public function validate(Resource\Address $oAddress, Formatter $oFormatter = null)
    {
        if (is_string($oFormatter)) {
            $oFormatter = static::getFormatterForCountry($oFormatter);
        } elseif ($oFormatter === null) {
            $oFormatter = Factory::factory('FormatterGeneric', Constants::MODULE_SLUG);
        }

        $oFormatter::validate($oAddress);
    }

    // --------------------------------------------------------------------------

    /**
     * Returns a formatter for a country code
     *
     * @param string $sCountry The country code
     *
     * @return Formatter
     * @throws FactoryException
     */
    public static function getFormatterForCountry(string $sCountry): Formatter
    {
        try {
            /** @var Formatter $oFormatter */
            $oFormatter = Factory::factory('Formatter' . $sCountry, Constants::MODULE_SLUG);
        } catch (FactoryException $e) {
            /** @var Formatter $oFormatter */
            $oFormatter = Factory::factory('FormatterGeneric', Constants::MODULE_SLUG);
        }

        return $oFormatter;
    }
}
