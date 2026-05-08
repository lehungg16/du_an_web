<!-- Nút duyệt -->
<?php if(!$isDone): ?>
<a href="approve_review.php?id=<?= $row['id'] ?>">
    <button class="action-btn btn-approve">✔ Duyệt</button>
</a>
<?php endif; ?>

<!-- Nút xóa -->
<a href="delete_review.php?id=<?= $row['id'] ?>" onclick="return confirm('Xác nhận xóa?')">
    <button class="action-btn btn-delete">🗑</button>
</a>