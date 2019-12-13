<?php

namespace Nails\Address\Formatter;

use Nails\Address\Interfaces\Formatter;
use Nails\Address\Resource\Address;

/**
 * Formats an address in a generic way
 *
 * @package Nails\Address\Formatter
 */
class Generic implements Formatter
{
    /**
     * The Address object
     *
     * @var Address
     */
    protected $oAddress;

    // --------------------------------------------------------------------------

    /**
     * Generic constructor.
     *
     * @param Address $oAddress The address to format
     */
    public function __construct(Address $oAddress)
    {
        $this->setAddress($oAddress);
    }

    // --------------------------------------------------------------------------

    /**
     * Sets the address to format
     *
     * @param Address $oAddress The address to format
     *
     * @return Formatter
     */
    public function setAddress(Address $oAddress): Formatter
    {
        $this->oAddress = $oAddress;
        return $this;
    }

    // --------------------------------------------------------------------------

    /**
     * Formats as a CSV
     *
     * @return string
     */
    public function asCsv(): string
    {
        //  @todo (Pablo - 2019-12-13) - Complete this
    }

    // --------------------------------------------------------------------------

    /**
     * Formats as JSON
     *
     * @return string
     */
    public function asJson(): string
    {
        //  @todo (Pablo - 2019-12-13) - Complete this
    }

    // --------------------------------------------------------------------------

    /**
     * formats as an array
     *
     * @return array
     */
    public function asArray(): array
    {
        //  @todo (Pablo - 2019-12-13) - Complete this
    }
}
