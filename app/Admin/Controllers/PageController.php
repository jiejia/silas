<?php
namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\Common\Controller;

class PageController extends Controller
{
    public function login(Request $request)
    {
        return view('admin.login');
    }

    public function dashboard(Request $request)
    {

    }

    public function forgetPassword(Request $request)
    {

    }

    public function setting(Request $request)
    {

    }

    public function role(Request $request)
    {

    }
}
