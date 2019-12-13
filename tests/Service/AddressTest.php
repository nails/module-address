<?php

namespace Test\Address\Service;

use Nails\Address\Formatter;
use Nails\Address\Validator;
use Nails\Address\Service\Address;
use Nails\Common\Exception\FactoryException;
use PHPUnit\Framework\TestCase;

/**
 * Class AddressTest
 *
 * @package Test\Address\Service
 */
class AddressTest extends TestCase
{
    public function test_validation_passes_with_valid_data()
    {
        $this->markTestIncomplete();
        //  @todo (Pablo - 2019-12-13) - Complete this
    }

    public function test_validation_fails_with_invalid_data()
    {
        $this->markTestIncomplete();
        //  @todo (Pablo - 2019-12-13) - Complete this
    }

    /**
     * @throws FactoryException
     */
    public function test_correct_validator_is_returned_for_valid_country()
    {
        //  @todo (Pablo - 2019-12-13) - Fix factory issues
        $this->markTestIncomplete();

        $this->assertInstanceOf(
            Validator\Gb::class,
            Address::getValidatorForCountry('GB')
        );
    }

    /**
     * @throws FactoryException
     */
    public function test_generic_validator_is_returned_for_invalid_country()
    {
        //  @todo (Pablo - 2019-12-13) - Fix factory issues
        $this->markTestIncomplete();

        $this->assertInstanceOf(
            Validator\Generic::class,
            Address::getValidatorForCountry('XX')
        );
    }

    /**
     * @throws FactoryException
     */
    public function test_correct_formatter_is_returned_for_valid_country()
    {
        //  @todo (Pablo - 2019-12-13) - Fix factory issues
        $this->markTestIncomplete();

        $this->assertInstanceOf(
            Formatter\Gb::class,
            Address::getFormatterForCountry('GB')
        );
    }

    /**
     * @throws FactoryException
     */
    public function test_generic_formatter_is_returned_for_invalid_country()
    {
        //  @todo (Pablo - 2019-12-13) - Fix factory issues
        $this->markTestIncomplete();

        $this->assertInstanceOf(
            Formatter\Generic::class,
            Address::getFormatterForCountry('XX')
        );
    }
}
