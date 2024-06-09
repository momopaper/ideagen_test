@props(['object', 'users'])
@push('header_scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@endpush

<button onclick="openModal('{{ $object }}')"
    class="inline-flex items-center mb-4 px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">Add
    User
</button>

<div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
    <div class="border-b border-gray-200 bg-white p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border-b px-4 py-2 text-left">Name</th>
                        <th class="border-b px-4 py-2 text-left">Employee No.</th>
                        <th class="border-b px-4 py-2 text-left">Identity No.</th>
                        <th class="border-b px-4 py-2 text-left">Email</th>
                        <th class="border-b px-4 py-2 text-left">EPF No.</th>
                        <th class="border-b px-4 py-2 text-left">SOCSO No.</th>
                        <th class="border-b px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td class="border-b px-4 py-2">{{ $user->name }}</td>
                            <td class="border-b px-4 py-2">{{ $user->employee_no }}</td>
                            <td class="border-b px-4 py-2">{{ $user->ic }}</td>
                            <td class="border-b px-4 py-2">{{ $user->email }}</td>
                            <td class="border-b px-4 py-2">{{ $user->epf_no }} </td>
                            <td class="border-b px-4 py-2">{{ $user->socso_no }}</td>
                            <td class="border-b px-4 py-2">
                                <button onclick="openModal('{{ $object }}', {{ $user->id }})"
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
