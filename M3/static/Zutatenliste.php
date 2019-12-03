<!DOCTYPE html>
<html lang="en">
    <?php
        include 'snippets/connection.php';
    ?>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="Zutatenliste.css">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="header.css">
        <title>e-Mensa</title>
    </head>
    <body class="bg-dark">
        <?php
            include 'snippets/header.php';
        ?>
        <main>
            <div class="row">
                <div class="col-1"></div>
                <div class="col-5 text-warning">
                    <?php
                        $count = "SELECT COUNT(*) count FROM Zutaten";
                        if ($result = mysqli_query($remoteConnection, $count)) {
                            $row = mysqli_fetch_assoc($result);
                            echo '<h1>Zutatenliste ('.$row['count'].')</h1>';
                        } else {
                            echo '<h1>Zutatenliste</h1>';
                        }
                    ?>
                    <br>
                </div>

            </div>
            <div class="row">
                <div class="col-1"></div>
                <div class="col-10">
                    <form action="http://www.google.de/search" method="get" target="_blank">
                        <table class="text-warning table table-dark">
                            <thead class="text-center">
                                <tr>
                                    <th scope="col">Nr.</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Bio</th>
                                    <th scope="col">Vegetarisch</th>
                                    <th scope="col">Vegan</th>
                                    <th scope="col">Glutenfrei</th>
                                </tr>
                            </thead>
                            <tbody class="align-content-center text-center align-self-center">
                                <?php
                                    function printFlags(bool $flag) {
                                        if ($flag == 1) {
                                            echo '<td><img src="../img/fontawesome-free-5.11.2-desktop/svgs/solid/check.svg" alt="Icon"></td>';
                                        } else {
                                            echo '<td><img src="../img/fontawesome-free-5.11.2-desktop/svgs/solid/times.svg" alt="Icon"></td>';
                                        }
                                    }

                                    $query = "SELECT * FROM Zutaten ORDER BY Bio DESC , Name";

                                    if($result = mysqli_query($remoteConnection, $query)) {
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo '<tr><td>'.$row['ID'].'</td><td><button type="submit" name="q" class="btn btn-link text-warning" value="'.$row['Name'].'" data-toggle="tooltip" data-placement="right" title="Suchen Sie nach '.$row['Name'].' im Web">'.$row['Name'].'</button></td>';

                                            printFlags($row['Bio']);
                                            printFlags($row['Vegetarisch']);
                                            printFlags($row['Vegan']);
                                            printFlags($row['Glutenfrei']);

                                            echo '</tr>';
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="col-1"></div>
            </div>
            <?php
                include 'snippets/footer.php';

                mysqli_close($remoteConnection);
            ?>
        </main>

    </body>
</html>
