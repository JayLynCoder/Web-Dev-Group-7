<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'My App')</title>
    @vite(['resources/css/auth.css', 'resources/js/app.js'])
</head>
<body>
    <div id="trail-stage">
        <h1>Dashboard</h1>
        <p>Successfully logged in!</p>

        <h3>Group 7</h3>
        <ul style="list-style-type: none;">
            <li>BERNARTE, Jaylee Johralyn C.</li>
            <li>CRUZ, Aaron James</li>
            <li>GAVIOLA, Jonna N.</li>
            <li>RANESES, Princess Cayenne M.</li>
            <li>TAN, Lensy P.</li>
        </ul>

        <form action="/logout" method="POST">
            @csrf
            <button type="submit" class="auth-button">
                Sign Out
            </button>
        </form>
    </div>
</body>
</html>