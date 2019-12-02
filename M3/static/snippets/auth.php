<?php
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $query = "SELECT * FROM Benutzer b 
                    LEFT JOIN FH_Angehoerige FA ON b.Nummer = FA.Nummer 
                    LEFT JOIN Mitarbeiter m ON FA.Nummer = m.Nummer 
                    LEFT JOIN Studenten s ON FA.Nummer = s.Nummer
                    LEFT JOIN Gaeste g on b.Nummer = g.Nummer
                    WHERE Nutzername = ".$_POST['username'];

        if($result = mysqli_query($remoteConnection, $query)) {
            if($row = mysqli_fetch_assoc($result)) {
                if(password_verify($_POST['password'], $row['Hash'])) {
                    session_start();
                    $_SESSION['username'] = $_POST['username'];
                    $_SESSION['loggedIn'] = true;

                    if($row['g.Nummer'] == $row['b.Nummer']) {
                        $_SESSION['role'] = "Gast";
                    } else if($row['FA.Nummer'] == $row['b.Nummer']) {
                        if($row['FA.Nummer'] == $row['m.Nummer']) {
                            $_SESSION['role'] = "Mitarbeiter";
                        } else {
                            $_SESSION['role'] = "Student";
                        }
                    }

                } else {

                }
            }
        }
    }

    function getLoginFeedback() {
        if ($_SESSION['loggedIn']) {
            return true;
        } else {
            return false;
        }
    }
