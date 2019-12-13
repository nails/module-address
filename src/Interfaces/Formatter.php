<?php

namespace Nails\Address\Interfaces;

use Nails\Address\Resource\Address;
use Nails\Common\Exception\ValidationException;

/**
 * Interface Formatter
 *
 * @package Nails\Address\Interfaces
 */
interface Formatter
{
    /**
     * Formatter constructor.
     *
     * @param Address $oAddress The address to format
     */
    public function __construct(Address $oAddress);

    // --------------------------------------------------------------------------

    /**
     * Sets the address to format
     *
     * @param Address $oAddress The address to format
     *
     * @return Formatter
     */
    public function setAddress(Address $oAddress): Formatter;

    // --------------------------------------------------------------------------

    /**
     * Validates an address object
     *
     * @param Address $oAddress
     *
     * @throws ValidationException
     */
    public static function validate(Address $oAddress): void;

    // --------------------------------------------------------------------------

    /**
     * Formats as a CSV
     *
     * @return string
     */
    public function asCsv(): string;

    // --------------------------------------------------------------------------

    /**
     * Formats as JSON
     *
     * @return string
     */
    public function asJson(): string;

    /**
     * formats as an array
     *
     * @return array
     */
    public function asArray(): array;
}
