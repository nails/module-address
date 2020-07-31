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
     * Sets the address to format
     *
     * @param Address $oAddress The address to format
     *
     * @return Formatter
     */
    public function setAddress(Address $oAddress): Formatter;

    // --------------------------------------------------------------------------

    /**
     * Formats with separator
     *
     * @param string $sSeparator The separator to use
     *
     * @return string
     */
    public function withSeparator(string $sSeparator): string;

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
