<?php
include 'db.php';

// 查詢閱讀進度資料，並顯示用戶姓名
$sql = "SELECT rp.user_id, u.name AS user_name, rp.book_id, b.book_name, b.author, rp.current_page, rp.last_updated
        FROM ReadingProgress rp
        INNER JOIN Books b ON rp.book_id = b.book_id
        INNER JOIN Users u ON rp.user_id = u.user_id";  // 加入 Users 表格來取得用戶姓名
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>我的書籤</title>
</head>
<body>
    <h1>我的書籤</h1>
    <a href="add_progress.php"><button>新增進度</button></a>
    <table border="1">
        <tr>
            <th>書名</th>
            <th>作者</th>
            <th>當前進度</th>
            <th>最後更新</th>
            <th>操作</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['book_name'], ENT_QUOTES, 'UTF-8') . "</td>";
                echo "<td>" . htmlspecialchars($row['author'], ENT_QUOTES, 'UTF-8') . "</td>";
                echo "<td>" . htmlspecialchars($row['current_page'], ENT_QUOTES, 'UTF-8') . "</td>";
                echo "<td>" . htmlspecialchars($row['last_updated'], ENT_QUOTES, 'UTF-8') . "</td>";
                echo "<td>
                        <a href='update_progress.php?book_id=" . $row['book_id'] . "'>更新進度</a> | 
                        <a href='delete_progress.php?book_id=" . $row['book_id'] . "' onclick='return confirm(\"確定要刪除這個進度嗎?\")'>刪除進度</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>沒有進度記錄</td></tr>";  // 更新 colspan 為 6，包含用戶姓名欄位
        }
        ?>
    </table>
    <a href="index.php"><button>返回首頁</button></a>
</body>
</html>
