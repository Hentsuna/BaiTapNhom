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
            WHERE reviews.ma_sach = '$Masach'";
        $resultr = mysqli_query($conn, $sqlr);
        if (mysqli_num_rows($resultr) <> 0){
            while ($rows = mysqli_fetch_array($resultr)) {
                echo "<textarea rows='2'></textarea>";
                echo "{$rows['avatar']}";
                echo "<span>{$rows['avatar']}" . "{$rows['tennv']}" . "</span>";
                echo "<span> - " . "{$row['ngay_danh_gia']}" . "</span>";
                echo "<div>" . "htmlspecialchars({$row['binh_luan']})" . "</div>";
                echo "</div>";
            }
        }
        ?>
        <!-- <form method="post">
        <textarea name="comment" rows="2"><?php if(isset($_POST['comment'])) echo $_POST['comment']; ?></textarea><br>
        <img src="./images/avatars/">$name
        $binh_luan
        $nagy -->

        </form>
        </div>
    </main>
    <?php include "giaodien/footer.php"; ?>

</body>

</html>