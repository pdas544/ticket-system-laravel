<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

/**
 *
 */
class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::with('user','categories')->latest()->paginate(10);

        /**
         * we can pass data to the view using compact method and using an associative array
         * for eg: view('tickets.index',['tickets'=>$tickets]);
         *
         */
        return view('tickets.index',compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'priority' => 'required|in:low,medium,high',
            'category_ids' => 'nullable|array', // For attaching categories
            'category_ids.*' => 'exists:categories,id' // Each ID must exist in DB
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        // Load the ticket's relationships
        $ticket->load(['user', 'agent', 'categories']);

        // Pass the single ticket to the 'tickets.show' view
        return view('tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
