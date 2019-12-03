<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <?php
        include 'snippets/connection.php';
    ?>
    <head>
        <meta charset="UTF-8">
        <title>e-Mensa</title>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="Details.css">
        <link rel="stylesheet" href="snippets/header.css">
    </head>
    <body class="bg-dark">
        <?php
            include 'snippets/header.php';
        ?>
        <div class="row">
            <div class="col-4"></div>
            <div class="col-4">
                <?php
                    include 'snippets/login.php';
                    include 'snippets/auth.php';
                ?>
            </div>
            <div class="col-4"></div>
        </div>
        <?php
            include 'snippets/footer.php';
        ?>
    </body>
</html>
