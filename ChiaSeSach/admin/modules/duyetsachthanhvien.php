<?php
if(isset($_GET['id'])){
    $getid = $_GET['id'];
    mysqli_query($conn,"UPDATE list_book set duyet=1 where id = $getid");
}
?>
<div style="background: #0056b3; height: 33px; color: #f2f2f2; font-size: 18px; padding-left: 10px; line-height: 33px; ">
    <i class="fab fa-pied-piper-square"></i>
    Duyệt sách thành viên
</div>
<br>
<table style="width: 100%; margin: 5px;">
    <tr style="font-weight: 600; color: #000; font-size: 18px;">
        <td colspan="6" style="text-align: left">
            <i class="fas fa-filter"></i>
            Lọc</td>
    </tr>
    <tr style="background: #f9f9f9">
        <td style="text-align: left">
            <form method="get">
                <input style="display: none" name="chucnang" value="quanlysach">
                <select name="filter" style="width: 300px;">
                    <option value="all">Tất cả</option>
                    <?php
                    $data = mysqli_query($conn, "SELECT * FROM theloai");
                    if(mysqli_num_rows($data)>0){
                        while ($getdata = mysqli_fetch_assoc($data)){
                            $gettheloai = $getdata['id'];
                            $check = mysqli_num_rows(mysqli_query($conn, "select * from list_book where id_theloai = '$gettheloai'"));
                            if($check>0)echo '<option value="'.$getdata['id'].'">'.$getdata['tentheloai'].'</option>';
                        }
                    }
                    ?>
                </select>
                <button class="btn btn-primary" style=" padding-top: 1px; padding-right: 10px; padding-bottom: 1px; padding-left: 10px;">Lọc</button>
            </form>
        </td>
    </tr>
</table>
<br>
<table style="width: 100%; margin: 5px;">
    <tr style="font-weight: 600; color: #000; font-size: 18px;">
        <td colspan="8" style="text-align: left">
            <i class="fas fa-bars" style="margin-right: 3px;"></i>
            Danh sách sách</td>
    </tr>
    <?php
    if( $_SESSION['loginadmin'] == 2){
        if(isset($_GET['filter'])){
            $gettheloai = $_GET['filter'];
            if($gettheloai === 'all') $sql = "Select * from list_book where duyet = '0'";
            else $sql = "Select * from list_book where id_theloai = $gettheloai and duyet = '0'";
        }
        else $sql = "Select * from list_book where duyet = 0";
    }else{
        $getuser = $_SESSION['user'];
        if(isset($_GET['filter'])){
            $gettheloai = $_GET['filter'];
            if($gettheloai === 'all') $sql = "Select * from list_book";
            else $sql = "Select * from list_book where id_theloai = $gettheloai";
        }
        else $sql = "Select * from list_book where id_user='$getuser'";
    }
    $data = mysqli_query($conn, $sql);
    if(mysqli_num_rows($data) > 0){
        echo ' <tr style="background: #fff">
        <td style="color: #cc0000; font-weight: 500">STT</td>
        <td style="color: #115095; font-weight: 500">Ảnh đại diện</td>
        <td style="color: #115095; font-weight: 500">Tên sách</td>
        <td style="color: #115095; font-weight: 500">Người đăng</td>
        <td style="color: #115095; font-weight: 500">Thể loại</td>
        <td style="color: #115095; font-weight: 500">Link file mềm</td>
        <td style="color: #115095; font-weight: 500">Hiển thị</td>
        <td style="color: #115095; font-weight: 500">Hành động</td>
    </tr>';
        $dem=0;
        while ($getdata = mysqli_fetch_assoc($data)){
            $getidnd = $getdata['id_user'];
            $getnguoidang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT name from user where email = '$getidnd'"))['name'];
            $getidtheloai = $getdata['id_theloai'];
            $gettheloai = mysqli_fetch_assoc(mysqli_query($conn, "SELECT tentheloai from theloai where id = $getidtheloai"))['tentheloai'];
            echo '<tr style="background: ';
            if($dem%2 == 0) echo '#f5ffff'; else echo "#fff";
            echo '">
                <td >'.++$dem.'</td>
                <td ><img style="width: 80px; height: 55px" src="'.$getdata['linkavatar'].'"></td>
                <td id="name'.$getdata['id'].'" style="color: #000;font-weight: 500; text-align: left;font-size: 11px;">'.$getdata['tensach'].'</td>
                 <td id="name'.$getdata['id'].'" style="color: #000;font-weight: 500; text-align: left;font-size: 11px;">'.$getnguoidang.'</td>
                <td style="color: #000; font-weight: 500;font-size: 11px;">'.$gettheloai.'</td>
                 <td id="name'.$getdata['linkdown'].'" style="color: #000;font-weight: 500; text-align: left;font-size: 11px;">
                 <textarea style="width: 100%">
                 '.$getdata['linkdown'].'</textarea></td>
                 <td id="name'.$getdata['duyet'].'" style="color: #000;font-weight: 500; text-align: center;font-size: 11px;">
                 ';
            if($getdata['duyet']==='1') echo '<span style="background: #117a8b; padding-top: 3px; padding-bottom: 3px; padding-left: 20px; padding-right: 20px; color: #fff; border-radius: 3px; font-size: 15px">YES</span>';
            else echo '<span style="background: #ff253a; padding-top: 3px; padding-bottom: 3px; padding-left: 20px; padding-right: 20px; color: #fff; border-radius: 3px; font-size: 15px">NO</span>';
            echo'
                 </td>
                <td style="color: #b21f2d;  font-weight: 500">
                        <a href="?chucnang=duyetsach&id='.$getdata['id'].'"><button  onClick="edititem(this.id)" id="'.$getdata['id'].'" class="btn-edit backgroundbutton">Duyệt</button></a>
                      ';



            echo'  
                </td>
            </tr>';
        }
        ?>
        <div style="display: none" id="num-rows"><?php echo $dem ?></div>
        <script>
            var n=(parseInt(document.getElementById('num-rows').textContent));

        </script>
        <?php
    }else{
        echo "<tr><td>DANH SÁCH RỖNG</td></tr>";
    }
    ?>
</table>

<dialog id="xacnhanxoa" style="border: none; width: 500px;  box-shadow: 0px 0px 5px 5px #666; border-radius: 5px">
    <p style="font-size: 18px;">Bạn có thực sự muốn xóa mục này!!</p>
    <hr>
    <button class="btn btn-danger" style="float: right; margin-left: 10px; padding: 5px;" id="huydelete">Hủy</button>
    <form style="float: right">
        <input name="chucnang" value="quanlysach" style="display: none">
        <input id = "dele" name="dele" value="" style="display: none">
        <button style="padding: 5px;" class="btn btn-primary" id="xacnhandelete">Xác nhận</button>
    </form>
</dialog>
<script>function deleteitemn(clicked_id)
    {
        var xacnhan = document.getElementById('xacnhanxoa');
        var id =  document.getElementById(clicked_id);
        var huydelete = document.getElementById('huydelete');
        var dele = document.getElementById('dele');
        dele.value = clicked_id;
        huydelete.addEventListener('click', function() {
            xacnhan.close();
        });
        xacnhan.showModal();
    }</script>