<?php
include 'db.php';

if (isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];
    $user_id = 1; // 假設當前用戶ID為1，可以根據實際登入系統調整

    $sql = "DELETE FROM ReadingProgress WHERE book_id = $book_id AND user_id = $user_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: reading_progess.php");
        exit();
    } else {
        echo "刪除進度失敗：" . $conn->error;
    }
}
?>