<?php
class db {
    private $dbh=null;
    public function __construct() {

        $hostname = 'localhost';
        $username = 'root';
        $password = 'm';

        try {
            $this->dbh = new PDO("mysql:host=$hostname;dbname=demo", $username, $password);
            //echo 'Connected to database';
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }

    }
    public function __destruct() {
        $this->dbh=null;
    }


    public function read($param) {
        $rs= array();

        $sql = null;
        if(isset($param['searchtxt']))
        {
            $searchTxt = strToLower(htmlentities($param['searchtxt']));
            if($searchTxt==='true') $searchTxt1 =1;
            else if($searchTxt==='false') $searchTxt1 =0;
            $searchTxt2 = "%".$searchTxt."%";
            $sql  = $this->dbh->prepare("SELECT * FROM products WHERE LOWER(name) LIKE ? OR quantity=? OR price=? OR LOWER(description) LIKE ? OR is_in_stock=?");
            $sql->bindParam(1, $searchTxt2);
            $sql->bindParam(2, $searchTxt);
            $sql->bindParam(3, $searchTxt);
            $sql->bindParam(4, $searchTxt2);
            $sql->bindParam(5, $searchTxt1);
        }
        else if(isset($param['id']))
        {
            $id = $param['id'];
            $sql  = $this->dbh->prepare("SELECT * FROM products WHERE id=?");
            $sql->bindParam(1, $id);
        }

        else
        {
            $dummyTxt = 0;
            $sql  = $this->dbh->prepare("SELECT * FROM products WHERE id>?");
            $sql->bindParam(1, $dummyTxt);
        }
        $sql->execute();
        if($sql)
        {
            while($row = $sql->fetch(PDO::FETCH_ASSOC))
            {
                if($row['is_in_stock']==1) $row['is_in_stock']='true';
                else if($row['is_in_stock']==0) $row['is_in_stock']='false';
                $rs[] = $row;
            }
        }
        return $rs;
    }
    public function insert($rec) {
        $rec=(get_object_vars($rec));
        $sql = $this->dbh->prepare("INSERT INTO products  VALUES (0,?,?,?,?,?)");
        $sql->bindParam(1, $rec['name']);
        $sql->bindParam(2, $rec['quantity']);
        $sql->bindParam(3, $rec['price']);
        $sql->bindParam(4, $rec['description']);
        $sql->bindParam(5, $rec['is_in_stock']);
        $this->dbh->beginTransaction();
        $sql->execute();
        $id= $this->dbh->lastInsertId();
        //echo $this->dbh->lastInsertId();
        $this->dbh->commit();
        return $id;



    }
    public function update($idx, $attributes) {
        $attributes=get_object_vars($attributes);
        $sql = "UPDATE products SET ";
        foreach($attributes as $key=>$val)
        {
            if($key=='is_in_stock')
                $sql .= $key."='".$val."' ";
            else if($key=='id')
                continue;
            else
                $sql .= $key."='".$val."', ";
        }
        $sql .= " WHERE id=?";
        $query=$this->dbh->prepare($sql);
        $query->bindParam(1,$idx);
        $this->dbh->beginTransaction();
        $query->execute();
        $count= $query->rowCount();
        $this->dbh->commit();
        return  $count ;
    }
    public function destroy($param) {
        $sql = $this->dbh->prepare("DELETE FROM products WHERE id=?");
        //print_r($attributes['id']);
        $sql->bindParam(1, $param['id']);
        $this->dbh->beginTransaction();
        $sql->execute();
        $count= $sql->rowCount();
        $this->dbh->commit();
        return $count ;
    }
    public function doLogin($user, $pass) {
        $user = strToLower($user);
        $sql  = $this->dbh->prepare("SELECT uid, `name` FROM users WHERE (LOWER(username)=? OR LOWER(email)=?) AND passwd=?");
        $pass = md5($pass);
        $sql->bindParam(1, $user);
        $sql->bindParam(2, $user);
        $sql->bindParam(3, $pass);
        $sql->execute();
        if($sql)
        {
            if($row = $sql->fetch(PDO::FETCH_ASSOC))
            {

                return true;
            }
        }
        return false;
    }

    public function insert_token($rec) {
        //$rec=(get_object_vars($rec));

        print_r($rec);
        $sql = $this->dbh->prepare("INSERT INTO tokens  VALUES (?,?,NOW())");
        $sql->bindParam(1, $rec['token']);
        $sql->bindParam(2, $rec['username']);
        $sql->execute();
        return true;

    }

    public function check_token($token) {
        $sql  = $this->dbh->prepare("SELECT * FROM tokens WHERE token=?");
        $sql->bindParam(1, $token);
        $sql->execute();
        if($sql)
        {
            if($row = $sql->fetch(PDO::FETCH_ASSOC))
            {
                return true;
            }
        }
        return false;
    }


}
