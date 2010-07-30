<?php

/**
 * Description of Oil
 *
 * @author Hrvoje Gorajscan
 */


class Oil extends Product {

    private $id=0;
    private $name="";
    private $group=0;
    private $image="";
    private $price=0;



    /*
    *
    * Konstruktor prima ili asocijativni niz odnosno rezultat mysql_fetch_assoc() nakon upita bazi
    * ili ID ulja. U slučaju da je $info ID onda sam popuni vrijednosti objekta.
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
            $res=$db->sql_select('*', 'cars','id='.$info);

            if (!$db->error) {

                $this->populate($res);

            }

        }

    }

   /*
    *
    * Postavlja privatne varijable na dobivene vrijednosti
    *
    * $info_array - assoc Array
    */

    protected function populate($info_array) {

        $this->id=$info_array['id'];
        $this->name=$info_array['oilName'];
        $this->group=$info_array['oilGroup'];
        $this->image=$info_array['oilImage'];
        $this->price=$info_array['oilPrice'];
        $this->type=$info_array['oilType'];


    }

    /*
    * Ažurira podatke ulja
    */



    public function update() {

        $this->DBConnection();//from Product class
        $db=$this->db;

        $upd_array=Array (
            'oilName'=>$this->name,
            'oilGroup'=>$this->group,
            'oilImage'=>$this->image,
            'oilPrice'=>$this->price
        );

        $db->sql_update('oil', $upd_array, 'id='.$this->id);
        if ($db->error) {

            throw new Exception('Couldn\'t update Oil. Oil id: '.$this->id);

        }

    }

    /*
    * Briše dano ulje iz baze (s krpicom)
    */


    public function delete() {

        $this->DBConnection();
        $db=$this->db;

        $db->sql_delete('oil', 'id='.$this->id);

        if ($db->error) {
            throw new Exception ('Couldn\'t delete oil. Oil id: '.$this->id);
        }

    }


    /*
    * Geteri i seteri
    */

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
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
