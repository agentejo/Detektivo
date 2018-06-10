<?php

namespace Detektivo\Storage;

class Algolia extends Storage {

    public $client;

    public function __construct($config) {

        $this->client = new \AlgoliaSearch\Client($config['app_id'], $config['api_key']);
    }

    public function search($index, $query, $options = []) {

        $index = $this->client->initIndex($index);

        return $index->search($query, $options);
    }

    public function save($index, $data) {

        $index = $this->client->initIndex($index);
        $data['objectID'] = $data['_id'];
        return $index->partialUpdateObject($data, true);
    }

    public function batchSave($index, $items) {

        foreach ($items as &$item) {
            $item['objectID'] = $item['_id'];
        }

        $index = $this->client->initIndex($index);

        return $index->addObjects($items);

    }

    public function delete($index, $ids) {
        return $this->client->initIndex($index)->deleteObjects($ids);
    }

    public function empty($index) {
        return $this->client->initIndex($index)->clearIndex();
    }

    public function deleteIndex($index) {
        return $this->client->deleteIndex($index);
    }

    public function count($index, $query) {

    }

    protected function getObject($index, $id)  {

        try {
            return $index->getObject($id);
        } catch (\Exception $e) {
            return null;
        }
    }

}
