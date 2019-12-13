<?php

namespace Nails\Address\Formatter;

use Nails\Address\Interfaces\Formatter;
use Nails\Address\Resource\Address;

class Generic implements Formatter
{
    /**
     * The Address object
     *
     * @var Address
     */
    protected $oAddress;

    // --------------------------------------------------------------------------

    public function __construct(Address $oAddress)
    {
        $this->setAddress($oAddress);
    }

    // --------------------------------------------------------------------------

    public function setAddress(Address $oAddress): Formatter
    {
        $this->oAddress = $oAddress;
        return $this;
    }

    // --------------------------------------------------------------------------

    public function asCsv(): string
    {
        //  @todo (Pablo - 2019-12-13) -
    }

    // --------------------------------------------------------------------------

    public function asJson(): string
    {
        //  @todo (Pablo - 2019-12-13) -
    }

    // --------------------------------------------------------------------------

    public function asArray(): array
    {
        //  @todo (Pablo - 2019-12-13) -
    }
}
