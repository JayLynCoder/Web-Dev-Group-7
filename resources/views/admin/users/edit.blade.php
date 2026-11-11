{{--
|--------------------------------------------------------------------------
| Super admin: Edit User  →  UserController@update  (PUT /users/{id})
|--------------------------------------------------------------------------
|   $user      the account being edited
|   $students  students available to link (+ the one already linked)
--}}
<x-layouts.portal title="Edit User" :heading="'Edit: ' . $user->username">
    <div class="mx-auto max-w-xl">
        <x-card eyebrow="Account" title="Edit Account">
            <x-flash :skip="['username', 'email', 'role', 'student_id', 'password', 'password_confirmation']" />

            <form method="POST" action="{{ route('users.update', $user->id) }}">
                @csrf
                @method('PUT') {{-- HTML forms only send GET/POST; this tells Laravel it's a PUT --}}

                <div class="grid gap-x-4 sm:grid-cols-2">
                    <x-form.input name="username" label="Username" :value="$user->username" required />
                    <x-form.input name="email" type="email" label="Email" :value="$user->email" required />
                </div>

                @if ($user->role === 'superadmin')
                    <x-form.input name="role_display" label="Role" value="Super Admin" disabled
                                  hint="The super admin role can't be changed." />
                @else
                    <x-form.select name="role" label="Role" required>
                        <option value="student" @selected(old('role', $user->role) === 'student')>Student</option>
                        <option value="admin" @selected(old('role', $user->role) === 'admin')>Admin</option>
                    </x-form.select>
                @endif

                <x-form.select name="student_id" label="Linked Student">
                    <option value="">— None —</option>
                    @foreach ($students as $student)
                        <option value="{{ $student->student_number }}"
                            @selected((string) old('student_id', $user->student_id) === (string) $student->student_number)>
                            {{ $student->last_name }}, {{ $student->first_name }} ({{ $student->student_number }})
                        </option>
                    @endforeach
                </x-form.select>

                <fieldset class="mb-6 rounded-xl border border-white/15 bg-white/5 p-4">
                    <legend class="eyebrow px-2">Change password (optional)</legend>
                    <x-form.input name="password" type="password" label="New Password" autocomplete="new-password"
                                  hint="Leave blank to keep the current password." />
                    <x-form.input name="password_confirmation" type="password" label="Confirm New Password" autocomplete="new-password" />
                </fieldset>

                <div class="grid gap-2 sm:grid-cols-2">
                    <a href="{{ route('users.index') }}" class="btn-ghost">Cancel</a>
                    <button type="submit" class="btn-primary">Save Changes</button>
                </div>
            </form>
        </x-card>
    </div>
</x-layouts.portal>
