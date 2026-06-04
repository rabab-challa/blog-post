<?php

require_once("../config/db.php");

if(isset($_POST['register']))
{
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Hash Password
    $hashedPassword = password_hash(
        $password,
        PASSWORD_DEFAULT
    );

    // Check if email already exists
    $check = $conn->prepare(
        "SELECT id FROM users WHERE email = ?"
    );

    $check->bind_param("s", $email);
    $check->execute();

    if($check->get_result()->num_rows > 0)
    {
        die("Email already registered.");
    }

    $stmt = $conn->prepare(
        "INSERT INTO users(username,email,password)
         VALUES(?,?,?)"
    );

    $stmt->bind_param(
        "sss",
        $username,
        $email,
        $hashedPassword
    );

    if($stmt->execute())
    {
        echo "Registration Successful";
    }
    else
    {
        echo "Registration Failed";
    }

}

if(isset($_POST['login']))
{
    session_start();

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare(
        "SELECT * FROM users WHERE email = ?"
    );

    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows == 1)
    {
        $user = $result->fetch_assoc();

        if(password_verify(
            $password,
            $user['password']
        ))
        {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header(
                "Location: ../views/dashboard.php"
            );
            exit();
        }
    }

    echo "Invalid Email or Password";
}
?>