<?php
include 'db.php';

// 處理新增借閱
if (isset($_POST['add_loan'])) {
    $book_id = $_POST['book_id'];
    $borrower_id = $_POST['borrower_id'];
    $lender_id = $_POST['lender_id'];
    $borrow_date = $_POST['borrow_date'];
    $due_date = $_POST['due_date'];

    $add_sql = "INSERT INTO Loans (book_id, borrower_id, lender_id, borrow_date, due_date) 
                VALUES ('$book_id', '$borrower_id', '$lender_id', '$borrow_date', '$due_date')";
    if ($conn->query($add_sql) === TRUE) {
        echo "借閱記錄新增成功!";
        header('Location: borrow.php');  // 新增成功後，跳轉回借閱記錄頁面
        exit;
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
    <title>新增借閱記錄</title>
</head>
<body>
    <h1>新增借閱記錄</h1>
    <form action="add_loan.php" method="POST">
        <label for="book_id">書籍:</label>
        <select name="book_id" required>
            <?php
            // 查詢所有書籍
            $books_sql = "SELECT book_id, book_name FROM Books";
            $books_result = $conn->query($books_sql);
            while ($book = $books_result->fetch_assoc()) {
                echo "<option value='{$book['book_id']}'>{$book['book_name']}</option>";
            }
            ?>
        </select><br>

        <label for="borrower_id">借閱者:</label>
        <select name="borrower_id" required>
            <?php
            // 查詢所有用戶
            $users_sql = "SELECT user_id, name FROM Users";
            $users_result = $conn->query($users_sql);
            while ($user = $users_result->fetch_assoc()) {
                echo "<option value='{$user['user_id']}'>{$user['name']}</option>";
            }
            ?>
        </select><br>

        <label for="lender_id">借出者:</label>
        <select name="lender_id" required>
            <?php
            // 查詢所有用戶
            $users_result = $conn->query($users_sql);
            while ($user = $users_result->fetch_assoc()) {
                echo "<option value='{$user['user_id']}'>{$user['name']}</option>";
            }
            ?>
        </select><br>

        <label for="borrow_date">借書日期:</label>
        <input type="date" name="borrow_date" required><br>

        <label for="due_date">還書期限:</label>
        <input type="date" name="due_date" required><br>

        <button type="submit" name="add_loan">新增借閱記錄</button>
    </form>

    <a href="borrow.php"><button>返回借閱記錄頁面</button></a>

</body>
</html>
