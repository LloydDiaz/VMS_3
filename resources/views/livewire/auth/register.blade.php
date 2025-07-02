<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-6">
        <!-- Name -->
        <flux:input
            wire:model="firstname"
            :label="__('First Name')"
            type="text"
            required
            autofocus
            autocomplete="first name"
            :placeholder="__('First name')"
        />
        <flux:input
            wire:model="lastname"
            :label="__('Last Name')"
            type="text"
            required
            autofocus
            autocomplete="last name"
            :placeholder="__('Last name')"
        />
        <flux:input
            wire:model="middlename"
            :label="__('Middle Name')"
            type="text"
            
            autofocus
            autocomplete="middle name"
            :placeholder="__('Middle name')"
        />
        <flux:input
            wire:model="xname"
            :label="__('Extension Name')"
            type="text"
          
            autofocus
            autocomplete="extension name"
            :placeholder="__('Extension name')"
        />
        <flux:input
            wire:model="username"
            :label="__('User name')"
            type="text"
            required
            autofocus
            autocomplete="user name"
            :placeholder="__('User name')"
        />

        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email address')"
            type="email"
            required
            autocomplete="email"
            placeholder="email@example.com"
        />

        <!-- Password -->
        <flux:input
            wire:model="password"
            :label="__('Password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Password')"
            viewable
        />

        <!-- Confirm Password -->
        <flux:input
            wire:model="password_confirmation"
            :label="__('Confirm password')"
            type="password"
            required
            autocomplete="new-password"
            :placeholder="__('Confirm password')"
            viewable
        />

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Create account') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('Already have an account?') }}
        <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>
</div>
