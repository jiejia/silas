<?php

namespace App\Admin\Controllers;

use App\Common\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        view()->share('currentNav', 'content');
    }

    public function index(Request $request, $model = ''): Factory|View|Application
    {
        if (empty($model)) {
            view()->share('currentNav', 'model');
        }
        return view('admin.category.index', compact('model'));
    }

    public function add(Request $request, $model = ''): Factory|View|Application
    {
        if (empty($model)) {
            view()->share('currentNav', 'model');
        }
        return view('admin.category.add', compact('model'));
    }

    public function edit(Request $request, $model = ''): Factory|View|Application
    {
        if (empty($model)) {
            view()->share('currentNav', 'model');
        }
        return view('admin.category.edit', compact('model'));
    }
}
