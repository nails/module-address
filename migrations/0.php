<?php
/**
 * Migration:   0
 * Started:     13/12/2019
 *
 * @package     Nails
 * @subpackage  module-address
 * @category    Database Migration
 * @author      Nails Dev Team
 */

namespace Nails\Database\Migration\Nails\ModuleAddress;

use Nails\Common\Console\Migrate\Base;

class Migration0 extends Base
{
    public function execute(): void
    {
        $this->query('
            CREATE TABLE `{{NAILS_DB_PREFIX}}address` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `country` char(2) NOT NULL,
                `label` varchar(150) DEFAULT NULL,
                `line_1` varchar(150) DEFAULT NULL,
                `line_2` varchar(150) DEFAULT NULL,
                `line_3` varchar(150) DEFAULT NULL,
                `town` varchar(150) DEFAULT NULL,
                `region` varchar(150) DEFAULT NULL,
                `postcode` varchar(150) DEFAULT NULL,
                `created` datetime NOT NULL,
                `created_by` int(11) unsigned DEFAULT NULL,
                `modified` datetime NOT NULL,
                `modified_by` int(11) unsigned DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `created_by` (`created_by`),
                KEY `modified_by` (`modified_by`),
                CONSTRAINT `{{NAILS_DB_PREFIX}}address_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `{{NAILS_DB_PREFIX}}user` (`id`) ON DELETE SET NULL,
                CONSTRAINT `{{NAILS_DB_PREFIX}}address_ibfk_2` FOREIGN KEY (`modified_by`) REFERENCES `{{NAILS_DB_PREFIX}}user` (`id`) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ');
        $this->query('
            CREATE TABLE `{{NAILS_DB_PREFIX}}address_associated` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `address_id` int(11) unsigned NOT NULL,
                `associated_type` varchar(150) DEFAULT NULL,
                `associated_id` int(11) unsigned NOT NULL,
                `created` datetime NOT NULL,
                `created_by` int(11) unsigned DEFAULT NULL,
                `modified` datetime NOT NULL,
                `modified_by` int(11) unsigned DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `created_by` (`created_by`),
                KEY `modified_by` (`modified_by`),
                KEY `address_id` (`address_id`),
                KEY `association` (`associated_type`,`associated_id`) USING BTREE,
                CONSTRAINT `{{NAILS_DB_PREFIX}}address_associated_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `{{NAILS_DB_PREFIX}}user` (`id`) ON DELETE SET NULL,
                CONSTRAINT `{{NAILS_DB_PREFIX}}address_associated_ibfk_2` FOREIGN KEY (`modified_by`) REFERENCES `{{NAILS_DB_PREFIX}}user` (`id`) ON DELETE SET NULL,
                CONSTRAINT `{{NAILS_DB_PREFIX}}address_associated_ibfk_3` FOREIGN KEY (`address_id`) REFERENCES `{{NAILS_DB_PREFIX}}address` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8
        ');
    }
}
