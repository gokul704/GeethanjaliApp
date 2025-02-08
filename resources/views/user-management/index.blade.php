<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-200 leading-tight">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 text-white p-6 rounded-lg shadow-lg">

                <!-- Success Messages with SweetAlert -->
                @if(session('success'))
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: "{{ session('success') }}",
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        });
                    </script>
                @endif

                <!-- Error Messages with SweetAlert -->
                @if(session('error'))
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: "{{ session('error') }}",
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'OK'
                        });
                    </script>
                @endif

                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Manage Users</h3>
                    <a href="{{ route('users.create') }}" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                        + Add User
                    </a>
                </div>

                <!-- User Table -->
                <div class="overflow-hidden border border-gray-700 rounded-lg">
                    <table class="w-full text-left text-gray-300">
                        <thead class="bg-gray-800 text-gray-300 uppercase">
                            <tr>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Email</th>
                                <th class="px-4 py-3">Role</th>
                                <th class="px-4 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="border-t border-gray-700 hover:bg-gray-800 transition">
                                    <td class="px-4 py-3">{{ $user->name }}</td>
                                    <td class="px-4 py-3">{{ $user->email }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 rounded-full text-sm font-semibold
                                            {{ $user->role === 'superadmin' ? 'bg-purple-600' :
                                               ($user->role === 'admin' ? 'bg-blue-600' :
                                               ($user->role === 'faculty' ? 'bg-yellow-600' : 'bg-green-600')) }} ">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center flex justify-center space-x-3">
                                        <a href="{{ route('users.edit', $user->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                                            Edit
                                        </a>
                                        <button onclick="confirmDelete({{ $user->id }})" class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                            Delete
                                        </button>
                                        <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- Delete Confirmation -->
    <script>
        function confirmDelete(userId) {
            Swal.fire({
                title: "Are you sure?",
                text: "This action cannot be undone!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + userId).submit();
                }
            });
        }
    </script>

</x-app-layout>
