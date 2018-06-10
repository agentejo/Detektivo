<?php

namespace Detektivo\Storage;

abstract class Storage {

    abstract public function search($index, $query, $options = []);
    abstract public function save($index, $data);
    abstract public function batchSave($index, $items);
    abstract public function delete($index, $filter);
    abstract public function empty($index);
    abstract public function count($index, $query);
}
