<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group input:focus {
            outline: none;
            border-color: #007bff;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Đăng Ký</h2>
        <form action="../php/xulidangky.php" method="post" id="formRegister">
            <div class="form-group">
                <label for="username">Tên người dùng:</label>
                <input type="text" id="username" name="username" maxlength="50" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password" maxlength="100" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" maxlength="100" required>
            </div>
            <button type="submit" name="submit">Đăng Ký</button>
        </form>
    </div>
    <script>
        const form = document.getElementById('formRegister');
        const patternUsername = /^[A-Za-z0-9][a-z0-9-_]{6,11}$/;

        form.addEventListener('submit', function(e) {
            const username = document.getElementById('username').value;

            if (!patternUsername.test(username)) {
                alert("Tên người dùng không hợp lệ! Phải bắt đầu bằng chữ hoặc số, sau đó 6-11 ký tự gồm chữ thường, số, dấu _ hoặc -");
                e.preventDefault(); // ngăn form submit nếu sai pattern
            }
        });
    </script>
</body>

</html>