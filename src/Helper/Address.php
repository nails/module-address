<?php

namespace Nails\Address\Helper;

use Nails\Address\Constants;
use Nails\Address\Resource;
use Nails\Common\Exception\FactoryException;
use Nails\Factory;

/**
 * Class Address
 *
 * @package Nails\Address\Helper
 */
class Address
{
    /**
     * Extracts the various components from an array
     *
     * @param array $aArray The array to extract from
     *
     * @return array
     * @throws FactoryException
     */
    public static function extractAddressComponentsFromArray(array $aArray): array
    {
        return [
            'id'       => (int) getFromArray('id', $aArray) ?: null,
            'label'    => trim(getFromArray('label', $aArray)),
            'line_1'   => trim(getFromArray('line_1', $aArray)),
            'line_2'   => trim(getFromArray('line_2', $aArray)),
            'line_3'   => trim(getFromArray('line_3', $aArray)),
            'town'     => trim(getFromArray('town', $aArray)),
            'region'   => trim(getFromArray('region', $aArray)),
            'postcode' => trim(getFromArray('postcode', $aArray)),
            'country'  => trim(getFromArray('country', $aArray)),
        ];
    }

    // --------------------------------------------------------------------------

    /**
     * Extracts the various components from an array and returns an Address resource
     *
     * @param array $aArray The array to extract from
     *
     * @return Resource\Address
     * @throws FactoryException
     */
    public static function extractAddressFromArray(array $aArray): Resource\Address
    {
        return Factory::resource('Address', Constants::MODULE_SLUG, static::extractAddressComponentsFromArray($aArray));
    }
}
