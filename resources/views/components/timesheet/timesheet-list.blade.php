@props(['object', 'timesheets', 'users'])
@push('header_scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@endpush

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
    <button onclick="openModal('{{ $object }}')"
        class="inline-flex items-center mb-4 px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">Add
        Timesheet
    </button>
@endhasrole

<div class="bg-white
        overflow-hidden shadow-xl sm:rounded-lg">
    <div class="border-b border-gray-200 bg-white p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100" align="center">
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
                            <td class="border-b px-4 py-2" align="center">
                                @if ($timesheet->is_approved)
                                    <svg width="16px" height="16px" viewBox="0 0 32 32" version="1.1"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#00f030"
                                        stroke="#00f030">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <g id="Page-1" stroke="none" stroke-width="1" fill="none"
                                                fill-rule="evenodd" sketch:type="MSPage">
                                                <g id="Icon-Set-Filled" sketch:type="MSLayerGroup"
                                                    transform="translate(-102.000000, -1141.000000)" fill="#00bd42">
                                                    <path
                                                        d="M124.393,1151.43 C124.393,1151.43 117.335,1163.73 117.213,1163.84 C116.81,1164.22 116.177,1164.2 115.8,1163.8 L111.228,1159.58 C110.85,1159.18 110.871,1158.54 111.274,1158.17 C111.677,1157.79 112.31,1157.81 112.688,1158.21 L116.266,1161.51 L122.661,1150.43 C122.937,1149.96 123.548,1149.79 124.027,1150.07 C124.505,1150.34 124.669,1150.96 124.393,1151.43 L124.393,1151.43 Z M118,1141 C109.164,1141 102,1148.16 102,1157 C102,1165.84 109.164,1173 118,1173 C126.836,1173 134,1165.84 134,1157 C134,1148.16 126.836,1141 118,1141 L118,1141 Z"
                                                        id="checkmark-circle" sketch:type="MSShapeGroup"> </path>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                @else
                                    <svg fill="#ec9e32" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="16px" height="16px"
                                        viewBox="0 0 45.311 45.311" xml:space="preserve" stroke="#ec9e32">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round">
                                        </g>
                                        <g id="SVGRepo_iconCarrier">
                                            <g>
                                                <path
                                                    d="M22.675,0.02c-0.006,0-0.014,0.001-0.02,0.001c-0.007,0-0.013-0.001-0.02-0.001C10.135,0.02,0,10.154,0,22.656 c0,12.5,10.135,22.635,22.635,22.635c0.007,0,0.013,0,0.02,0c0.006,0,0.014,0,0.02,0c12.5,0,22.635-10.135,22.635-22.635 C45.311,10.154,35.176,0.02,22.675,0.02z M22.675,38.811c-0.006,0-0.014-0.001-0.02-0.001c-0.007,0-0.013,0.001-0.02,0.001 c-2.046,0-3.705-1.658-3.705-3.705c0-2.045,1.659-3.703,3.705-3.703c0.007,0,0.013,0,0.02,0c0.006,0,0.014,0,0.02,0 c2.045,0,3.706,1.658,3.706,3.703C26.381,37.152,24.723,38.811,22.675,38.811z M27.988,10.578 c-0.242,3.697-1.932,14.692-1.932,14.692c0,1.854-1.519,3.356-3.373,3.356c-0.01,0-0.02,0-0.029,0c-0.009,0-0.02,0-0.029,0 c-1.853,0-3.372-1.504-3.372-3.356c0,0-1.689-10.995-1.931-14.692C17.202,8.727,18.62,5.29,22.626,5.29 c0.01,0,0.02,0.001,0.029,0.001c0.009,0,0.019-0.001,0.029-0.001C26.689,5.29,28.109,8.727,27.988,10.578z">
                                                </path>
                                            </g>
                                        </g>
                                    </svg>
                                @endif
                            </td>
                            <td class="border-b px-4 py-2">
                                {{-- <a href="{{ route('timesheet.edit', $timesheet) }}"
                                    class="text-blue-600 hover:text-blue-800"> View </a> --}}
                                <button onclick="openModal('{{ $object }}', {{ $timesheet->id }})"
                                    class="text-blue-600 hover:text-blue-800">
                                    View
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
