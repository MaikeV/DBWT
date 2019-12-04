<?php
    require '../../../vendor/autoload.php';
    Use eftec\bladeone\BladeOne;

    include '../includes/connection.php';

    $views = __DIR__ . '/../../views';
    $cache = __DIR__ . '/../../cache';
    $blade = new BladeOne($views,$cache, BladeOne::MODE_AUTO);

    $count = "SELECT COUNT(*) count FROM Zutaten";
    if ($resultCount = mysqli_query($remoteConnection, $count)) {
        $rowCount = mysqli_fetch_assoc($resultCount);
    }

    $ingredientsCount = $rowCount;

    $queryIngredientsAll = "SELECT * FROM Zutaten ORDER BY Bio DESC , Name";
    $allIngredients = array();
    if($resultIngredientsAll = mysqli_query($remoteConnection, $queryIngredientsAll)) {
        while($rowIngredientsAll = mysqli_fetch_assoc($resultIngredientsAll)) {
            array_push($allIngredients, $rowIngredientsAll);
        }
    }

    $year = date('Y');

    echo $blade->run("layouts.head");
    echo $blade->run("layouts.header");
    echo $blade->run("pages.Zutatenliste", array("ingredientsCount" => $ingredientsCount, "allIngredients" => $allIngredients));
    echo $blade->run("layouts.footer", array("year" => $year));

    mysqli_close($remoteConnection);

