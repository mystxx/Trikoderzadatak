<?php

/**
 * Description of ProductClass
 * Apstraktna klasa
 * Implementira samo DBConnection()
 * @author Hrvoje
 */

abstract class Product {

    protected $db;

    protected abstract function populate($array);
    public abstract function delete();
    public abstract function update();


    protected function DBConnection() {

        $db=new SQL();
        $db->connect('root', 'root', 'localhost', 'trikoder', 'MYSQL');

        if ($db->error) {
        
            throw new Exception('Can\'t connect to database');

        }
        else {

            $this->db=$db;

        }


    }


}
?>
