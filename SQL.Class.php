<?php
/**
 * Description of SQLClass
 *
 * @author Hrvoje G
 */


if (!defined("SQL_CLASS")) {
    define ("SQL_CLASS","sql.class.php");



    class SQL {

        var $error=false;
        var $rows;
        var $last_id;
        var $db_link;
        var $query;
        var $db_type="MYSQL";
        var $current_query;


        /*
        * $link - link na bazu ukoliko već postoji odnosno spajanje je složeno izvana
        * $db_type - tip baze, nije implementirano ništa osim MySQL
        * $db na link
        */
        public function link ($link="",$db_type="MYSQL") {

            if (!$link) {

                throw new Exception ("Database link error");

            }
            else {

                $this->db_link=$link;
            }

            $this->db_type=$db_type;

        }

        /*
        * Spajanje na bazu ukoliko link ne postoji izvana
        *
        *  $db_username - korisničko ime za bazu
        *  $db_password - lozinka
        *  $db_server - adresa servera
        *  $db_name - ime baze
        *  $db_type - tip - MYSQL trenutno implementiran
        */

        function connect ($db_username,$db_password,$db_server,$db_name,$db_type) {

            if ($db_type=="MYSQL") {

                $this->db_link=mysql_connect($db_server, $db_username, $db_password);

                if (!$this->db_link) {

                    throw new Exception('Couldn\'t connect to database.');

                    $this->error=mysql_error();

                }

                mysql_select_db($db_name);

            }
        }


        /*
        * Select iz baze - uzima podatke iz baze
        *  $what - koje atribute da uzmem (npr. *)
        *  $table - ime tablice
        *  $where - uvjet ako postoji
        *  $order - redoslijed ako postoji
        *  $limit - granica ako postoji
        *  $db_link - drugi link ako postoji
        *  $debug - ispisivanje debug poruka
        *
        */


        function sql_select ($what,$table,$where="",$order="",$limit="",$db_link="",$debug=0) {


            $q_where="";
            $q_order="";
            $q_limit="";

            if ($this->db_type=="MYSQL") {

                if ($where!="") {
                    $q_where="WHERE $where";
                }

                if ($order!="") {
                    $q_order="ORDER BY $order";
                }

                if ($limit!="") {
                    $q_limit="LIMIT $limit";
                }

                $queryText="SELECT $what FROM $table $q_where $q_order $q_limit";

                $this->current_query=$queryText;

                if ($debug) {
                    echo "Debug: <br>\n $query <br> /n -------------------------------------<br>";

                }

                $query=mysql_query($queryText);

                if ($tmp=mysql_error()!="") {

                    $this->error=$tmp.$_SERVER["SCRIPT_FILENAME"];

                    echo "<br><font color=\"green\">Database error occured:<br>";
                    echo "In script: ".$_SERVER["SCRIPT_FILENAME"]."<br>";
                    echo "Error: ".mysql_error()."<br></font><br>";

                    return false;
                }
                else {
                    $this->error=false;
                    $this->rows=mysql_num_rows($query);

                    $this->query=$query;
                    return $query;
                }


            }


        }//fend sql_select


        /*
        *
        *  Ažurira podatke u bazi
        *  $table - ime tablice
        *  $set - Array() - parovi ključeva i vrijednosti koje treba ažurirati
        *  $where - uvjet
        *  $db_link - link
        */

        function sql_update ($table,$set,$where,$db_link="") { //$set is an Array


            if ($this->db_type=="MYSQL") {

                if ($where!="") {
                    $q_where="WHERE $where";
                }

                foreach ($set as $key => $val) {
                    if (stristr($val,"()")) {
                        $new_array[]="$key=$val";
                    }
                    else {
                        $new_array[]="$key='$val'";
                    }


                }

                $q_set=implode(",",$new_array);
                $query=mysql_query("UPDATE $table SET $q_set $q_where");

                if ($tmp=mysql_error()!="") {
                    $this->error=$tmp.'<br>\n'.$_SERVER["REQUEST_URI"];
                    return false;
                }
                else {
                    $this->error=false;
                    $this->query=$query;
                    return true;
                }


            }

            return false;
        }

        /*
        *
        * Ubacuje podatke u bazu
        * $table - ime tablice
        * $what - što da ubacim - Array - parovi ključeva i vrijednosti
        * $db_link - link
        */

        function sql_insert ($table,$what,$db_link="") { //$what is an Array



            if ($this->db_type=="MYSQL") {


                foreach ($what as $key => $val) {
                    $keys[]=$key;

                    if (stristr($val,"()")) { //Fix for CURDATE() and CURTIME()
                        $vals[]="".$val."";
                    }
                    else {
                        $vals[]="'".$val."'";
                    }

                }

                $q_fields="(".implode(",",$keys).")";
                $q_values="(".implode(",",$vals).")";





                $query=mysql_query("INSERT INTO $table $q_fields VALUES $q_values");
                echo mysql_error();

                if (($tmp=mysql_error())!="") {
                    $this->error=$tmp.$_SERVER["REQUEST_URI"];
                    return false;
                }
                else {
                    $this->last_id=mysql_insert_id();
                    $this->query=$query;
                    return true;
                }


            }

            return false;
        }

        /*
        * Briše podatke iz baze
        * $table - tablica
        * $where - uvjet
        * $db_link - link
        */

        function sql_delete ($table,$where,$db_link="") {


            if ($this->db_type=="MYSQL") {


                if ($where!="") {
                    $q_where="WHERE $where";
                }


                $query=mysql_query("DELETE FROM $table $q_where");

                if ($tmp=mysql_error()!="") {

                    $this->error=$tmp.$_SERVER["REQUEST_URI"];
                }
                else {
                    $this->error=false;
                    $this->query=$query;
                    return true;
                }


            }
            return false;
        }

        /*
        * Vraća broj redaka koje je vratio zadnji query
        */

        function countrows($resource="") {
            return mysql_num_rows($this->query);
        }


        /*
        * Vraća rezultat u asocijativnom obliku
        *
        *
        */

        function sql_f_a($resource="") {
            echo "Running function <br>";
            if ($resource=="") {
                $resource=$this->query;
            }

            if ($db_type=="MYSQL") {
                $tmp=mysql_fetch_assoc($resource);
                echo mysql_error();
                return $tmp;
            }
        }


        /*
        * Mijenja retke.
        * $id - redak kojeg treba zamijeniti
        * $id_name - ime tog retka
        * $table - tablica
        * $direction - UP ili DOWN
        * *** NOTE *** Za tablice s manje od 1M redaka
        */

        function switch_rows($id,$id_name,$table,$direction) {

            if ($this->db_type=="MYSQL") {

                if ($direction=="up") {
                    $dbl=$this->sql_select($id_name,$table,"$id_name < $id","$id_name DESC","1");
                }
                else {
                    $dbl=$this->sql_select($id_name,$table,"$id_name > $id","$id_name ASC","1");
                }



                if (mysql_num_rows($dbl)==0) {
                    return 0;
                }


                $row=mysql_fetch_assoc($dbl);
                $id_to_switch=$row[$id_name];


                $this->sql_update($table,Array($id_name=>'999999'),"$id_name='$id_to_switch'");
                $this->sql_update($table,Array($id_name=>$id_to_switch),"$id_name='$id'");
                $this->sql_update($table,Array($id_name=>$id),"$id_name='999999'");

                return 1;
            }
            return 1;
        }






    }//end class sql


}//ifndef


