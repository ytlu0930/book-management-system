<?php
include 'db.php';

// 處理修改借閱記錄
if (isset($_POST['update_loan'])) {
    $loan_id = $_POST['loan_id'];
    $borrow_date = $_POST['borrow_date'];
    $due_date = $_POST['due_date'];

    $update_sql = "UPDATE Loans SET borrow_date = '$borrow_date', due_date = '$due_date' WHERE loan_id = $loan_id";
    if ($conn->query($update_sql) === TRUE) {
        echo "借閱記錄已更新!";
        header("Location: borrow.php"); // 修改後返回借閱記錄頁面
        exit();
    } else {
        echo "錯誤: " . $conn->error;
    }
}

// 查詢特定借閱記錄
if (isset($_GET['id'])) {
    $loan_id = $_GET['id'];
    $sql = "SELECT * FROM Loans WHERE loan_id = $loan_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "找不到借閱記錄!";
        exit();
    }
} else {
    echo "無法識別的借閱記錄!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>修改借閱記錄</title>
</head>
<body>
    <h1>修改借閱記錄</h1>
    <form action="edit_loan.php" method="POST">
        <input type="hidden" name="loan_id" value="<?php echo $row['loan_id']; ?>">

        <label for="borrow_date">借書日期:</label>
        <input type="date" name="borrow_date" value="<?php echo $row['borrow_date']; ?>" required><br>

        <label for="due_date">還書期限:</label>
        <input type="date" name="due_date" value="<?php echo $row['due_date']; ?>" required><br>

        <button type="submit" name="update_loan">更新借閱記錄</button>
    </form>

    <a href="borrow.php"><button>返回借閱記錄</button></a>
</body>
</html>
