<?php

namespace Nails\Address\Helper;

use Nails\Common\Exception\FactoryException;
use Nails\Common\Service;
use Nails\Factory;

/**
 * Class Form
 *
 * @package Nails\Address\Helper
 */
class Form
{
    /**
     * Renders an address form field
     *
     * @param array $aField The fields config array
     *
     * @return string
     * @throws FactoryException
     */
    public static function address(array $aField)
    {
        /** @var Service\Country $oCountryService */
        $oCountryService = Factory::service('Country');

        $aField['class'] .= 'js-address-picker loading';
        $aField['html']  = implode(
            PHP_EOL,
            [
                sprintf(
                    '<input type="hidden" name="%s" value="%s" class="js-address-picker__id">',
                    $aField['key'],
                    $aField['default']
                ),
                '<div class="js-address-picker__fields">',
                form_input(
                    $aField['key'] . '_data[label]',
                    set_value($aField['key'] . '_data[label]'),
                    'class="js-address-picker__label" placeholder="Label"'
                ),
                form_input(
                    $aField['key'] . '_data[line_1]',
                    set_value($aField['key'] . '_data[line_1]'),
                    'class="js-address-picker__line_1" placeholder="Line 1"'
                ),
                form_input(
                    $aField['key'] . '_data[line_2]',
                    set_value($aField['key'] . '_data[line_2]'),
                    'class="js-address-picker__line_2" placeholder="Line 2"'
                ),
                form_input(
                    $aField['key'] . '_data[line_3]',
                    set_value($aField['key'] . '_data[line_3]'),
                    'class="js-address-picker__line_3" placeholder="Line 3"'
                ),
                form_input(
                    $aField['key'] . '_data[town]',
                    set_value($aField['key'] . '_data[town]'),
                    'class="js-address-picker__town" placeholder="Town"'
                ),
                form_input(
                    $aField['key'] . '_data[region]',
                    set_value($aField['key'] . '_data[region]'),
                    'class="js-address-picker__region" placeholder="Region"'
                ),
                form_input(
                    $aField['key'] . '_data[postcode]',
                    set_value($aField['key'] . '_data[postcode]'),
                    'class="js-address-picker__postcode" placeholder="Postcode"'
                ),
                form_dropdown(
                    $aField['key'] . '_data[country]',
                    ['' => 'Select a country'] + $oCountryService->getCountriesFlat(),
                    set_value($aField['key'] . '_data[country]'),
                    'class="select2 js-address-picker__country" placeholder="Country"'
                ),
                '</div>',
            ]
        );
        return \Nails\Common\Helper\Form\Field::html($aField);
    }
}
