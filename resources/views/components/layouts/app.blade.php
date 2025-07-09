<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.store('modal', {
                    show: false
                });
            });
        </script>
        
    </flux:main>
@livewire('bottom-nav')
</x-layouts.app.sidebar>
