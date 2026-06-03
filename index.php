<?php
require_once 'database.php';

$stmt = $pdo->query("SELECT * FROM sinhvien");
$sinhviens = $stmt->fetchAll(PDO::FETCH_ASSOC);

$tong_sv = count($sinhviens);
$tong_hoc_bong = 0;
$count_gioi = 0;
$count_kha = 0;
$count_tb = 0;
$count_yeu = 0;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý điểm học tập</title>
   <link rel="stylesheet" href="style.css">
</head>
<body>

    <h2>DANH SÁCH ĐIỂM HỌC TẬP CỦA SINH VIÊN</h2>
    <a href="add.php" class="btn-add">Thêm mới sinh viên</a>

    <table>
        <tr>
            <th>MSSV</th>
            <th>Họ tên</th>
            <th>Điểm PHP</th>
            <th>Điểm MySQL</th>
            <th>Điểm HTML</th>
            <th>ĐTB</th>
            <th>Xếp loại</th>
            <th>Học bổng</th>
            <th>Max môn</th>
            <th>Min môn</th>
            <th>ĐTB chung</th>
            <th>Hành động</th>
        </tr>
        <?php foreach($sinhviens as $sv): 
            $p = $sv['diem_php'];
            $m = $sv['diem_mysql'];
            $h = $sv['diem_html'];
            $dtb = round((($p * 2) + ($m * 2) + $h) / 5, 2);
            if ($dtb >= 8) {
                $xep_loai = "Giỏi";
                $count_gioi++;
            } elseif ($dtb >= 6.5) {
                $xep_loai = "Khá";
                $count_kha++;
            } elseif ($dtb >= 5) {
                $xep_loai = "Trung bình";
                $count_tb++;
            } else {
                $xep_loai = "Yếu";
                $count_yeu++;
            }

            if ($dtb >= 8.0 && $p >= 7.0 && $m >= 7.0 && $h >= 7.0) {
                $hoc_bong = "Đủ điều kiện học bổng";
                $tong_hoc_bong++;
            } else {
                $hoc_bong = "Không đủ điều kiện học bổng";
            }

            $max_mon = max($p, $m, $h);
            $min_mon = min($p, $m, $h);
            $dtb_chung = round(($p + $m + $h) / 3, 2);
        ?>
        <tr>
            <td><?= $sv['mssv'] ?></td>
            <td><?=$sv['hoten'] ?></td>
            <td><?= $p ?></td>
            <td><?= $m ?></td>
            <td><?= $h ?></td>
            <td><?= $dtb ?></td>
            <td><?= $xep_loai ?></td>
            <td><?= $hoc_bong ?> </td>
            <td><?= $max_mon ?></td>
            <td><?= $min_mon ?></td>
            <td><?= $dtb_chung ?></td>
            <td>
                <a href="delete.php?mssv=<?= $sv['mssv'] ?>" class="btn-delete" 
                   onclick="return confirm('Bạn chắc chắn muốn xóa sinh viên này chứ?');">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div class="thong-ke-box">
        <h3>BẢNG THỐNG KÊ CHUNG</h3>
        <ul>
            <li>Tổng số sinh viên: <strong><?= $tong_sv ?></strong></li>
            <li>Tổng số sinh viên đạt học bổng: <strong><?= $tong_hoc_bong ?></strong></li>
            <li>Số lượng sinh viên <strong>Giỏi</strong>: <?= $count_gioi ?></li>
            <li>Số lượng sinh viên <strong>Khá</strong>: <?= $count_kha ?></li>
            <li>Số lượng sinh viên <strong>Trung bình</strong>: <?= $count_tb ?></li>
            <li>Số lượng sinh viên <strong>Yếu</strong>: <?= $count_yeu ?></li>
        </ul>
    </div>



</body>
</html>