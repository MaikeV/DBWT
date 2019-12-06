<?php
    require '../../../vendor/autoload.php';
    Use eftec\bladeone\BladeOne;

    include '../includes/connection.php';
    include '../includes/auth.php';

    $views = __DIR__ . '/../../views';
    $cache = __DIR__ . '/../../cache';
    $blade = new BladeOne($views,$cache, BladeOne::MODE_AUTO);

    session_start();

    $year = date("Y");

    echo $blade->run('layouts.head');
    echo $blade->run('layouts.header');
    echo $blade->run('loginChild', array());
    echo $blade->run('layouts.footer', array("year" => $year));