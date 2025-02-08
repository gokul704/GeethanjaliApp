<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-200 leading-tight">
            {{ __('Create User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 text-white p-6 rounded-lg shadow-lg">
                <!-- Include SweetAlert -->
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                <!-- Success Message -->
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

                <!-- Error Message -->
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

                <form action="{{ route('users.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block">Name:</label>
                        <input type="text" name="name" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white" required>
                    </div>

                    <div class="mb-4">
                        <label class="block">Email:</label>
                        <input type="email" name="email" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white" required>
                    </div>

                    <div class="mb-4">
                        <label class="block">Password:</label>
                        <input type="password" name="password" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white" required>
                    </div>

                    <div class="mb-4">
                        <label class="block">Confirm Password:</label>
                        <input type="password" name="password_confirmation" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white" required>
                    </div>

                    <div class="mb-4">
                        <label class="block">Role:</label>
                        <select id="role" name="role" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white" required>
                            <option value="" selected disabled>Select Role</option>
                            <option value="student">Student</option>
                            <option value="faculty">Faculty</option>
                        </select>
                    </div>

                    <!-- Student Fields -->
                    <div id="student-fields" class="hidden">
                        <h3 class="text-lg font-semibold mb-2">Student Details</h3>

                        <label class="block">First Name:</label>
                        <input type="text" name="first_name" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white">

                        <label class="block mt-2">Last Name:</label>
                        <input type="text" name="last_name" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white">

                        <label class="block mt-2">Roll No:</label>
                        <input type="text" name="roll_no" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white">

                        <label class="block mt-2">Stream:</label>
                        <input type="text" name="stream" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white">

                        <label class="block mt-2">Joining Year:</label>
                        <input type="text" name="joining_year" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white">

                        <label class="block mt-2">
                            <input type="checkbox" name="is_alumuni" value="1"> Is Alumni?
                        </label>
                    </div>

                    <!-- Faculty Fields -->
                    <div id="faculty-fields" class="hidden">
                        <h3 class="text-lg font-semibold mt-4 mb-2">Faculty Details</h3>

                        <label class="block">Faculty ID:</label>
                        <input type="text" name="faculty_id" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white">

                        <label class="block mt-2">First Name:</label>
                        <input type="text" name="first_name" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white">

                        <label class="block mt-2">Last Name:</label>
                        <input type="text" name="last_name" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white">

                        <label class="block mt-2">Mobile:</label>
                        <input type="text" name="mobile" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white">

                        <label class="block mt-2">Stream:</label>
                        <input type="text" name="stream" class="w-full p-2 rounded bg-gray-800 border border-gray-600 text-white">

                        <h3 class="text-lg font-semibold mt-4">Select Faculty Role:</h3>
                        <div class="grid grid-cols-2 gap-2">
                            <label><input type="radio" name="faculty_role" value="faculty"> Faculty</label>
                            <label><input type="radio" name="faculty_role" value="hod"> Head of Department (HoD)</label>
                            <label><input type="radio" name="faculty_role" value="dean"> Dean</label>
                            <label><input type="radio" name="faculty_role" value="principal"> Principal</label>
                            <label><input type="radio" name="faculty_role" value="admin"> Admin</label>
                            <label><input type="radio" name="faculty_role" value="superadmin"> Super Admin</label>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">Create User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript to Show/Hide Fields and Ensure Submission -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let roleSelect = document.getElementById('role');
            let studentFields = document.getElementById('student-fields');
            let facultyFields = document.getElementById('faculty-fields');

            function toggleFields() {
                let selectedRole = roleSelect.value;

                studentFields.classList.toggle('hidden', selectedRole !== 'student');
                facultyFields.classList.toggle('hidden', selectedRole !== 'faculty');

                document.querySelectorAll('#student-fields input').forEach(input => {
                    input.disabled = (selectedRole !== 'student');
                });

                document.querySelectorAll('#faculty-fields input').forEach(input => {
                    input.disabled = (selectedRole !== 'faculty');
                });
            }

            roleSelect.addEventListener('change', toggleFields);
            toggleFields(); // Ensure correct state on load
        });
    </script>

</x-app-layout>
