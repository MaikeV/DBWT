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

    $errors = array();

    $fields = array();
    $queryFields = "SELECT ID, Name FROM Fachbereiche";

    if ($resultFields = mysqli_query($remoteConnection, $queryFields)) {
        while($rowFields = mysqli_fetch_assoc($resultFields)) {
            array_push($fields, $rowFields);
        }
    }

    if (isset($_POST['registered']) || isset($_POST['roleSelection'])) {
        if (isset($_POST['registered'])) {
            $registered = $_POST['registered'];

            if ($role == "Studenten") {
                $option1 = $_POST['studies'];
                $option2 = $_POST['matrikel'];
                $fieldNum = $_POST['field'];
            } else if($role == "Mitarbeiter") {
                $option1 = $_POST['phone'];
                $option2 = $_POST['room'];
                $fieldNum = $_POST['field'];
            } else if($role == "Gaeste"){
                $option1 = $_POST['reason'];
                $option2 = $_POST['endDate'];
                $fieldNum = "";
            } else {
                $option1 = "";
                $option2 = "";
                $fieldNum = "";
            }
        } else {
            $registered = false;
            $option1 = "";
            $option2 = "";
            $fieldNum = "";
        }

        if(isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['birthday']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['username'])) {
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $birthday = $_POST['birthday'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $username = $_POST['username'];
            $studies = "";
            $phone = "";
            $room = "";
            $reason = "";
            $endDate = "";
            $matrikel = "";
            $message = "";
        } else {
            $studies = "";
            $phone = "";
            $room = "";
            $reason = "";
            $endDate = "";
            $matrikel = "";
            $fieldNum = "";
            $option1 = "";
            $option2 = "";
            $message = "";
        }
    } else {
        $registered = false;

        $studies = "";
        $phone = "";
        $room = "";
        $reason = "";
        $endDate = "";
        $matrikel = "";
        $registered = "";
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
    //echo $blade->run("pages.Registration", array("registered" => $registered, "firstName" => $firstName, "lastName" => $lastName,
    //    "birthday" => $birthday, "email" => $email, "password" => $password, "role" => $role, "username" => $username,
    //    "option1" => $option1, "option2" => $option2, "message" => $message));
    echo $blade->run("RegistrationChild", array("registered" => $registered, "firstName" => $firstName, "lastName" => $lastName,
        "birthday" => $birthday, "email" => $email, "password" => $password, "role" => $role, "username" => $username,
        "option1" => $option1, "option2" => $option2, "studies" => $studies, "phone" => $phone, "matrikel" => $matrikel, "room" => $room,
        "reason" => $reason, "endDate" => $endDate, "fields" => $fields, "fieldNum" => $fieldNum, "message" => $message, "errors" => $errors, "remoteConnection" => $remoteConnection));
    echo $blade->run("layouts.footer", array("year" => $year));

    function register($username, $email, $password, $firstName, $lastName, $birthday, $role, $option1, $option2, $errors, &$message, $fieldNum, $remoteConnection) {
        if (checkUserExists($username, $errors, $remoteConnection) || checkEmailExists($email, $errors, $remoteConnection)) {
            $message = "Die Registrierung konnte nicht abgeschlossen werden. Bitte Ueberpruefen Sie Ihre Eingaben";
            return false;
        }

        $password = password_hash($password,PASSWORD_BCRYPT);

        $queryUser = "INSERT INTO Benutzer(`E-Mail`, Nutzername, Aktiv, Vorname, Nachname, Geburtsdatum, Hash) VALUES (".$email.", ".$username.", 1, ".$firstName.", ".$lastName.", ".$birthday.", ".$password.")";
        $usernum = getUserNum($username, $remoteConnection);

        if($result = mysqli_query($remoteConnection, $queryUser) && $usernum != "") {
            if($role == "Studenten") {
                $params = "Matrikelnummer, Studiengang";

                addToFH($usernum, $remoteConnection);
                addToField($fieldNum, $usernum, $remoteConnection);
            } else if($role == "Mitarbeiter") {
                $params = "Buero, Telefon";

                addToFH($usernum, $remoteConnection);
                addToField($fieldNum, $usernum, $remoteConnection);
            } else if($role == "Gaeste") {
                $params = "Ablaufdatum, Grund";
            } else {
                return false;
            }

            $queryRole = "INSERT INTO ".$role."(".$params.") VALUES (".$option2.", ".$option1.")";

            echo $queryRole;

            if (!mysqli_query($remoteConnection, $queryRole)) {
                echo "Error: " . $queryRole . "<br>" . mysqli_error($remoteConnection);
            }

            $message = "Sie haben sich erfolgreich registriert.";

            session_start();
            $_SESSION['loggedIn'] = true;
            $_SESSION['visited'] = true;
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['firstName'] = $firstName;
            $_SESSION['role'] = $role;

            $queryUpdateLogin = "UPDATE Benutzer SET LetzterLogin = NOW() WHERE Nutzername = '".$_POST['username']."'";
            mysqli_query($remoteConnection, $queryUpdateLogin);

            return true;
        }

        $message = "Die Registrierung konnte nicht abgeschlossen werden.";
        return false;
    }

    function addToFH($usernum, $remoteConnection) {
        $queryFH = "INSERT INTO FH_Angehoerige(Nummer) VALUES (".$usernum.")";

        if(!mysqli_query($remoteConnection, $queryFH)) {
            echo "Error: " . $queryFH . "<br>" . mysqli_error($remoteConnection);
        }
    }

    function addToField($fieldNum, $usernum, $remoteConnection) {
        $queryInsertField = "INSERT INTO gehoertZu(IDFachbereich, NummerBenutzer) VALUES (".$fieldNum.", ".$usernum.")";

        if(!mysqli_query($remoteConnection, $queryInsertField)){
            echo "Error: " . $queryInsertField . "<br>" . mysqli_error($remoteConnection);
        }
    }

    function getUserNum($username, $remoteConnection) {
        $queryGetNum = "SELECT Nummer FROM Benutzer WHERE Nutzername = ".$username;

        if($resultGetNum = mysqli_query($remoteConnection, $queryGetNum)) {
            return mysqli_fetch_assoc($resultGetNum);
        } else return "";
    }

    function checkUserExists($username, $errors, $remoteConnection) {
        $query = "SELECT * FROM Benutzer WHERE Nutzername = ".$username;

        if($result = mysqli_query($remoteConnection, $query)) {
            while($row = mysqli_fetch_assoc($result)) {
                array_push($errors, "Nutzername schon vergeben");
                return true;
            }
        }
        return false;
    }

    function checkEmailExists($email, $errors, $remoteConnection) {
        $query = "SELECT * FROM Benutzer WHERE `E-Mail` = ".$email;

        if($result = mysqli_query($remoteConnection, $query)) {
            while($row = mysqli_fetch_assoc($result)) {
                array_push($errors, "Es existiert bereits ein Benutzer mit der angegebenen Mail-Adresse");
                return true;
            }
        }
        return false;
    }