<?php

    function register($post, $remoteConnection) {
        if (checkUserExists($post['username'], $post['email'], $remoteConnection)) {
            echo "User already exists";
            return false;
        }

        $password = password_hash($post['password'],PASSWORD_BCRYPT);

        $queryUser = "INSERT INTO Benutzer(`E-Mail`, Nutzername, Aktiv, Vorname, Nachname, Geburtsdatum, Hash) VALUES (".$post['email'].", ".$post['username'].", 1, ".$post['firstName'].", ".$post['lastName'].", ".$post['birthday'].", ".$password.")";

        if($result = mysqli_query($remoteConnection, $queryUser)) {
            if($post['role'] == "Studenten") {
                $params = "Matrikelnummer, Studiengang";
            } else if($post['role'] == "Mitarbeiter") {
                $params = "Buero, Telefon";
            } else if($post['role'] == "Gaeste") {
                $params = "Grund, Ablaufdatum";
            } else {
                $params = "";
            }
            $queryRole = "INSERT INTO ".$post['role']."(".$params.")";

            echo "Sie haben sich erfolgreich registriert.";
            return true;
        }

        echo "Die Registrierung konnte nicht abgeschlossen werden.";
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