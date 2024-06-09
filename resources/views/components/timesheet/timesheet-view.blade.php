@props(['mode', 'timesheet' => null])

<div
    class="mx-auto bg-white overflow-hidden shadow-xl sm:rounded-lg {{ Auth()->user()->hasRole('admin') && $mode == 'edit' ? 'flex' : 'w-1/3' }}">
    <div
        class="p-6 border-gray-300 {{ Auth()->user()->hasRole('admin') && $mode == 'edit' ? 'w-1/2 border-r pr-6' : '' }}">
        <h3 class="text-lg font-semibold text-gray-800 leading-tight mb-4">Timesheet Details</h3>
        <div class="mb-4">
            <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
            <input name="date" x-data x-init="flatpickr($refs.input, { dateFormat: 'Y-m-d', allowInput: true });" x-ref="input" type="text" data-input required
                class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm disabled:bg-gray-100 disabled:cursor-not-allowed"
                @if ($mode == 'edit' || Auth()->user()->hasRole('admin') || old('date')) value="{{ old('date', $timesheet != null ? $timesheet->date : '') }}" @endif />
            <x-input-error-bottom :field="'err-date'" />
        </div>
        <div class="mb-4">
            <label for="time_in" class="block text-sm font-medium text-gray-700">Time In</label>
            <input name="time_in" x-data x-init="flatpickr($refs.input, { dateFormat: 'H:i:S', allowInput: true, enableTime: true, noCalendar: true, altInput: true, altFormat: 'h:i K' });" x-ref="input" type="text" data-input required
                class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm disabled:bg-gray-100 disabled:cursor-not-allowed"
                @if ($mode == 'edit' || Auth()->user()->hasRole('admin') || old('time_in')) value="{{ old('time_in', $timesheet != null ? $timesheet->time_in : '') }}" @endif />
            <x-input-error-bottom :field="'err-time_in'" />
        </div>
        <div class="mb-4">
            <label for="time_out" class="block text-sm font-medium text-gray-700">Time Out</label>
            <input name="time_out" x-data x-init="flatpickr($refs.input, { dateFormat: 'H:i:S', allowInput: true, enableTime: true, noCalendar: true, altInput: true, altFormat: 'h:i K' });" x-ref="input" type="text" data-input required
                class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm disabled:bg-gray-100 disabled:cursor-not-allowed"
                @if ($mode == 'edit' || Auth()->user()->hasRole('admin') || old('time_out')) value="{{ old('time_out', $timesheet != null ? $timesheet->time_out : '') }}" @endif />
            <x-input-error-bottom :field="'err-time_out'" />
        </div>
        <div class="mb-4">
            <label for="task_information" class="block text-sm font-medium text-gray-700">Project / Task
                Information</label>
            <textarea name="task_information" id="task_information" rows="3" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm disabled:bg-gray-100 disabled:cursor-not-allowed">
