<?php


namespace App\Http\Controllers;


class CommentController {
    function addComment($id) {
        include 'connection.php';
        $this->database = $remoteConnection;

        $commentQuery = "INSERT INTO Kommentare(Bemerkung, Bewertung, zu, GeschriebenVon, Zeitpunkt) 
                            VALUES ('".$_POST['bemerkung']."', ".$_POST['bewertung'].", ".$id.", '".$_POST['benutzer']."', NOW())";

        echo $commentQuery;
        mysqli_query($this->database, $commentQuery);

        return;
    }
}
