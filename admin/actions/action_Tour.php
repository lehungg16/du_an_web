<?php require_once '../../config.php';
/* Xử lý xóa tour
- Lấy ID từ URL
- Chuẩn bị câu lệnh DELETE với tham số ID
- Thực thi câu lệnh
- Nếu thành công, chuyển hướng về trang danh sách tour để cập nhật giao diện
*/
if(isset($_GET['id'])) {    
    $id = $_GET['id'];
    $sql = "DELETE FROM tb_tours WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if($stmt->execute()){
        header("Location: ../index.php?tab=list_Tours");
    } else {
        echo "Xóa thất bại!";
    }
}
?>