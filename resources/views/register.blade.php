<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/home.css'])
    <title>HexaHub Group 6</title>
</head>
<body>
    <h1>HexaHub Group 6</h1>
    <form>
        <label for="name">Username: </label>
        <input type="text" name="username" placeholder="Username" />

        <label for="email">Email: </label>
        <input type="text" name="email" placeholder="Email" />

        <label for="[password]">Password: </label>
        <input type="password" name="password" placeholder="Password" />
        <button>Register</button>
    </form>
    <a href="{{url('/')}}">Already have an account? Log in here</a>
</body>
</html>