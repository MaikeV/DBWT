<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StartController extends Controller {
    function getStart() {
        $year = date("Y");
        $date = date("H:i:s");

        return view("pages.Start", ["date" => $date, "year" => $year]);
    }
}
