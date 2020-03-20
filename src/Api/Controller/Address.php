<?php

/**
 * Admin API end points: Addresses
 *
 * @package     Nails
 * @subpackage  module-address
 * @category    Controller
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\Address\Api\Controller;

use Nails\Api;
use Nails\Address\Constants;
use Nails\Common\Exception\ValidationException;
use Nails\Common\Service\HttpCodes;

/**
 * Class Address
 *
 * @package Nails\Address\Api\Controller
 */
class Address extends Api\Controller\CrudController
{
    const CONFIG_MODEL_NAME     = 'Address';
    const CONFIG_MODEL_PROVIDER = Constants::MODULE_SLUG;
    const REQUIRE_AUTH          = true;

    // --------------------------------------------------------------------------

    protected function userCan($sAction, $oItem = null)
    {
        if (!isAdmin()) {
            throw new ValidationException(
                HttpCodes::getByCode(HttpCodes::STATUS_UNAUTHORIZED),
                HttpCodes::STATUS_UNAUTHORIZED
            );
        }
    }
}
