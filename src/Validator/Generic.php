<?php

namespace Nails\Address\Validator;

use Nails\Address\Interfaces\Validator;
use Nails\Address\Resource\Address;
use Nails\Common\Exception\FactoryException;
use Nails\Common\Exception\ValidationException;
use Nails\Common\Service\Country;
use Nails\Common\Service\FormValidation;
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
     * @param array   $aRules   Any additional validation rules to apply
     *
     * @throws FactoryException
     * @throws ValidationException
     */
    public static function validate(Address $oAddress, array $aRules = []): void
    {
        /** @var FormValidation $oFormValidation */
        $oFormValidation = Factory::service('FormValidation');
        /** @var Country $oCountryService */
        $oCountryService = Factory::service('Country');

        $oFormValidation
            ->buildValidator(array_merge(
                [
                    'line_1'   => [
                        FormValidation::RULE_REQUIRED,
                        FormValidation::rule(FormValidation::RULE_MAX_LENGTH, 150),
                    ],
                    'line_2'   => [
                        FormValidation::rule(FormValidation::RULE_MAX_LENGTH, 150),
                    ],
                    'line_3'   => [
                        FormValidation::rule(FormValidation::RULE_MAX_LENGTH, 150),
                    ],
                    'town'     => [
                        FormValidation::rule(FormValidation::RULE_MAX_LENGTH, 150),
                    ],
                    'region'   => [
                        FormValidation::rule(FormValidation::RULE_MAX_LENGTH, 150),
                    ],
                    'postcode' => [
                        FormValidation::RULE_REQUIRED,
                        FormValidation::rule(FormValidation::RULE_MAX_LENGTH, 150),
                    ],
                    'country'  => [
                        FormValidation::RULE_REQUIRED,
                        FormValidation::rule(FormValidation::RULE_MAX_LENGTH, 2),
                        FormValidation::rule(
                            FormValidation::RULE_IN_LIST,
                            implode(',', array_keys($oCountryService->getCountriesFlat()))
                        ),
                    ],
                ],
                $aRules
            ))
            ->run($oAddress->formatted()->asArray(false));
    }
}
