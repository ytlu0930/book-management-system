function confirmDelete(bookId) {
    if (confirm("確定要刪除此書嗎？")) {
        window.location.href = `delete.php?id=${bookId}`;
    }
}
