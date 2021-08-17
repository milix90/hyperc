<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PanelController extends Controller
{
    public function index()
    {
        $links = [
            'admin.category.index' => 'Manage Categories',
            'api.categories' => 'API Test : Parent Categories',
        ];

        return view('dashboard', compact('links'));
    }
}
