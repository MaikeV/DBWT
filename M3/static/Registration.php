<!DOCTYPE html>
<html lang="en">
    <?php
        include 'snippets/connection.php';
    ?>
    <head>
        <meta charset="UTF-8">
        <title>e-Mensa</title>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="Register.nocache.css">
        <link rel="stylesheet" href="header.css">
    </head>
    <body class="bg-dark">
        <main>
            <?php
                include 'snippets/header.php';
                include 'snippets/register.php';

                if(isset($_POST['registered']) && $_POST['registered'] == "true") {
                    if(register($_POST, $remoteConnection)) {
                        echo '<p class="text-warning">Sie haben sich erfolgreich registriert. Weiter zur <a href="Start.php">Startseite</a></p>';
                    } else {
                        $_POST['registered'] = false;
                        echo '<p class="text-warning">Registrierung Fehlgeschlagen. <a href="Registration.php">Versuchen Sie es erneut</a></p>';
                    }
                } else {
                    include 'snippets/registrationForm.php';
                }
            ?>
        </main>
        <?php
            include 'snippets/footer.php';

            mysqli_close($remoteConnection);
        ?>
    </body>
</html>