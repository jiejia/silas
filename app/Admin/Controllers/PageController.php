<?php
namespace App\Admin\Controllers;

use App\Common\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function login(Request $request): View|Factory|Application
    {
        return view('admin.login');
    }


    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function forgetPassword(Request $request): View|Factory|Application
    {
        return view('admin.forget_password');
    }

    public function setting(Request $request)
    {

    }

    public function role(Request $request)
    {

    }
}
