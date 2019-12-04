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
        <link rel="stylesheet" href="Zutatenliste.css">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="views/layouts/header.css">
        <title>e-Mensa</title>
    </head>
    <body class="bg-dark">
        <?php
            include '../layouts/header.php';
        ?>
        <main>
            <?php
//                Route::get('/', function()
//                {
//                    return View::make('pages.Start');
//                });
//                Route::get('produkte', function()
//                {
//                    return View::make('pages.Mahlzeiten');
//                });
//                Route::get('details?id=', function()
//                {
//                    return View::make('pages.Details');
//                });
//                Route::get('login', function()
//                {
//                    return View::make('pages.Login');
//                });
//                Route::get('zutatenliste', function()
//                {
//                    return View::make('pages.Zutatenliste');
//                });
//                Route::get('upload', function()
//                {
//                    return View::make('pages.Upload');
//                });
            ?>
        </main>
        <?php
            include '../layouts/footer.blade.php';
            mysqli_close($remoteConnection);
        ?>
    </body>
</html>
