<!DOCTYPE html>
<html lang="en">
    <?php
        include 'snippets/connection.php';
    ?>
    <head>
        <meta charset="UTF-8">
        <title>e-Mensa</title>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="Mahlzeiten.css">
        <link rel="stylesheet" href="header.css">
    </head>
    <body class="bg-dark">
        <?php
            include 'snippets/header.php';
        ?>
        <main>
            <div class="container-fluid mb-xl-5">
                <div class="row mb-3 text-left ml-5 text-warning">
                    <div class="col-3"></div>
                    <div class="col-9">
                        <?php
                            if(isset($_GET['cat']) && $_GET['cat'] != "") {
                                $queryHeading = "SELECT Bezeichnung FROM Kategorien WHERE ID = ".$_GET['cat'];

                                if($resultHeading = mysqli_query($remoteConnection, $queryHeading)) {
                                    if($rowHeading = mysqli_fetch_assoc($resultHeading)) {
                                        echo '<h1>Verfuegbare Speisen ('.$rowHeading['Bezeichnung'].')</h1>';
                                    }
                                }
                            } else {
                                echo '<h1>Verfuegbare Speisen (Bestseller)</h1>';
                            }
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        <fieldset class="border border-primary p-5">
                            <legend class="text-warning text-center w-auto"> Speisenliste filtern </legend>
                            <form class="align-content-center justify-content-center p-5" method="get" action="Mahlzeiten.php">
                                <div class="row">
                                    <select class="form-control" name="cat">
                                        <optgroup label="Generell">
                                            <option value="">Alle Anzeigen</option>
                                        </optgroup>
                                        <?php
                                            $queryCategoriesGroup = "SELECT ID, Bezeichnung FROM Kategorien WHERE hatKategorien IS NULL";

                                            if($resultCategoriesGroup = mysqli_query($remoteConnection, $queryCategoriesGroup)) {
                                                while($rowCategoriesGroup = mysqli_fetch_assoc($resultCategoriesGroup)) {
                                                    echo '<optgroup label="'.$rowCategoriesGroup['Bezeichnung'].'">';
                                                    $queryCategories = "SELECT ID, Bezeichnung FROM Kategorien WHERE hatKategorien = ".$rowCategoriesGroup['ID'];

                                                    if($resultCategories = mysqli_query($remoteConnection, $queryCategories)) {
                                                        while($rowCategories = mysqli_fetch_assoc($resultCategories)) {
                                                            echo '<option value="'.$rowCategories['ID'].'">'.$rowCategories['Bezeichnung'].'</option>';
                                                        }
                                                    }
                                                    echo '</optgroup>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-8">
                                        <div class="form-check text-warning mt-5 mx-auto align-content-center justify-content-center text-left">
                                            <input class="form-check-input" type="checkbox" id="avail" value="1" <?php if (isset($_GET['avail'])) echo ' checked="checked" ';?> name="avail">
                                            <label for="avail">nur verfuegbare</label>
                                            <br>
                                            <input class="form-check-input" type="checkbox" id="veggie" value="1" <?php if (isset($_GET['veggie'])) echo ' checked="checked" ';?> name="veggie">
                                            <label for="veggie">nur vegetarische</label>
                                            <br>
                                            <input class="form-check-input" type="checkbox" id="vegan" value="1" <?php if (isset($_GET['vegan'])) echo ' checked="checked" ';?> name="vegan">
                                            <label for="vegan">nur vegane</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-5 justify-content-center">
                                    <div class="col-8">
                                        <button class="btn btn-primary">Speisen filtern</button>
                                    </div>
                                </div>
                            </form>
                        </fieldset>
                    </div>
                    <div class="col-9 text-warning text-center justify-content-center">
                        <div class="row mb-3">
                            <?php
                                if(!isset($_GET['avail'])) {
                                    $_GET['avail'] = '\'%\'';
                                }
                                if(!isset($_GET['limit'])) {
                                    $_GET['limit'] = 8;
                                }
                                if(!isset($_GET['cat']) || $_GET['cat'] == "") {
                                    $_GET['cat'] = '\'%\'';
                                }

                                if(isset($_GET['vegan']) && $_GET['vegan'] == 1 && !isset($_GET['veggie'])) {
                                    $indexName = "VeganIndex";
                                    $index = 0;
                                } else if(isset($_GET['veggie']) && $_GET['veggie'] == 1 && !isset($_GET['vegan'])) {
                                    $indexName = "VeggieIndex";
                                    $index = 0;
                                } else if(isset($_GET['vegan']) && $_GET['vegan'] == 1 && isset($_GET['veggie']) && $_GET['veggie'] == 1) {
                                    $indexName = "VeganIndex";
                                    $index = 0;
                                } else {
                                    $indexName = "VeggieIndex";
                                    $index = '\'%\'';
                                }

                                $query = 'SELECT m.ID, m.Name, m.istIn, m.Verfuegbar, 
                                                            (COUNT(z.ID) - SUM(z.Vegan)) AS VeganIndex, 
                                                            (COUNT(z.ID) - SUM(z.Vegetarisch)) AS VeggieIndex, 
                                                            b.ID AS BildID, b.`Alt-Text`, b.Titel, b.Binaerdaten
                                                            FROM Mahlzeiten AS m
                                                            LEFT JOIN enthaeltMZ eM ON m.ID = eM.IDMahlzeiten
                                                            LEFT JOIN Zutaten z on eM.IDZutaten = z.ID
                                                            LEFT JOIN hatMB hB ON m.ID = hB.IDMahlzeiten
                                                            LEFT JOIN Bilder AS b ON hB.IDBilder = b.ID
                                                            WHERE b.Titel LIKE \'%Preview\' AND m.Verfuegbar LIKE '.$_GET['avail'].' AND m.istIn LIKE '.$_GET['cat'].' 
                                                            GROUP BY m.ID
                                                            HAVING '.$indexName.' LIKE '.$index.'
                                                            LIMIT '.$_GET['limit'];

                                if($result = mysqli_query($remoteConnection, $query)) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        if ($row['Verfuegbar'] == true) {
                                            echo '<div class="col-3 ">';
                                            echo '<img src="data:image/jpeg;base64,'.$row['Binaerdaten'].'" class="img rounded" alt="'.$row['Alt-Text'].'"><br>';
                                            echo '<a>'.$row['Name'].'</a><br>';
                                            echo '<a href="Details.php?id='.$row['ID'].'"  class="details">Details</a></div>';
                                        } else {
                                            echo '<div class="col-3 soldOut">';
                                            echo '<img src="data:image/jpeg;base64,'.$row['Binaerdaten'].'" class="img rounded border border-danger" alt="'.$row['Alt-Text'].'"><br>';
                                            echo '<a>'.$row['Name'].'</a><br>';
                                            echo '<a class="details">vergriffen</a></div>';
                                        }
                                    }
                                }
                            ?>
                        </div>
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