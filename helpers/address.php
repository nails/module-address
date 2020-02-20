<?php

use Nails\Address;

if (!function_exists('extractAddressComponentsFromArray')) {
    function extractAddressComponentsFromArray(array $aArray): Address\Resource\Address
    {
        return Address\Helper\Address::extractAddressComponentsFromArray($aArray);
    }
}

if (!function_exists('extractAddressFromArray')) {
    function extractAddressFromArray(array $aArray): Address\Resource\Address
    {
        return Address\Helper\Address::extractAddressFromArray($aArray);
    }
}
