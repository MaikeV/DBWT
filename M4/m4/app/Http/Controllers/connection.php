<?php

    require __DIR__ . "/../../../vendor/autoload.php";

    $dotenv = Dotenv\Dotenv::create(__DIR__ . '/../../../', '.env');
    $dotenv->load();
    $dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS','DB_PORT']);

    $remoteConnection = mysqli_connect(
        getenv('DB_HOST'),
        getenv('DB_USER'),
        getenv('DB_PASS'),
        getenv('DB_NAME'),
        (int)getenv('DB_PORT')
    );


