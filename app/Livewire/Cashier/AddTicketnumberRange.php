<?php

namespace App\Livewire\Cashier;

use App\Models\TicketRange;
use App\Models\TicketRangeRequest;
use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;


use Livewire\WithPagination;

class AddTicketnumberRange extends Component
{
    use WithPagination;
    public $start_number;
    public $end_number;
    public $search = '';
    public $enforcer_id;

    protected $updatesQueryString = ['search'];

    public function approve($requestId)
    {
        $request = TicketRangeRequest::findOrFail($requestId);
        $user = $request->user;

        $hasIncomplete = $user->ticketRanges()
            ->where('year', now()->year)
            ->where(function ($q) {
                $q->whereNull('current_number')
                    ->orWhereColumn('current_number', '<', 'end_number');
            })->exists();

        if ($hasIncomplete) {
            session()->flash('error', 'User has an unfinished bundle.');
            return;
        }

        $year = now()->year;
        $last = TicketRange::where('year', $year)->orderByDesc('end_number')->first();
        $start = $last ? $last->end_number + 1 : 1;
        $end = $start + 49;

        TicketRange::create([
            'user_id' => $user->id,
            'start_number' => $start,
            'end_number' => $end,
            'year' => $year,
            'current_number' => null,
        ]);

        $request->update(['status' => 'approved']);

        session()->flash('success', 'Approved and assigned ticket range to ' . $user->firstname . '' . $user->lastname);
    }


    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $enforcersWithRanges = User::where('user_role', 'enforcer')
            ->whereHas('ticketRanges')
            ->where(function ($query) {
                $query->where('firstname', 'like', '%' . $this->search . '%')
                    ->orWhere('lastname', 'like', '%' . $this->search . '%');
            })
            ->with(['ticketRanges' => function ($query) {
                $query->orderByDesc('year');
            }, 'tickets']) // Include tickets for usage calculation
            ->paginate(5);

        // Inject used/total ticket data into each enforcer's ticketRanges
        foreach ($enforcersWithRanges as $enforcer) {
            foreach ($enforcer->ticketRanges as $range) {
                $start = (int) ($range->year . str_pad($range->start_number, 5, '0', STR_PAD_LEFT));
                $end = (int) ($range->year . str_pad($range->end_number, 5, '0', STR_PAD_LEFT));

                $range->used = $enforcer->tickets()
                    ->whereBetween('tct_number', [$start, $end])
                    ->count();

                $range->total = $range->end_number - $range->start_number + 1;
            }
        }

        $allEnforcers = User::where('user_role', 'enforcer')
            ->orderBy('lastname')
            ->get(); // for dropdown

        return view('livewire.cashier.add-ticketnumber-range', [
            'enforcers' => $enforcersWithRanges,     // list view (with "used" and "total" injected)
            'dropdownEnforcers' => $allEnforcers,    // dropdown (full list)
            'requests' => TicketRangeRequest::with('user')->where('status', 'pending')->get(),
        ]);
    }
}
