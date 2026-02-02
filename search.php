<?php
include 'db.php';  // 連接資料庫

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 從表單取得查詢條件
    $book_name = $_POST['book_name'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $status = $_POST['status'];

    // 根據用戶的輸入組合 SQL 查詢語句
    $sql = "SELECT b.book_name, b.author, c.name AS category, b.status
            FROM Books b
            JOIN Book_Categories bc ON b.book_id = bc.book_id
            JOIN Categories c ON bc.category_id = c.category_id
            WHERE b.book_name LIKE '%$book_name%'
              AND b.author LIKE '%$author%'
              AND c.name LIKE '%$category%'
              AND b.status LIKE '%$status%'";

    // 執行查詢
    $result = $conn->query($sql);

    // 顯示查詢結果
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "書名: " . $row['book_name'] . " - 作者: " . $row['author'] . " - 類型: " . $row['category'] . " - 狀態: " . $row['status'] . "<br>";
        }
    } else {
        echo "查無資料";
    }
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>查詢書籍</title>
</head>
<body>
    <h1>查詢書籍</h1>
    <form method="POST" action="search.php">
        <label>書名：</label>
        <input type="text" name="book_name" placeholder="輸入書名"><br>

        <label>作者：</label>
        <input type="text" name="author" placeholder="輸入作者"><br>

        <label>類型：</label>
        <input type="text" name="category" placeholder="輸入類型"><br>

        <label>狀態：</label>
        <select name="status">
            <option value="">選擇狀態</option>
            <option value="自購">自購</option>
            <option value="借來">借來</option>
            <option value="借出">借出</option>
        </select><br>

        <button type="submit">查詢</button>
    </form>

    <br>
    <a href="index.php">回首頁</a> <!-- 回首頁按鈕 -->
</body>
</html>
