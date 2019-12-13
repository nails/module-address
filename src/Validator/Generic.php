<?php

namespace Nails\Address\Validator;

use Nails\Address\Interfaces\Validator;
use Nails\Address\Resource\Address;
use Nails\Common\Exception\ValidationException;

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
     * @param Address $oAddress
     *
     * @throws ValidationException
     */
    public static function validate(Address $oAddress): void
    {
        //  @todo (Pablo - 2019-12-13) - Complete this
        throw new ValidationException();
    }
}
