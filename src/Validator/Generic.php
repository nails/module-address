<?php

namespace Nails\Address\Validator;

use Nails\Address\Interfaces;
use Nails\Address\Resource\Address;
use Nails\Common\Exception\FactoryException;
use Nails\Common\Exception\ValidationException;
use Nails\Common\Factory\Service\FormValidation\Validator;
use Nails\Common\Service\Country;
use Nails\Common\Service\FormValidation;
use Nails\Factory;

/**
 * Validates an address to a generic standard; country-specific validators extend
 * this and override `rules()` (merging with `parent::rules()` as needed).
 *
 * @package Nails\Address\Validator
 */
class Generic extends Validator implements Interfaces\Validator
{
    /**
     * The maximum length of a free-text address line
     */
    public const MAX_LINE_LENGTH = 150;

    // --------------------------------------------------------------------------

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
        (new static())
            ->addRules($aRules)
            ->run($oAddress->formatted()->asArray(false));
    }

    // --------------------------------------------------------------------------

    /**
     * @throws FactoryException
     */
    protected function rules(): array
    {
        /** @var Country $oCountryService */
        $oCountryService = Factory::service('Country');

        $sMaxLength = FormValidation::rule(FormValidation::RULE_MAX_LENGTH, static::MAX_LINE_LENGTH);

        return [
            'line_1'   => [FormValidation::RULE_REQUIRED, $sMaxLength],
            'line_2'   => [$sMaxLength],
            'line_3'   => [$sMaxLength],
            'town'     => [$sMaxLength],
            'region'   => [$sMaxLength],
            'postcode' => [FormValidation::RULE_REQUIRED, $sMaxLength],
            'country'  => [
                FormValidation::RULE_REQUIRED,
                FormValidation::rule(FormValidation::RULE_MAX_LENGTH, 2),
                FormValidation::rule(
                    FormValidation::RULE_IN_LIST,
                    implode(',', array_keys($oCountryService->getCountriesFlat()))
                ),
            ],
        ];
    }
}
