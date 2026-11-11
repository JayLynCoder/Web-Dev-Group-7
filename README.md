# HexaHub — Group 7 Student Attendance System

Laravel 12 + Tailwind CSS v4, with **Firebase Realtime Database** as the database.

* **Admins** register students, record attendance at a kiosk and view all logs.
* The **super admin** also manages user accounts.
* **Students** log in and time in / time out themselves.

No MySQL is needed. Users, students and attendance live in Firebase; sessions and cache are saved as files.

---

## 1. Requirements

PHP 8.2+ (XAMPP's PHP is fine), Composer, Node 20+, and access to the group's Firebase project.

## 2. First-time setup

```bash
composer install
npm install
npm install-scripts approve esbuild   # only if npm shows the esbuild warning
npm rebuild esbuild

copy .env.example .env                # Mac/Linux: cp .env.example .env
php artisan key:generate
php artisan storage:link              # lets student pictures show up
```

## 3. Connect Firebase (the database)

You need two things from the Firebase console: a **service account key file** and the **Realtime Database URL**.

1. Open https://console.firebase.google.com and choose the group's project.
   *(No project yet? Click **Add project**, then **Build → Realtime Database → Create database**, pick a location such as Singapore, and start in **locked mode**.)*
2. **Key file:** ⚙ **Project settings → Service accounts → Generate new private key**.
   Rename the downloaded file to `firebase_credentials.json` and put it in a folder called **`firebaseprivate`** in the project root:
   ```
   Web-Dev-Group-7/
   ├── firebaseprivate/
   │   └── firebase_credentials.json
   ├── app/
   └── ...
   ```
   `firebaseprivate/` is in `.gitignore`. **Never commit this file.** Share it with teammates privately.
3. **Database URL:** **Build → Realtime Database**. Copy the URL at the top of the Data tab (it looks like `https://your-project-default-rtdb.asia-southeast1.firebasedatabase.app`) and paste it into `.env`:
   ```
   FIREBASE_CREDENTIALS=firebaseprivate/firebase_credentials.json
   FIREBASE_DATABASE_URL=https://your-project-default-rtdb.asia-southeast1.firebasedatabase.app
   ```
4. Run `php artisan config:clear`.

## 4. Create the first account

Make yourself a super admin (it is saved in Firebase):

```bash
php artisan admin:create yourname you@example.com "YourPass@123" --role=superadmin
```

**Optional** demo data (2 students and 3 accounts). Skip this if your group shares one Firebase project that already has real data:

```bash
php artisan db:seed
```

| Role        | Email                     | Password      |
|-------------|---------------------------|---------------|
| Super admin | `superadmin@hexahub.test` | `Admin@123`   |
| Admin       | `admin@hexahub.test`      | `Admin@123`   |
| Student     | `student@hexahub.test`    | `Student@123` |

## 5. Run it

Two terminals:

```bash
php artisan serve      # http://localhost:8000
npm run dev            # Tailwind + JS, keep it running
```

---

## Where things live

```
app/
├── Console/Commands/CreateAdmin.php   php artisan admin:create
├── Http/Controllers/
│   ├── AuthController.php             login, logout, student self-registration
│   ├── AttendanceController.php       kiosk, logs, student time in/out (+10-minute rule)
│   ├── StudentController.php          register student (+ picture)
│   └── UserController.php             manage users (super admin only)
├── Http/Middleware/                   auth.check, admin
└── Services/UserStore.php             reads/writes users in Firebase

firebaseprivate/                       your Firebase key (git-ignored)
database/seeders/DatabaseSeeder.php    optional demo data → Firebase

resources/
├── css/app.css                        THE ONLY CSS FILE (Tailwind + HexaHub theme)
├── js/
│   ├── app.js                         entry point, loads the modules below
│   ├── cursorTrail.js                 binary mouse trail
│   ├── modals.js                      modals, "Are you sure?" dialog, auto-hide
│   ├── portal.js                      live clock, mobile sidebar
│   └── forms.js                       password checklist, picture preview
└── views/
    ├── components/                    reusable pieces (<x-card>, <x-modal>, …)
    │   └── layouts/                   auth.blade.php (guest) · portal.blade.php (logged in)
    ├── auth/                          login, register
    ├── admin/                         attendance (kiosk), logs, register-student, users/
    └── student/                       attendance (time in / time out)
```

### Firebase data shape

```
students/<student number>                 first_name, last_name, year_section, college_program, picture
attendance/<student number>/<YYYY-MM-DD>  time_in, time_out
users/<push id>                           username, email, full_name, password_hash, role, student_id
```

### Pages

| URL                                  | Who         | What |
|--------------------------------------|-------------|------|
| `/login`, `/register`                | guests      | sign in / student creates an account |
| `/attendance`                        | admins      | kiosk: student number → time in / time out |
| `/attendance/logs`                   | admins      | all records, filter by date |
| `/register-student`                  | admins      | add a student + photo |
| `/users`                             | super admin | create, edit, delete accounts |
| `/student-attendance`                | students    | time in / time out, own history |

## Troubleshooting

| Problem | Fix |
|---|---|
| `No application encryption key` | `php artisan key:generate` |
| `Unable to create an API client without credentials` / file not found | key file isn't at `firebaseprivate/firebase_credentials.json`, or `.env` path is wrong → `php artisan config:clear` |
| `PermissionDenied` / 401 | key belongs to a different Firebase project than the URL, or the key was deleted in the console → generate a new one |
| Page has no styling | `npm run dev` isn't running |
| Student pictures don't show | `php artisan storage:link` |
