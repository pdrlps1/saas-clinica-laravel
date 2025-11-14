<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $organizations = $user->organizations()
            ->withPivot('role')
            ->get();

        $stats = [
            'total_organizations' => $organizations->count(),
            'owned_organizations' => $user->ownedOrganizations()->count(),
        ];

        return view('dashboard', compact('organizations', 'stats'));
    }
}