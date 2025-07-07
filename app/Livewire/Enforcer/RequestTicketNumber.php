<?php

namespace App\Livewire\Enforcer;

use App\Models\TicketRangeRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class RequestTicketNumber extends Component
{
    public function requestTicketRange()
    {
        $user = Auth::user();

        // Check if enforcer has an unfinished ticket range
        $hasUnfinished = $user->ticketRanges()
            ->where('year', now()->year)
            ->where(function ($q) {
                $q->whereNull('current_number')
                    ->orWhereColumn('current_number', '<', 'end_number');
            })
            ->exists();

        if ($hasUnfinished) {
            session()->flash('error', 'You still have remaining ticket bundle. Please use all your tickets before requesting a new one.');
            return;
            // redirect
            return redirect()->route('enforcer-ticket-request');
        }

        //  Check if a pending request already exists
        $hasPending = TicketRangeRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->exists();

        if ($hasPending) {
            session()->flash('error', 'You already have a pending request.');
            return;
        }

        //  Create a new request
        TicketRangeRequest::create([
            'user_id' => $user->id,
            'status' => 'pending',
        ]);

        session()->flash('success', 'Your ticket request has been submitted for approval.');

        //reset page

    }

    public function render()
    {
        return view('livewire.enforcer.request-ticket-number');
    }
}
