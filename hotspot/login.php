<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f0f2f5;">
    <div style="width: 300px; padding: 20px; background-color: #ffffff; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); border-radius: 8px; text-align: center; display: flex; flex-direction: column; align-items: center;">
        <form action="login_process.php" method="post">
            <label for="username" style="display: block; margin-bottom: 5px;">Username:</label>
            <input type="text" id="username" name="username" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px;">
            <label for="password" style="display: block; margin-bottom: 5px;">Password:</label>
            <input type="password" id="password" name="password" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px;">
            <input type="submit" value="Login" style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer;">
        </form>
    </div>
    <style>
        @keyframes pulse {
            0% { background-color: #f0f2f5; }
            50% { background-color: #e0e7eb; }
            100% { background-color: #f0f2f5; }
        }

        body {
            animation: pulse 2s infinite ease-in-out;
        }
    </style>
</body>
</html>
