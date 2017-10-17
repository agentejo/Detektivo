<?php

namespace Detektivo\Storage;

class Manager {

    public static function getStorage($config) {

        switch(@$config['engine']) {

            case 'algolia':
                $storage = new Algolia($config);
                break;

            case 'elasticsearch':
                $storage = new ElasticSearch($config);
                break;

            case 'tntsearch':
                $storage = new TNTSearch($config);
                break;

            default:
                $storage = null;
        }

        return $storage;

    }
}
