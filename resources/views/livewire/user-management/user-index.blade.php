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
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="p-2">
                {{ $users->links() }}
            </div>
        </div>



        <div x-show="showModal" @close-user-modal.window="showModal = false" @click.outside="showModal = false"
            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-400 bg-opacity-50 backdrop-blur"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex min-h-screen items-end justify-center px-4 text-center sm:block sm:p-0 md:items-center">
                <div x-cloak @click="showModal = false" x-show="showModal"
                    x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-100 transform"
                    x-transition:leave-start="opacity-50" x-transition:leave-end="opacity-0"
                    class="g-opacity-40 fixed inset-0 transition-opacity" aria-hidden="true">
                </div>

                <div x-cloak x-show="showModal" x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="border-1 min-w-lg dark:border-n-700 my-20 inline-block w-full max-w-md transform rounded-xl bg-gray-50 p-6 text-left shadow-xl transition-all 2xl:max-w-2xl dark:bg-neutral-800">
                    <div>
                        <h2 class="mb-4 text-center text-lg font-semibold">Create New User</h2>


                    </div>



                    <form wire:submit.prevent="createUser" class="space-y-4">

                        <div>
                            <flux:select wire:model="user_role" placeholder="Choose Role...">
                                <flux:select.option>admin</flux:select.option>
                                <flux:select.option>user</flux:select.option>
                                <flux:select.option>cashier</flux:select.option>
                                <flux:select.option>enforcer</flux:select.option>
                            </flux:select>
                        </div>
                        <div>
                            <flux:input wire:model="firstname" :label="__('First Name')" type="text" required
                                autofocus autocomplete="first name" :placeholder="__('First name')" />
                        </div>

                        <div>
                            <flux:input wire:model="middlename" :label="__('Middle Name')" type="text" autofocus
                                autocomplete="middlename" :placeholder="__('Middle name')" />
                        </div>

                        <div>
                            <flux:input wire:model="lastname" :label="__('Last Name')" type="text" required autofocus
                                autocomplete="lastname" :placeholder="__('Last name')" />
                        </div>

                        <div>
                            <flux:input wire:model="xname" :label="__('Extension Name')" type="text" autofocus
                                autocomplete="xname" :placeholder="__('Extension name')" />
                        </div>

                        <div>
                            <flux:input wire:model="email" :label="__('Email Address')" type="email" autofocus
                                autocomplete="email" :placeholder="__('email@example.com')" />
                        </div>

                        <div>
                            <flux:input wire:model="username" :label="__('User Name')" type="text" autofocus
                                autocomplete="email" :placeholder="__('User Name')" />
                        </div>

                        <div>
                            <flux:input wire:model="password" :label="__('Password')" type="password" required
                                autocomplete="new-password" :placeholder="__('Password')" viewable />
                        </div>

                        <div class="flex justify-end gap-2 pt-4">
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
