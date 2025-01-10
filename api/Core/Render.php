<?php 

namespace Rabbit\Core; 

use Rabbit\Helpers\FormatCase;

class Render {
    private $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function __invoke() {
        $this->encodeJSON();
    }

    public function encodeJSON($formatCase='camelCase') {
        header('Content-Type: application/json');
        http_response_code($this->data['status']);
        
        $transformer = new FormatCase();
        $formatedData = $transformer->transform($formatCase, $this->data);

        echo json_encode($formatedData);

        exit(0);
    }

    public function encodeBinary() {
        header('Content-Type: application/octet-stream');
        http_response_code($this->data['status']);

        echo serialize($this->data);
        exit(0);
    }
}
