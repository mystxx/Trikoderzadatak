<?php


/**
 * Description of CarClass
 *
 * @author Hrvoje
 */
class Car extends Product {

    private $id=0;
    private $model="";
    private $make="";
    private $price=0;
    private $engineType=0;
    private $oilGroup=0;
    private $fuelGroup=0;
    private $image="";


    /*
    * Konstruktor prima ili asocijativni niz odnosno rezultat mysql_fetch_assoc() nakon upita bazi
    * ili ID automobila. U slučaju da je $info ID onda sam popuni vrijednosti objekta.
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
             * Postavlja privatne varijable na dobivene vrijednosti
             *
             * $info_array - assoc Array
             */

    protected function populate($info_array) {

        $this->id=$info_array['id'];
        $this->model=$info_array['carModel'];
        $this->make=$info_array['carMake'];
        $this->price=$info_array['carPrice'];
        $this->image=$info_array['carImage'];
        $this->engineType=$info_array['engineType'];
        $this->oilGroup=$info_array['oilGroupId'];
        $this->fuelGroup=$info_array['fuelGroupId'];


    }

    /*
    * Ažurira podatke automobila
    */

    public function update() {

        $this->DBConnection();
        $db=$this->db;

        $upd_array=Array (
            'carModel'=>$this->model,
            'carMake'=>$this->make,
            'carPrice'=>$this->price,
            'engineType'=>$this->engineType,
            'fuelGroupId'=>$this->fuelGroup,
            'oilGroupId'=>$this->oilGroup,
            'carImage'=>$this->image
        );

        $db->sql_update('cars', $upd_array, 'id='.$this->id);
        if ($db->error) {

            throw new Exception('Couldn\'t update car. Id: '.$this->id);

        }

    }

    /*
    * Briše dani automobili iz baze
    */

    public function delete() {

        $this->DBConnection();
        $db=$this->db;

        $db->sql_delete('cars', 'id='.$this->id);

        if ($db->error) {
            throw new Exception ('Couldn\'t delete car. Car id: '.$this->id);
        }

    }


    /*
    *
    * Seteri i geteri
    *
    * */

    public function getModel() {
        return $this->model;
    }

    public function setModel($model) {
        $this->model = $model;
    }

    public function getMake() {
        return $this->make;
    }

    public function setMake($make) {
        $this->make = $make;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function getEngineType() {
        return $this->engineType;
    }

    public function setEngineType($engineType) {
        $this->engineType = $engineType;
    }

    public function getOilGroup() {
        return $this->oilGroup;
    }

    public function setOilGroup($oilGroup) {
        $this->oilGroup = $oilGroup;
    }

    public function getFuelGroup() {
        return $this->fuelGroup;
    }

    public function setFuelGroup($fuelGroup) {
        $this->fuelGroup = $fuelGroup;
    }

    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function getId() {
        return $this->id;
    }



}
?>
