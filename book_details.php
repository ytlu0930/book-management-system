<?php 
include 'db.php';

// 獲取書籍ID
$book_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($book_id === 0) {
    echo "請提供有效的書籍ID！";
    exit;
}

// 查詢書籍詳細資訊
$book_details_sql = "
    SELECT * FROM Books WHERE book_id = $book_id
";
$book_details_result = $conn->query($book_details_sql);
$book = $book_details_result->fetch_assoc();

if (!$book) {
    echo "找不到該書籍的資料";
    exit;
}

// 查詢該書的所有借還記錄
$loans_sql = "
    SELECT 
        Borrower.name AS borrower_name, 
        Lender.name AS lender_name, 
        borrow_date, 
        due_date 
    FROM Loans 
    INNER JOIN Users AS Borrower ON Loans.borrower_id = Borrower.user_id
    INNER JOIN Users AS Lender ON Loans.lender_id = Lender.user_id
    WHERE Loans.book_id = $book_id
";
$loans_result = $conn->query($loans_sql);

// 查詢該書的所有類別
$categories_sql = "
    SELECT Categories.name 
    FROM Book_Categories 
    INNER JOIN Categories ON Book_Categories.category_id = Categories.category_id 
    WHERE Book_Categories.book_id = $book_id
";
$categories_result = $conn->query($categories_sql);
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles.css">
    <title>書籍詳細資訊</title>
    <style>
        /* 詳細資訊區域樣式 */
        .content {
            margin-left: 220px;
            padding: 20px;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
        }
        .details-table th, .details-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .details-table th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>

<!-- 內容區域 -->
<div class="content">
    <h1>書籍詳細資訊</h1>

    <?php if ($book) { ?>
        <h2><?php echo $book['book_name']; ?> - 詳細資料</h2>
        <table class="details-table">
            <tr>
                <th>書名</th>
                <td><?php echo $book['book_name']; ?></td>
            </tr>
            <tr>
                <th>作者</th>
                <td><?php echo $book['author']; ?></td>
            </tr>
            <tr>
                <th>格式</th>
                <td><?php echo $book['format']; ?></td>
            </tr>
            <tr>
                <th>狀態</th>
                <td><?php echo $book['status']; ?></td>
            </tr>
            <tr>
                <th>描述</th>
                <td><?php echo nl2br($book['description']); ?></td>
            </tr>
            <tr>
                <th>最後閱讀時間</th>
                <td><?php echo $book['last_read_time']; ?></td>
            </tr>
        </table>

        <!-- 顯示該書的類別 -->
        <h3>書籍類別</h3>
        <ul>
            <?php while ($category = $categories_result->fetch_assoc()) { ?>
                <li><?php echo $category['name']; ?></li>
            <?php } ?>
        </ul>

        <!-- 顯示該書的借還記錄 -->
        <h3>借還記錄</h3>
        <table class="details-table">
            <tr>
                <th>借書人</th>
                <th>借出人</th>
                <th>借書日期</th>
                <th>還書日期</th>
            </tr>
            <?php 
            if ($loans_result->num_rows > 0) {
                while ($loan = $loans_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $loan['borrower_name'] . "</td>";
                    echo "<td>" . $loan['lender_name'] . "</td>";
                    echo "<td>" . $loan['borrow_date'] . "</td>";
                    echo "<td>" . $loan['due_date'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>目前沒有借還記錄</td></tr>";
            }
            ?>
        </table>

    <?php } else { ?>
        <p>找不到該書籍的資料。</p>
    <?php } ?>

    <!-- 返回書籍清單按鈕 -->
    <a href="index.php"><button>回書籍清單</button></a>
</div>

</body>
</html>
