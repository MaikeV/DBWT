<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>e-Mensa</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="Details.css">
</head>
<body class="bg-dark">
    <?php include 'header.php'; ?>
    <main class="mb-xl-5">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-3"></div>
                <div class="col-9 text-warning">
                    <h1>Details fuer "Köttbullar"</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <fieldset class="border border-primary p-5">
                        <legend class="text-warning text-center w-auto"> Login </legend>
                        <form>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Benutzer">
                            </div>
                            <div class="form-group mt-3">
                                <input type="password" class="form-control" placeholder="******">
                            </div>
                            <a href="...">Anmelden</a>
                        </form>
                    </fieldset>
                </div>
                <div class="col-6">
                    <img src="../img/Köttbullar%20(Schwedische%20Hackfleischbällchen).jpg" class="img w-100" alt="Image">
                </div>
                <div class="col-3 p-5">
                    <div class="row">
                        <div class="col-12 text-center text-warning">
                            <p><strong>Gast</strong>-Preis</p>
                            <h4>5.95 EUR</h4>
                        </div>
                    </div>
                    <div class="row p-5 justify-content-end">
                        <div class="col-12 mx-auto">
                            <button class="btn btn-lg btn-primary"><img src="../img/fontawesome-free-5.11.2-desktop/svgs/solid/utensils.svg" class="icon"> Vorbestellen</button>
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
                            <p>Saftige Fleischbaellchen in Sosse mit Kartoffelpueree und Preisselbeeren. Dazu ein leckerer <a href="#">Gurkensalat</a>.</p>
                        </div>
                        <div class="tab-pane" id="ing" role="tabpanel" aria-labelledby="ing-tab">
                            <ul class="text-warning">
                                <li>
                                    <p>Hackfleisch</p>
                                </li>
                                <li>
                                    <p>Sahne</p>
                                </li>
                                <li>
                                    <p>Paniermehl</p>
                                </li>
                                <li>
                                    <p>Kartoffeln</p>
                                </li>
                                <li>
                                    <p>Milch</p>
                                </li>
                                <li>
                                    <p>Preisselbeeren</p>
                                </li>
                                <li>
                                    <p>Gurken</p>
                                </li>
                                <li>
                                    <p>Essig</p>
                                </li>
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
                                                <option>
                                                    Köttbullar
                                                </option>
                                                <option>
                                                    Ramen
                                                </option>
                                                <option>
                                                    Rumpsteak
                                                </option>
                                                <option>
                                                    Burger
                                                </option>
                                                <option>
                                                    Sushi
                                                </option>
                                                <option>
                                                    Pizza
                                                </option>
                                                <option>
                                                    Dumplings
                                                </option>
                                                <option>
                                                    Lachsforelle aus dem Ofen
                                                </option>
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
    <?php include 'footer.php'?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>