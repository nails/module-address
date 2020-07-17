<?php

namespace Nails\Address\Resource\Address;

use Nails\Address\Constants;
use Nails\Address\Resource\Address;
use Nails\Common\Exception\FactoryException;
use Nails\Common\Exception\ModelException;
use Nails\Common\Resource\Entity;
use Nails\Factory;

/**
 * Class Associated
 *
 * @package Nails\Address\Resource\Address
 */
class Associated extends Entity
{
    /** @var string */
    public $associated_type;

    /** @var int */
    public $associated_id;

    /** @var int */
    public $address_id;

    /** @var Address */
    public $address;

    /** @var bool */
    public $is_default;

    // --------------------------------------------------------------------------

    /**
     * Returns the item's address
     *
     * @return Address|null
     * @throws FactoryException
     * @throws ModelException
     */
    public function address(): ?Address
    {
        if ($this->address_id && !$this->address) {
            /** @var \Nails\Address\Model\Address $oModel */
            $oModel        = Factory::model('Address', Constants::MODULE_SLUG);
            $this->address = $oModel->getById($this->address_id);
        }

        return $this->address;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns whether the address is the default address or not
     *
     * @return bool
     */
    public function isDefault(): bool
    {
        return $this->is_default;
    }
}
