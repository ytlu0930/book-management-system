Book Management System

本專案為資料庫管理課程之期末專題，實作一套以資料庫為核心的書籍管理系統。
系統整合書籍管理、借閱紀錄、用戶管理與閱讀進度（書籤）功能，
透過網頁介面進行 CRUD 操作，實踐資料庫設計、正規化與關聯操作。

專案功能說明
書籍管理

新增、修改、刪除書籍資料

依書名、作者、借閱狀態進行查詢

依書籍類別顯示書籍清單

查看書籍詳細資訊（包含借閱與閱讀進度）

借閱紀錄管理

新增、修改、刪除借閱紀錄

查詢特定用戶的借閱與出借紀錄

顯示借書人與出借人資料

用戶管理

新增、修改、刪除用戶資料

查看用戶詳細資訊與相關借閱紀錄

閱讀進度管理（書籤）

紀錄每位用戶的閱讀進度

顯示最近閱讀頁數與最後更新時間

可新增、修改、刪除閱讀進度紀錄

系統架構與資料庫設計

本系統採用關聯式資料庫設計，包含以下資料表：

Books（書籍）

Users（用戶）

Loans（借閱紀錄）

Categories（書籍類別）

Book_Categories（書籍與類別關聯）

ReadingProgress（閱讀進度）

資料表之間透過外鍵建立關聯，並遵循正規化原則，以確保資料一致性與可維護性。

book_system/
├─ assets/                    # 前端靜態資源（CSS、JavaScript、圖片）
│  ├─ script.js               # 前端互動與功能腳本（書籍清單、操作事件）
│  └─ styles.css              # 系統整體樣式表
│
├─ sql/                       # 資料庫結構與範例資料
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


資料庫建立方式

請先建立資料庫並依序執行 SQL 建表與資料插入語法。

CREATE DATABASE MangeDB;
USE MangeDB;


接著依序建立 Books、Users、Loans、Categories、Book_Categories、ReadingProgress 等資料表，
並插入範例資料以供測試。

（完整 SQL 語法可放置於 sql/ 資料夾中）

開發環境

前端：HTML / CSS

後端：PHP

資料庫：MySQL

開發工具：VS Code

測試環境：XAMPP / phpMyAdmin

專案性質

本專案為課程期末作業，重點在於：

資料庫設計與 ER Model

關聯式資料表與外鍵應用

SQL 與網頁系統整合

CRUD 功能實作

作者資訊

姓名：盧宜婷
學號：B11201108