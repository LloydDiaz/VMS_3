 <div>
     <livewire:breadcrumbs />
     <span class="mx-6 bg-green-500 px-4 text-gray-50">
         Ticket Number Used: <strong>{{ $totalTicketsUsed }} /
             {{ $totalTicketsissued }}</strong>
     </span>
     <div class="rounded-lg border bg-gray-50 p-4 text-left shadow-md dark:border-gray-700 dark:bg-gray-800 sm:p-8">
         <h2 class="mb-6 text-xl font-semibold">Add Violation Ticket</h2>
         <form wire:submit.prevent="submit" class="p-4">
             <!-- Grid layout: full width on mobile, multiple columns on larger screens -->
             <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                 <!-- Example input -->

                 <div>
                     <label class="block text-sm font-medium text-gray-700">Date</label>
                     <input type="date" wire:model="tct_date"
                         class="mt-1 w-full rounded-md border px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                     @error('tct_date')
                         <span class="mt-3 block text-xs text-red-500">{{ $message }}</span>
                     @enderror
                 </div>
                 <div>
                     <label class="block text-sm font-medium text-gray-700">Time</label>
                     <input type="time" wire:model="time"
                         class="mt-1 w-full rounded-md border px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                 </div>
                 <div>
                     <label class="block text-sm font-medium text-gray-700">First Name</label>
                     <input type="text" wire:model="fname"
                         class="mt-1 w-full rounded-md border px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                     @error('fname')
                         <span class="mt-3 block text-xs text-red-500">{{ $message }}</span>
                     @enderror
                 </div>
                 <div>
                     <label class="block text-sm font-medium text-gray-700">Last Name</label>
                     <input type="text" wire:model="lname"
                         class="mt-1 w-full rounded-md border px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                     @error('lname')
                         <span class="mt-3 block text-xs text-red-500">{{ $message }}</span>
                     @enderror
                 </div>
                 <div>
                     <label class="block text-sm font-medium text-gray-700">Middle Name</label>
                     <input type="text" wire:model="mname"
                         class="mt-1 w-full rounded-md border px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                 </div>
                 <div>
                     <label class="block text-sm font-medium text-gray-700">Extension Number</label>
                     <input type="text" wire:model="xname"
                         class="mt-1 w-full rounded-md border px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                 </div>
                 <div>
                     <label class="block text-sm font-medium text-gray-700">Date of birth</label>
                     <input type="date" wire:model="dob"
                         class="mt-1 w-full rounded-md border px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                     @error('dob')
                         <span class="mt-3 block text-xs text-red-500">{{ $message }}</span>
                     @enderror
                 </div>
                 <div>
                     <label class="block text-sm font-medium text-gray-700">Streed Address</label>
                     <input type="text" wire:model="street_address"
                         class="mt-1 w-full rounded-md border px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                 </div>
                 <div>
                     <label class="block text-sm font-medium text-gray-700">Region</label>
                     <select wire:model.live="regionPSGCcode" id="regionPSGCcode"
                         class="mt-1 w-full rounded-md border px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                         <option selected>Select Region</option>
                         @foreach ($this->region2 as $region)
                             <option value="{{ $region->psgccode }}">{{ $region->name }}</option>
                         @endforeach
                     </select>
                 </div>
                 <div>
                     <label class="block text-sm font-medium text-gray-700">Province</label>

                     <select wire:model.live="provincePSGCcode" id="provincePSGCcode"
                         class="mt-1 w-full rounded-md border px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                         <option selected>Select Province</option>
                         @foreach ($this->province as $prov)
                             <option value="{{ $prov->psgccode }}">{{ $prov->name }}</option>
                         @endforeach

                     </select>
                 </div>
                 <div>
                     <label class="block text-sm font-medium text-gray-700">Municipality</label>
                     <select wire:model.live="municipalPSGCcode" id="municipalPSGCcode"
                         class="mt-1 w-full rounded-md border px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                         <option selected>Select Municipality</option>
                         @foreach ($this->municipality as $mun)
                             <option value="{{ $mun->psgccode }}">{{ $mun->name }}</option>
                         @endforeach
                     </select>
                 </div>
                 <div>
                     <label class="block text-sm font-medium text-gray-700">Barangay</label>
                     <select wire:model="brgyPSGCcode" id="brgyPSGCcode"
                         class="mt-1 w-full rounded-md border px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                         <option selected>Select Barangay</option>
                         @foreach ($this->barangay as $brgy)
                             <option value="{{ $brgy->psgccode }}">{{ $brgy->name }}</option>
                         @endforeach
                     </select>
                 </div>
                 <div>
                     <label class="block text-sm font-medium text-gray-700">Contact number</label>
                     <input type="text" wire:model="contact_number"
                         class="mt-1 w-full rounded-md border px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                 </div>
                 <div>
                     <label class="block text-sm font-medium text-gray-700">Confiscated</label>
                     <input type="text" wire:model="con_item"
                         class="mt-1 w-full rounded-md border px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                 </div>
                 <div>
                     <label class="block text-sm font-medium text-gray-700">Type Of Vehicle</label>
                     <input type="text" wire:model="mv_type"
                         class="mt-1 w-full rounded-md border px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                 </div>
                 <div>
                     <label class="block text-sm font-medium text-gray-700">Plate Number</label>
                     <input type="text" wire:model="plate_number"
                         class="mt-1 w-full rounded-md border px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                 </div>
                 <div>
                     <label class="block text-sm font-medium text-gray-700">Engine Number</label>
                     <input type="text" wire:model="engine_number"
                         class="mt-1 w-full rounded-md border px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                 </div>
                 <div>
                     <label class="block text-sm font-medium text-gray-700">MV Registration Number</label>
                     <input type="text" wire:model="mv_reg_number"
                         class="mt-1 w-full rounded-md border px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                 </div>
                 <div>
                     <label class="block text-sm font-medium text-gray-700">License Number</label>
                     <input type="text" wire:model="license_number"
                         class="mt-1 w-full rounded-md border px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                 </div>
                 <div>
                     <label class="block text-sm font-medium text-gray-700">Owner of Vehicle</label>
                     <input type="text" wire:model="owner_vehicle"
                         class="mt-1 w-full rounded-md border px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                 </div>
                 <div>
                     <label class="block text-sm font-medium text-gray-700">Chasis Number</label>
                     <input type="text" wire:model="chasis_number"
                         class="mt-1 w-full rounded-md border px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                 </div>
                 <div>
                     <label class="block text-sm font-medium text-gray-700">Place of Citatiom</label>
                     <input type="text" wire:model="place_of_citation"
                         class="mt-1 w-full rounded-md border px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                 </div>
                 <div>
                     <label class="block text-sm font-medium text-gray-700">Select Violation</label>
                     <div x-data="{
                         open: false,
                         search: '',
                         filteredOptions: @entangle('options'),
                         selectedOptions: @entangle('selectedOptions'),
                         selectedCount: 0,
                     
                         filterOptions() {
                             this.filteredOptions = @js($options).filter(option =>
                                 option.violation_type.toLowerCase().includes(this.search.toLowerCase())
                             );
                         },
                     
                         updateSelectedCount() {
                             this.selectedCount = this.selectedOptions.length;
                         }
                     }" x-init="$watch('selectedOptions', () => updateSelectedCount())" class="relative">

                         <!-- Selected items (Count) in the dropdown toggle button -->
                         <div @click="open = !open"
                             class="mt-1 flex cursor-pointer items-center justify-between rounded-md border border-gray-500 p-2">
                             <span
                                 x-text="selectedCount > 0 ? `${selectedCount} item(s) selected` : 'Select options'"></span>
                             <span class="ml-2 text-gray-500" x-text="open ? '▲' : '▼'"></span>
                         </div>

                         <!-- Dropdown options -->
                         <div x-show="open" @click.outside="open = false"
                             class="absolute bottom-full left-0 z-10 mb-2 max-h-60 w-full overflow-y-auto rounded-md border border-gray-300 bg-white shadow-lg">

                             <!-- Search box -->
                             <div class="px-4 py-2">
                                 <input type="text" placeholder="Search..." class="w-full rounded border p-2"
                                     x-model="search" @input="filterOptions" />
                             </div>

                             <!-- Display selected count at the top of the options list -->
                             <div class="px-4 py-2 text-sm font-semibold text-blue-600">
                                 <span
                                     x-text="selectedCount > 0 ? `${selectedCount} item(s) selected` : 'No items selected'"></span>
                             </div>

                             <!-- List of options -->
                             <div>
                                 <template x-for="option in filteredOptions" :key="option.id">
                                     <div class="flex items-center px-4 py-2">
                                         <input type="checkbox" :value="option.id"
                                             @click="$wire.toggleOption(option.id); updateSelectedCount()"
                                             :checked="$wire.selectedOptions.includes(option.id)" />
                                         <span class="ml-2" x-text="option.violation_type"></span>
                                     </div>
                                 </template>
                             </div>
                         </div>
                     </div>
                 </div>

                 @if (session('error'))
                     <div class="text-red-600">{{ session('error') }}</div>
                 @endif

                 <!-- Repeat similar div blocks for all 21 inputs -->
                 <!-- ... -->
             </div>

             <div class="mt-6 flex justify-center">
                 <button wire:click.prevent="store" type="submit"
                     class="w-full rounded bg-green-600 px-32 py-2 text-white hover:bg-green-700 sm:w-auto">
                     Add
                 </button>
             </div>
         </form>
     </div>

     <script>
         window.addEventListener('open-pdf', event => {
             const base64 = event.detail.pdf;
             const win = window.open("");
             win.document.write(`
            <iframe src="data:application/pdf;base64,${base64}" 
                    style="width:100%;height:100%" 
                    onload="this.contentWindow.print();">
            </iframe>
        `);
         });
     </script>
 </div>
