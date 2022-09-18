<?php

namespace App\Admin\Controllers;

use App\Common\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ModelController extends Controller
{
    public function __construct()
    {
        view()->share('currentNav', 'model');
    }

    public function index(Request $request): Factory|View|Application
    {
        return view('admin.model.index');
    }

    public function add(Request $request): Factory|View|Application
    {
        return view('admin.model.add');
    }

    public function edit(Request $request, $id): Factory|View|Application
    {
        $id = (int) $id;
        return view('admin.model.edit', compact('id'));
    }
}
