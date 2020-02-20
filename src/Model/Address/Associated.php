<?php

namespace Nails\Address\Model\Address;

use Nails\Address\Constants;
use Nails\Address\Formatter\Generic;
use Nails\Address\Helper;
use Nails\Common\Exception\ModelException;
use Nails\Common\Model\Base;

/**
 * Class Associated
 *
 * @package Nails\Address\Model\Address
 */
class Associated extends Base
{
    /**
     * The table this model represents
     *
     * @var string
     */
    const TABLE = NAILS_DB_PREFIX . 'address_associated';

    /**
     * The name of the resource to use (as passed to \Nails\Factory::resource())
     *
     * @var string
     */
    const RESOURCE_NAME = 'AddressAssociated';

    /**
     * The provider of the resource to use (as passed to \Nails\Factory::resource())
     *
     * @var string
     */
    const RESOURCE_PROVIDER = Constants::MODULE_SLUG;

    // --------------------------------------------------------------------------

    /**
     * Associated constructor.
     *
     * @throws ModelException
     */
    public function __construct()
    {
        parent::__construct();
        $this
            ->addExpandableField([
                'trigger'   => 'address',
                'model'     => 'Address',
                'provider'  => Constants::MODULE_SLUG,
                'id_column' => 'address_id',
            ]);
    }
}
