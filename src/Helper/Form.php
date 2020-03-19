<?php

namespace Nails\Address\Helper;

use Nails\Common\Service\Country;
use Nails\Factory;

/**
 * Class Form
 *
 * @package Nails\Address\Helper
 */
class Form
{
    public static function address(array $aField)
    {
        /** @var Country $oCountryService */
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
                form_input('', '', ' class="js-address-picker__label" placeholder="Label"'),
                form_input('', '', ' class="js-address-picker__line_1" placeholder="Line 1"'),
                form_input('', '', ' class="js-address-picker__line_2" placeholder="Line 2"'),
                form_input('', '', ' class="js-address-picker__line_3" placeholder="Line 3"'),
                form_input('', '', ' class="js-address-picker__town" placeholder="Town"'),
                form_input('', '', ' class="js-address-picker__region" placeholder="Region"'),
                form_input('', '', ' class="js-address-picker__postcode" placeholder="Postcode"'),
                form_dropdown(
                    '',
                    ['' => 'Select a country'] + $oCountryService->getCountriesFlat(),
                    '',
                    'class="select2 js-address-picker__country" placeholder="Country"'
                ),
                '</div>',
            ]
        );
        return \Nails\Common\Helper\Form\Field::html($aField);
    }
}
