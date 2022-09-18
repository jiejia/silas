<?php
namespace App\Admin\Controllers;

use App\Common\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        view()->share('currentNav', 'home');
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function dashboard(Request $request): View|Factory|Application
    {
        return view('admin.dashboard');
    }
}
