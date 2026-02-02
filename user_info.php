<?php 
include 'db.php';

$user_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($user_id) {
    // 查詢用戶信息
    $sql = "SELECT * FROM users WHERE user_id = $user_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "找不到該用戶";
        exit;
    }
} else {
    echo "未提供用戶ID";
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>使用者資訊</title>
</head>
<body>

    <h1>使用者資訊</h1>

    <p><strong>姓名：</strong><?php echo $user['name']; ?></p>
    <p><strong>Email：</strong><?php echo $user['email']; ?></p>
    <p><strong>電話：</strong><?php echo $user['phone']; ?></p>

    <a href="borrow.php">返回借閱表</a>

</body>
</html>

