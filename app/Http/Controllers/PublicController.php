<?php

namespace App\Http\Controllers;

use App\Models\BusinessOpportunity;

class PublicController extends Controller
{
    public function home()
    {
        return view('public.home');
    }

    public function opportunities()
    {
        $items = BusinessOpportunity::where('is_active', true)->latest()->get();
        return view('public.opportunities', compact('items'));
    }

    public function opportunityDetail($slug)
    {
        $item = BusinessOpportunity::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('public.opportunity_detail', compact('item'));
    }
}
