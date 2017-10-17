<?php


$app->on('admin.init', function() {

    $this->on('cockpit.menu.aside', function() {
        $this->renderView("detektivo:views/partials/menu.php");
    });

    // bind admin routes /detektivo/*
    $this->bindClass('Detektivo\\Controller\\Admin', 'detektivo');
});
