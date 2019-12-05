<?php
    require '../../../vendor/autoload.php';
    Use eftec\bladeone\BladeOne;

    $views = __DIR__ . '/../../views';
    $cache = __DIR__ . '/../../cache';
    $blade = new BladeOne($views,$cache, BladeOne::MODE_AUTO);

    $year = date("Y");
    $date = date("H:i:s");

    echo $blade->run("layouts.head");
    echo $blade->run("layouts.header");
    echo $blade->run("pages.Start", array("date" => $date));
    echo $blade->run("layouts.footer", array("year" => $year));