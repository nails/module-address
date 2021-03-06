<?php

namespace Nails\Address\Formatter;

use Nails\Address\Interfaces\Formatter;
use Nails\Address\Resource\Address;
use Nails\Common\Exception\ValidationException;
use Nails\Common\Service\Country;
use Nails\Factory;

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

    public function withSeparator(string $sSeparator): string
    {
        return implode($sSeparator, array_filter($this->asArray()));
    }

    // --------------------------------------------------------------------------

    /**
     * Formats as a CSV
     *
     * @return string
     */
    public function asCsv(): string
    {
        return $this->withSeparator(', ');
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
     * @param bool $bUseCountryLabel Whether to use the country's label or it's ISO code
     *
     * @return array
     */
    public function asArray(bool $bUseCountryLabel = true): array
    {
        /** @var Country $oCountryService */
        $oCountryService = Factory::service('Country');

        return [
            'label'    => $this->oAddress->label,
            'line_1'   => $this->oAddress->line_1,
            'line_2'   => $this->oAddress->line_2,
            'line_3'   => $this->oAddress->line_3,
            'town'     => $this->oAddress->town,
            'region'   => $this->oAddress->region,
            'postcode' => $this->oAddress->postcode,
            'country'  => $bUseCountryLabel
                ? ($this->oAddress->country->name ?? null)
                : ($this->oAddress->country->iso ?? null),
        ];
    }
}
