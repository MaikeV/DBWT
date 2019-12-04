<?php
    include '../includes/connection.php';

    require '../../../vendor/autoload.php';
    Use eftec\bladeone\BladeOne;

    include '../includes/connection.php';

    $views = __DIR__ . '/../../views';
    $cache = __DIR__ . '/../../cache';
    $blade = new BladeOne($views,$cache, BladeOne::MODE_AUTO);

    $year = date("Y");

    if(isset($_GET['cat']) && $_GET['cat'] != "") {
        $cat = $_GET['cat'];
        $queryHeading = "SELECT Bezeichnung FROM Kategorien WHERE ID = ".$_GET['cat'];

        if($resultHeading = mysqli_query($remoteConnection, $queryHeading)) {
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
    if($resultCategoeries = mysqli_query(@$remoteConnection, $queryCategories)) {
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
    if($result = mysqli_query($remoteConnection, $query)) {
        while($row = mysqli_fetch_assoc($result)) {
            array_push($meals, $row);
        }
    }

    echo $blade->run("layouts.head");
    echo $blade->run("layouts.header");
    echo $blade->run("pages.Mahlzeiten", array("heading" => $heading, "categories" => $categories, "meals" => $meals, "cat" => $cat, "veggie" => $veggie, "vegan" => $vegan, "avail" => $avail));
    echo $blade->run("layouts.footer", array("year" => $year));