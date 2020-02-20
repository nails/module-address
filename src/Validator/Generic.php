<?php

namespace Nails\Address\Validator;

use Nails\Address\Exception\Validation\InvalidCountryException;
use Nails\Address\Interfaces\Validator;
use Nails\Address\Resource\Address;
use Nails\Common\Exception\FactoryException;
use Nails\Common\Exception\ValidationException;
use Nails\Common\Service\Country;
use Nails\Factory;

/**
 * Validates an address to a country's standards
 *
 * @package Nails\Address\Validator
 */
class Generic implements Validator
{
    /**
     * Validates an address object
     *
     * @param Address $oAddress The Address to validate
     *
     * @throws FactoryException
     * @throws InvalidCountryException
     */
    public static function validate(Address $oAddress): void
    {
        static::validateCountry($oAddress);
    }

    // --------------------------------------------------------------------------

    /**
     * @param Address $oAddress The Address to validate
     *
     * @throws InvalidCountryException
     * @throws FactoryException
     */
    protected static function validateCountry(Address $oAddress): void
    {
        if (empty($oAddress->country)) {
            throw new InvalidCountryException(
                'Missing country property'
            );
        }

        /** @var Country $oCountryService */
        $oCountryService = Factory::service('Country');
        $oCountry        = $oCountryService->getCountry($oAddress->country);
        if (empty($oCountry)) {
            throw new InvalidCountryException(
                sprintf(
                    '"%s" is not a valid country',
                    $oAddress->country
                )
            );
        }
    }
}
