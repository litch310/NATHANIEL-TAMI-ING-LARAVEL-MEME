<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GiftController extends Controller
{
    /**
     * Show the gift page to a logged-in human.
     */
    public function __invoke(Request $request): View
    {
        return view('gift', [
            'human' => $request->user(),
            'verifiedHumanCount' => User::count(),
        ]);
    }
}
