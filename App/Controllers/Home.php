<?php

namespace App\Controllers;

use Core\View;
use App\Models\Shop;

class Home
{
    public function index()
    {
        $shops = Shop::getAll();

        View::renderTemplate('home.html', ['shops' => $shops]);
    }
}
