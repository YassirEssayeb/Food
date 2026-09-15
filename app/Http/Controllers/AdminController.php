<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\Reservation;
use App\Models\Message;

class AdminController extends Controller
{
    public function index()
    {
        $totalReservations = Reservation::count();
        $totalMessages = Message::where('is_read', false)->count();
        $totalMenuItems = MenuItem::count();
        $recentReservations = Reservation::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('totalReservations', 'totalMessages', 'totalMenuItems', 'recentReservations'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index_menu()
    {
        $menuItems = MenuItem::all();
        return view('admin.menu.index', compact('menuItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.menu.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'is_special' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('menu', 'public');
            $validated['image'] = $path;
        }

        $validated['is_special'] = $request->has('is_special');

        MenuItem::create($validated);

        return redirect()->route('menu-items.index')->with('success', 'Menu item created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MenuItem $menuItem)
    {
        return view('admin.menu.edit', compact('menuItem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MenuItem $menuItem)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'is_special' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('menu', 'public');
            $validated['image'] = $path;
        }

        $validated['is_special'] = $request->has('is_special');

        $menuItem->update($validated);

        return redirect()->route('menu-items.index')->with('success', 'Menu item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();
        return redirect()->route('menu-items.index')->with('success', 'Menu item deleted successfully.');
    }

    public function reservations()
    {
        $reservations = Reservation::orderBy('date', 'desc')->orderBy('time', 'desc')->get();
        return view('admin.reservations', compact('reservations'));
    }

    public function updateReservationStatus(Request $request, Reservation $reservation)
    {
        $reservation->update(['status' => $request->status]);
        return back()->with('success', 'Reservation status updated.');
    }

    public function messages()
    {
        $messages = Message::orderBy('created_at', 'desc')->get();
        return view('admin.messages', compact('messages'));
    }

    public function markMessageRead(Message $message)
    {
        $message->update(['is_read' => true]);
        return back()->with('success', 'Message marked as read.');
    }

    // Since I'm using resource routes, I need to make sure index maps correctly or I use individual routes
    // For simplicity, I'll update web.php to map index to index_menu or just use this:
    public function index_resource() {
        return $this->index_menu();
    }
}
