<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id']; // 假設從 Session 或其他地方獲取
    $book_id = $_POST['book_id'];
    $current_page = $_POST['current_page'];
    $last_updated = date('Y-m-d');

    $sql = "REPLACE INTO ReadingProgress (user_id, book_id, current_page, last_updated) 
            VALUES ($user_id, $book_id, '$current_page', '$last_updated')";

    if ($conn->query($sql) === TRUE) {
        echo "閱讀進度已更新!";
    } else {
        echo "錯誤: " . $conn->error;
    }

    header("Location: reading_progress.php");
    exit;
} elseif (isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];
    $book_sql = "SELECT * FROM Books WHERE book_id = $book_id";
    $book_result = $conn->query($book_sql)->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>更新閱讀進度</title>
</head>
<body>
    <h1>更新閱讀進度</h1>
    <form method="POST" action="update_progress.php">
        <input type="hidden" name="user_id" value="1"> <!-- 假設用戶ID為1 -->
        <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
        <label>書名: <?php echo $book_result['book_name']; ?></label><br>
        <label>當前進度:</label>
        <input type="text" name="current_page" required><br>
        <button type="submit">更新</button>
    </form>
    <a href="reading_progress.php"><button>取消</button></a>
</body>
</html>
