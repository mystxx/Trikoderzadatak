<?php

include ("SQL.Class.php");
include ('Product.Class.php');
include ('Car.Class.php');
include ('Oil.Class.php');
include ('Fuel.Class.php');

error_reporting(0);

if (!isset($_GET)){

$_GET['car_id']=0;

};


foreach ($_GET as $key => $val) {

    if (!ctype_digit(trim($val))){

        $_GET[$key]=0;

        }
    }

$car_id=$_GET['car_id'];
$oil_id=$_GET['oil_id'];
$fuel_id=$_GET['fuel_id'];

$db=new SQL();

try {

    $db->connect('root', 'root', 'localhost', 'trikoder', 'MYSQL');
}
catch (Exception $e) {

    die("Error: ".$e->getMessage());
    

}


if ($car_id=="" && $fuel_id=="" && $oil_id=="") {

    $res=$db->sql_select('*', 'cars');

    while ($row=mysql_fetch_assoc($res)) {

        $cars[]=new Car($row);

    }

   $res=$db->sql_select('oil.*,oilgroup.oilType', 'oil,oilgroup', 'oilgroup.id=oil.oilGroup');

    while ($row=mysql_fetch_assoc($res)) {

        $oils[]=new Oil($row);

    }

    $res=$db->sql_select('fuel.*,fuelgroup.fuelType', 'fuel,fuelgroup', 'fuelgroup.id=fuel.fuelGroup');

    while ($row=mysql_fetch_assoc($res)) {

        $fuels[]=new Fuel($row);

    }


}
else {

    if ($car_id!="") {

        $res=$db->sql_select('*', 'cars', 'id='.$car_id);

        $row=mysql_fetch_assoc($res);

        if ($db->rows > 0){

        $cars[]=new Car($row);



        $res=$db->sql_select('oil.*,oilgroup.oilType', 'oil,oilgroup', 'oilgroup.id=oil.oilGroup AND oilGroup='.$cars[0]->getOilGroup());

        while ($row=mysql_fetch_assoc($res)) {
            $oils[]=new Oil($row);
        }

        $res=$db->sql_select('fuel.*,fuelgroup.fuelType', 'fuel,fuelgroup', 'fuelgroup.id=fuel.fuelGroup AND fuelGroup='.$cars[0]->getFuelGroup());

        while ($row=mysql_fetch_assoc($res)) {
            $fuels[]=new Fuel($row);
        }
    }
    }


    /*
    * Ako imamo samo id ulja onda ne trebamo gorivo s obzirom da je gorivo vezano uz jedan automobil.
    */
    if ($oil_id!="") {

        $res=$db->sql_select('oil.*,oilgroup.oilType', 'oil,oilgroup', 'oilgroup.id=oil.oilGroup AND oil.id='.$oil_id);

        if ($db->rows > 0){
        $row=mysql_fetch_assoc($res);

        $oils[]=new Oil($row);

        $res=$db->sql_select('*', 'cars', 'oilGroupId='.$row['oilGroup']);

        while ($row=mysql_fetch_assoc($res)) {

            $cars[]=new Car($row);

        }
        }
    }

    /*
    * Ako imamo samo id goriva onda ne trebamo ulje s obzirom da je ulje vezano uz jedan automobil.
    */


    if ($fuel_id!="") {

        $res=$db->sql_select('fuel.*,fuelgroup.fuelType', 'fuel,fuelgroup', 'fuelgroup.id=fuel.fuelGroup AND fuel.id='.$fuel_id);

        if ($db->rows > 0){

        $row=mysql_fetch_assoc($res);

        $fuels[]=new Fuel($row);

        $res=$db->sql_select('*', 'cars', 'fuelGroupId='.$row['fuelGroup']);

        while ($row=mysql_fetch_assoc($res)) {

            $cars[]=new Car($row);

        }
        
        }

    }


}



?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Trikoder Zadatak</title>
        <link type="text/css" rel="stylesheet" href="style.css" >

    </head>
    <body>

        <div class="left">

            <?php

            if (count($cars)>0) {

                foreach ($cars as $key => $CarObj) {

        ?>
            <div class="proizvod">

                <div class="slika">
                    <img src="<?php echo $CarObj->getImage();?>" width="100" height="100" border="0" alt="">
                </div>

                <div class="info">

                    <table>
                    <tr><td colspan="2"><a href="?car_id=<?php echo $CarObj->getId();?>" > <?php echo $CarObj->getMake()." ".$CarObj->getModel();?></a></td></tr>
                    <tr><td>Cijena</td><td><?php echo number_format($CarObj->getPrice(),2,",",".");?></td></tr>
                    </table>

                </div>

            </div>
        <?php
    }

}
?>

            <span><a href="?index.php">Svi proizvodi</a></span>

            <div class="bottom">

                <div style="width:100%;text-align:center;">Preporučena goriva</div>

                <?php
                if (count($fuels)>0) {

                foreach ($fuels as $key => $FuelObj) {

                ?>

                <div class="fuel">

                    <div class="slikica">
                        <a href="?fuel_id=<?php echo $FuelObj->getId();?>"> <img src="<?php  echo $FuelObj->getImage();?>" width="100" height="100" border="0" alt=""></a>
                    </div>

                    <br>
                    
                    <div>

                        <table width="100%">
                            <tr><td>Proizvođač</td><td><?php echo $FuelObj->getMaker();?></td></tr>
                            <tr><td>Tip</td><td><?php echo $FuelObj->getType();?></td></tr>
                            <tr><td>Cijena</td><td><?php echo $FuelObj->getPrice();?></td></tr>
                        </table>

                    </div>

                </div>
        <?php
    }


            }
            else {
                echo "Nema preporučenih goriva ili izaberite automobil.";
            }
            ?>
            </div>

        </div>

        <div class="right">
            <span>Preporučena ulja</span>

<?php

if (count($oils)>0) {

    foreach ($oils as $key => $OilObj) {

        ?>

            <div class="oil">

                <div class="slikica">

                    <a href="?oil_id=<?php echo $OilObj->getId();?>"> <img src="<?php  echo $OilObj->getImage();?>" width="100" height="100" border="0" alt=""></a>

                </div>

                <br>

                <div>
                    <table width="100%">
                        <tr><td>Ime</td><td><?php echo $OilObj->getName();?></td></tr>
                        <tr><td>Tip</td><td><?php echo $OilObj->getType();?></td></tr>
                        <tr><td>Cijena</td><td><?php echo $OilObj->getPrice();?></td></tr>
                    </table>

                </div>
            </div>

        <?php

    }
    
}
else {
    echo "<br>Nema preporučenih ulja ili izaberite automobil.";
}

?>

        </div>

    </body>
</html>
