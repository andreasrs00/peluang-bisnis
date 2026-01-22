<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusinessOpportunity;

class DashboardController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.peluang_bisnis.index');
    }
}
