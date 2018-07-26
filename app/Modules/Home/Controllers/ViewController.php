<?php

namespace app\Modules\Home\Controllers;

use App\Http\Controllers\Controller;
use app\Modules\FindFriends\Models\Friend;
use app\Modules\FindFriends\Models\User;

class ViewController extends Controller
{

    public function index()
    {
        return view('Home::index');
    }
}
