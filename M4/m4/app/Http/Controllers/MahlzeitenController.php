<?php


namespace App\Http\Controllers;
require 'connection.php';
require __DIR__ . "/../../../vendor/autoload.php";
class MahlzeitenController extends Controller {

//    function getConnection() {
//
//
//        $dotenv = Dotenv\Dotenv::create(__DIR__ . '/../../../', '.env');
//        $dotenv->load();
//        $dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS','DB_PORT']);
//
//        $remoteConnection = mysqli_connect(
//            getenv('DB_HOST'),
//            getenv('DB_USER'),
//            getenv('DB_PASS'),
//            getenv('DB_NAME'),
//            (int)getenv('DB_PORT')
//        );
//
//        return $remoteConnection;
//    }

    function getMahlzeiten() {
        include  'connection.php';

        $this->database = $remoteConnection;

        $year = date("Y");

        if(isset($_GET['cat']) && $_GET['cat'] != "") {
            $cat = $_GET['cat'];
            $queryHeading = "SELECT Bezeichnung FROM Kategorien WHERE ID = ".$_GET['cat'];

            if($resultHeading = mysqli_query($this->database, $queryHeading)) {
                $heading = mysqli_fetch_assoc($resultHeading);
            }
        } else {
            $heading = "";
            $cat = "";
        }

        $queryCategories = "SELECT ID, Bezeichnung, hatKategorien AS general 
                        FROM Kategorien 
                        ORDER BY general";

        $categories = array();
        if($resultCategoeries = mysqli_query($this->database, $queryCategories)) {
            while($rowCategories = mysqli_fetch_assoc($resultCategoeries)) {
                array_push($categories, $rowCategories);
            }
        }

        if(isset($_GET['avail']) && $_GET['avail'] == 1) {
            $avail = 1;
        } else {
            $avail = 0;
        }
        if(isset($_GET['veggie'])) {
            $veggie = $_GET['veggie'];
        } else {
            $veggie = 0;
        }
        if(isset($_GET['vegan'])) {
            $vegan = $_GET['vegan'];
        } else {
            $vegan = 0;
        }

        if(!isset($_GET['avail'])) {
            $_GET['avail'] = '\'%\'';
        }
        if(!isset($_GET['limit'])) {
            $_GET['limit'] = 8;
        }
        if(!isset($_GET['cat']) || $_GET['cat'] == "") {
            $_GET['cat'] = '\'%\'';
        }

        if(isset($_GET['vegan']) && $_GET['vegan'] == 1 && !isset($_GET['veggie'])) {
            $indexName = "VeganIndex";
            $index = 0;
        } else if(isset($_GET['veggie']) && $_GET['veggie'] == 1 && !isset($_GET['vegan'])) {
            $indexName = "VeggieIndex";
            $index = 0;
        } else if(isset($_GET['vegan']) && $_GET['vegan'] == 1 && isset($_GET['veggie']) && $_GET['veggie'] == 1) {
            $indexName = "VeganIndex";
            $index = 0;
        } else {
            $indexName = "VeggieIndex";
            $index = '\'%\'';
        }

        $query = 'SELECT m.ID, m.Name, m.istIn, m.Verfuegbar,
                    (COUNT(z.ID) - SUM(z.Vegan)) AS VeganIndex,
                    (COUNT(z.ID) - SUM(z.Vegetarisch)) AS VeggieIndex,
                    b.ID AS BildID, b.`Alt-Text`, b.Titel, b.Binaerdaten
                    FROM Mahlzeiten AS m
                    LEFT JOIN enthaeltMZ eM ON m.ID = eM.IDMahlzeiten
                    LEFT JOIN Zutaten z on eM.IDZutaten = z.ID
                    LEFT JOIN hatMB hB ON m.ID = hB.IDMahlzeiten
                    LEFT JOIN Bilder AS b ON hB.IDBilder = b.ID
                    WHERE b.Titel LIKE \'%Preview\' AND m.Verfuegbar LIKE '.$_GET['avail'].' AND m.istIn LIKE '.$_GET['cat'].'
                    GROUP BY m.ID
                    HAVING '.$indexName.' LIKE '.$index.'
                    LIMIT '.$_GET['limit'];

        $meals = array();
        if($result = mysqli_query($this->database, $query)) {
            while($row = mysqli_fetch_assoc($result)) {
                array_push($meals, $row);
            }
        }

        return view("pages.Mahlzeiten", ["heading" => $heading, "categories" => $categories, "meals" => $meals, "cat" => $cat, "veggie" => $veggie, "vegan" => $vegan, "avail" => $avail, "year" => $year]);
    }
}
