<?php

namespace Detektivo\Storage;

class TNTSearch extends Storage {

    public $client;

    public function __construct($config) {

        $this->client = new \TeamTNT\TNTSearch\TNTSearch();

        $idxfolder = cockpit()->path('#storage:tntindex');

        if (!$idxfolder) {
            cockpit()->helper('fs')->mkdir('#storage:tntindex');
            $idxfolder = cockpit()->path('#storage:tntindex');
        }

        $this->client->loadConfig([
            'storage'   => $idxfolder,
            'driver'    => 'sqlite',
            'database'  => ':memory:'
        ]);
    }

    public function search($index, $query, $options = []) {

        try {
            $this->client->selectIndex("{$index}.index");
            $this->client->fuzziness = true;

            $res = $this->client->search($query);

            return $res;
        } catch (\Exception $e) {
            return [];
        }
    }

    public function save($index, $data) {

        $idx = $this->getIndex($index);

        $data['id'] = $data['_id'];

        $idx->delete($data['id']);

        return $idx->insert($data);
    }

    public function batchSave($index, $items) {

        foreach ($items as &$item) {
            $this->save($index, $item);
        }

        return true;
    }

    public function delete($index, $ids) {

        $idx = $this->getIndex($index);

        foreach ($ids as $id) {
            $idx->delete($id);
        }
    }

    public function empty($index) {
        $this->deleteIndex($index);
    }

    public function deleteIndex($index) {

        if (!file_exists($this->client->config['storage']."/{$index}.index")) {
            @unlink($this->client->config['storage']."/{$index}.index");
        }
    }

    public function count($index, $query) {

    }

    protected function getIndex($index) {

        if (!file_exists($this->client->config['storage']."/{$index}.index")) {
            $indexer = $this->client->createIndex("{$index}.index");
            $indexer->setDatabaseHandle(new Connector);
            $indexer->setPrimaryKey('_id');
        }

        $this->client->selectIndex("{$index}.index");

        $index = $this->client->getIndex();

        return $index;
    }

}


class Connector extends \PDO {

    public function __construct() {

    }

    public function getAttribute($attribute) {
        return false;
    }

    public function query($query) {
        return new ResultObject([]);
    }
}

class ResultObject {

    protected $items;
    protected $counter;

    public function __construct($items) {
        $this->counter = 0;
        $this->items   = $items;
    }

    public function fetch($options) {
        return $this->items[$this->counter++];
    }
}
