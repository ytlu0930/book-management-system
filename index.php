<?php 
include 'db.php';

// 刪除沒有書籍關聯的類型
$delete_empty_categories_sql = "DELETE FROM Categories WHERE category_id NOT IN (SELECT DISTINCT category_id FROM Book_Categories)";
$conn->query($delete_empty_categories_sql);

// 查詢所有類別
$categories_sql = "SELECT * FROM Categories";
$categories_result = $conn->query($categories_sql);

// 查詢書籍功能
$search_query = "";
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;
$status_filter = isset($_POST['status']) ? $_POST['status'] : '';  // 添加狀態篩選

$sql = "SELECT * FROM Books WHERE 1";  // 讓查詢預設為全部書籍

// 根據類別篩選書籍
if ($category_id) {
    $sql = "SELECT Books.* FROM Books 
            INNER JOIN Book_Categories ON Books.book_id = Book_Categories.book_id 
            WHERE Book_Categories.category_id = $category_id";
}

// 根據書名或作者進行模糊查詢
if (isset($_POST['search']) && !empty($_POST['search_query'])) {
    $search_query = $_POST['search_query'];
    $sql .= " AND (book_name LIKE '%$search_query%' OR author LIKE '%$search_query%')";
}

// 根據狀態篩選
if ($status_filter != '') {
    $sql .= " AND status = '$status_filter'";  // 根據狀態過濾
}
// 查詢各種狀態下的書籍數量
$books_count_query = "
    SELECT
        status,
        COUNT(*) AS count
    FROM Books
    GROUP BY status
";
$books_count_result = $conn->query($books_count_query);
$books_count = [
    '自購' => 0,
    '借來' => 0,
    '借出' => 0,
];

// 儲存查詢結果
if ($books_count_result->num_rows > 0) {
    while ($row = $books_count_result->fetch_assoc()) {
        $books_count[$row['status']] = $row['count'];
    }
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles.css">
    <title>書籍管理</title>
    <style>
        /* 目錄側邊欄樣式 */
        .sidebar {
            width: 200px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            background-color: #f4f4f4;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        .sidebar h2 {
            text-align: center;
        }
        .sidebar a {
            display: block;
            padding: 8px;
            margin: 8px 0;
            background-color: #ddd;
            text-decoration: none;
            color: black;
            border-radius: 4px;
        }
        .sidebar a:hover {
            background-color: #aaa;
        }
        /* 高亮當前選中的類型 */
        .sidebar a.selected {
            background-color: #4CAF50;
            color: white;
        }

        /* 內容區域樣式 */
        .content {
            margin-left: 220px;
            padding: 20px;
        }

        /* 查詢表單並排顯示 */
        .search-form {
            display: flex;
            gap: 10px; /* 在欄位之間加入間距 */
            margin-bottom: 20px;
        }
        .search-form input, .search-form select, .search-form button {
            padding: 8px;
        }
    </style>
</head>
<body>

    <!-- 目錄側邊欄 -->
    <div class="sidebar">
        <a href="reading_progress.php">我的書籤</a>
        <h2>類別</h2>
        <a href="index.php" class="<?php echo $category_id == null ? 'selected' : ''; ?>">所有類型</a>
        <?php while ($category = $categories_result->fetch_assoc()) { ?>
            <a href="index.php?category_id=<?php echo $category['category_id']; ?>" class="<?php echo $category_id == $category['category_id'] ? 'selected' : ''; ?>">
                <?php echo $category['name']; ?>
            </a>
        <?php } ?>
        <h2>書籍統計</h2>
        <p>自購書籍：<?php echo $books_count['自購']; ?></p>
        <p>借來書籍：<?php echo $books_count['借來']; ?></p>
        <p>借出書籍：<?php echo $books_count['借出']; ?></p>
    </div>


    <!-- 內容區域 -->
    <div class="content">
    <h1>書籍管理系統</h1>

    <!-- 新增書籍按鈕 -->
    <a href="add.php"><button>新增書籍</button></a>

    <!-- 借閱表按鈕 -->
    <a href="borrow.php"><button>查看借閱表</button></a>  <!-- 這裡是新增的連結 -->

    <!-- 查詢書籍功能 -->
    <h2>查詢書籍</h2>
    <form action="index.php" method="POST" class="search-form">
        <label>搜尋書名或作者：</label>
        <input type="text" name="search_query" value="<?php echo $search_query; ?>">

        <label>選擇狀態：</label>
        <select name="status">
            <option value="">全部</option>
            <option value="自購" <?php echo $status_filter == '自購' ? 'selected' : ''; ?>>自購</option>
            <option value="借來" <?php echo $status_filter == '借來' ? 'selected' : ''; ?>>借來</option>
            <option value="借出" <?php echo $status_filter == '借出' ? 'selected' : ''; ?>>借出</option>
        </select>

        <button type="submit" name="search">搜尋</button>
    </form>

    <!-- 顯示書籍列表 -->
    <h3>書籍清單</h3>
    <table border="1">
        <tr>
            <th>書名</th>
            <th>作者</th>
            <th>格式</th>
            <th>狀態</th>
            <th>描述</th>
            <th>最後閱讀時間</th>
            <th>操作</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['book_name'] . "</td>";
                echo "<td>" . $row['author'] . "</td>";
                echo "<td>" . $row['format'] . "</td>";
                echo "<td>" . $row['status'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td>" . $row['last_read_time'] . "</td>";
                // 在操作欄位新增 "詳細資訊" 連結
                echo "<td><a href='book_details.php?id=" . $row['book_id'] . "'>詳細資訊</a> | <a href='edit.php?id=" . $row['book_id'] . "'>編輯</a> | <a href='delete.php?id=" . $row['book_id'] . "' onclick='return confirm(\"確定要刪除這本書嗎?\")'>刪除</a></td>";
                echo "</tr>";

            }
        } else {
            echo "<tr><td colspan='7'>沒有資料</td></tr>";
        }
        ?>
    </table>

    <!-- 查詢後顯示回上一頁按鈕 -->
    <?php if ($search_query || $status_filter) { ?>
        <a href="index.php"><button>回上一頁</button></a>
    <?php } ?>
</div>

</body>
</html>