@if ($mode == 'edit' || old('task_information'))
{{ old('task_information', $timesheet != null ? $timesheet->task_information : '') }}
@endif
</textarea>
            <x-input-error-bottom :field="'err-task_information'" />
        </div>

        @if ($mode == 'edit')
            <div class="mb-4 flex">
                <label for="is_approved" class="block text-sm font-medium text-gray-700 mr-2">Status</label>
                <div class="flex items-center">
                    @if ($timesheet->is_approved)
                        <svg width="16px" height="16px" viewBox="0 0 32 32" version="1.1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#00f030" stroke="#00f030"
                            class="mr-1">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                                    sketch:type="MSPage">
                                    <g id="Icon-Set-Filled" sketch:type="MSLayerGroup"
                                        transform="translate(-102.000000, -1141.000000)" fill="#00bd42">
                                        <path
                                            d="M124.393,1151.43 C124.393,1151.43 117.335,1163.73 117.213,1163.84 C116.81,1164.22 116.177,1164.2 115.8,1163.8 L111.228,1159.58 C110.85,1159.18 110.871,1158.54 111.274,1158.17 C111.677,1157.79 112.31,1157.81 112.688,1158.21 L116.266,1161.51 L122.661,1150.43 C122.937,1149.96 123.548,1149.79 124.027,1150.07 C124.505,1150.34 124.669,1150.96 124.393,1151.43 L124.393,1151.43 Z M118,1141 C109.164,1141 102,1148.16 102,1157 C102,1165.84 109.164,1173 118,1173 C126.836,1173 134,1165.84 134,1157 C134,1148.16 126.836,1141 118,1141 L118,1141 Z"
                                            id="checkmark-circle" sketch:type="MSShapeGroup"> </path>
                                    </g>
                                </g>
                            </g>
                        </svg>
                        <span class="text-sm font-medium text-gray-700">Approved</span>
                    @else
                        <svg fill="#ec9e32" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" width="16px" height="16px"
                            viewBox="0 0 45.311 45.311" xml:space="preserve" stroke="#ec9e32" class="mr-1">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <g>
                                    <path
                                        d="M22.675,0.02c-0.006,0-0.014,0.001-0.02,0.001c-0.007,0-0.013-0.001-0.02-0.001C10.135,0.02,0,10.154,0,22.656 c0,12.5,10.135,22.635,22.635,22.635c0.007,0,0.013,0,0.02,0c0.006,0,0.014,0,0.02,0c12.5,0,22.635-10.135,22.635-22.635 C45.311,10.154,35.176,0.02,22.675,0.02z M22.675,38.811c-0.006,0-0.014-0.001-0.02-0.001c-0.007,0-0.013,0.001-0.02,0.001 c-2.046,0-3.705-1.658-3.705-3.705c0-2.045,1.659-3.703,3.705-3.703c0.007,0,0.013,0,0.02,0c0.006,0,0.014,0,0.02,0 c2.045,0,3.706,1.658,3.706,3.703C26.381,37.152,24.723,38.811,22.675,38.811z M27.988,10.578 c-0.242,3.697-1.932,14.692-1.932,14.692c0,1.854-1.519,3.356-3.373,3.356c-0.01,0-0.02,0-0.029,0c-0.009,0-0.02,0-0.029,0 c-1.853,0-3.372-1.504-3.372-3.356c0,0-1.689-10.995-1.931-14.692C17.202,8.727,18.62,5.29,22.626,5.29 c0.01,0,0.02,0.001,0.029,0.001c0.009,0,0.019-0.001,0.029-0.001C26.689,5.29,28.109,8.727,27.988,10.578z">
                                    </path>
                                </g>
                            </g>
                        </svg>
                        <span class="text-sm font-medium text-gray-700">Pending</span>
                    @endif
                </div>
            </div>
        @endif

        <div class="flex justify-end space-x-4 mt-4">
            @if ($mode === 'create')
                <button type="button" onclick="createTimesheet()"
                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Submit</button>
            @else
                @if (Auth()->user()->hasRole('admin') || Auth::user()->id == $timesheet->user->id)
                    <button type="button" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700"
                        onclick="confirmDelete('{{ $object }}', {{ $timesheet->id }})">Delete</button>

                    <button type="button" onclick="updateTimesheet({{ $timesheet->id }})"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Update</button>
                @endif
                @hasrole('admin')
                    @if ($timesheet->is_approved === false)
                        <button type="button" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700"
                            onclick="approveTimesheet({{ $timesheet->id }})">Approve</button>
                    @endif
                @endhasrole
            @endif
        </div>
    </div>

    @hasrole('admin')
        @if ($mode !== 'create')
            <div class="w-1/2 border-r border-gray-300 pr-6 p-6">
                <h3 class="text-lg font-semibold text-gray-800 leading-tight mb-4">User Details</h3>
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input id="name"
                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm disabled:bg-gray-100 disabled:cursor-not-allowed"
                        type="text" value="{{ $timesheet->user->name }}" disabled />
                </div>

                <div class="mb-4">
                    <label for="ic" class="block text-sm font-medium text-gray-700">Identity No.</label>
                    <input id="ic"
                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm disabled:bg-gray-100 disabled:cursor-not-allowed"
                        type="text" value="{{ $timesheet->user->ic }}" disabled />
                </div>

                <div class="mb-4">
                    <label for="epf_no" class="block text-sm font-medium text-gray-700">EPF No.</label>
                    <input type="text" name="epf_no" id="epf_no" value={{ $timesheet->user->epf_no }}
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm disabled:bg-gray-100 disabled:cursor-not-allowed"
                        disabled />
                </div>

                <div class="mb-4">
                    <label for="socso_no" class="block text-sm font-medium text-gray-700">SOCSO No.</label>
                    <input type="text" name="socso_no" id="socso_no" value={{ $timesheet->user->socso_no }}
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm disabled:bg-gray-100 disabled:cursor-not-allowed"
                        disabled>
                </div>

                <div class="mb-4">
                    <label for="employee_no" class="block text-sm font-medium text-gray-700">Employee No.</label>
                    <input type="text" name="employee_no" id="employee_no" value={{ $timesheet->user->employee_no }}
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm disabled:bg-gray-100 disabled:cursor-not-allowed"
                        disabled>
                </div>
            </div>
        @endif
    @endhasrole
</div>
