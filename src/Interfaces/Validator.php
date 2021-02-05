<?php

namespace Nails\Address\Interfaces;

use Nails\Address\Resource\Address;
use Nails\Common\Exception\ValidationException;

/**
 * Interface Validator
 *
 * @package Nails\Address\Interfaces
 */
interface Validator
{
    /**
     * Validates an address object
     *
     * @param Address $oAddress The Address to validate
     * @param array   $aRules   Any additional validation rules to apply
     *
     * @throws ValidationException
     */
    public static function validate(Address $oAddress, array $aRules = []): void;
}
