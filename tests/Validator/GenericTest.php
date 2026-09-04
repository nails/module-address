<?php

namespace Tests\Validator;

use Nails\Address\Resource\Address;
use Nails\Address\Validator\Generic;
use Nails\Common\Exception\ValidationException;
use Nails\Common\Service\FormValidation;
use PHPUnit\Framework\TestCase;

class GenericTest extends TestCase
{
    private function cleanAddress(): array
    {
        return [
            'line_1'   => '1 Test Street',
            'line_2'   => '',
            'line_3'   => '',
            'town'     => 'Testville',
            'region'   => '',
            'postcode' => 'TE5 7ST',
            'country'  => 'GB',
        ];
    }

    private function errorsFor(array $aData, array $aExtraRules = []): array
    {
        try {
            (new Generic())->addRules($aExtraRules)->run($aData);
            return [];
        } catch (ValidationException $e) {
            return $e->getData();
        }
    }

    // --------------------------------------------------------------------------

    public function test_a_clean_address_passes(): void
    {
        self::assertSame([], $this->errorsFor($this->cleanAddress()));
    }

    public function test_line_1_postcode_and_country_are_required(): void
    {
        self::assertSame(
            ['line_1', 'postcode', 'country'],
            array_keys($this->errorsFor([]))
        );
    }

    public function test_free_text_lines_are_limited_in_length(): void
    {
        $aErrors = $this->errorsFor(array_merge($this->cleanAddress(), [
            'line_2' => str_repeat('x', Generic::MAX_LINE_LENGTH + 1),
            'town'   => str_repeat('x', Generic::MAX_LINE_LENGTH),
        ]));

        self::assertSame(['line_2'], array_keys($aErrors));
        self::assertStringContainsString((string) Generic::MAX_LINE_LENGTH, $aErrors['line_2']);
    }

    public function test_the_country_must_be_a_known_iso_code(): void
    {
        $aErrors = $this->errorsFor(array_merge($this->cleanAddress(), ['country' => 'XX']));
        self::assertSame(['country'], array_keys($aErrors));

        $aErrors = $this->errorsFor(array_merge($this->cleanAddress(), ['country' => 'GBR']));
        self::assertSame(['country'], array_keys($aErrors));
    }

    public function test_additional_rules_merge_with_the_generic_ones(): void
    {
        $aErrors = $this->errorsFor(
            array_merge($this->cleanAddress(), ['town' => '']),
            ['town' => [FormValidation::RULE_REQUIRED]]
        );

        self::assertSame(['town'], array_keys($aErrors));
    }

    public function test_the_static_interface_validates_an_address_resource(): void
    {
        Generic::validate(new Address($this->cleanAddress()));

        $this->expectException(ValidationException::class);
        Generic::validate(new Address(array_merge($this->cleanAddress(), ['postcode' => ''])));
    }
}
