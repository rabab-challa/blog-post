<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form action="../controllers/authController.php" method="POST">
            <input
            type="text"
            name="username"
            placeholder="Username"
            required
            >
            <br><br>
        <input
            type="email"
            name="email"
            placeholder="Email"
            required
            >
            <br><br>
        <input
            type="password"
            name="password"
            placeholder="Password"
            required
            >
            <br><br>
        <button type="submit" name="register">Register</button>
    </form>
</body>
</html>