<?php
    require '../../../vendor/autoload.php';
    Use eftec\bladeone\BladeOne;

    include '../includes/connection.php';

    $views = __DIR__ . '/../../views';
    $cache = __DIR__ . '/../../cache';
    $blade = new BladeOne($views,$cache, BladeOne::MODE_AUTO);


    echo $blade->run('layouts.head');
    echo $blade->run('layouts.header');
    echo $blade->run('loginChild', array("loggedIn" => $loggedIn, "role" => $role, "visited" => $visited, "username" => $username));
    echo $blade->run('layouts.footer', array("year" => $year));
