<?php


namespace App\Http\Controllers;

class DetailsController extends Controller {
    function redirToMahlzeiten($remoteConnection) {
        echo 'Invalid ID: Redirecting to Mahlzeiten';
        sleep(3);
        header("Location: http://localhost:8000/products");
        mysqli_close($remoteConnection);
        exit();
    }

    function getDetails($id) {
//        session_start();

        include 'auth.php';
        include  'connection.php';

        $this->database = $remoteConnection;

        $year = date("Y");

        if (session()->has('role') && session()->has('loggedIn') && session()->has('visited') && session()->has('username')) {
            $loggedIn = session()->get('loggedIn');
            $role = session()->get('role');
            $visited = session()->get('visited');
            $username = session()->get('username');
            $userID = session()->get('userID');
        } else {
            $loggedIn = "";
            $role = "";
            $visited = "";
            $username = "";
            $userID = "";
        }

        if (isset($_GET['id']) || $id != "") {
            $query = 'SELECT * FROM Mahlzeiten m 
                        LEFT JOIN hatMB hM on m.ID = hM.IDMahlzeiten 
                        LEFT JOIN Bilder B on hM.IDBilder = B.ID 
                        LEFT JOIN Preise P on m.ID = P.ID
                        HAVING B.Titel LIKE \'%Detail%\' AND m.ID LIKE '.$id;

            if($result = mysqli_query($this->database, $query)) {
                $meal = mysqli_fetch_assoc($result);
            } else {
                $meal = "";
                $this->redirToMahlzeiten($this->database);
            }
        } else {
            $meal = "";
            $this->redirToMahlzeiten($this->database);
        }

        $ingredientsIDQuery = 'SELECT IDZutaten, Z.Name FROM enthaeltMZ 
                                LEFT JOIN Mahlzeiten ON enthaeltMZ.IDMahlzeiten = Mahlzeiten.ID
                                LEFT JOIN Zutaten Z on enthaeltMZ.IDZutaten = Z.ID
                                WHERE IDMahlzeiten LIKE '.$id;
        $ingredients = array();
        if($ingredientsIDResult = mysqli_query($this->database, $ingredientsIDQuery)) {
            while ($ingredientsIDRow = mysqli_fetch_assoc($ingredientsIDResult)) {
                array_push($ingredients, $ingredientsIDRow);
            }
        }

        $queryAllMeals = "SELECT Name FROM Mahlzeiten";

        $allMeals = array();
        if ($resultAllMeals = mysqli_query($this->database, $queryAllMeals))
            array_push($allMeals, mysqli_fetch_assoc($resultAllMeals));

        $comments = $this->getComments($this->database, $meal['ID']);
        $commentsLength = count($comments);
        $average = $this->calcAverage($this->database, $meal['ID']);

        return view("pages.Details", ["meal" => $meal, "ingredients" => $ingredients, "allMeals" => $allMeals,
            "loggedIn" => $loggedIn, "role" => $role, "visited" => $visited, "username" => $username, "comments" => $comments,
            "average" => $average, "commentsLength" => $commentsLength, "userID" => $userID]);
    }

    function calcAverage($remoteConnection, $mealId) {
        $ratingQuery = "SELECT Bewertung FROM Kommentare WHERE zu LIKE ".$mealId;

        $average = 0;
        $numOfRows = 0;
        if($ratingResult = mysqli_query($remoteConnection, $ratingQuery)) {
            while($ratingRow = mysqli_fetch_assoc($ratingResult)) {
                $average += $ratingRow['Bewertung'];
                $numOfRows++;
            }
        }

        if ($numOfRows != 0) {
            $average /= $numOfRows;
        }

        return $average;
    }

    function getComments($remoteConnection, $mealId) {
        $commentsQuery = "SELECT K.*, B.Nutzername FROM Kommentare K 
                            LEFT JOIN Benutzer B on K.GeschriebenVon = B.Nummer
                            WHERE zu LIKE ".$mealId." ORDER BY Zeitpunkt DESC LIMIT 5";

        $allComments = array();
        if ($resultComments = mysqli_query($remoteConnection, $commentsQuery)) {
            while($rowComments = mysqli_fetch_assoc($resultComments)) {
                array_push($allComments, $rowComments);
            }
        }

        return $allComments;
    }
}
