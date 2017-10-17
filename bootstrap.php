<?php

include(__DIR__.'/vendor/autoload.php');


$app->module('detektivo')->extend([

    'config' => function($key = null, $default = null) {

        static $config;

        if (!$config) {

            if ($configfile = $this->app->path('#config:detektivo.yaml')) {
                $config = $this->app->helper('yaml')->fromFile($configfile);
            }
        }

        if ($key) {
            return isset($config[$key]) ? $config[$key] : $default;
        }

        return $config;
    },

    'storage' => function() {

        static $storage;

        if (!$storage) {

            if ($config = $this->config()) {
                $storage = \Detektivo\Storage\Manager::getStorage($config);
            }
        }

        return $storage;
    }

]);

$app->on('cockpit.bootstrap', function() {

    $this->on('collections.removecollection', function($collection) {

        $collections = $this->module('detektivo')->config('collections', []);

        if (isset($collections[$collection])) {
            $this->module('detektivo')->storage()->deleteIndex($collection);
        }
    });

    $this->on('collections.save.after', function($collection, $entry, $isUpdate) {

        static $collections;

        if (!$collections) {
            $collections = $this->module('detektivo')->config('collections', []);
        }

        if (isset($collections[$collection])) {

            $data = [];

            if ($collections[$collection] == '*') {
                $fields = array_keys($entry);
            } else {
                $fields = $collections[$collection];
            }

            $data['_id'] = $entry['_id'];

            foreach ($fields as $field) {
                if (isset($entry[$field])) { $data[$field] = $entry[$field]; }
            }

            if (count($data)) {
                $ret = $this->module('detektivo')->storage()->save($collection, $data);
            }
        }
    });

    $this->on('collections.remove.before', function($collection, $criteria) {

        $collections = $this->module('detektivo')->config('collections', []);

        if (!isset($collections[$collection])) return;

        $entries = $this->module('collections')->find($collection, [
            'fields' => ['_id' => true],
            'filter' => $criteria
        ]);

        if (!count($entries)) return;

        $ids = [];
        foreach ($entries as $entry) $ids[] = $entry['_id'];

        $this->module('detektivo')->storage()->delete($collection, $ids);
    });
});


// ADMIN
if (COCKPIT_ADMIN && !COCKPIT_API_REQUEST) {

    include_once(__DIR__.'/admin.php');
}
