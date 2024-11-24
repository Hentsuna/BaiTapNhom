<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin chi tiết sách</title>
    <link rel="stylesheet" href="cssfolder/detail.css">
    <link rel="stylesheet" href="cssfolder/header.css">
    <link rel="stylesheet" href="cssfolder/footer.css">
</head>

<body>
    <?php
    session_start();
    require "connect.php";
    include "giaodien/header.php";
    ?>

    <main>
        <div class="row">
            <?php
            require("connect.php");
            $Masach = $_GET['ma_sach'];

            $sqlb = "SELECT tieu_de, tac_gia, ten_the_loai, nam_xuat_ban, mo_ta, anh_bia, link_file
            FROM books join categories on books.ma_the_loai = categories.ma_the_loai
            WHERE books.ma_sach = '$Masach'";
            $result = mysqli_query($conn, $sqlb);
            if (mysqli_num_rows($result) <> 0) {
                while ($rows = mysqli_fetch_array($result)) {
                    echo "<table>";
                    echo "<a href='index.php'>Trang chủ</a>  /  <a href=''>{$rows['tieu_de']}</a>";
                    echo "<tr'>";
                    echo "<td><img src='./images/cover/{$rows['anh_bia']}' width='150' height='250'/></td>";
                    echo "<td>
                    {$rows['tieu_de']}<br>
                    <b>Tác giả:</b>
                    {$rows['tac_gia']}<br>
                    <b>Thể loại:</b>
                    {$rows['ten_the_loai']}<br>
                    <b>Năm xuất bản:</b>
                    {$rows['nam_xuat_ban']}<br>
                    <a href='{$rows['link_file']}'><button type='submit'>Đọc sách</button></a>
                    </td>";
                    echo "</table>";
                    echo "<b>Mô tả:</b><br>
                    {$rows['mo_ta']}<br>";
                } //while
            }
            

        $sqlr = "SELECT tennv, avatar, binh_luan, ngay_danh_gia
            FROM reviews join nhanvien on reviews.manv = nhanvien.manv
            WHERE reviews.ma_sach = '$Masach' ORDER BY ngay_danh_gia DESC";
        $resultr = mysqli_query($conn, $sqlr);
        
            if(isset($_POST["binhluan"])) {
                $query = "INSERT INTO `reviews` (`manv`, `ma_sach`, `xep_hang`, `binh_luan`, `ngay_danh_gia`)
                 VALUES (?, ?, '5', ?, current_timestamp());";
                $addbl = $conn->prepare($query);
                $addbl->bind_param("iss",$userData["ma_nguoi_dung"], $Masach, $_POST["comment"]);
                if($addbl->execute()) {
                    
                } else {
                    
                }
                header("Location: detail.php?ma_sach=$Masach");
            }
        
        ?>
        <form method="post">
        <textarea name="comment" rows="2" required></textarea><br>
        
        <input type="submit" value="Đăng" name="binhluan">
        </form>
        <?php 
        if (mysqli_num_rows($resultr) <> 0){
            while ($rows = mysqli_fetch_array($resultr)) {
                echo "<span>{$rows['tennv']}" . "</span>";
                echo '<img src=' . $rows["avatar"] . '>'; 
                echo "<span> - " . "{$rows['ngay_danh_gia']}" . "</span>";
                echo "<div>" . htmlspecialchars($rows['binh_luan']) . "</div>";
                echo "</div>";
            }
        }
        ?>
        </div>
    </main>
    <?php include "giaodien/footer.php"; ?>

</body>

</html>