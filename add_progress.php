<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = 1; // 預設用戶為 user_id = 1
    $book_id = $_POST['book_id'];
    $current_page = $_POST['current_page'];
    $last_updated = date('Y-m-d');

    // 插入進度數據
    $sql = "INSERT INTO ReadingProgress (user_id, book_id, current_page, last_updated)
            VALUES ($user_id, $book_id, '$current_page', '$last_updated')";

    if ($conn->query($sql) === TRUE) {
        echo "進度新增成功！";
        header("Location: reading_progress.php");
        exit();
    } else {
        echo "新增進度失敗：" . $conn->error;
    }
}

// 查詢書籍
$books_sql = "SELECT book_id, book_name FROM Books";
$books_result = $conn->query($books_sql);
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>新增閱讀進度</title>
</head>
<body>
    <h1>新增閱讀進度</h1>
    <form action="add_progress.php" method="POST">
        <!-- 移除用戶選擇的下拉選單 -->
        
        <label for="book_id">選擇書籍：</label>
        <select name="book_id" id="book_id" required>
            <?php while ($book = $books_result->fetch_assoc()) { ?>
                <option value="<?php echo $book['book_id']; ?>"><?php echo $book['book_name']; ?></option>
            <?php } ?>
        </select>
        <br>
        
        <label for="current_page">當前進度：</label>
        <input type="text" name="current_page" id="current_page" required>
        <br>
        
        <button type="submit">新增進度</button>
    </form>
    <a href="reading_progress.php"><button>返回我的書籤</button></a>
</body>
</html>
