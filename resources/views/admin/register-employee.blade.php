<x-layouts.portal title="Register Employee">
    <div class="mx-auto max-w-2xl">
        <x-card eyebrow="New Employee" title="Register Employee">
            <x-flash />

            <form action="{{ route('admin.employees.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid gap-x-4 sm:grid-cols-2">
                    <x-form.input name="first_name" id="fname" label="First Name" required />
                    <x-form.input name="last_name" id="lname" label="Last Name" required />
                    <x-form.input name="employee_number" id="employee-number" label="Employee Number" placeholder="HH-2026-003" required />
                    <x-form.input name="department" label="Department" required />
                </div>

                <div class="mb-5">
                    <label for="picture" class="mb-2 block text-xs font-bold tracking-wide">Picture</label>
                    <input type="file" name="picture" id="picture" accept="image/*" required data-preview="picture-preview"
                           class="block w-full text-sm text-white/70 file:mr-4 file:cursor-pointer file:rounded-md file:border-0 file:bg-white/90 file:px-4 file:py-2 file:font-mono file:text-sm file:text-[#24243b] hover:file:bg-white">
                    <img id="picture-preview" alt="Picture preview" class="mt-3 hidden max-h-48 rounded-lg border border-white/20">
                </div>

                <fieldset class="mb-5 rounded-xl border border-white/15 bg-white/5 p-4">
                    <legend class="eyebrow px-2">Portal login (optional)</legend>
                    <p class="mb-4 text-xs text-white/55">Fill these in so the employee can sign in to the Employee Portal and clock in themselves. Leave blank for kiosk-only.</p>
                    <div class="grid gap-x-4 sm:grid-cols-2">
                        <x-form.input name="email" type="email" label="Email" icon="✉︎" autocomplete="off" />
                        <x-form.input name="password" type="password" label="Temporary Password" icon="🔒︎" autocomplete="new-password" />
                    </div>
                </fieldset>

                <button type="submit" class="btn-primary w-full" id="register-button">Register Employee</button>
            </form>
        </x-card>
    </div>
</x-layouts.portal>
