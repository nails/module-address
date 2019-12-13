<?php
/**
 * Define your module's services, models and factories.
 *
 * @link http://nailsapp.co.uk/docs/services
 */

use Nails\Address\Model;
use Nails\Address\Resource;
use Nails\Address\Service;
use Nails\Address\Formatter;

return [

    'services' => [
        'Address' => function (): Service\Address {
            if (class_exists('\App\Address\Service\Address')) {
                return new \App\Address\Service\Address();
            } else {
                return new Service\Address();
            }
        },
    ],

    'models'    => [
        'Address' => function (): Model\Address {
            if (class_exists('\App\Address\Model\Address')) {
                return new \App\Address\Model\Address();
            } else {
                return new Model\Address();
            }
        },
    ],

    /**
     * A class for which a new instance is created each time it is requested.
     */
    'factories' => [
        'FormatterGb'      => function (): Formatter\Gb {
            if (class_exists('\App\Address\Formater\Gb')) {
                return new \App\Address\Formatter\Gb();
            } else {
                return new Formatter\Gb();
            }
        },
        'FormatterGeneric' => function (): Formatter\Generic {
            if (class_exists('\App\Address\Formater\Generic')) {
                return new \App\Address\Formatter\Generic();
            } else {
                return new Formatter\Generic();
            }
        },
        'FormatterUs'      => function (): Formatter\Us {
            if (class_exists('\App\Address\Formater\Us')) {
                return new \App\Address\Formatter\Us();
            } else {
                return new Formatter\Us();
            }
        },
    ],

    /**
     * A class which represents an object from the database
     */
    'resources' => [
        'Address' => function ($mObj): Resource\Address {

            if (class_exists('\App\Address\Resouce\Address')) {
                return new \App\Address\Resource\Address($mObj);
            } else {
                return new Resource\Address($mObj);
            }
        },
    ],
];
