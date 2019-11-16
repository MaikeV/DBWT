<!DOCTYPE html>
<html lang="en">
<?php include 'snippets/connection.php'; ?>
<head>
    <meta charset="UTF-8">
    <title>e-Mensa</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="Start.css">
    <link rel="stylesheet" href="header.css">
</head>
<body class="bg-dark">
    <?php include 'snippets/header.php' ?>
    <main>
        <div class="container-fluid mw-100">
            <?php
                $query = 'SELECT Binaerdaten, `Alt-Text` FROM Bilder WHERE Titel LIKE \'Sushi%Start\'';

                if($result = mysqli_query($remoteConnection, $query)) {
                    $row = mysqli_fetch_assoc($result);

                    echo '<img src="data:image/jpeg;base64,'.$row['Binaerdaten'].'" id="banner" class="img w-100" alt="'.$row['Alt-Text'].'">';
                }
            ?>
        </div>
        <div class="container-fluid p-3">
            <div class="row mt-3 text-warning">
                <div class="col-2 text-left infoText">
                    <p>Der Dienst der e-Mensa ist noch beta. Sie koennen bereits <a href="Mahlzeiten.php">Mahlzeiten</a> durchstoebern, aber noch nicht bestellen.</p>
                </div>
                <div class="col-4 catchline">
                    <h2>Leckere Gerichte vorbestellen</h2>
                    <p>... und gemeinsam mit Kommilitonen und Freunden essen</p>
                </div>
                <div class="col-4 text-center">
                    <h2>Schon Essenszeit?</h2>
                    <h4><?php echo date('H:i:s')?></h4>
                </div>
                <div class="col-2 align-content-end justify-content-end align-items-end">
                    <button class="btnSign btn btn-primary mb-3"><img src="../img/fontawesome-free-5.11.2-desktop/svgs/solid/user-plus.svg" alt="Image" class="img-fluid icon "> Registrieren</button>
                    <br>
                    <button class="btnSign btn btn-primary"><img src="../img/fontawesome-free-5.11.2-desktop/svgs/solid/sign-in-alt.svg" alt="Image" class="img-fluid icon"> Anmelden</button>
                </div>
            </div>
            <div class="row mt-3 text-warning">
                <div class="col-2 text-left infoText">
                    <p>Registrieren Sie sich <a href="Register.html">hier</a>, um ueber die Veroeffentlichungen des Dienstes per Mail informiert zu werden.</p>
                </div>
                <div class="col-10">
                    <?php
                        $query = 'SELECT Binaerdaten, `Alt-Text` FROM Bilder WHERE Titel LIKE \'Ramen%Start\'';

                        if($result = mysqli_query($remoteConnection, $query)) {
                            $row = mysqli_fetch_assoc($result);

                            echo '<img src="data:image/jpeg;base64,'.$row['Binaerdaten'].'" id="imgStart" class="img w-100" alt="'.$row['Alt-Text'].'">';
                        }
                    ?>
                </div>
            </div>
        </div>
    </main>
    <?php
        include 'snippets/footer.php';
        mysqli_close($remoteConnection);
    ?>
</body>
</html>