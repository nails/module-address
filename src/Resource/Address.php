<?php

namespace Nails\Address\Resource;

use Nails\Address\Interfaces\Formatter;
use Nails\Common\Exception\FactoryException;
use Nails\Common\Resource\Entity;
use Nails\Factory;

class Address extends Entity
{
    /**
     * The formatter to use for this address
     *
     * @var Formatter
     */
    protected $oFormatter;

    /**
     * The address' country component
     *
     * @var string
     */
    public $country;

    /**
     * The address' label component
     *
     * @var string
     */
    public $label;

    /**
     * The address' line_1 component
     *
     * @var string
     */
    public $line_1;

    /**
     * The address' line_2 component
     *
     * @var string
     */
    public $line_2;

    /**
     * The address' line_3 component
     *
     * @var string
     */
    public $line_3;

    /**
     * The address' town component
     *
     * @var string
     */
    public $town;

    /**
     * The address' region component
     *
     * @var string
     */
    public $region;

    /**
     * The address' postcode component
     *
     * @var string
     */
    public $postcode;

    // --------------------------------------------------------------------------

    /**
     * Address constructor.
     *
     * @param array $mObj The data to populate the resource with
     */
    public function __construct($mObj = [])
    {
        parent::__construct($mObj);
    }

    // --------------------------------------------------------------------------

    /**
     * Returns a formatter object
     *
     * @param Formatter|null $oFormatter A specific formatter to use
     *
     * @return Formatter
     * @throws FactoryException
     */
    public function formatted(Formatter $oFormatter = null): Formatter
    {
        if ($oFormatter !== null) {

            return $oFormatter->setAddress($this);

        } elseif ($this->oFormatter === null) {

            try {
                $this->oFormatter = Factory::factory('Formatter' . $this->country);
            } catch (\Exception $e) {
                $this->oFormatter = Factory::factory('FormatterGeneric');
            }

            return $this->oFormatter->setAddress($this);

        } else {
            return $this->oFormatter;
        }
    }
}
