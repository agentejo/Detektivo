<?php
namespace Detektivo\Controller;

class RestApi extends \LimeExtra\Controller {

    protected function before() {
        $this->app->response->mime = 'json';
    }

    public function collection($collection=null) {

        if (!$collection) {
            return $this->stop('{"error": "Missing collection name"}', 412);
        }

        if (!$this->module('collections')->exists($collection)) {
            return $this->stop('{"error": "Collection not found"}', 412);
        }

        $query = trim($this->param('q', ''));

        if (!$query) {
            return $this->stop('{"error": "Missing query"}', 412);
        }

        $res = $this->module('detektivo')->storage()->search($collection, $query);

        return $res;
    }

}
