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
            <input type="text" wire:model.live="search" placeholder="Search users..."
                class="w-1/3 rounded-lg border px-4 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-700" />

            <button @click="showModal = true"
                class="rounded-lg bg-neutral-800 px-5 py-2 font-semibold text-white shadow hover:bg-neutral-900 dark:bg-gray-100 dark:text-black dark:hover:bg-gray-200">
                Add user
            </button>
        </div>

        <!-- User Table -->
        <div class="overflow-x-auto rounded-xl bg-neutral-100 shadow dark:bg-neutral-900">
            <table class="min-w-full border-separate border-spacing-y-1 text-left text-sm">
                <thead class="bg-stone-950 text-xs uppercase text-gray-100 dark:bg-gray-300 dark:text-black">
                    <tr>
                        <th class="px-6 py-3">Name</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Username</th>
                        <th class="px-6 py-3">Created</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="d rounded-xl bg-neutral-100 transition dark:bg-neutral-900">
                            <td class="px-4 py-2">{{ $user->firstname }} {{ $user->lastname }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2">{{ $user->username }}</td>
                            <td class="px-4 py-2">{{ $user->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-4 text-center text-gray-400">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->

        </div>
        <div class="p-4">
            {{ $users->links() }}
        </div>


        <div x-show="showModal" @close-user-modal.window="showModal = false" @click.outside="showModal = false"
            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-400 bg-opacity-50 backdrop-blur"
            aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex min-h-screen items-end justify-center px-4 text-center sm:block sm:p-0 md:items-center">
                <div x-cloak @click="showModal = false" x-show="showModal"
                    x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                    class="g-opacity-40 fixed inset-0 transition-opacity" aria-hidden="true">
                </div>

                <div x-cloak x-show="showModal" x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="border-1 my-20 inline-block w-full max-w-md transform rounded-xl bg-gray-50 p-6 text-left shadow-xl transition-all 2xl:max-w-2xl dark:border-gray-700 dark:bg-gray-800">
                    <div>
                        <h2 class="mb-4 text-center text-lg font-semibold">Create New User</h2>


                    </div>



                    <form wire:submit.prevent="createUser" class="space-y-4">
                        <div>
                            <label class="text-sm">First Name</label>
                            <input type="text" wire:model.defer="firstname" class="w-full rounded border p-2">
                            @error('firstname')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="text-sm">Middle Name</label>
                            <input type="text" wire:model.defer="middlename" class="w-full rounded border p-2">
                        </div>

                        <div>
                            <label class="text-sm">Last Name</label>
                            <input type="text" wire:model.defer="lastname" class="w-full rounded border p-2">
                            @error('lastname')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="text-sm">Extension Name</label>
                            <input type="text" wire:model.defer="xname" class="w-full rounded border p-2">
                        </div>

                        <div>
                            <label class="text-sm">Email</label>
                            <input type="email" wire:model.defer="email" class="w-full rounded border p-2">
                            @error('email')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="text-sm">Username</label>
                            <input type="text" wire:model.defer="username" class="w-full rounded border p-2">
                            @error('username')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="text-sm">Password</label>
                            <input type="password" wire:model.defer="password" class="w-full rounded border p-2">
                            @error('password')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex justify-end gap-2 pt-4">
                            <button type="button" @click="showModal = false"
                                class="rounded bg-gray-300 px-4 py-2">Cancel</button>
                            <button type="submit"
                                class="rounded bg-gray-600 px-4 py-2 text-white hover:bg-gray-700">Save</button>
                        </div>
                    </form>

                </div>

            </div>

        </div>
    </div>
    </div>
