<?php

namespace Detektivo\Controller;


class Admin extends \Cockpit\AuthController {

    public function index() {

        $collections = $this->module('detektivo')->config('collections', []);

        return $this->render('detektivo:views/index.php', compact('collections'));
    }
}
