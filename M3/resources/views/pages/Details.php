<?php
    require '../../../vendor/autoload.php';
    Use eftec\bladeone\BladeOne;

    include '../includes/connection.php';

    $views = __DIR__ . '/../../views';
    $cache = __DIR__ . '/../../cache';
    $blade = new BladeOne($views,$cache, BladeOne::MODE_AUTO);

    session_start();

    include '../includes/auth.php';

    $year = date("Y");

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

    if (isset($_GET['id'])) {
        $query = 'SELECT * FROM Mahlzeiten m 
                        LEFT JOIN hatMB hM on m.ID = hM.IDMahlzeiten 
                        LEFT JOIN Bilder B on hM.IDBilder = B.ID 
                        LEFT JOIN Preise P on m.ID = P.ID
                        HAVING B.Titel LIKE \'%Detail%\' AND m.ID LIKE '.$_GET['id'];

        if($result = mysqli_query($remoteConnection, $query)) {
            $meal = mysqli_fetch_assoc($result);
        } else {
            $meal = "";
            redirToMahlzeiten($remoteConnection);
        }
    } else {
        $meal = "";
        redirToMahlzeiten($remoteConnection);
    }

    $ingredientsIDQuery = 'SELECT IDZutaten, Z.Name FROM enthaeltMZ 
                                LEFT JOIN Mahlzeiten ON enthaeltMZ.IDMahlzeiten = Mahlzeiten.ID
                                LEFT JOIN Zutaten Z on enthaeltMZ.IDZutaten = Z.ID
                                WHERE IDMahlzeiten LIKE '.$_GET['id'];
    $ingredients = array();
    if($ingredientsIDResult = mysqli_query($remoteConnection, $ingredientsIDQuery)) {
        while ($ingredientsIDRow = mysqli_fetch_assoc($ingredientsIDResult)) {
            array_push($ingredients, $ingredientsIDRow);
        }
    }

    $queryAllMeals = "SELECT Name FROM Mahlzeiten";

    $allMeals = array();
    if ($resultAllMeals = mysqli_query($remoteConnection, $queryAllMeals))
        array_push($allMeals, mysqli_fetch_assoc($resultAllMeals));

    function redirToMahlzeiten($remoteConnection) {
        echo 'Invalid ID: Redirecting to Mahlzeiten';
        sleep(3);
        header("Location: http://127.0.0.1/DBWT/M3/static/Mahlzeiten.php");
        mysqli_close($remoteConnection);
        exit();
    }

    echo $blade->run('layouts.head');
    echo $blade->run('layouts.header');
    echo $blade->run('loginChild', array("meal" => $meal, "ingredients" => $ingredients, "allMeals" => $allMeals, "loggedIn" => $loggedIn, "role" => $role, "visited" => $visited, "username" => $username));
    echo $blade->run('layouts.footer', array("year" => $year));

