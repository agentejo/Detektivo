<?php

namespace Detektivo\Controller;


class Admin extends \Cockpit\AuthController {

    public function index() {

        $collections = $this->module('detektivo')->config('collections', []);

        return $this->render('detektivo:views/index.php', compact('collections'));
    }


    public function reindex() {

        $storage = $this->module('detektivo')->storage();
        $collection = $this->param('collection');

        if (!$collection) {
            return false;
        }

        //$this->module('detektivo')->storage()->empty($collection);

        $items = $this->module('collections')->find($collection);

        foreach ($items as $item) {
            try {
                $storage->save($collection, $item);
            } catch (\Exception $e) {}
        }


        return 1;

    }
}
