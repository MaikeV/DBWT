<?php
    include '../includes/connection.php';

    require '../../../vendor/autoload.php';
    Use eftec\bladeone\BladeOne;



    $views = __DIR__ . '/../../views';
    $cache = __DIR__ . '/../../cache';
    $blade = new BladeOne($views,$cache, BladeOne::MODE_AUTO);



    echo $blade->run("layouts.head");
    echo $blade->run("layouts.header");
    echo $blade->run("pages.Mahlzeiten", array("heading" => $heading, "categories" => $categories, "meals" => $meals, "cat" => $cat, "veggie" => $veggie, "vegan" => $vegan, "avail" => $avail));
    echo $blade->run("layouts.footer", array("year" => $year));
