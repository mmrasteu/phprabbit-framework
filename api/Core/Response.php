<?php 

namespace Rabbit\Core;

use Rabbit\Core\Render;

class Response{
    
    private $render;

    public function __construct() {
        $this->render = new Render();
    }
    
    public function status200(
        $data=[],
        $message='200 - Success',
        $status=200,
        $title='Success'
    ){
        http_response_code($status);
        $response = json_encode([
            'status' => $status,
            'title' => $title,
            'message' => $message,
            'data' => $data
        ]);

        $this->render->return($response);
    }

    public function status201(
        $data=[],
        $message='201 - OK',
        $status=404,
        $title='OK',
    ){
        http_response_code($status);
        $response = json_encode([
            'status' => $status,
            'title' => $title,
            'message' => $message,
            'data' => $data
        ]);

        $this->render->return($response);
    }

    public function status500(
        $data=[],
        $message='500 - Server Error',
        $status=404,
        $title='Server Error'
    ){
        http_response_code($status);
        $response = json_encode([
            'status' => $status,
            'title' => $title,
            'message' => $message,
            'data' => $data
        ]);

        $this->render->return($response);
    }

    public function status404(
        $data=[],
        $message='404 - Not found',
        $status=404,
        $title='Not Found'
    )
    {
        http_response_code($status);
        $response = json_encode([
            'status' => $status,
            'title' => $title,
            'message' => $message,
            'data' => $data
        ]);

        $this->render->return($response);
    }
}