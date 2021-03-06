<?php

namespace Nails\Address\Model;

use Nails\Address\Constants;
use Nails\Address\Formatter\Generic;
use Nails\Address\Helper;
use Nails\Common\Exception\ModelException;
use Nails\Common\Model\Base;

/**
 * Class Address
 *
 * @package Nails\Address\Model
 */
class Address extends Base
{
    /**
     * The table this model represents
     *
     * @var string
     */
    const TABLE = NAILS_DB_PREFIX . 'address';

    /**
     * The name of the resource to use (as passed to \Nails\Factory::resource())
     *
     * @var string
     */
    const RESOURCE_NAME = 'Address';

    /**
     * The provider of the resource to use (as passed to \Nails\Factory::resource())
     *
     * @var string
     */
    const RESOURCE_PROVIDER = Constants::MODULE_SLUG;

    // --------------------------------------------------------------------------

    /**
     * Address constructor.
     *
     * @throws ModelException
     */
    public function __construct()
    {
        parent::__construct();
        $this
            ->addExpandableField([
                'trigger'   => 'associated',
                'type'      => static::EXPANDABLE_TYPE_MANY,
                'model'     => 'AddressAssociated',
                'provider'  => Constants::MODULE_SLUG,
                'id_column' => 'address_id',
            ]);
    }
}
