<?php

class ProductsController {

    public $request, $id, $params;

    public function _response($data, $status = 200)
    {
        header('HTTP/1.1 ' . $status . ' ' . $this->_requestStatus($status));
        return json_encode($data);
    }

    public function _requestStatus($code)
    {
        $status = array(
            200 => 'OK',
            201 => 'Created',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        );
        return ($status[$code]) ? $status[$code] : $status[500];
    }

    public function execute($request) {

        //  echo 1;
        $this->request = $request;
        $this->id = $request->id;
        $this->params = $request->params;

        print_r($request);

        switch ($this->request->method) {
            case 'GET':
                return $this->get();
                break;
            case 'POST':
                return $this->create();
                break;
            case 'PUT':
                return $this->update();
                break;
            case 'DELETE':
                return $this->destroy();
                break;
        }



    }

}
?>