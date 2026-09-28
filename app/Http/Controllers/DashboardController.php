<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $members = [
            'BERNARTE, Jaylee Johralyn C.',
            'CRUZ, Aaron James',
            'GAVIOLA, Jonna N.',
            'RANESES, Princess Cayenne M.',
            'TAN, Lensy P.',
        ];

        return view('dashboard', compact('members'));
    }
}