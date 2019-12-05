<?php
    require '../../../vendor/autoload.php';
    Use eftec\bladeone\BladeOne;

    include '../includes/connection.php';

    $views = __DIR__ . '/../../views';
    $cache = __DIR__ . '/../../cache';
    $blade = new BladeOne($views,$cache, BladeOne::MODE_AUTO);

    $year = date("Y");

    if (isset($_POST['role'])) {
        $role = $_POST['role'];
    } else {
        $role = "";
    }

    if (isset($_POST['registered']) || isset($_POST['roleSelection'])) {
        if (isset($_POST['registered'])) {
            $registered = $_POST['registered'];

            if ($role == "Studenten") {
                $option1 = $_POST['studies'];
                $option2 = $_POST['matrikel'];
            } else if($role == "Mitarbeiter") {
                $option1 = $_POST['phone'];
                $option2 = $_POST['room'];
            } else {
                $option1 = $_POST['reason'];
                $option2 = $_POST['endDate'];
            }
        } else {
            $registered = "";
            $option2 = "";
            $option1 = "";
        }

        if(isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['birthday']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['username'])) {
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $birthday = $_POST['birthday'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $role = $_POST['role'];
            $username = $_POST['username'];

            $message = "";
        }
    } else {
        $registered = false;
        $firstName = "";
        $lastName = "";
        $birthday = "";
        $password = "";
        $email = "";
        $role = "";
        $username = "";
        $option1 = "";
        $option2 = "";

        $message = "";
    }

    echo $blade->run("layouts.head");
    echo $blade->run("layouts.header");
    echo $blade->run("pages.Registration", array("registered" => $registered, "firstName" => $firstName, "lastName" => $lastName,
        "birthday" => $birthday, "email" => $email, "password" => $password, "role" => $role, "username" => $username,
        "option1" => $option1, "option2" => $option2, "message" => $message));
    echo $blade->run("layouts.footer", array("year" => $year));

    function register($username, $email, $password, $firstName, $lastName, $birthday, $role, $option1, $option2, $remoteConnection) {
        if (checkUserExists($username, $email, $remoteConnection)) {
            echo "User already exists";
            return false;
        }

        $password = password_hash($password,PASSWORD_BCRYPT);

        $queryUser = "INSERT INTO Benutzer(`E-Mail`, Nutzername, Aktiv, Vorname, Nachname, Geburtsdatum, Hash) VALUES (".$email.", ".$username.", 1, ".$firstName.", ".$lastName.", ".$birthday.", ".$password.")";

        //get number + fh ange
        if($result = mysqli_query($remoteConnection, $queryUser)) {
            if($role == "Studenten") {
                $params = "Matrikelnummer, Studiengang";
            } else if($role == "Mitarbeiter") {
                $params = "Buero, Telefon";
            } else if($role == "Gaeste") {
                $params = "Ablaufdatum, Grund";
            } else {
                $params = "";
            }

            $queryRole = "INSERT INTO ".$role."(".$params.") VALUES (".$option2.", ".$option2.")";

            $message = "Sie haben sich erfolgreich registriert.";

            session_start();
            $_SESSION['loggedIn'] = true;
            $_SESSION['visited'] = true;
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['firstName'] = $firstName;
            $_SESSION['role'] = $role;

            return true;
        }

        $message = "Die Registrierung konnte nicht abgeschlossen werden.";
        return false;
    }

    function checkUserExists($username, $email, $remoteConnection) {
        $query = "SELECT * FROM Benutzer WHERE Nutzername = ".$username." OR `E-Mail` = ".$email;

        if($result = mysqli_query($remoteConnection, $query)) {
            while($row = mysqli_fetch_assoc($result)) {
                return true;
            }
        }
        return false;
    }


