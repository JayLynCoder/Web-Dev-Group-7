# HexaHub — Group 7 Attendance System

Laravel 12 + Tailwind CSS v4 + MySQL.
Admins register employees and record attendance at a kiosk; employees sign in to the **Employee Portal** to clock in/out themselves.

---

## 1. First-time setup

Requirements: PHP 8.2+, Composer, Node 20+, MySQL (XAMPP or Laragon is fine).

```bash
composer install
npm install

cp .env.example .env          # Windows: copy .env.example .env
php artisan key:generate
```

Create an **empty database called `hexahub`** in phpMyAdmin (or change `DB_DATABASE` in `.env`). Then:

```bash
php artisan migrate --seed    # creates all tables + demo accounts
php artisan storage:link      # lets employee pictures show up
```

## 2. Running it

Two terminals:

```bash
php artisan serve             # http://localhost:8000
npm run dev                   # compiles Tailwind + JS, auto-refreshes
```

(Or `composer run dev` to start both at once.)

## 3. Demo logins (from the seeder)

| Role     | Email                    | Password       |
|----------|--------------------------|----------------|
| Admin    | `admin@hexahub.test`     | `Admin@123`    |
| Employee | `employee@hexahub.test`  | `Employee@123` |

Kiosk test numbers: `HH-2026-001` (Juan), `HH-2026-002` (Maria, kiosk only).

To wipe everything and start over: `php artisan migrate:fresh --seed`

---

## 4. Where things live

```
app/
├── Http/Controllers/
│   ├── AuthController.php            login, logout, register, /dashboard redirect
│   ├── Admin/
│   │   ├── DashboardController.php   admin home (stats + today's attendance)
│   │   ├── AttendanceController.php  kiosk + attendance logs
│   │   └── EmployeeController.php    employee list + register employee
│   └── Employee/
│       └── PortalController.php      employee dashboard, my attendance, profile, clock in/out
├── Http/Middleware/                  auth.check, admin, employee
└── Models/                           User, Employee, Attendance (clock-in rules: Attendance::toggleFor)

config/attendance.php                 work schedule (start/end/break) — used for "Late"
config/members.php                    Group 7 member names

database/
├── migrations/                       users, employees, attendance (+ Laravel's cache/jobs/sessions)
└── seeders/DatabaseSeeder.php        demo admin, employees, attendance history

resources/
├── css/app.css                       THE ONLY CSS FILE: Tailwind + HexaHub theme colors
├── js/
│   ├── app.js                        entry point, loads the modules below
│   ├── cursorTrail.js                binary mouse trail
│   ├── modals.js                     open/close any <x-modal>
│   ├── employee.js                   live clock, mobile menu, sign-out warning
│   └── forms.js                      password checklist, picture preview
└── views/
    ├── components/
    │   ├── layouts/auth.blade.php    shell for login/register (video bg + glass card)
    │   ├── layouts/portal.blade.php  shell for every logged-in page (sidebar + top bar)
    │   ├── card, modal, flash, avatar, nav-link, stat, status-badge,
    │   ├── attendance-table          shared table used on 4 pages
    │   └── form/input                label + icon + input + error
    ├── auth/      login, register
    ├── admin/     dashboard, attendance (kiosk), logs, employees, register-employee
    └── employee/  dashboard, attendance, profile

routes/web.php                        grouped: guest / admin (/admin/...) / employee (/employee/...)
```

### Pages

| URL                       | Who      | What |
|---------------------------|----------|------|
| `/login`, `/register`     | guests   | sign in / create account |
| `/admin`                  | admin    | stats, today's attendance, Group 7 members |
| `/admin/attendance`       | admin    | kiosk: type employee number → time in / time out |
| `/admin/logs`             | admin    | all attendance records, filter by date |
| `/admin/employees`        | admin    | employee list |
| `/admin/employees/create` | admin    | register employee (+ optional portal login) |
| `/employee`               | employee | clock in / clock out, schedule, recent attendance |
| `/employee/attendance`    | employee | full attendance history |
| `/employee/profile`       | employee | employee info + days logged / late |

---

## 5. Styling rules (Tailwind)

* Write Tailwind classes directly in the Blade files. **Don't add new .css files.**
* HexaHub colors are in `@theme` in `resources/css/app.css`:
  `hexa-cyan`, `hexa-night`, `hexa-navy`, `hexa-indigo`, `hexa-green`, `hexa-amber`, `hexa-red`
  → use as `text-hexa-cyan`, `bg-hexa-navy/90`, `border-hexa-cyan/30`, etc.
* Shared looks are ready-made classes: `glass` (frosted card), `btn-primary`, `btn-ghost`, `field` (input), `eyebrow` (small cyan label).
* New logged-in page? Start from:

```blade
<x-layouts.portal title="My Page">
    <x-card eyebrow="Section" title="Something">
        ...
    </x-card>
</x-layouts.portal>
```
