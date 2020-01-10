<?php
    namespace Emensa\Model {
        require_once __DIR__ . '/../views/includes/connection.php';

        class Zutaten {

            private $database;
            public function __construct() {
                include __DIR__ . '/../views/includes/connection.php';

                $this->database = $remoteConnection;
            }

            public function getIngeredients() {
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

            public function getYear() {
                return date('Y');
            }
        }
    }
