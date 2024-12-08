<?php
include 'db.php';
session_start();

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];
try{
    $sql = "SELECT * FROM appusers WHERE username = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user['username'];
        header("Location: home.php");
        exit;
    } else {
        $message = "Invalid username or password!";
    }
} catch(PDOException $e){
    $message = "Database error: " .$e->getMessage();
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel = "stylesheet" href="login.css">
</head>
<body>
    <div class = "container">
    <h2>User Login</h2>
    <p><?php echo $message; ?></p>
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <div class = "button-group">
        <button type="submit" class = "login">Login</button>
        <button type="reset" class = "clear">Clear</button>
    </div>
    </form>
    </div>
</body>
</html>
