<div class="rounded bg-white p-6 shadow">
    <h2 class="mb-4 text-lg font-semibold">Assign Ticket Bundle to Enforcer</h2>

    @if (session('message'))
        <div class="mb-4 text-green-600">{{ session('message') }}</div>
    @endif

    <div>
        @if (session()->has('success'))
            <p class="text-green-600">{{ session('success') }}</p>
        @endif
        @if (session()->has('error'))
            <p class="text-red-600">{{ session('error') }}</p>
        @endif

        <h2 class="mb-2 font-bold">Pending Ticket Requests</h2>

        @forelse($requests as $request)
            <div class="mb-3 border p-2">
                <p><strong>{{ ucfirst(trans($request->user->firstname)) }}
                        {{ ucfirst(trans($request->user->lastname)) }}</strong>
                    requested a ticket
                    bundle
                    ({{ $request->created_at->diffForHumans() }})
                </p>
                <button wire:click="approve({{ $request->id }})" class="rounded bg-green-600 px-3 py-1 text-white">
                    Approve & Assign
                </button>
            </div>
        @empty
            <p>No pending requests.</p>
        @endforelse
    </div>

    <hr class="my-6">

    <h3 class="text-md mb-2 font-semibold">Existing Ticket Ranges per Enforcer</h3>

    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Search Enforcer:</label>
        <input type="text" wire:model.live="search" placeholder="Type name..."
            class="w-full rounded border px-3 py-2 shadow-sm" />
    </div>

    <div class="mt-6 space-y-4">
        @foreach ($enforcers as $enforcer)
            <div x-data="{ open: false }" class="rounded-md border p-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-md font-semibold">
                        {{ $enforcer->firstname }} {{ $enforcer->lastname }}
                    </h3>
                    {{-- <button @click="open = !open" class="text-sm text-blue-600 hover:underline">
                        View Ranges
                    </button> --}}
                </div>

                <div class="mt-2 text-sm text-gray-700">
                    @if ($enforcer->ticketRanges->isEmpty())
                        <p class="text-gray-400">No ranges assigned.</p>
                    @else
                        <ul>
                            @foreach ($enforcer->ticketRanges as $range)
                                <li>
                                    <strong>{{ $range->year }}</strong>:
                                    {{ $range->start_number }} → {{ $range->end_number }}
                                    (Used: {{ $range->used }} / {{ $range->total }})
                                </li>
                            @endforeach
                        </ul>
                </div>
        @endif
    </div>
    @endforeach
</div>
<div class="mt-4">
    {{ $enforcers->links() }}
</div>
