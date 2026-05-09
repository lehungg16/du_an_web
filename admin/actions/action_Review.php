/* =======================
    DUYỆT ĐÁNH GIÁ TỪ TRANG list_Reviews.php
    -------------------------------
    XÓA ĐÁNH GIÁ TỪ TRANG list_Reviews.php
======================= */

<?php require_once '../../config.php';
/* Xử lý duyệt đánh giá
- Lấy ID từ URL
- Chuẩn bị câu lệnh UPDATE với tham số ID và trạng thái 'Đã Duyệt'
- Thực thi câu lệnh
- Nếu thành công, chuyển hướng về trang danh sách đánh giá để cập nhật giao diện
*/  
if(isset($_GET['approve'])) {
    $id = intval($_GET['approve']);
    $sql = "UPDATE tb_reviews SET status='Đã Duyệt' WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if($stmt->execute()){
        header("Location: ../index.php?tab=list_Reviews");
    } else {
        echo "Duyệt thất bại!";
    }
}
/* Xứ lý xóa đánh giá
- Lấy ID từ URL
- Chuẩn bị câu lệnh DELETE với tham số ID
- Thực thi câu lệnh
- Nếu thành công, chuyển hướng về trang danh sách đánh giá để cập nhật giao diện
*/
if(isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $sql = "DELETE FROM tb_reviews WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if($stmt->execute()){
        header("Location: ../index.php?tab=list_Reviews");
    } else {
        echo "Xóa thất bại!";
    }
}
?>