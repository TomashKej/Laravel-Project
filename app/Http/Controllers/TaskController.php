<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

include_once(app_path("pages/TasksPage.php"));

class TaskController extends Controller
{
    public function Index()
    {
        $page = new \TasksPage();

        ob_start();
        $page->initialize();
        $content = ob_get_clean();

        return response($content);
    }
}