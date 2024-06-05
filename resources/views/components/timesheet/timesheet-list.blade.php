@props(['timesheets', 'users'])

@hasrole('admin')
    <div class="flex justify-between items-center mb-4">
        <div>
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                        <span>Filter by User</span>
                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M5.293 9.293a1 1 0 011.414 0L10 12.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link href="{{ route('timesheet.index') }}">
                        All
                    </x-dropdown-link>
                    @foreach ($users as $user)
                        <x-dropdown-link href="{{ route('timesheet.index') }}?user={{ $user->id }}"
                            class="truncate max-w-xs">
                            {{ $user->name }}
                        </x-dropdown-link>
                    @endforeach
                </x-slot>
            </x-dropdown>
        </div>
    </div>
@endhasrole

<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
    <div class="border-b border-gray-200 bg-white p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border-b px-4 py-2 text-left">Name</th>
                        <th class="border-b px-4 py-2 text-left">Date</th>
                        <th class="border-b px-4 py-2 text-left">Time In</th>
                        <th class="border-b px-4 py-2 text-left">Time Out</th>
                        <th class="border-b px-4 py-2 text-left">Working Hours</th>
                        <th class="border-b px-4 py-2 text-left">Task Information</th>
                        <th class="border-b px-4 py-2 text-left">Status</th>
                        <th class="border-b px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($timesheets as $timesheet)
                        <tr>
                            <td class="border-b px-4 py-2">{{ $timesheet->user->name }}</td>
                            <td class="border-b px-4 py-2">{{ $timesheet->date }}</td>
                            <td class="border-b px-4 py-2">{{ $timesheet->formatted_time_in }}</td>
                            <td class="border-b px-4 py-2">{{ $timesheet->formatted_time_out }}</td>
                            <td class="border-b px-4 py-2">{{ $timesheet->workingHours() }} hour(s)</td>
                            <td class="border-b px-4 py-2">{{ $timesheet->task_information }}</td>
                            <td class="border-b px-4 py-2">
                                {{ $timesheet->is_approved === true ? 'approved' : 'pending' }}</td>
                            <td class="border-b px-4 py-2">
                                <a href="{{ route('timesheet.edit', $timesheet) }}"
                                    class="text-blue-600 hover:text-blue-800"> View </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
