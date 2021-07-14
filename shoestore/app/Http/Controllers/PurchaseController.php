<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function postPurchase(Request $request)
    {
        $message = "";
        if ($request->session()->has('basket')) {
            foreach ($request->session()->get('basket') as $id)
                Auth::user()->purchases()->attach($id);
            $request->session()->forget('basket');
            $message = "Purchase succesfully completed.";
        } else
            $message = "Basket is empty";
            
        return view('dashboard', [
            'user' => Auth::user(),
            'message' => $message
        ]);
    }

    public function addToBasket(Request $request, $id)
    {
        $request->session()->push('basket', $id);
        return redirect()->route('checkout');
    }

    public function removeFromBasket(Request $request, $id)
    {
        $articles = $request->session()->pull('basket');
        if (($key = array_search($id, $articles)) !== false) 
            unset($articles[$key]);
        session()->put('basket', $articles);
        return redirect()->route('checkout');
    }
}
