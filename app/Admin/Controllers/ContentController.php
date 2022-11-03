<?php

namespace App\Admin\Controllers;

use App\Common\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function __construct()
    {
        view()->share('currentNav', 'content');
    }

    public function index(Request $request, $model): Factory|View|Application
    {
        return view('admin.content.index', compact('model'));
    }

    public function add(Request $request, $model): Factory|View|Application
    {
        return view('admin.content.add', compact('model'));
    }

    public function edit(Request $request, $model): Factory|View|Application
    {
        return view('admin.content.edit', compact('model'));
    }
}
