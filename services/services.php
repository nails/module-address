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
use Nails\Address\Validator;

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
        'Address'           => function (): Model\Address {
            if (class_exists('\App\Address\Model\Address')) {
                return new \App\Address\Model\Address();
            } else {
                return new Model\Address();
            }
        },
        'AddressAssociated' => function (): Model\Address\Associated {
            if (class_exists('\App\Address\Model\Address\Associated')) {
                return new \App\Address\Model\Address\Associated();
            } else {
                return new Model\Address\Associated();
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
        'ValidatorGb'      => function (): Validator\Gb {
            if (class_exists('\App\Address\Formater\Gb')) {
                return new \App\Address\Validator\Gb();
            } else {
                return new Validator\Gb();
            }
        },
        'ValidatorGeneric' => function (): Validator\Generic {
            if (class_exists('\App\Address\Formater\Generic')) {
                return new \App\Address\Validator\Generic();
            } else {
                return new Validator\Generic();
            }
        },
        'ValidatorUs'      => function (): Validator\Us {
            if (class_exists('\App\Address\Formater\Us')) {
                return new \App\Address\Validator\Us();
            } else {
                return new Validator\Us();
            }
        },
    ],

    /**
     * A class which represents an object from the database
     */
    'resources' => [
        'Address'           => function ($mObj): Resource\Address {

            if (class_exists('\App\Address\Resource\Address')) {
                return new \App\Address\Resource\Address($mObj);
            } else {
                return new Resource\Address($mObj);
            }
        },
        'AddressAssociated' => function ($mObj): Resource\Address\Associated {

            if (class_exists('\App\Address\Resource\Address\Associated')) {
                return new \App\Address\Resource\Address\Associated($mObj);
            } else {
                return new Resource\Address\Associated($mObj);
            }
        },
    ],
];
