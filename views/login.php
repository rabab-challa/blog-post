<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form action="../controllers/authController.php" method="POST">
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
        <button type="submit" name="login">Login</button>
    </form>
    
</body>
</html>