<div>
    <div class="p-6" x-data="{ showModal: false }">

        <div class="mb-4 flex items-center justify-between">
            <flux:input wire:model.live="search" :label="__('')" type="text" required autofocus
                :placeholder="__('Search  Name')" class="w-1/3" />

            <button @click="showModal = true"
                class="rounded-lg bg-neutral-800 px-5 py-2 font-semibold text-white shadow hover:bg-neutral-900 dark:bg-gray-100 dark:text-black dark:hover:bg-gray-200">
                Add user
            </button>
        </div>

        <!-- User Table -->
        <div class="shadow-xs relative overflow-x-auto rounded-lg border dark:border-zinc-600">
            <table class="w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400">
                <thead class="bg-zinc-700 text-xs uppercase text-gray-700 dark:bg-zinc-900 dark:text-gray-100">
                    <tr class="border-b border-gray-200 bg-zinc-100 dark:border-zinc-600 dark:bg-zinc-900">
                        <th class="px-6 py-4">Name</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Username</th>
                        <th class="px-6 py-4">user Role</th>
                        <th class="px-6 py-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr
                            class="border-b border-gray-200 bg-white dark:border-zinc-500 dark:bg-zinc-800 dark:text-white">
                            <td class="px-6 py-2">{{ $user->firstname }} {{ $user->lastname }}</td>
                            <td class="px-6 py-2">{{ $user->email }}</td>
                            <td class="px-6 py-2">{{ $user->username }}</td>
                            <td class="px-6 py-2">{{ $user->user_role }}</td>
                            <td>
                            <button class="delete-btn text-red-600 hover:underline" data-id="{{ $user->id }}">
                                Delete
                            </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="p-2">
                {{ $users->links() }}
            </div>
        </div>



        <!-- Modal Backdrop -->
        <div x-show="showModal" @close-user-modal.window="showModal = false" @click.outside="showModal = false"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center   bg-black/50 px-4 py-6 "
            aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">

            <!-- Modal Box -->
            <div x-cloak x-show="showModal" x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="mx-auto max-h-[90vh] border-2 w-full max-w-sm overflow-y-auto rounded-xl bg-neutral-50 p-6 shadow-xl transition-all sm:w-full sm:max-w-lg dark:bg-neutral-800"
                @click.outside="showModal = false" @keydown.escape.window="showModal = false">

                <!-- Modal Title -->
                <h2 class="mb-6 text-center text-xl font-semibold text-gray-800 dark:text-white">Create New User</h2>

                <!-- Modal Form -->
                <form wire:submit.prevent="createUser" class="space-y-4">
                    <!-- Role -->
                    <div>
                        <flux:select wire:model="user_role" placeholder="Choose Role...">
                            <flux:select.option>admin</flux:select.option>
                            <flux:select.option>user</flux:select.option>
                            <flux:select.option>cashier</flux:select.option>
                            <flux:select.option>enforcer</flux:select.option>
                        </flux:select>
                    </div>

                    <!-- Name Fields -->
                    <div>
                        <flux:input wire:model="firstname" :label="__('First Name')" type="text" required autofocus
                            placeholder="First name" />
                    </div>
                    <div>
                        <flux:input wire:model="middlename" :label="__('Middle Name')" type="text"
                            placeholder="Middle name" />
                    </div>
                    <div>
                        <flux:input wire:model="lastname" :label="__('Last Name')" type="text" required
                            placeholder="Last name" />
                    </div>
                    <div>
                        <flux:input wire:model="xname" :label="__('Extension Name')" type="text"
                            placeholder="Extension name" />
                    </div>

                    <!-- Email & Username -->
                    <div>
                        <flux:input wire:model="email" :label="__('Email Address')" type="email"
                            placeholder="email@example.com" />
                    </div>
                    <div>
                        <flux:input wire:model="username" :label="__('User Name')" type="text"
                            placeholder="User name" />
                    </div>

                    <!-- Password -->
                    <div>
                        <flux:input wire:model="password" :label="__('Password')" type="password" required
                            placeholder="Password" viewable />
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col justify-end gap-2 pt-4 sm:flex-row">
                        <flux:button type="submit" variant="primary" class="w-full">
                            {{ __('Create') }}
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if (session('user_success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ session('user_success') }}',
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
                text: "This User will be permanently deleted.",
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

    Livewire.on('User-deleted', () => {
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