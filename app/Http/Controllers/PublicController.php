<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\Reservation;
use App\Models\Message;
use App\Models\Order;
use App\Models\FoodReview;

class PublicController extends Controller
{
    public function index()
    {
        $specials = MenuItem::where('is_special', true)->get();
        $reviews = FoodReview::latest()->take(10)->get();
        return view('welcome', compact('specials', 'reviews'));
    }

    public function menu()
    {
        $categories = MenuItem::select('category')->distinct()->get();
        $menuItems = MenuItem::all()->groupBy('category');
        return view('menu', compact('menuItems', 'categories'));
    }

    public function reservation()
    {
        return view('reservation');
    }

    public function storeReservation(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'party_size' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        Reservation::create($validated);

        return back()->with('success', 'Your reservation has been submitted successfully!');
    }

    public function contact()
    {
        return view('contact');
    }

    public function storeMessage(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        Message::create($validated);

        return back()->with('success', 'Thank you for your message. We will get back to you soon!');
    }

    public function storeOrder(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $validated = $request->validate([
                'menu_item_name' => 'required|string|max:255',
                'price' => 'required|numeric',
                'quantity' => 'required|integer|min:1',
                'customer_name' => 'required|string|max:255',
                'customer_email' => 'required|email|max:255',
                'customer_phone' => 'required|string|max:20',
                'delivery_address' => 'required|string',
                'notes' => 'nullable|string',
            ]);

            $validated['total'] = $validated['price'] * $validated['quantity'];
            $validated['status'] = 'pending';

            Order::create($validated);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid request'], 400);
    }

    public function storeReview(Request $request)
    {
        // If it's a GET request with _load=1, return reviews
        if ($request->isMethod('get') && $request->_load) {
            $reviews = FoodReview::where('menu_item_name', $request->menu_item_name)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($r) {
                    return [
                        'user_name' => $r->user_name,
                        'comment' => $r->comment,
                        'rating' => $r->rating,
                        'created_at' => $r->created_at->diffForHumans(),
                    ];
                });

            return response()->json(['reviews' => $reviews]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            $validated = $request->validate([
                'menu_item_name' => 'required|string|max:255',
                'user_name' => 'required|string|max:255',
                'comment' => 'required|string',
                'rating' => 'nullable|integer|min:1|max:5',
            ]);

            FoodReview::create($validated);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid request'], 400);
    }
}
