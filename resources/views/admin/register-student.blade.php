{{--
|--------------------------------------------------------------------------
| Admin: Register Student  →  StudentController@store
|--------------------------------------------------------------------------
| Saves the student to Firebase (students/<student number>) and the photo
| to storage/app/public/students/<student number>.jpg
--}}
<x-layouts.portal title="Register Student">
    <div class="mx-auto max-w-2xl">
        <x-card eyebrow="New Student" title="Register Student">
            <x-flash :skip="['first_name', 'last_name', 'student_number', 'year_section', 'college_program', 'picture']" />

            {{-- enctype is required for file uploads --}}
            <form action="{{ route('register-student.submit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid gap-x-4 sm:grid-cols-2">
                    <x-form.input name="first_name" id="fname" label="First Name" required />
                    <x-form.input name="last_name" id="lname" label="Surname" required />
                    <x-form.input name="student_number" id="student-number" label="Student Number" placeholder="e.g. 2023-00001" required />
                    <x-form.input name="year_section" id="year-section" label="Year / Section" placeholder="e.g. 3-1"
                                  pattern="[1-9]-[0-9]{1,2}" title="Use the format 3-1" required />
                </div>
                <x-form.input name="college_program" id="college-program" label="College Program" placeholder="e.g. BSIT" required />

                <div class="mb-6">
                    <label for="picture" class="mb-2 block text-xs font-bold tracking-wide">Picture (JPEG only)</label>
                    {{-- data-preview: resources/js/forms.js shows the chosen photo in #picture-preview --}}
                    <input type="file" name="picture" id="picture" accept="image/jpeg" required data-preview="picture-preview"
                           class="block w-full text-sm text-white/70 file:mr-4 file:cursor-pointer file:rounded-md file:border-0 file:bg-white/90 file:px-4 file:py-2 file:font-mono file:text-sm file:text-[#24243b] hover:file:bg-white">
                    @error('picture')
                        <p class="mt-1.5 text-xs text-hexa-red">{{ $message }}</p>
                    @enderror
                    <img id="picture-preview" alt="Picture preview" class="mx-auto mt-4 hidden max-h-52 rounded-lg border border-white/20">
                </div>

                <button type="submit" class="btn-primary w-full" id="register-button">Register Student</button>
            </form>
        </x-card>
    </div>
</x-layouts.portal>
