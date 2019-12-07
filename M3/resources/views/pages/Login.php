<?php
    require '../../../vendor/autoload.php';
    Use eftec\bladeone\BladeOne;

    include '../includes/connection.php';
    
    $views = __DIR__ . '/../../views';
    $cache = __DIR__ . '/../../cache';
    $blade = new BladeOne($views,$cache, BladeOne::MODE_AUTO);

    session_start();

    include '../includes/auth.php';

    if (isset($_SESSION['role']) && isset($_SESSION['loggedIn']) && isset($_SESSION['visited']) && isset($_SESSION['username'])) {
        $loggedIn = $_SESSION['loggedIn'];
        $role = $_SESSION['role'];
        $visited = $_SESSION['visited'];
        $username = $_SESSION['username'];
    } else {
        $loggedIn = "";
        $role = "";
        $visited = "";
        $username = "";
    }

    $year = date("Y");

    echo $blade->run('layouts.head');
    echo $blade->run('layouts.header');
    echo $blade->run('loginChild', array("loggedIn" => $loggedIn, "role" => $role, "visited" => $visited, "username" => $username));
    echo $blade->run('layouts.footer', array("year" => $year));