<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>e-Mensa</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="Mahlzeiten.css">
</head>
<body class="bg-dark">
    <?php include 'header.php'; ?>
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
                        <div class="col-3 ">
                            <img src="../img/kotbullarstockholm.jpg" class="img rounded" alt="Image">
                            <br>
                            <a>Köttbullar</a>
                            <br>
                            <a href="Details.php" class="details">Details</a>
                        </div>
                        <div class="col-3">
                            <img src="../img/ramen-teaser.jpg" class="img rounded" alt="Image">
                            <br>
                            <a>Ramen</a>
                            <br>
                            <a href="Details.php" class="details">Details</a>
                        </div>
                        <div class="col-3">
                            <img src="../img/Rumpsteak.jpg" class="img rounded" alt="Image">
                            <br>
                            <a>Rumpsteak</a>
                            <br>
                            <a href="Details.php" class="details">Details</a>
                        </div>
                        <div class="col-3">
                            <img src="../img/burger.jpg" class="img soldOut border border-danger rounded" alt="Image">
                            <br>
                            <a class="soldOut">Burger</a>
                            <br>
                            <a class="soldOut">vergriffen</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <img src="../img/sushi.jpg" class="img rounded" alt="Image">
                            <br>
                            <a>Sushi</a>
                            <br>
                            <a href="Details.php" class="details">Details</a>
                        </div>
                        <div class="col-3">
                            <img src="../img/pizza.jpeg" class="img rounded" alt="Image">
                            <br>
                            <a>Pizza</a>
                            <br>
                            <a href="Details.php" class="details">Details</a>
                        </div>
                        <div class="col-3">
                            <img src="../img/Dumplings.jpg" class="img rounded" alt="Image">
                            <br>
                            <a>Dumplings</a>
                            <br>
                            <a href="Details.php" class="details">Details</a>
                        </div>
                        <div class="col-3">
                            <img src="../img/lachs.jpg" class="img rounded" alt="Image">
                            <br>
                            <a>Lachsforelle aus dem Ofen</a>
                            <br>
                            <a href="Details.php" class="details">Details</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include 'footer.php'?>
</body>
</html>