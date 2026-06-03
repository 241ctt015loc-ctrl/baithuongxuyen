<?php
    require_once "database.php";
    $mssv=$_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM sinhvien WHERE mssv = ?");
    $stmt->execute([$_GET['mssv']]);
    if($stmt){
        header("Location: index.php");
    }else{
        echo " Thông báo không thể xóa";
    }
?>