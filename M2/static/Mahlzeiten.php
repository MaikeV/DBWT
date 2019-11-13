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
            <?php include 'snippets/header.php' ?>
            <main>
                <div class="container-fluid mb-xl-5">
                    <div class="row mb-3 text-left ml-5 text-warning">
                        <div class="col-3"></div>
                        <div class="col-9">
                            <h1>Verfuegbare Speisen (Bestseller)</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <fieldset class="border border-primary p-5">
                                <legend class="text-warning text-center w-auto"> Speisenliste filtern </legend>
                                <form class="align-content-center justify-content-center p-5">
                                    <div class="row">
                                        <select class="form-control">
                                            <option>Kategorien</option>
                                        </select>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-8">
                                            <div class="form-check text-warning mt-5 mx-auto align-content-center justify-content-center text-left">
                                                <input class="form-check-input" type="checkbox" value="" >
                                                <label>nur verfuegbare</label>
                                                <br>
                                                <input class="form-check-input" type="checkbox" value="" >
                                                <label>nur vegetarische</label>
                                                <br>
                                                <input class="form-check-input" type="checkbox" value="" >
                                                <label>nur vegane</label>
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
                                    $query = "SELECT * FROM Mahlzeiten";

                                    if($result = mysqli_query($remoteConnection, $query)) {
                                        while ($row = mysqli_fetch_assoc($result)) {

                                            if ($row['Verfuegbar'] == true) {
                                                echo '<div class="col-3 ">';
                                                echo '<img src="../img/'.$row['Name'].'.jpg" class="img rounded" alt="Image"><br>';
                                                echo '<a>'.$row['Name'].'</a><br>';
                                                echo '<a href="Details.php?id='.$row['ID'].'"  class="details">Details</a></div>';
                                            } else {
                                                echo '<div class="col-3 soldOut">';
                                                echo '<img src="../img/'.$row['Name'].'.jpg" class="img rounded border border-danger" alt="Image"><br>';
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