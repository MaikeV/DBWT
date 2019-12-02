<?php
    include 'connection.php';

    function getSubCategories($id, $remoteConnection) {
        $queryCategories = "SELECT ID, Bezeichnung FROM Kategorien WHERE hatKategorien = ".$id;

        if($resultCategories = mysqli_query($remoteConnection, $queryCategories)) {
            return $resultCategories;
        }

        return null;
    }
