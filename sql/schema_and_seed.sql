#建立資料庫
create database MangeDB;
use MangeDB;

#建立表格
#書籍表
create table Books(
book_id INT AUTO_INCREMENT PRIMARY KEY,      -- 書籍ID（主鍵）
book_name VARCHAR(255) NOT NULL,             -- 書名
author VARCHAR(255),                         -- 作者
format ENUM('電子書', '實體書') NOT NULL,    -- 格式：電子書 或 實體書
status ENUM('自購','借來','借出'),           -- 狀態：自買 或 借來
description TEXT,                            -- 書籍描述
last_read_time DATE                          -- 最後閱讀時間
)ENGINE=InnoDB;

#用戶表
create table Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,  -- 用戶ID（主鍵）
    name VARCHAR(100) NOT NULL,              -- 用戶名稱
    email VARCHAR(100) UNIQUE,               -- 電子郵件
    phone CHAR(10)                           -- 電話號碼
)ENGINE=InnoDB;

#借還記錄表 
CREATE TABLE Loans (
    loan_id INT AUTO_INCREMENT PRIMARY KEY,  -- 借還記錄ID（主鍵）
    book_id INT NOT NULL,                    -- 書籍ID（外鍵）
    borrower_id INT NOT NULL,                -- 借書人ID（外鍵）
    lender_id INT NOT NULL,                  -- 借出人ID（外鍵）
    borrow_date DATE NOT NULL,               -- 借書日期
    due_date DATE NOT NULL,                  -- 還書期限
    FOREIGN KEY (book_id) REFERENCES Books(book_id) ON DELETE CASCADE,
    FOREIGN KEY (borrower_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (lender_id) REFERENCES Users(user_id) ON DELETE CASCADE
)ENGINE=InnoDB;

#分類表
CREATE TABLE Categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY, -- 類型ID（主鍵）
    name VARCHAR(50) NOT NULL UNIQUE            -- 類型名稱
)ENGINE=InnoDB;

CREATE TABLE Book_Categories (
    book_id INT NOT NULL,                       -- 書籍ID（外鍵）
    category_id INT NOT NULL,                   -- 類型ID（外鍵）
    PRIMARY KEY (book_id, category_id),
    FOREIGN KEY (book_id) REFERENCES Books(book_id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES Categories(category_id) ON DELETE CASCADE
)ENGINE=InnoDB;

#閱讀進度表
CREATE TABLE ReadingProgress (
    user_id INT NOT NULL,                       -- 用戶ID（外鍵）
    book_id INT NOT NULL,                       -- 書籍ID（外鍵）
    current_page VARCHAR(255),                  -- 當前進度
    last_updated DATE,                          -- 最後更新時間
    primary key (user_id,book_id),
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES Books(book_id) ON DELETE CASCADE
)ENGINE=InnoDB;

#插入一些書籍資料
insert into Books (book_name,author,format,status,description,last_read_time)
values
('作業研究',NULL,'電子書','自購','把簡單的東西用得很複雜','2024-11-28'),
('財務管理',NULL,'電子書','自購','我沒有財務可以管理','2024-11-29'),
('廚房','蕉本芭娜娜','實體書','借來',NULL,'2024-08-30'),
('吉伊卡哇','長野','實體書','自購','烏拉拉烏拉 烏拉拉呀哈呀哈 030 ~鋪魯','2024-09-15'),
('異鄉人','卡謬','實體書','借來',NULL,'2024-02-26'),
('再見繪梨','藤本樹','實體書','借出','運用很多電影分鏡，分不出那些是現實哪些是鏡頭前的故事，非常好看。','2024-11-13'),
('驀然回首','藤本樹','實體書','自購','非常感動，溫馨小品，我哭爛。','2024-09-23'),
('鏈鋸人','藤本樹','實體書','自購','神作，有伏筆有轉折有巧思，每個猝不及防的便當都有來由與伏筆。不是揍宿回戰','2024-11-30'),
('統計學',NULL,'電子書','自購','學完統計學，需要統計的是我會不會過。','2024-11-29'),
('小王子','安托萬','實體書','借來',NULL,'2023-12-23');

#插入一些用戶資料
insert into Users (name,email,phone)
values
('Daisy','1234@gmail.com',0912345678),
('Teddy','bear@yahoo.mail.com.tw',NULL),
('Asiii',NULL,0987654321),
('Jay',NULL,0911223455);

#插入一些借還記錄
insert into Loans (book_id,borrower_id,lender_id,borrow_date,due_date)
values
(3,1,2,'2024-06-25','2025-02-26'),
(5,1,3,'2023-11-11','2024-11-30'),
(6,4,1,'2024-12-01','2025-04-26'),
(10,3,2,'2024-03-19','2024-09-16');



#插入類型表
insert into Categories (name)
values
('課本'),('漫畫'),('文學小說'),('繪本');

insert into Book_Categories (book_id,category_id)
values
(1,1),(2,1),(3,3),(4,2),(5,3),(6,2),(7,2),(8,2),(9,1),(10,4);

#插入一些閱讀進度(書籤)
insert into ReadingProgress (user_id,book_id,current_page,last_updated)
values
(1,1,'CH9','2024-11-28'),
(1,4,'第100集','2024-09-10'),
(4,6,'第50頁','2024-11-13');


