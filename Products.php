<?php

class Products extends  ProductsController {

    public $request;

    public function get()
    {

        global $dbh;
        $param=array();

        if(isset($this->request->action)&&$this->request->action=='new')
        {
            $data['attributes']=['name','quantity','price','description','is_in_stock'];
            print $this->_response($data,200);

        }

        else
        {

            //print_r($_REQUEST);
            if(isset($this->request->id))
            {
                $param['id']=$this->request->id;

            }


            else if(isset($_REQUEST['searchtxt']) && strlen($_REQUEST['searchtxt'])>=1)
            {
                $param['searchtxt']=$_REQUEST['searchtxt'];

            }

            $data['products']=$dbh->read($param);

            //print_r($param);

            if(isset($data['products'][0]))
                print $this->_response($data,200);

            else
            {
                $data='';
                $data['description']='The product you were looking for is not available';
                $data['error']='404 Not Found';
                print $this->_response($data,404);

            }
        }
    }

    public function destroy()
    {
        if(isset($_REQUEST['access_token']))
        {
            global $dbh;
            if($dbh->check_token($_REQUEST['access_token']))
            {
                if(isset($this->request->id))
                {
                    $param['id']=$this->request->id;
                    global $dbh;
                    if($dbh->destroy($param)>0)
                    {
                        $data['description']='Deleted product with id:'.$param['id'];
                        print $this->_response($data,200);
                    }

                    else
                    {
                        $data['description']='Cannot delete product with id:'.$param['id'];
                        print $this->_response($data,404);
                    }
                }
            }
            else
            {
                $data['description']='Invalid access token';
                print $this->_response($data,200);
            }
        }
        else
        {
            $data['description']='Invalid access token';
            print $this->_response($data,200);
        }

    }

    public function create()
    {
        if(isset($_REQUEST['access_token']))
        {
            global $dbh;
            if($dbh->check_token($_REQUEST['access_token']))
            {
                global $dbh;

                $id=$dbh->insert($this->params);
                if(isset($id)&&$id>0)
                {
                    $data['description']='Product created with id:'.$id;
                    print $this->_response($data,201);
                }

                else
                {
                    $data['description']='Product not created';
                    print $this->_response($data,200);
                }
            }
            else
            {
                $data['description']='Invalid access token';
                print $this->_response($data,200);
            }
        }
        else
        {
            $data['description']='Provide access token';
            print $this->_response($data,200);
        }

    }

    public function update()
    {
        if(isset($_REQUEST['access_token']))
        {
            global $dbh;
            if($dbh->check_token($_REQUEST['access_token']))
            {


                if(isset($this->request->id))
                {
                    $param['id']=$this->request->id;
                    global $dbh;
                    $rec = $dbh->read($param);
                    if($rec)
                    {
                        if($dbh->update($this->request->id,$this->params)>0)
                        {
                            $data['description']='Product updated with id:'.$this->request->id;
                            print $this->_response($data,201);
                        }
                        else
                        {
                            $data['description']='Product not updated';
                            print $this->_response($data,200);
                        }
                    }

                    else
                    {
                        $data['description']='Wrong Parameters or not found';
                        print $this->_response($data,404);
                    }

                }
            }
            else
            {
                $data['description']='Invalid access token';
                print $this->_response($data,200);
            }
        }
        else
        {
            $data['description']='Provide access token';
            print $this->_response($data,200);
        }

    }

}


?>