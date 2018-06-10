<?php

namespace Detektivo\Storage;

use Elasticsearch\ClientBuilder;

class ElasticSearch extends Storage {

    public $client;

    protected $config;

    public function __construct($config) {
        $this->config = $config;
        $this->client = ClientBuilder::create()->setHosts((array)$config['hosts'])->build();

        try {
            $this->client->indices()->create(['index' => $this->config['index']]);
        } catch (\Exception $e) {}
    }

    public function search($type, $query, $options = []) {

        $params = array_merge([
            "index" => $this->config['index'],
            "body" => [
                "query" => [
                    "bool" => [
                        "should" => [
                            "multi_match" => [
                                "query" => $query,
                                "fields" => "*"
                            ]
                        ]
                    ]

                ]
            ]
        ], $options);

        if (!isset($params['body']['query'])) {
            return null;
        }

        return $this->client->search($params);
    }

    public function save($type, $data) {

        $id = $data['_id'];

        unset($data['_id']);

        $params = [
            'index' => $this->config['index'],
            'type'  => $type,
            'id'    => $id,
            'body'  => $data
        ];

        return $this->client->index($params);
    }

    public function batchSave($type, $items) {

        foreach ($items as &$item) {
            $this->save($type, $item);
        }

        return true;
    }

    public function delete($type, $ids) {

        foreach ($ids as $id) {
            $params = [
                'index' => $this->config['index'],
                'type'  => $type,
                'id'    => $id
            ];

            $response = $this->client->delete($params);
        }
    }

    public function empty($type) {
        return false;
    }

    public function deleteIndex($type) {
        return $this->empty($type);
    }

    public function count($type, $query) {

    }

}
