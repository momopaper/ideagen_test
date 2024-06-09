<x-app-layout>
    <x-spinner />
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if ($object === 'timesheet')
                {{ __('Timesheets') }}
            @elseif ($object === 'user')
                {{ __('Users') }}
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($object === 'timesheet')
                <x-timesheet.timesheet-list :object="$object" :timesheets="$timesheets" :users="$users" />
            @elseif ($object === 'user')
                <x-user.user-list :object="$object" :users="$users" />
            @endif
        </div>
    </div>

    <x-toggle-modal :object="$object" />
</x-app-layout>
