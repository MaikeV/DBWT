<!DOCTYPE html>
<html lang="en">
    <?php include 'snippets/connection.php'; ?>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="Zutatenliste.css">
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="header.css">
        <title>e-Mensa</title>
    </head>
    <body class="bg-dark">
        <?php include 'snippets/header.php'; ?>
        <main>
            <div class="row">
                <div class="col-2"></div>
                <div class="col-5">
                    <form action="Upload.php" target="_self" method="post" class="text-warning">
                        <div class="form-group">
                            <label>Kategorie:</label>
                            <select class="form-control" name="cat">
                                <option value="">---</option>

                                <?php
                                $queryCategories = "SELECT ID, Name FROM Mahlzeiten";

                                if($resultCategories = mysqli_query($remoteConnection, $queryCategories)) {
                                    while($rowCategories = mysqli_fetch_assoc($resultCategories)) {
                                        echo '<option value="'.$rowCategories['ID'].'">'.$rowCategories['Name'].'</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Platzierung des Bildes:</label>
                            <select class="form-control" name="placing" required>
                                <option value="">---</option>
                                <option value="Details">Details</option>
                                <option value="Start">Start</option>
                                <option value="Preview">Preview</option>
                            </select>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="image" required placeholder="Choose File..." accept="image/jpeg, image/png">
                            <label class="custom-file-label"></label>
                        </div>
                        <button class="btn btn-primary mt-3" type="submit">Upload and Add to DB</button>

                        <?php
                            if (isset($_POST['image']) && isset($_POST['cat']) && isset($_POST['placing'])) {
                                $image='../img/'.$_POST['image'];

                                $data = fopen ($image, 'rb');
                                $size = filesize ($image);
                                $contents = fread ($data, $size);
                                fclose ($data);

                                $encoded = base64_encode($contents);

                                $queryPicID = 'SELECT ID FROM Bilder WHERE Titel LIKE \''.$_POST['image'].'-'.$_POST['placing'].'\'';

                                if ($resultPicID = mysqli_query($remoteConnection, $queryPicID)) {
                                    $rowPicID = mysqli_fetch_assoc($resultPicID);

                                    $queryPic = 'INSERT INTO Bilder(`Alt-Text`, Titel, Binaerdaten) VALUES (\''.$_POST['cat'].$_POST['placing'].'\', \''.$_POST['image'].'-'.$_POST['placing'].'\', \''.$encoded.'\')';

                                    if(mysqli_query($remoteConnection, $queryPic)) {
                                        echo '<p>New Record created successfully!</p>';
                                    } else {
                                        echo "Error: " . $queryPic . "<br>" . mysqli_error($remoteConnection);
                                    }

//                                    $queryMB = 'INSERT INTO hatMB(IDMahlzeiten, IDBilder) VALUES (' . $_POST['cat'] . ', \'' . $rowPicID['ID'] . '\')';
//
//                                    if(mysqli_query($remoteConnection, $queryMB)) {
//                                        echo '<p>New Record created successfully!</p>';
//                                    } else {
//                                        echo "Error: " . $queryMB . "<br>" . mysqli_error($remoteConnection);
//                                    }
                                }
                            }
                        ?>
                    </form>
                    <form action="Upload.php" target="_self" method="post" class="text-warning mt-3">
                        <button class="btn btn-primary" name="update">Update</button>
                        <?php
                            if(isset($_POST['update'])) {
                                $binary = "SELECT ID, Binaerdaten FROM Bilder";

                                if($resultBinary = mysqli_query($remoteConnection, $binary)) {
                                    while($binary = mysqli_fetch_assoc($resultBinary)) {
                                        $decoded = base64_decode($binary['Binaerdaten']);
                                        $query = 'UPDATE Bilder SET Binaerdaten = \''.$decoded.'\' WHERE ID = '.$binary['ID'];

                                        if(mysqli_query($remoteConnection, $query)) {
                                            echo '<p>Record Updated Successfully!</p>';
                                        } else {
                                            echo "Error: " . $query . "<br>" . mysqli_error($remoteConnection);
                                        }
                                    }
                                }
                            }
                        ?>
                    </form>
                </div>
            </div>
        </main>
        <?php
            include 'snippets/footer.php';

            mysqli_close($remoteConnection);
        ?>
    </body>
</html>