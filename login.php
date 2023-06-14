<!DOCTYPE html>
<html>
<head>
  <title>登录页面</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="container">
    <h2>登录</h2>
    <form action="login.php" method="POST">
      <div class="form-group">
        <label for="username">用户名：</label>
        <input type="text" id="username" name="username" required>
      </div>
      <div class="form-group">
        <label for="password">密码：</label>
        <input type="password" id="password" name="password" required>
      </div>
      <button type="submit" class="btn">登录</button>
    </form>
  </div>
</body>
</html>
<?php
// 获取表单提交的数据
$username = $_POST['username'];
$password = $_POST['password'];

// 进行一些基本的验证和处理

// 连接到MySQL数据库
$conn = new mysqli('localhost', 'root', 'Q5x37259', 'mydatabase');
if ($conn->connect_error) {
  die('数据库连接失败：' . $conn->connect_error);
}

if (!empty($username) && !empty($password)) {
  // 查询数据库中的用户数据
  $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    header('Location:1.html');
  } else {
    echo "用户名或密码错误";
  }
} else {
  echo "请输入用户名和密码";
}

// 关闭数据库连接
$conn->close();
?>
