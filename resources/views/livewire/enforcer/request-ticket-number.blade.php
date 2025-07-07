<div class="min-h-screen bg-gradient-to-br from-white to-blue-50 px-4 py-6 sm:px-6 md:px-8">
    {{-- Flash Messages --}}
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            class="mb-4 rounded-md bg-green-100 px-4 py-3 text-sm text-green-800 shadow sm:text-base">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            class="mb-4 rounded-md bg-red-100 px-4 py-3 text-sm text-red-800 shadow sm:text-base">
            {{ session('error') }}
        </div>
    @endif

    {{-- Action Button --}}
    <div class="flex justify-start">
        <button wire:click="requestTicketRange"
            class="w-full rounded bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow transition duration-200 hover:bg-blue-700 sm:w-auto sm:text-base">
            Request Ticket Bundle
        </button>
    </div>

    {{-- Loading Indicator --}}
    <div wire:loading wire:target="requestTicketRange" class="mt-4 text-sm text-gray-600">
        Processing your request...
    </div>
</div>
