<?php

namespace Nails\Address\Interfaces;

use Nails\Address\Resource\Address;

interface Formatter
{
    public function __construct(Address $oAddress);

    public function setAddress(Address $oAddress): Formatter;

    public function asCsv(): string;

    public function asJson(): string;

    public function asArray(): array;
}
