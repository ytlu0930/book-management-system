<?php
include 'db.php';

// 新增用戶
if (isset($_POST['add_user'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $add_user_sql = "INSERT INTO Users (name, email, phone) VALUES ('$name', '$email', '$phone')";
    if ($conn->query($add_user_sql) === TRUE) {
        echo "用戶新增成功!";
    } else {
        echo "錯誤: " . $conn->error;
    }
}

// 修改用戶
if (isset($_POST['update_user'])) {
    $user_id = $_POST['user_id'];

    // 如果某欄位未提交，則設定為 NULL
    $name = !empty($_POST['name']) ? "'" . $_POST['name'] . "'" : "NULL";
    $email = !empty($_POST['email']) ? "'" . $_POST['email'] . "'" : "NULL";
    $phone = !empty($_POST['phone']) ? "'" . $_POST['phone'] . "'" : "NULL";

    $update_user_sql = "UPDATE Users SET name = $name, email = $email, phone = $phone WHERE user_id = $user_id";
    if ($conn->query($update_user_sql) === TRUE) {
        echo "用戶資料已更新!";
    } else {
        echo "錯誤: " . $conn->error;
    }
}

// 刪除用戶
if (isset($_GET['delete_user'])) {
    $user_id = $_GET['delete_user'];
    $delete_user_sql = "DELETE FROM Users WHERE user_id = $user_id";
    if ($conn->query($delete_user_sql) === TRUE) {
        echo "用戶已刪除!";
    } else {
        echo "錯誤: " . $conn->error;
    }
}

// 查詢要修改的用戶
$edit_user = null;
if (isset($_GET['edit_user'])) {
    $user_id = $_GET['edit_user'];
    $edit_user_sql = "SELECT * FROM Users WHERE user_id = $user_id";
    $edit_result = $conn->query($edit_user_sql);

    if ($edit_result->num_rows > 0) {
        $edit_user = $edit_result->fetch_assoc();
    } else {
        echo "找不到用戶!";
    }
}

// 查詢所有用戶
$sql = "SELECT * FROM Users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用戶管理</title>
</head>
<body>
    <h1>用戶管理</h1>

    <!-- 新增或修改用戶表單 -->
    <h2><?php echo $edit_user ? "修改用戶" : "新增用戶"; ?></h2>
    <form action="user.php" method="POST">
        <?php if ($edit_user): ?>
            <input type="hidden" name="user_id" value="<?php echo $edit_user['user_id']; ?>">
        <?php endif; ?>

        <label for="name">姓名:</label>
        <input type="text" name="name" value="<?php echo $edit_user['name'] ?? ''; ?>"><br>

        <label for="email">電子郵件:</label>
        <input type="email" name="email" value="<?php echo $edit_user['email'] ?? ''; ?>"><br>

        <label for="phone">電話:</label>
        <input type="text" name="phone" value="<?php echo $edit_user['phone'] ?? ''; ?>"><br>

        <button type="submit" name="<?php echo $edit_user ? "update_user" : "add_user"; ?>">
            <?php echo $edit_user ? "更新用戶" : "新增用戶"; ?>
        </button>
    </form>

    <!-- 用戶清單 -->
    <h2>用戶清單</h2>
    <table border="1">
        <tr>
            <th>姓名</th>
            <th>電子郵件</th>
            <th>電話</th>
            <th>操作</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['phone'] . "</td>";
                echo "<td>
                        <a href='user.php?edit_user=" . $row['user_id'] . "'>修改</a> | 
                        <a href='user.php?delete_user=" . $row['user_id'] . "' onclick='return confirm(\"確定刪除這個用戶?\")'>刪除</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>沒有用戶</td></tr>";
        }
        ?>
    </table>

    <a href="index.php"><button>返回首頁</button></a>
    <a href="borrow.php"><button>返回借閱表</button></a>
</body>
</html>
