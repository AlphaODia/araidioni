<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
        public function index()
    {
        $featuredVoyages = [
            [
                'trajet' => 'Conakry - Dakar',
                'date' => Carbon::now()->addDays(3)->format('d/m/Y'),
                'prix' => '150 000 GNF'
            ],
            // ... autres voyages
        ];

        $testimonials = [
            [
                'name' => 'Mamadou Diallo',
                'comment' => 'Service très professionnel, mon colis est arrivé à temps !',
                'avatar' => asset('images/avatars/user1.jpg')
            ],
            // ... autres témoignages
        ];

        return view('client.home', [
            'featuredVoyages' => $featuredVoyages,
            'testimonials' => $testimonials
        ]);
    }
    // HomeController.php
public function about()
{
    return view('client.about');
}

public function contact()
{
    return view('client.contact');
}
}
