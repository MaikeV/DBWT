<?php
    $_SESSION['visited'] = true;
    if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['function']) && $_POST['function'] == "login") {
        $queryLogin = "SELECT b.Nummer AS UserNum, b.Nutzername, b.Hash, FA.Nummer AS FHANum, m.Nummer AS EmpNum, s.Nummer AS StudNum, g.Nummer AS VisNum FROM Benutzer b 
                    LEFT JOIN FH_Angehoerige FA ON b.Nummer = FA.Nummer 
                    LEFT JOIN Mitarbeiter m ON FA.Nummer = m.Nummer 
                    LEFT JOIN Studenten s ON FA.Nummer = s.Nummer
                    LEFT JOIN Gaeste g on b.Nummer = g.Nummer
                    WHERE Nutzername = '".$_POST['username']."'";

        echo $queryLogin;
        if($resultLogin = mysqli_query($remoteConnection, $queryLogin)) {
            if($rowLogin = mysqli_fetch_assoc($resultLogin)) {
                if (password_verify($_POST['password'], $rowLogin['Hash'])) {
                    $_SESSION['username'] = $_POST['username'];
                    $_SESSION['loggedIn'] = true;

                    if ($rowLogin['VisNum'] == $rowLogin['UserNum']) {
                        $_SESSION['role'] = "Gast";
                    } else if ($rowLogin['FHANum'] == $rowLogin['UserNum']) {
                        if ($rowLogin['FHANum'] == $rowLogin['EmpNum']) {
                            $_SESSION['role'] = "Mitarbeiter";
                        } else {
                            $_SESSION['role'] = "Student";
                        }
                    }
                   header("Refresh:0");
                } else {
                    $_SESSION['loggedIn'] = false;
                    header("Refresh:0");
                }
            } else {
                $_SESSION['loggedIn'] = false;
                header("Refresh:0");
            }
        } else {
            $_SESSION['loggedIn'] = false;
            header("Refresh:0");
        }
    } else if (!empty($_POST['function']) && $_POST['function'] == "logout") {
        echo 'Hello';
        $_SESSION['username'] = "";
        $_SESSION['loggedIn'] = false;
        session_destroy();
        header("Refresh:0");
    }


