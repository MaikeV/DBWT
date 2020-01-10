<?php
    include  'connection.php';

    session()->put('visited', true);

    if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['function']) && $_POST['function'] == "login") {
        $queryLogin = "SELECT b.Nummer AS UserNum, b.Nutzername, b.Hash, b.Vorname
                            FROM Benutzer b 
                            WHERE Nutzername = '".$_POST['username']."'";

        $queryRole = "SELECT `Role` FROM getRole WHERE Nutzername = '".$_POST['username']."'";

        if($resultLogin = mysqli_query($remoteConnection, $queryLogin) and $resultRole = mysqli_query($remoteConnection, $queryRole)) {
            if($rowLogin = mysqli_fetch_assoc($resultLogin) and $rowRole = mysqli_fetch_assoc($resultRole)) {
                if (password_verify($_POST['password'], $rowLogin['Hash'])) {
                    session()->put('username', $_POST['username']);
                    session()->put('firstName', $rowLogin['Vorname']);
                    session()->put('loggedIn', true);
                    session()->put('role', $rowRole['Role']);
                } else {
                    session()->put('loggedIn', false);
                }
            } else {
                session()->put('loggedIn', false);
            }
        } else {
            session()->put('loggedIn', false);
        }

        $queryUpdateLogin = "UPDATE Benutzer SET LetzterLogin = NOW() WHERE Nutzername = '".$_POST['username']."'";
        mysqli_query($remoteConnection, $queryUpdateLogin);

        //header("Refresh:0");
    } else if (!empty($_POST['function']) && $_POST['function'] == "logout") {
        session()->put('username', "");
        session()->put('loggedIn', false);
        session()->flush();
        header("Refresh:0");
    }
