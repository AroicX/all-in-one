<?php

namespace App\Http\Controllers;

class UserController extends Controller
{

    public function Dashboard()
    {

        return view('panel.Dashboard');

    }

    public function getProtected()
    {

        return view('auth.protected');

    }

}