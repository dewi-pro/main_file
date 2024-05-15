<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class SystemAnalyticsController extends Controller
{
    public function telescope()
    {
        if (Auth::user()->type == 'Admin') {
            return view('vendor.telescope.layout');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }
}
