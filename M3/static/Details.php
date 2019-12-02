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
            <link rel="stylesheet" href="header.css">
        </head>
        <body class="bg-dark">
            <?php
                include 'snippets/header.php';

                if (isset($_GET['id'])) {
                    $query = 'SELECT * FROM Mahlzeiten m 
                                                        LEFT JOIN hatMB hM on m.ID = hM.IDMahlzeiten 
                                                        LEFT JOIN Bilder B on hM.IDBilder = B.ID 
                                                        LEFT JOIN Preise P on m.ID = P.ID
                                                        HAVING B.Titel LIKE \'%Detail%\' AND m.ID LIKE '.$_GET['id'];

                    if($result = mysqli_query($remoteConnection, $query)) {
                        $row = mysqli_fetch_assoc($result);
                    } else {
                        redirToMahlzeiten($remoteConnection);
                    }
                } else {
                    redirToMahlzeiten($remoteConnection);
                }

                function redirToMahlzeiten($remoteConnection) {
                    echo 'Invalid ID: Redirecting to Mahlzeiten';
                    sleep(3);
                    header("Location: http://127.0.0.1/M3/static/Mahlzeiten.php");
                    mysqli_close($remoteConnection);
                    exit();
                }
            ?>
            <main class="mb-xl-5">
                <div class="container-fluid">
                    <div class="row ">
                        <div class="col-3"></div>
                        <div class="col-9 text-warning">
                            <h1>Details fuer "<?php
                                echo ''.$row['Name'].'"';
                                ?>
                            </h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <?php
                            include 'snippets/login.php';
                            ?>
                        </div>
                        <div class="col-6">
                            <?php
                            echo '<img src="data:image/jpeg;base64,'.$row['Binaerdaten'].'" class="img rounded" alt="'.$row['Alt-Text'].'">';
                            ?>
                        </div>
                        <div class="col-3 p-5">
                            <div class="row">
                                <div class="col-12 text-center text-warning">
                                    <p><strong>Gast</strong>-Preis</p>
                                    <h4>
                                        <?php
                                        echo round($row['Gastpreis'], 2).' EUR';
                                        ?>
                                    </h4>
                                </div>
                            </div>
                            <div class="row p-5 justify-content-end">
                                <div class="col-12 mx-auto">
                                    <button class="btn btn-lg btn-primary"><img src="../img/fontawesome-free-5.11.2-desktop/svgs/solid/utensils.svg" class="icon" alt="Image"> Vorbestellen</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row text-left text-warning mt-5">
                        <div class="col-3">
                            <p>Melden Sie sich jetzt an, um die wirklich viel guenstigeren Preise fuer Mitarbeiter oder Studenten zu sehen.</p>
                        </div>
                        <div class="col-6">
                            <ul class="nav nav-tabs w-100 border border-bottom border-primary border-left-0 border-top-0 border-right-0" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="desc-tab" href="#desc" data-toggle="tab" role="tab" aria-controls="desc" aria-selected="true">Beschreibung</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="ing-tab" href="#ing" data-toggle="tab" role="tab" aria-controls="ing" aria-selected="false">Zutaten</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="rec-tab" href="#rec" data-toggle="tab" role="tab" aria-controls="rec" aria-selected="false">Bewertungen</a>
                                </li>
                            </ul>
                            <div class="tab-content border border-primary p-3">
                                <div class="tab-pane active" id="desc" role="tabpanel" aria-labelledby="desc-tab">
                                    <?php
                                    echo '<p>'.$row['Beschreibung'].'</p>';
                                    ?>
                                </div>
                                <div class="tab-pane" id="ing" role="tabpanel" aria-labelledby="ing-tab">
                                    <ul class="text-warning">
                                        <?php
                                        $ingredientsIDQuery = 'SELECT IDZutaten FROM enthaeltMZ CROSS JOIN Mahlzeiten ON enthaeltMZ.IDMahlzeiten = Mahlzeiten.ID WHERE IDMahlzeiten LIKE '.$_GET['id'];

                                        if($ingredientsIDResult = mysqli_query($remoteConnection, $ingredientsIDQuery)) {
                                            while ($ingredientsIDRow = mysqli_fetch_assoc($ingredientsIDResult)) {
                                                foreach($ingredientsIDRow as $ingRow) {
                                                    $ingredientsNameQuery = "SELECT Name FROM Zutaten WHERE ID = ".$ingRow;

                                                    if ($ingredientsNameResult = mysqli_query($remoteConnection, $ingredientsNameQuery)) {
                                                        $ingredientsNameRow = mysqli_fetch_assoc($ingredientsNameResult);
                                                        echo '<li><p>'.$ingredientsNameRow['Name'].'</p></li>';
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <div class="tab-pane" id="rec" role="tabpanel" aria-labelledby="rec-tab">
                                    <fieldset class="text-warning border border-primary p-5">
                                        <legend class="text-center w-auto"> Mahlzeit bewerten </legend>
                                        <form action="http://bc5.m2c-lab.fh-aachen.de/form.php" method="post">
                                            <div class="form-group row">
                                                <div class="col-3">
                                                    <label for="dishInput" class="text-left p-2">Mahlzeit</label>
                                                </div>
                                                <div class="col-9">
                                                    <select class="form-control w-50" id="dishInput" name="mahlzeit" required>
                                                        <option value="">---</option>
                                                        <?php
                                                        while($row = mysqli_fetch_assoc($result)) {
                                                            echo '<option>'.$row['Name'].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-3">
                                                    <label for="username" class="p-2">Benutzername</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="text" name="benutzer" id="username" class="w-50">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-3">
                                                    <label for="rating" class="p-2">Bewertung</label>
                                                </div>
                                                <div class="col-9">
                                                    <input type="number" name="bewertung" max="5" min="0" id="rating" class="w-50">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-3">
                                                    <label for="comment" class="p-2">Bewertung</label>
                                                </div>
                                                <div class="col-9">
                                                    <textarea id="comment" name="bemerkung" class="w-50"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <input name="matrikel" type="hidden" value="3191233">
                                                <input name="kontrolle" type="hidden" value="Voß">
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-3">
                                                </div>
                                                <div class="col-9">
                                                    <button type="submit" id="send" class="btn btn-link text-left w-50">Bewertung absenden <strong> > </strong></button>
                                                </div>
                                            </div>
                                        </form>
                                    </fieldset>
                                </div>
                            </div>
                            <script>
                                $(function () {
                                    $("#myTab li:last-child a").tab('show');
                                    $("#myTab .active").addClass("bg-dark text-warning border border-primary")
                                })
                            </script>
                        </div>
                    </div>
                </div>
                <br>
            </main>
        <?php include 'snippets/footer.php' ?>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>