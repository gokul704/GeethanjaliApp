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
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white" required>
                    </div>

                    <div class="mb-4">
                        <label class="block">Email:</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white" required>
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
                        <input type="text" name="first_name" value="{{ old('first_name', optional($user->student)->first_name) }}" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white">

                        <label class="block mt-2">Last Name:</label>
                        <input type="text" name="last_name" value="{{ old('last_name', optional($user->student)->last_name) }}" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white">

                        <label class="block mt-2">Student ID:</label>
                        <input type="text" name="student_id" value="{{ old('student_id', optional($user->student)->student_id) }}" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white">

                        <label class="block mt-2">Roll No:</label>
                        <input type="text" name="roll_no" value="{{ old('roll_no', optional($user->student)->roll_no) }}" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white">

                        <label class="block mt-2">Stream:</label>
                        <input type="text" name="stream" value="{{ old('stream', optional($user->student)->stream) }}" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white">

                        <label class="block mt-2">Joining Year:</label>
                        <input type="text" name="joining_year" value="{{ old('joining_year', optional($user->student)->joining_year) }}" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white">
                    </div>

                    <!-- Faculty Fields -->
                    <div id="faculty-fields" class="{{ $user->role === 'faculty' ? '' : 'hidden' }}">
                        <h3 class="text-lg font-semibold mt-4 mb-2">Faculty Details</h3>

                        <label class="block">Faculty ID:</label>
                        <input type="text" name="faculty_id" value="{{ old('faculty_id', optional($user->faculty)->faculty_id) }}" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white">

                        <label class="block mt-2">First Name:</label>
                        <input type="text" name="first_name" value="{{ old('first_name', optional($user->faculty)->first_name) }}" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white">

                        <label class="block mt-2">Last Name:</label>
                        <input type="text" name="last_name" value="{{ old('last_name', optional($user->faculty)->last_name) }}" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white">

                        <label class="block mt-2">Mobile:</label>
                        <input type="text" name="mobile" value="{{ old('mobile', optional($user->faculty)->mobile) }}" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white">

                        <label class="block mt-2">Stream:</label>
                        <input type="text" name="stream" value="{{ old('stream', optional($user->faculty)->stream) }}" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white">

                        <h3 class="text-lg font-semibold mt-4">Faculty Role:</h3>
                        <select name="faculty_role" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white">
                            <option value="faculty" {{ optional($user->faculty)->designation == 'faculty' ? 'selected' : '' }}>Faculty</option>
                            <option value="hod" {{ optional($user->faculty)->designation == 'hod' ? 'selected' : '' }}>Head of Department (HoD)</option>
                            <option value="dean" {{ optional($user->faculty)->designation == 'dean' ? 'selected' : '' }}>Dean</option>
                            <option value="principal" {{ optional($user->faculty)->designation == 'principal' ? 'selected' : '' }}>Principal</option>
                            <option value="admin" {{ optional($user->faculty)->designation == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="superadmin" {{ optional($user->faculty)->designation == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                        </select>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let roleSelect = document.getElementById('role');
            let studentFields = document.getElementById('student-fields');
            let facultyFields = document.getElementById('faculty-fields');

            function toggleFields() {
                let selectedRole = roleSelect.value;
                studentFields.style.display = (selectedRole === 'student') ? 'block' : 'none';
                facultyFields.style.display = (selectedRole === 'faculty') ? 'block' : 'none';
            }

            roleSelect.addEventListener('change', toggleFields);
            toggleFields();
        });
    </script>

</x-app-layout>
