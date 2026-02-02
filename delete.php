<?php
include 'db.php';

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];
    
    // 刪除書籍資料
    $sql = "DELETE FROM Books WHERE book_id='$book_id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");  // 刪除成功後返回書籍清單
    } else {
        echo "錯誤: " . $conn->error;
    }
} else {
    echo "未提供書籍ID";
}
?>
