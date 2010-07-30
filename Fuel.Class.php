<?php

/**
 * Description of Fuel
 *
 * @author Hrvoje Gorajscan
 */


class Fuel extends Product {

    private $id=0;
    private $maker="";
    private $group=0;
    private $image="";
    private $price=0;
    private $type=0;

    /*
    *
    * Konstruktor prima ili asocijativni niz odnosno rezultat mysql_fetch_assoc() nakon upita bazi
    * ili ID goriva. U slučaju da je $info ID onda sam popuni vrijednosti objekta.
    * $info - Array
    * $info - int
    */

    function __construct ($info) {



        if (is_array($info)) {

            $this->populate($info);

        }
        else {

            $this->id=$info;

            $this->DBConnection();
            $db=$this->db;
            $res=$db->sql_select('*', 'fuel','id='.$info);

            if (!$db->error) {

                $this->populate($res);

            }

        }

    }

   /*
    *
    *
    * Postavlja privatne varijable na dobivene vrijednosti
    *
    * $info_array - assoc Array
    */

    protected function populate($info_array) {

        $this->id=$info_array['id'];
        $this->maker=$info_array['fuelMaker'];
        $this->group=$info_array['fuelGroup'];
        $this->image=$info_array['fuelImage'];
        $this->price=$info_array['fuelPrice'];
        $this->type=$info_array['fuelType'];


    }


    /*
    *
    * Ažurira podatke goriva
    */

    public function update() {

        $this->DBConnection();//from Product class
        $db=$this->db;

        $upd_array=Array (
            'fuelMaker'=>$this->maker,
            'fuelGroup'=>$this->group,
            'fuelImage'=>$this->image,
            'fuelPrice'=>$this->price
        );

        $db->sql_update('fuel', $upd_array, 'id='.$this->id);
        if ($db->error) {

            throw new Exception('Couldn\'t update fuel. Fuel id: '.$this->id);

        }

    }

    /*
    * Briše dano gorivo iz baze (s krpicom)
    */


    public function delete() {

        $this->DBConnection();
        $db=$this->db;

        $db->sql_delete('fuel', 'id='.$this->id);

        if ($db->error) {
            throw new Exception ('Couldn\'t delete fuel. Fuel id: '.$this->id);
        }

    }

    /*
    *  Geteri i seteri
    */


    public function getMaker() {
        return $this->maker;
    }

    public function setMaker($maker) {
        $this->maker = $maker;
    }

    public function getGroup() {
        return $this->group;
    }

    public function setGroup($group) {
        $this->group = $group;
    }

    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function getType() {
        return $this->type;
    }

    public function getId() {
        return $this->id;
    }

    



}
?>
