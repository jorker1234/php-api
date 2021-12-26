<?php
    class BookController extends BaseController
    {
        public function action() {
            $action = strtoupper($_SERVER["REQUEST_METHOD"]);
            $params = $this->getQueryStringParams();

            if($action == 'GET' && !isset($params['id'])) {
                $this->list();
            }else if($action == 'GET' && isset($params['id'])) {
                $this->get($params['id']);
            }else if($action == 'DELETE' && isset($params['id'])) {
                $this->remove($params['id']);
            }else if($action == 'PUT') {
                $paramJSON = file_get_contents('php://input');
                $book = json_decode($paramJSON);
                $this->edit($book);
            }else if($action == 'POST') {
                $paramJSON = file_get_contents('php://input');
                $book = json_decode($paramJSON);
                $this->add($book);
            }else if($action == 'OPTIONS') {
                $this->sendOutput(null, array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                );
            }else {
                $strErrorDesc = 'Method not supported';
                $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
                $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                    array('Content-Type: application/json', $strErrorHeader)
                );
            }
        }

        public function list() 
        {
            $result = '';
            $error = '';
            try {
                $bookModel = new BookModel();
                $result = $bookModel->list(1000);
            } catch (Error $e) {
                $error = $e->getMessage().'Something went wrong! Please contact support.';
            }
            $this->renderJson($result, $error);
        }

        public function get($id) 
        {
            $result = '';
            $error = '';
            try {
                $bookModel = new BookModel();
                $books = $bookModel->get($id);
                $result = $books[0];
            } catch (Error $e) {
                $error = $e->getMessage().'Something went wrong! Please contact support.';
            }
            $this->renderJson($result, $error);
        }

        public function add($book) 
        {
            $result = '';
            $error = '';
            try {
                $bookModel = new BookModel();
                $success = $bookModel->add($book);
                $result = array('success' => $success);
            } catch (Error $e) {
                $error = $e->getMessage().'Something went wrong! Please contact support.';
            }

            $this->renderJson($result, $error);
        }

        public function edit($book) 
        {
            $result = '';
            $error = '';
            try {
                $bookModel = new BookModel();
                $success = $bookModel->edit($book);
                $result = array('success' => $success);
            } catch (Error $e) {
                $error = $e->getMessage().'Something went wrong! Please contact support.';
            }
            $this->renderJson($result, $error);
        }


        public function remove($id) 
        {
            $result = '';
            $error = '';
            try {
                $bookModel = new BookModel();
                $success = $bookModel->delete($id);
                $result = array('success' => $success);
            } catch (Error $e) {
                $error = $e->getMessage().'Something went wrong! Please contact support.';
            }
            $this->renderJson($result, $error);
        }

        public function renderJson($result, $error) {
            $header = !$error? 'HTTP/1.1 200 OK' : 'HTTP/1.1 500 Internal Server Error';
            $resultObj = !$error? $result: array('error' => $error);
            $this->sendOutput(json_encode($resultObj), array('Content-Type: application/json', $header));
        }
    }
?>