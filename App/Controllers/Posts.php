<?php

namespace App\Controllers;

use App\Services\Test;

class Posts
{
    public function index(Test $test)
    {
        echo "hello from Posts controller index action.";
        echo "<br>";
        echo $test->test();
    }
}
