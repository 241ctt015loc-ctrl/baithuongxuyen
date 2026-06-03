<?php
require_once 'database.php';
$errors = [];
 
    $mssv = $_POST['mssv'] ?? '';
    $hoten = $_POST['hoten'] ?? '';
    $diem_php = $_POST['diem_php'] ?? '';
    $diem_mysql = $_POST['diem_mysql'] ?? '';
    $diem_html = $_POST['diem_html'] ?? '';

    if ($mssv === '' || $hoten === '' || $diem_php === '' || $diem_mysql === '' || $diem_html === '') {
        $errors[] = "Vui lòng nhập đầy đủ tất cả các trường dữ liệu!";
    } else {
        if (!is_numeric($diem_php) || $diem_php < 0 || $diem_php > 10) $errors[] = "Điểm PHP phải nằm trong khoảng từ 0 đến 10!";
        if (!is_numeric($diem_mysql) || $diem_mysql < 0 || $diem_mysql > 10) $errors[] = "Điểm MySQL phải nằm trong khoảng từ 0 đến 10!";
        if (!is_numeric($diem_html) || $diem_html < 0 || $diem_html > 10) $errors[] = "Điểm HTML phải nằm trong khoảng từ 0 đến 10!";
    }

    if (empty($errors)) {
        try {   
            $stmt = $pdo->prepare("INSERT INTO sinhvien (mssv, hoten, diem_php, diem_mysql, diem_html) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$mssv, $hoten, $diem_php, $diem_mysql, $diem_html]);
            header("Location: index.php"); 
            exit;
        } catch (PDOException $e) {
            $errors[] = "Lỗi: Mã sinh viên đã tồn tại hoặc có lỗi hệ thống! " . $e->getMessage();
        }
    }

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm mới Sinh viên</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form method="POST">
        <h2>THÊM MỚI SINH VIÊN</h2>
        
        <?php if (!empty($errors)): ?>
            <div class="error">
                <?php foreach ($errors as $err) echo "<p>• $err</p>"; ?>
            </div>
        <?php endif; ?>

        <div class="form-group">
            <label>Mã sinh viên:</label>
            <input type="text" name="mssv" value="<?= $_POST['mssv'] ?? '' ?>">
        </div>
        <div class="form-group">
            <label>Họ tên:</label>
            <input type="text" name="hoten" value="<?= $_POST['hoten'] ?? '' ?>">
        </div>
        <div class="form-group">
            <label>Điểm PHP:</label>
            <input type="number" step="0.1" name="diem_php" value="<?= $_POST['diem_php'] ?? '' ?>">
        </div>
        <div class="form-group">
            <label>Điểm MySQL:</label>
            <input type="number" step="0.1" name="diem_mysql" value="<?= $_POST['diem_mysql'] ?? '' ?>">
        </div>
        <div class="form-group">
            <label>Điểm HTML:</label>
            <input type="number" step="0.1" name="diem_html" value="<?= $_POST['diem_html'] ?? '' ?>">
        </div>
        <button type="submit">Lưu lại</button>
        <a href="index.php" style="margin-left: 10px;">Quay lại danh sách</a>
    </form>
</body>
</html>