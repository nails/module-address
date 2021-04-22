<?php
/**
 * Migration:   1
 * Started:     17/07/2020
 *
 * @package     Nails
 * @subpackage  module-address
 * @category    Database Migration
 * @author      Nails Dev Team
 */

namespace Nails\Address\Database\Migration;

use Nails\Common\Console\Migrate\Base;

class Migration1 extends Base
{
    public function execute(): void
    {
        $this->query('ALTER TABLE `{{NAILS_DB_PREFIX}}address_associated` ADD COLUMN `is_default` int(11) unsigned NOT NULL DEFAULT 0 AFTER `associated_id`;');
    }
}
