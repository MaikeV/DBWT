<?php
    namespace Emensa\Controller {
        require '../../vendor/autoload.php';
        Use eftec\bladeone\BladeOne;
        require 'model/Zutaten.php';
        Use Emensa\Model\Zutaten;

        class ZutatenController {
            private $blade;

            public function __construct() {
                $views = __DIR__ . '/../views';
                $cache = __DIR__ . '/../cache';
                $this->blade = new BladeOne($views, $cache, BladeOne::MODE_AUTO);
            }

            public function zutaten($id = 0) {
                $allIngredients = (new \Emensa\Model\Zutaten)->getIngeredients();
                $count = (new \Emensa\Model\Zutaten)->getIngredientsCount();
                $year = (new \Emensa\Model\Zutaten)->getYear();

                echo $this->blade->run("layouts2.head");
                echo $this->blade->run("layouts2.header");
                echo $this->blade->run("pages.Zutatenliste", array("allIngredients" => $allIngredients, "count" => $count));
                echo $this->blade->run("layouts2.footer", array("year" => $year));
            }
        }
    }