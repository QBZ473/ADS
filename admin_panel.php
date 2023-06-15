<?php
session_start();

// 检查管理员是否已经登录
if (!isset($_SESSION["username"])) {
    header("Location: index.php"); // 未登录则重定向到登录页
}

// 连接到数据库
$host = "127.0.0.1";
$db = "mydatabase";
$user = "root";
$password = "Q5x37259";

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("数据库连接失败: " . $conn->connect_error);
}

// 处理表单提交（新增管理员）
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add"])) {
    $newUsername = $_POST["new_username"];
    $newPassword = $_POST["new_password"];
    $newEmail = $_POST["new_email"];

    // 插入新管理员数据
    $query = "INSERT INTO users (username, password, email) VALUES ('$newUsername', '$newPassword', '$newEmail')";
    $conn->query($query);
}


// 处理表单提交（删除管理员）
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
    $deleteId = $_POST["delete_id"];

    // 删除管理员数据
    $query = "DELETE FROM users WHERE id = '$deleteId'";
    $conn->query($query);
}

// 查询数据库，获取管理员列表
$query = "SELECT * FROM users";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>管理员面板</title>
</head>
<body>
    <h1>管理员面板</h1>
    <h2>欢迎, <?php echo $_SESSION["username"]; ?></h2>

    <h3>新增管理员</h3>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="new_username">用户名:</label>
    <input type="text" id="new_username" name="new_username" required><br><br>
    <label for="new_password">密码:</label>
    <input type="password" id="new_password" name="new_password" required><br><br>
    <label for="new_email">邮箱:</label>
    <input type="email" id="new_email" name="new_email" required><br><br>
    <input type="submit" value="添加" name="add">
</form>


    <h3>列表</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>用户名</th>
	    <th>邮箱</th>
            <th>操作</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row["id"]; ?></td>
                <td><?php echo $row["username"]; ?></td>
                <td><?php echo $row["email"]; ?></td>
                <td>
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <input type="hidden" name="delete_id" value="<?php echo $row["id"]; ?>">
                        <input type="submit" value="删除" name="delete">
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>

    <br>
    <a href="logout.php">退出</a> <!-- 提供退出登录的链接 -->
</body>
</html>
