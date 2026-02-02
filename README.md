# Book Management System (書籍管理系統)

> **資料庫管理課程期末專題**

本專案實作了一套以資料庫為核心的書籍管理系統。系統整合了書籍管理、借閱紀錄、用戶管理與閱讀進度（書籤）功能。透過網頁介面進行 CRUD 操作，實踐資料庫設計、正規化與關聯操作的應用。

## 專案性質

本專案為課程期末作業，開發重點在於：
* **資料庫設計**：ER Model 的規劃與實作。
* **資料完整性**：關聯式資料表設計與外鍵（Foreign Key）應用。
* **系統整合**：SQL 語法與 PHP 網頁系統的結合。
* **功能實作**：完整的 CRUD（新增、讀取、更新、刪除）流程。

## 開發環境與技術

* **前端**：HTML, CSS, JavaScript
* **後端**：PHP
* **資料庫**：MySQL
* **開發工具**：VS Code
* **測試環境**：XAMPP / phpMyAdmin

## 專案功能說明

### 1. 書籍管理 (Books)
* **CRUD 操作**：可新增、修改、刪除書籍資料。
* **進階查詢**：支援依「書名」、「作者」、「借閱狀態」進行搜尋。
* **分類瀏覽**：依書籍類別顯示書籍清單。
* **詳細資訊**：查看書籍詳細內容，包含關聯的借閱狀態與閱讀進度。

### 2. 借閱紀錄管理 (Loans)
* **紀錄維護**：新增、修改、刪除借閱紀錄。
* **歷史查詢**：查詢特定用戶的借閱歷史與出借紀錄。
* **關聯顯示**：顯示借書人與出借人的詳細資料。

### 3. 用戶管理 (Users)
* **資料維護**：新增、修改、刪除用戶基本資料。
* **個人資訊**：查看用戶詳細資訊及其相關的借閱紀錄。

### 4. 閱讀進度管理 (Reading Progress)
* **書籤功能**：紀錄每位用戶針對特定書籍的閱讀進度。
* **進度追蹤**：顯示最近閱讀頁數與最後更新時間。
* **彈性管理**：可隨時新增、修改或刪除閱讀進度。

## 資料庫設計

本系統採用關聯式資料庫設計，透過外鍵建立關聯並遵循正規化原則，以確保資料一致性。主要資料表如下：

| 資料表名稱 | 說明 |
| :--- | :--- |
| **Books** | 儲存書籍基本資料 |
| **Users** | 儲存用戶資料 |
| **Loans** | 儲存借閱與歸還紀錄 |
| **Categories** | 書籍類別定義 |
| **Book_Categories** | 書籍與類別的中介關聯表 |
| **ReadingProgress** | 儲存用戶閱讀頁數與進度 |

## 📂 檔案結構

```text
book_system/
├─ assets/                    # 前端靜態資源
│  ├─ script.js               # 前端互動腳本（書籍清單、操作事件）
│  └─ styles.css              # 系統整體樣式表
│
├─ sql/                       # 資料庫結構
│  └─ schema_and_seed.sql     # 建立資料表與初始測試資料
│
├─ index.php                  # 書籍清單首頁
├─ add.php                    # 新增書籍資料
├─ edit.php                   # 修改書籍資料
├─ delete.php                 # 刪除書籍資料
│
├─ book_details.php           # 書籍詳細資訊（關聯借閱與閱讀進度）
├─ search.php                 # 書籍查詢功能
│
├─ borrow.php                 # 借閱紀錄清單
├─ add_loan.php               # 新增借閱紀錄
├─ edit_loan.php              # 修改借閱紀錄
│
├─ user.php                   # 用戶管理（新增／修改／刪除）
├─ user_info.php              # 用戶詳細資訊與相關借閱紀錄
│
├─ reading_progress.php       # 閱讀進度（書籤）清單
├─ add_progress.php           # 新增閱讀進度
├─ update_progress.php        # 修改閱讀進度
├─ delete_progress.php        # 刪除閱讀進度
│
├─ db.php                     # 資料庫連線設定
└─ README.md                  # 專案說明文件
```

## 安裝與資料庫建立

請依照以下步驟在本地端部署專案：

1. **啟動伺服器**：開啟 XAMPP，啟動 Apache 與 MySQL。
2. **建立資料庫**：進入 phpMyAdmin 或使用 SQL 指令工具，執行以下指令建立資料庫：

   ```sql
   CREATE DATABASE MangeDB;
   USE MangeDB;

3. **匯入資料表**：
   請執行 `sql/schema_and_seed.sql` 檔案中的 SQL 語法。
   此步驟將會依序建立 `Books`, `Users`, `Loans`, `Categories`, `Book_Categories`, `ReadingProgress` 等資料表，並寫入預設的測試資料。

4. **設定連線**：
   確認 `db.php` 中的資料庫帳號密碼設定是否正確（預設通常為 user: `root`, password: ``）。

5. **執行專案**：
   開啟瀏覽器，輸入 `http://localhost/book_system/index.php` 即可開始使用。

## 作者資訊

* **姓名**：盧宜婷
