<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Timesheets') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($object === 'timesheet')
                @switch($mode)
                    @case('create')
                        <x-timesheet.timesheet-view :mode='$mode' />
                    @break

                    @case('edit')
                    @case('view')
                        <x-timesheet.timesheet-view :mode='$mode' :timesheet="$timesheet" />
                    @break

                    @default
                        <x-timesheet.timesheet-list :timesheets="$timesheets" :users="$users" />
                @endswitch
            @elseif ($object === 'user')
                @switch($mode)
                    @case('create')
                        <x-user.user-view :mode='$mode' />
                    @break

                    @case('edit')
                    @case('view')
                        <x-user.user-view :mode='$mode' :user="$user" />
                    @break

                    @default
                        <x-user.user-list :users="$users" />
                @endswitch
            @endif
        </div>
    </div>
</x-app-layout>
