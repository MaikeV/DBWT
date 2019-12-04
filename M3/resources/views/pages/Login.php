<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <?php
        include '../includes/connection.php';
    ?>
    <head>
        <meta charset="UTF-8">
        <title>e-Mensa</title>
        <link rel="stylesheet" href="../../css/bootstrap.css">
        <link rel="stylesheet" href="Details.css">
        <link rel="stylesheet" href="../layouts/header.css">
    </head>
    <body class="bg-dark">
        <?php
            include '../layouts/header.php';
        ?>
        <div class="row">
            <div class="col-4"></div>
            <div class="col-4">
                <?php
                    include '../includes/login.php';
                    include '../includes/auth.php';
                ?>
            </div>
            <div class="col-4"></div>
        </div>
        <?php
            include '../layouts/footer.blade.php';
        ?>
    </body>
</html>
