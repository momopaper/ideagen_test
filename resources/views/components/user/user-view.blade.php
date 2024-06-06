@props(['mode', 'user' => null])

<div class="w-1/3 mx-auto bg-white overflow-visible shadow-xl sm:rounded-lg">
    <form id="form_submission" action="{{ $mode === 'create' ? route('user.store') : route('user.update', $user) }}"
        method="POST" enctype="multipart/form-data" class="p-6">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="name" id="name"
                @if ($mode == 'edit' || old('name')) value="{{ old('name', $user != null ? $user->name : '') }}" @endif
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                required>
            @error('name')
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
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="text" name="email" id="email"
                @if ($mode == 'edit' || old('email')) value="{{ old('email', $user != null ? $user->email : '') }}" @endif
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                required>
            @error('email')
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
        @if ($mode == 'create')
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    required>
                @error('password')
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
        @endif

        <div class="mb-4">
            <label for="ic" class="block text-sm font-medium text-gray-700">Identity No.</label>
            <input type="text" name="ic" id="ic"
                @if ($mode == 'edit' || old('ic')) value="{{ old('ic', $user != null ? $user->ic : '') }}" @endif
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                required>
            @error('ic')
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
            <label for="epf_no" class="block text-sm font-medium text-gray-700">EPF No.</label>
            <input type="text" name="epf_no" id="epf_no"
                @if ($mode == 'edit' || old('epf_no')) value="{{ old('epf_no', $user != null ? $user->epf_no : '') }}" @endif
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                required />
            @error('epf_no')
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
            <label for="socso_no" class="block text-sm font-medium text-gray-700">SOCSO No.</label>
            <input type="text" name="socso_no" id="socso_no"
                @if ($mode == 'edit' || old('socso_no')) value="{{ old('socso_no', $user != null ? $user->socso_no : '') }}" @endif
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                required>
            @error('socso_no')
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
            <label for="employee_no" class="block text-sm font-medium text-gray-700">Employee No.</label>
            <input type="text" name="employee_no" id="employee_no"
                @if ($mode == 'edit' || old('employee_no')) value="{{ old('employee_no', $user != null ? $user->employee_no : '') }}" @endif
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                required>
            @error('employee_no')
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
            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>

            <x-dropdown align="right" width="w-full">
                <x-slot name="trigger">
                    <button id="role-button" type="button"
                        class="inline-flex justify-between w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span id="role-text">
                            {{ old('role', $user != null ? $user->roles->pluck('name')[0] : 'user') }}
                        </span>
                        <svg class="ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 9.707a1 1 0 011.414 0L10 13.086l3.293-3.379a1 1 0 011.414 1.414l-4 4.12a1 1 0 01-1.414 0l-4-4.12a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link onclick="setRole('user')">
                        user
                    </x-dropdown-link>
                    <x-dropdown-link onclick="setRole('admin')">
                        admin
                    </x-dropdown-link>
                </x-slot>
            </x-dropdown>
            <input id="role" type="hidden" name="role" required
                @if ($mode == 'edit' || old('role')) value="{{ old('role', $user != null ? $user->roles->pluck('name')[0] : 'user') }}" @endif />
            @error('role')
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
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Update</button>
                <button type="button" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700"
                    onclick="confirmDelete(event)">Delete</button>
            @endif
        </div>
    </form>

    @if ($mode !== 'create')
        <form id="delete_form" action="{{ route('user.destroy', $user) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
        </form>
    @endif
</div>

<script>
    function confirmDelete(event) {
        event.preventDefault();
        if (confirm('Are you sure you want to delete this user?')) {
            document.getElementById('delete_form').submit();
        }
    }

    function setRole(role) {
        event.preventDefault();
        document.getElementById('role').value = role;
        document.getElementById('role-text').innerText = role.charAt(0).toUpperCase() + role.slice(1);
    }
</script>
