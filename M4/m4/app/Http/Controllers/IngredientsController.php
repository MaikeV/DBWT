<?php


namespace App\Http\Controllers;


class IngredientsController {
    function getIngView() {
        $allIngredients = $this->getIngredients();
        $ingredientCount = $this->getIngredientsCount();

        return view('pages.Zutatenliste', ["allIngredients" => $allIngredients, "count" => $ingredientCount]);
    }

    public function getIngredients() {
        include 'connection.php';
        $this->database = $remoteConnection;

        $queryIngredientsAll = "SELECT * FROM Zutaten ORDER BY Bio DESC , Name";
        $allIngredients = array();
        if ($resultIngredientsAll = mysqli_query($this->database, $queryIngredientsAll)) {
            while($rowIngredientsAll = mysqli_fetch_assoc($resultIngredientsAll)) {
                array_push($allIngredients, $rowIngredientsAll);
            }
        }
        return $allIngredients;
    }

    public function getIngredientsCount() {
        $count = "SELECT COUNT(*) count FROM Zutaten";
        if ($resultCount = mysqli_query($this->database, $count)) {
            return mysqli_fetch_assoc($resultCount);
        }
    }
}
