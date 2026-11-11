{{--
|--------------------------------------------------------------------------
| Super admin: Manage Users  (UserController@index / store / destroy)
|--------------------------------------------------------------------------
|   $users     every account in Firebase (id, username, email, role, student_id…)
|   $students  students that don't have an account yet (for the "Link to Student" dropdown)
--}}
<x-layouts.portal title="Manage Users">
    <div class="grid items-start gap-6 xl:grid-cols-[360px_minmax(0,1fr)]">

        {{-- ============ CREATE ACCOUNT ============ --}}
        <x-card eyebrow="New Account" title="Create User Account">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <x-form.input name="username" label="Username" required />
                <x-form.input name="email" type="email" label="Email" required />
                <x-form.input name="password" type="password" label="Password" autocomplete="new-password" required />
                <x-form.input name="password_confirmation" type="password" label="Confirm Password" autocomplete="new-password" required />

                <x-form.select name="student_id" label="Link to Student" hint="Only students without an account are listed.">
                    <option value="">— None —</option>
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}" @selected(old('student_id') == $student->id)>
                            {{ $student->student_number }} – {{ $student->first_name }} {{ $student->last_name }}
                        </option>
                    @endforeach
                </x-form.select>

                <label for="is_admin" class="mb-6 flex cursor-pointer items-center gap-3 text-sm">
                    <input type="checkbox" name="is_admin" id="is_admin" value="1" @checked(old('is_admin'))
                           class="size-4 accent-hexa-cyan">
                    Admin account
                </label>

                <button type="submit" class="btn-primary w-full">Create Account</button>
            </form>
        </x-card>

        {{-- ============ EXISTING ACCOUNTS ============ --}}
        <x-card eyebrow="Accounts" title="Existing Accounts">
            <x-flash :skip="['username', 'email', 'password', 'password_confirmation', 'student_id']" />

            <div class="overflow-x-auto">
                <table class="w-full min-w-[620px] text-left text-sm whitespace-nowrap">
                    <thead class="bg-white/5 text-[0.65rem] uppercase tracking-wider text-white/50">
                        <tr>
                            <th class="px-4 py-3 font-normal">User</th>
                            <th class="px-4 py-3 font-normal">Role</th>
                            <th class="px-4 py-3 font-normal">Linked Student</th>
                            <th class="px-4 py-3 text-right font-normal">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/8 text-white/80">
                        @foreach ($users as $user)
                            <tr>
                                <td class="px-4 py-3">
                                    <span class="block text-white">{{ $user->username }}</span>
                                    <span class="text-xs text-white/50">{{ $user->email }}</span>
                                </td>
                                <td class="px-4 py-3"><x-status-badge :status="$user->role" /></td>
                                <td class="px-4 py-3 text-xs">{{ $user->student_id ?? '—' }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn-ghost min-h-8 px-3 text-xs">Edit</a>

                                        @if ($user->id === session('user_id'))
                                            <span class="w-[66px] text-center text-xs text-white/45">(you)</span>
                                        @elseif ($user->role !== 'superadmin')
                                            {{-- data-confirm: opens the styled "Are you sure?" dialog first --}}
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                  data-confirm="Delete the account “{{ $user->username }}”? This cannot be undone."
                                                  data-confirm-button="Delete">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="min-h-8 cursor-pointer rounded-lg border border-hexa-red/40 bg-hexa-red/10 px-3 text-xs font-bold text-hexa-red transition hover:bg-hexa-red/20">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
</x-layouts.portal>
