<?php

namespace Nails\Address\Formatter;

use Nails\Address\Interfaces\Formatter;
use Nails\Address\Resource\Address;
use Nails\Common\Exception\ValidationException;

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
     * @var Address|null
     */
    protected $oAddress;

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
        return implode(', ', $this->asArray());
    }

    // --------------------------------------------------------------------------

    /**
     * Formats as JSON
     *
     * @return string
     */
    public function asJson(): string
    {
        return json_encode($this->asArray());
    }

    // --------------------------------------------------------------------------

    /**
     * Formats as an array
     *
     * @return array
     */
    public function asArray(): array
    {
        return [
            'label'    => $this->oAddress->label,
            'line_1'   => $this->oAddress->line_1,
            'line_2'   => $this->oAddress->line_2,
            'line_3'   => $this->oAddress->line_3,
            'town'     => $this->oAddress->town,
            'region'   => $this->oAddress->region,
            'postcode' => $this->oAddress->postcode,
            'country'  => $this->oAddress->country,
        ];
    }
}
