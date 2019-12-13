<?php

namespace Test\Address;

use Nails\Address\Constants;
use PHPUnit\Framework\TestCase;

/**
 * Class ConstantsTest
 *
 * @package Test\Address
 */
class ConstantsTest extends TestCase
{
    public function test_module_slug_is_correct()
    {
        $this->assertEquals(
            'nails/module-address',
            Constants::MODULE_SLUG
        );
    }
}
