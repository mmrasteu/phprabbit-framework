<?php 

namespace Rabbit\Controllers;

use Rabbit\Core\BaseController;
use Rabbit\Validators\StatusValidator;

class StatusController extends BaseController{

    public function getStatus(){
        $this->validate(new StatusValidator($this->request, $this->response));

        $headers = $this->request->getAllHeaders();

        $id = $this->request->getParam('id');

        $data = [
            'id' => (int) $id
        ];
        
        $this->response->withStatus200($data);
    }

    public function getStatusWithID($id=0, $test=''){
        $data = [
            'id' => $id,
            'test' => $test
        ];
        
        $this->response->withStatus200($data);
    }

}