<?php
    $_SESSION['visited'] = true;
    if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['function']) && $_POST['function'] == "login") {
        $queryLogin = "SELECT b.Nummer AS UserNum, b.Nutzername, b.Hash, b.Vorname
                            FROM Benutzer b 
                            WHERE Nutzername = '".$_POST['username']."'";

        $queryRole = "SELECT `Role` FROM getRole WHERE Nutzername = '".$_POST['username']."'";

        if($resultLogin = mysqli_query($remoteConnection, $queryLogin) and $resultRole = mysqli_query($remoteConnection, $queryRole)) {
            if($rowLogin = mysqli_fetch_assoc($resultLogin) and $rowRole = mysqli_fetch_assoc($resultRole)) {
                if (password_verify($_POST['password'], $rowLogin['Hash'])) {
                    $_SESSION['username'] = $_POST['username'];
                    $_SESSION['firstName'] = $rowLogin['Vorname'];
                    $_SESSION['loggedIn'] = true;
                    $_SESSION['role'] = $rowRole['Role'];
                } else {
                    $_SESSION['loggedIn'] = false;
                }
            } else {
                $_SESSION['loggedIn'] = false;
            }
        } else {
            $_SESSION['loggedIn'] = false;
        }

        $queryUpdateLogin = "UPDATE Benutzer SET LetzterLogin = NOW() WHERE Nutzername = '".$_POST['username']."'";
        mysqli_query($remoteConnection, $queryUpdateLogin);

        header("Refresh:0");
    } else if (!empty($_POST['function']) && $_POST['function'] == "logout") {
        $_SESSION['username'] = "";
        $_SESSION['loggedIn'] = false;
        session_destroy();
        header("Refresh:0");
    }