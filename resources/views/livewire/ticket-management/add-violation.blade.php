<div>
    <div class="p-6" x-data="{ showModal: false }">
        <!-- Flash Message -->
        @if (session()->has('message'))
            <div class="mb-4 rounded bg-green-100 px-4 py-2 text-green-800 shadow">
                {{ session('message') }}
            </div>
        @endif

        <!-- Search and Create -->
        <div class="mb-4 flex items-center justify-between">
            <flux:input wire:model.live="search" :label="__('')" type="text" required autofocus
                :placeholder="__('Search  Name')" class="w-1/3" />

            <button @click="showModal = true"
                class="rounded-lg bg-neutral-800 px-5 py-2 font-semibold text-white shadow hover:bg-neutral-900 dark:bg-gray-100 dark:text-black dark:hover:bg-gray-200">
                Add Violation
            </button>
        </div>

        <div class="shadow-xs relative overflow-x-auto rounded-lg border dark:border-zinc-600">
            <table class="w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400">
                <thead class="bg-zinc-700 text-xs uppercase text-gray-700 dark:bg-zinc-900 dark:text-gray-100">
                    <tr class="border-b border-gray-200 bg-zinc-100 dark:border-zinc-600 dark:bg-zinc-900">
                        <th class="px-6 py-4">Violation Tupe</th>
                        <th class="px-6 py-4">Fine</th>
                        <th class="px-6 py-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($violations as $v)
                        <tr
                            class="border-b border-gray-200 bg-white dark:border-zinc-500 dark:bg-zinc-800 dark:text-white">
                            <td class="px-6 py-2">{{ $v->violation_type }} </td>
                            <td class="px-6 py-2">{{ $v->amount }}</td>
                            <td class="px-6 py-2">
                                <button class="delete-btn text-red-600 hover:underline" data-id="{{ $v->id }}">
                                    Delete
                                </button>

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->

        </div>

        <div x-show="showModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50  px-4 py-6 m"
            @keydown.escape.window="showModal = false">

            <!-- MODAL BOX -->
            <div x-cloak x-show="showModal" x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="mx-auto max-h-[90vh] w-full max-w-lg overflow-y-auto rounded-xl bg-white p-6 shadow-xl transition-all sm:p-8 dark:bg-neutral-800"
                @click.outside="showModal = false">

                <!-- MODAL CONTENT -->
                <h2 class="mb-4 text-center text-xl font-semibold">Add Violation</h2>

                <form wire:submit.prevent="addViolationType" class="space-y-4">
                    <div>
                        <flux:input wire:model="violation_type" :label="__('Violation Type')" type="text" required
                            autofocus />
                    </div>

                    <div>
                        <flux:input wire:model="amount" :label="__('Amount')" type="text" />
                    </div>

                    <div class="flex justify-end gap-2 pt-4">
                        <flux:button type="submit" variant="primary" class="w-full">
                            {{ __('Add Violation') }}
                        </flux:button>
                        <flux:button type="button" @click="showModal = false" variant="danger" class="w-full">
                            {{ __('Cancel') }}
                        </flux:button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('violation_success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ session('violation_success') }}',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        });
    </script>
@endif


<script>
    document.addEventListener('click', function(e) {
        if (e.target.matches('.delete-btn')) {
            const id = e.target.getAttribute('data-id');
            Swal.fire({
                title: 'Are you sure?',
                text: "This violation will be permanently deleted.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('perform-delete', {
                        id: id
                    });
                }
            });
        }
    });

    Livewire.on('violation-deleted', () => {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Violation deleted successfully.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    });
</script>
