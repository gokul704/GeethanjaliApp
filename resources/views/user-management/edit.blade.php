<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-200 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 text-white p-6 rounded-lg shadow-lg">
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block">Name:</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white" required>
                    </div>

                    <div class="mb-4">
                        <label class="block">Email:</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white" required>
                    </div>

                    <div class="mb-4">
                        <label class="block">Role:</label>
                        <select id="role" name="role" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white" required>
                            <option value="" disabled>Select Role</option>
                            <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>Student</option>
                            <option value="faculty" {{ $user->role == 'faculty' ? 'selected' : '' }}>Faculty</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="superadmin" {{ $user->role == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                        </select>
                    </div>

                    <!-- Student Fields -->
                    <div id="student-fields" class="{{ $user->role === 'student' ? '' : 'hidden' }}">
                        <h3 class="text-lg font-semibold mb-2">Student Details</h3>
                        <label class="block">First Name:</label>
                        <input type="text" name="first_name" value="{{ $user->student->first_name ?? '' }}" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white">

                        <label class="block mt-2">Last Name:</label>
                        <input type="text" name="last_name" value="{{ $user->student->last_name ?? '' }}" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white">

                        <label class="block mt-2">Roll No:</label>
                        <input type="text" name="roll_no" value="{{ $user->student->roll_no ?? '' }}" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white">

                        <label class="block mt-2">Stream:</label>
                        <input type="text" name="stream" value="{{ $user->student->stream ?? '' }}" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white">

                        <label class="block mt-2">Joining Year:</label>
                        <input type="text" name="joining_year" value="{{ $user->student->joining_year ?? '' }}" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white">
                    </div>

                    <!-- Faculty Fields -->
                    <div id="faculty-fields" class="{{ $user->role === 'faculty' ? '' : 'hidden' }}">
                        <h3 class="text-lg font-semibold mt-4 mb-2">Faculty Details</h3>
                        <label class="block">First Name:</label>
                        <input type="text" name="first_name" value="{{ $user->faculty->first_name ?? '' }}" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white">

                        <label class="block mt-2">Last Name:</label>
                        <input type="text" name="last_name" value="{{ $user->faculty->last_name ?? '' }}" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white">

                        <label class="block mt-2">Mobile:</label>
                        <input type="text" name="mobile" value="{{ $user->faculty->mobile ?? '' }}" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white">

                        <label class="block mt-2">Stream:</label>
                        <input type="text" name="stream" value="{{ $user->faculty->stream ?? '' }}" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white">

                        <h3 class="text-lg font-semibold mt-4">Additional Roles:</h3>
                        <div class="flex space-x-4">
                            <label><input type="checkbox" name="extra_roles[]" value="admin" {{ in_array('admin', json_decode($user->extra_roles ?? '[]')) ? 'checked' : '' }}> Admin</label>
                            <label><input type="checkbox" name="extra_roles[]" value="superadmin" {{ in_array('superadmin', json_decode($user->extra_roles ?? '[]')) ? 'checked' : '' }}> Super Admin</label>
                            <label><input type="checkbox" name="extra_roles[]" value="dean" {{ in_array('dean', json_decode($user->extra_roles ?? '[]')) ? 'checked' : '' }}> Dean</label>
                            <label><input type="checkbox" name="extra_roles[]" value="principal" {{ in_array('principal', json_decode($user->extra_roles ?? '[]')) ? 'checked' : '' }}> Principal</label>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('role').addEventListener('change', function () {
            let studentFields = document.getElementById('student-fields');
            let facultyFields = document.getElementById('faculty-fields');

            studentFields.style.display = (this.value === 'student') ? 'block' : 'none';
            facultyFields.style.display = (this.value === 'faculty') ? 'block' : 'none';
        });
    </script>

</x-app-layout>
