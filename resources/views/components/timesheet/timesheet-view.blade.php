@props(['mode', 'timesheet' => null])
@push('header_scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@endpush

<div class="w-1/3 mx-auto bg-white overflow-hidden shadow-xl sm:rounded-lg">
    <form id="form_submission"
        action="{{ $mode === 'create' ? route('timesheet.store') : route('timesheet.update', $timesheet) }}"
        method="POST" enctype="multipart/form-data" class="p-6">
        @csrf
        <div class="mb-4">
            <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
            <input name="date" x-data x-init="flatpickr($refs.input, { dateFormat: 'Y-m-d', allowInput: true });" x-ref="input" type="text" data-input required
                class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm disabled:bg-gray-100 disabled:cursor-not-allowed"
                @if ($mode == 'edit' || $mode == 'view' || old('date')) value="{{ old('date', $timesheet != null ? $timesheet->date : '') }}" @endif
                @if ($mode == 'view') disabled @endif />
            @error('date')
                <div class="mt-2 text-sm text-red-600 flex items-center">
                    <svg class="w-5 h-5 mr-1 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-11.293a1 1 0 00-1.414 0L9 8.414l-1.293-1.293a1 1 0 00-1.414 1.414L7.586 9.828l-1.293 1.293a1 1 0 101.414 1.414L9 11.414l1.293 1.293a1 1 0 001.414-1.414L10.414 9.828l1.293-1.293a1 1 0 000-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="time_in" class="block text-sm font-medium text-gray-700">Time In</label>
            <input name="time_in" x-data x-init="flatpickr($refs.input, { dateFormat: 'H:i:S', allowInput: true, enableTime: true, noCalendar: true, altInput: true, altFormat: 'h:i K' });" x-ref="input" type="text" data-input required
                class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm disabled:bg-gray-100 disabled:cursor-not-allowed"
                @if ($mode == 'edit' || $mode == 'view' || old('time_in')) value="{{ old('time_in', $timesheet != null ? $timesheet->time_in : '') }}" @endif
                @if ($mode == 'view') disabled @endif />
            @error('time_in')
                <div class="mt-2 text-sm text-red-600 flex items-center">
                    <svg class="w-5 h-5 mr-1 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-11.293a1 1 0 00-1.414 0L9 8.414l-1.293-1.293a1 1 0 00-1.414 1.414L7.586 9.828l-1.293 1.293a1 1 0 101.414 1.414L9 11.414l1.293 1.293a1 1 0 001.414-1.414L10.414 9.828l1.293-1.293a1 1 0 000-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="time_out" class="block text-sm font-medium text-gray-700">Time Out</label>
            <input name="time_out" x-data x-init="flatpickr($refs.input, { dateFormat: 'H:i:S', allowInput: true, enableTime: true, noCalendar: true, altInput: true, altFormat: 'h:i K' });" x-ref="input" type="text" data-input required
                class="mt-1 block rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm disabled:bg-gray-100 disabled:cursor-not-allowed"
                @if ($mode == 'edit' || $mode == 'view' || old('time_out')) value="{{ old('time_out', $timesheet != null ? $timesheet->time_out : '') }}" @endif
                @if ($mode == 'view') disabled @endif />
            @error('time_out')
                <div class="mt-2 text-sm text-red-600 flex items-center">
                    <svg class="w-5 h-5 mr-1 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-11.293a1 1 0 00-1.414 0L9 8.414l-1.293-1.293a1 1 0 00-1.414 1.414L7.586 9.828l-1.293 1.293a1 1 0 101.414 1.414L9 11.414l1.293 1.293a1 1 0 001.414-1.414L10.414 9.828l1.293-1.293a1 1 0 000-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="task_information" class="block text-sm font-medium text-gray-700">Project / Task
                Information</label>
            <textarea name="task_information" id="task_information" rows="3" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm disabled:bg-gray-100 disabled:cursor-not-allowed"
                @if ($mode == 'view') disabled @endif>
@if ($mode == 'edit' || $mode == 'view' || old('task_information'))
{{ old('task_information', $timesheet != null ? $timesheet->task_information : '') }}
@endif
</textarea>
            @error('task_information')
                <div class="mt-2 text-sm text-red-600 flex items-center">
                    <svg class="w-5 h-5 mr-1 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-11.293a1 1 0 00-1.414 0L9 8.414l-1.293-1.293a1 1 0 00-1.414 1.414L7.586 9.828l-1.293 1.293a1 1 0 101.414 1.414L9 11.414l1.293 1.293a1 1 0 001.414-1.414L10.414 9.828l1.293-1.293a1 1 0 000-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="flex justify-end space-x-4 mt-4">
            @if ($mode === 'create')
                <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Submit</button>
            @else
                @if (Auth::user()->id == $timesheet->user->id)
                    <button type="button" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700"
                        onclick="confirmDelete(event)">Delete</button>

                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Update</button>
                @endif
                @hasrole('admin')
                    <button type="button" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700"
                        onclick="document.getElementById('approve_form').submit();">Approve</button>
                @endhasrole
            @endif
        </div>
    </form>

    @if ($mode !== 'create')
        @if (Auth::user()->id == $timesheet->user->id)
            <form id="delete_form" action="{{ route('timesheet.destroy', $timesheet) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
            </form>
        @endif
        @hasrole('admin')
            <form id="approve_form" action="{{ route('timesheet.approve', $timesheet) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
            </form>
        @endhasrole
    @endif
</div>

<script>
    function confirmDelete(event) {
        event.preventDefault();
        if (confirm('Are you sure you want to delete this timesheet?')) {
            document.getElementById('delete_form').submit();
        }
    }
</script>
