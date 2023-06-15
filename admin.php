<?php
// 连接到数据库
$host = "127.0.0.1";
$db = "admin_db";
$user = "root";
$password = "Q5x37259";

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("数据库连接失败: " . $conn->connect_error);
}

// 处理表单提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // 查询数据库，检查用户名和密码
    $query = "SELECT * FROM admins WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        // 登录成功
        // 将管理员信息存储在会话中
        session_start();
        $_SESSION["username"] = $username;
        header("Location: admin_panel.php"); // 重定向到管理面板
    } else {
        // 登录失败
        $error_message = "无效的用户名或密码";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>管理员登录</title>
</head>
<body>
    <h1>管理员登录</h1>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">用户名:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">密码:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="登录">
    </form>
    <?php if (isset($error_message)) { ?>
        <p><?php echo $error_message; ?></p>
    <?php } ?>
</body>
</html>
