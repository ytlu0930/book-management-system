<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_id = $_POST['book_id'];
    $book_name = $_POST['book_name'];
    $author = $_POST['author'];
    $format = $_POST['format'];
    $status = $_POST['status'];
    $description = $_POST['description'];

    // 更新書籍資料
    $sql = "UPDATE Books SET book_name='$book_name', author='$author', format='$format', 
            status='$status', description='$description' WHERE book_id='$book_id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");  // 編輯完成後重定向回書籍清單頁
    } else {
        echo "錯誤: " . $conn->error;
    }
} else {
    // 獲取要編輯的書籍資料
    $book_id = $_GET['id'];
    $sql = "SELECT * FROM Books WHERE book_id='$book_id'";
    $result = $conn->query($sql);
    $book = $result->fetch_assoc();
}
?>

<?php
$previous_page = $_SERVER['HTTP_REFERER'];  // 获取上一页的 URL
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles.css">
    <title>編輯書籍</title>
</head>
<body>
    <h1>編輯書籍</h1>
    <form action="edit.php" method="POST">
        <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
        <label>書名：</label>
        <input type="text" name="book_name" value="<?php echo $book['book_name']; ?>" required><br>
        <label>作者：</label>
        <input type="text" name="author" value="<?php echo $book['author']; ?>"><br>
        <label>格式：</label>
        <select name="format">
            <option value="電子書" <?php echo $book['format'] == '電子書' ? 'selected' : ''; ?>>電子書</option>
            <option value="實體書" <?php echo $book['format'] == '實體書' ? 'selected' : ''; ?>>實體書</option>
        </select><br>
        <label>狀態：</label>
        <select name="status">
            <option value="自購" <?php echo $book['status'] == '自購' ? 'selected' : ''; ?>>自購</option>
            <option value="借來" <?php echo $book['status'] == '借來' ? 'selected' : ''; ?>>借來</option>
            <option value="借出" <?php echo $book['status'] == '借出' ? 'selected' : ''; ?>>借出</option>
        </select><br>
        <label>描述：</label>
        <textarea name="description"><?php echo $book['description']; ?></textarea><br>
        <button type="submit">儲存更改</button>
    </form>

    <!-- 回前頁按鈕 -->
    <a href="index.php"><button>回上一頁</button></a>

</body>
</html>
