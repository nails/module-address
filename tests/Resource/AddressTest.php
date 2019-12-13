<?php

namespace Test\Address\Resource;

use Nails\Address\Formatter;
use Nails\Address\Resource;
use Nails\Common\Exception\FactoryException;
use PHPUnit\Framework\TestCase;

/**
 * Class AddressTest
 *
 * @package Test\Address\Resource
 */
class AddressTest extends TestCase
{
    /**
     * @throws FactoryException
     */
    public function test_formatted_returns_generic_formatter()
    {
        //  @todo (Pablo - 2019-12-13) - Fix factory issues
        $this->markTestIncomplete();

        $oAddress = new Resource\Address([]);
        $this->assertInstanceOf(
            Formatter\Generic::class,
            $oAddress->formatted()
        );
    }

    /**
     * @throws FactoryException
     */
    public function test_formatted_returns_specific_formatter()
    {
        //  @todo (Pablo - 2019-12-13) - Fix factory issues
        $this->markTestIncomplete();

        $oAddress   = new Resource\Address([]);
        $oFormatter = new Formatter\Gb();

        $this->assertInstanceOf(
            Formatter\Gb::class,
            $oAddress->formatted($oFormatter)
        );
    }

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
}
