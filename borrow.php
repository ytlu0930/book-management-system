<?php
include 'db.php'; // 包含資料庫連接程式碼

// 處理新增借閱
if (isset($_POST['add_loan'])) {
    $book_id = $_POST['book_id'];
    $borrower_id = $_POST['borrower_id'];
    $lender_id = $_POST['lender_id'];
    $borrow_date = $_POST['borrow_date'];
    $due_date = $_POST['due_date'];

    $add_sql = $conn->prepare("INSERT INTO Loans (book_id, borrower_id, lender_id, borrow_date, due_date) 
                               VALUES (?, ?, ?, ?, ?)");
    $add_sql->bind_param("iiiss", $book_id, $borrower_id, $lender_id, $borrow_date, $due_date);
    
    if ($add_sql->execute()) {
        echo "<script>alert('借閱記錄新增成功!');</script>";
    } else {
        echo "<script>alert('錯誤: " . $conn->error . "');</script>";
    }
}

// 處理刪除借閱
if (isset($_GET['delete'])) {
    $loan_id = $_GET['delete'];

    $delete_sql = $conn->prepare("DELETE FROM Loans WHERE loan_id = ?");
    $delete_sql->bind_param("i", $loan_id);

    if ($delete_sql->execute()) {
        echo "<script>alert('借閱記錄已刪除!');</script>";
    } else {
        echo "<script>alert('錯誤: " . $conn->error . "');</script>";
    }
}

// 處理借閱記錄更新
if (isset($_POST['update_loan'])) {
    $loan_id = $_POST['loan_id'];
    $borrow_date = $_POST['borrow_date'];
    $due_date = $_POST['due_date'];

    $update_sql = $conn->prepare("UPDATE Loans SET borrow_date = ?, due_date = ? WHERE loan_id = ?");
    $update_sql->bind_param("ssi", $borrow_date, $due_date, $loan_id);

    if ($update_sql->execute()) {
        echo "<script>alert('借閱記錄已更新!');</script>";
    } else {
        echo "<script>alert('錯誤: " . $conn->error . "');</script>";
    }
}

// 查詢借閱記錄
$sql = "SELECT l.loan_id, b.book_name, l.borrower_id, l.lender_id, u1.name AS borrower_name, u2.name AS lender_name, l.borrow_date, l.due_date
        FROM Loans l
        INNER JOIN Books b ON l.book_id = b.book_id
        INNER JOIN Users u1 ON l.borrower_id = u1.user_id
        INNER JOIN Users u2 ON l.lender_id = u2.user_id";

if (isset($_POST['user_name']) && !empty($_POST['user_name'])) {
    $user_name = $_POST['user_name'];
    $sql .= " WHERE u1.name LIKE '%$user_name%' OR u2.name LIKE '%$user_name%'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles.css">
    <title>借閱記錄</title>
</head>
<body>

    <h1>借閱表</h1>
    
    <!-- 新增借閱記錄和用戶表按鈕 -->
    <div>
        <a href="add_loan.php"><button>新增借閱記錄</button></a>
        <a href="user.php"><button>查看用戶表</button></a>
    </div>

    <!-- 搜尋表單 -->
    <h2>搜尋借閱記錄</h2>
    <form action="borrow.php" method="POST">
        <label for="user_name">輸入用戶姓名：</label>
        <input type="text" id="user_name" name="user_name" placeholder="輸入借閱者或借出者姓名">
        <button type="submit">搜尋</button>
    </form>
    
    <?php if (isset($_POST['user_name']) && !empty($_POST['user_name'])) { ?>
        <a href="borrow.php"><button>顯示全部記錄</button></a>
    <?php } ?>

    <h2>借閱記錄清單</h2>
    <table border="1">
        <tr>
            <th>書名</th>
            <th>借閱者</th>
            <th>借出者</th>
            <th>借書日期</th>
            <th>還書期限</th>
            <th>操作</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['book_name'] . "</td>";
                echo "<td><a href='user_info.php?id=" . $row['borrower_id'] . "'>" . $row['borrower_name'] . "</a></td>";
                echo "<td><a href='user_info.php?id=" . $row['lender_id'] . "'>" . $row['lender_name'] . "</a></td>";
                echo "<td>" . $row['borrow_date'] . "</td>";
                echo "<td>" . $row['due_date'] . "</td>";
                echo "<td>
                        <a href='edit_loan.php?id=" . $row['loan_id'] . "'>修改</a> | 
                        <a href='borrow.php?delete=" . $row['loan_id'] . "' onclick='return confirm(\"確定刪除這筆借閱記錄?\")'>刪除</a>
                    </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>沒有借閱記錄</td></tr>";
        }
        ?>
    </table>

    <a href="index.php"><button>返回首頁</button></a>

</body>
</html>
