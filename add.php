<?php
include 'db.php';

// 處理表單提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['book_name'];
    $author = $_POST['author'];
    $format = $_POST['format'];
    $status = $_POST['status'];
    $description = $_POST['description'];
    $last_read_time = $_POST['last_read_time'];
    $category = $_POST['category'];  // 新增類型

    // 檢查類型是否已存在
    $category_check_sql = "SELECT * FROM Categories WHERE name = '$category'";
    $category_check_result = $conn->query($category_check_sql);

    // 如果類型不存在，新增類型
    if ($category_check_result->num_rows == 0) {
        $insert_category_sql = "INSERT INTO Categories (name) VALUES ('$category')";
        if ($conn->query($insert_category_sql) === TRUE) {
            echo "類型新增成功";
        } else {
            echo "錯誤: " . $conn->error;
        }
    }

    // 新增書籍
    $sql = "INSERT INTO Books (book_name, author, format, status, description, last_read_time)
            VALUES ('$name', '$author', '$format', '$status', '$description', '$last_read_time')";
    if ($conn->query($sql) === TRUE) {
        // 獲取新書籍的 ID
        $book_id = $conn->insert_id;

        // 將書籍類型與書籍關聯
        $get_category_id_sql = "SELECT category_id FROM Categories WHERE name = '$category'";
        $category_result = $conn->query($get_category_id_sql);
        $category_row = $category_result->fetch_assoc();
        $category_id = $category_row['category_id'];

        $insert_book_category_sql = "INSERT INTO Book_Categories (book_id, category_id) 
                                      VALUES ($book_id, $category_id)";
        $conn->query($insert_book_category_sql);

        header("Location: index.php");  // 新增後返回書籍清單頁面
    } else {
        echo "錯誤: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles.css">
    <title>新增書籍</title>
</head>
<body>
    <h1>新增書籍</h1>
    <form action="add.php" method="POST">
        <label>書名：</label>
        <input type="text" name="book_name" required><br>
        <label>作者：</label>
        <input type="text" name="author"><br>
        <label>格式：</label>
        <select name="format">
            <option value="電子書">電子書</option>
            <option value="實體書">實體書</option>
        </select><br>
        <label>狀態：</label>
        <select name="status">
            <option value="自購">自購</option>
            <option value="借來">借來</option>
            <option value="借出">借出</option>
        </select><br>
        <label>描述：</label>
        <textarea name="description"></textarea><br>
        <label>最後閱讀時間：</label>
        <input type="date" name="last_read_time"><br>

        <!-- 類型選擇 -->
        <label>書籍類型：</label>
        <input type="text" name="category" required><br>

        <button type="submit">新增書籍</button>
    </form>

    <!-- 回上一頁 -->
    <a href="index.php"><button>返回</button></a>
</body>
</html>
