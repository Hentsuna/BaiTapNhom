<?php

if(isset($_POST['name'])){

    $tensach = $_POST['name'];
    $theloai = $_POST['theloai'];
    $pathav = $domain."/upload/image/noavata.jpg";
    $id_user='admin';
    if($_SESSION['loginadmin'] ===1)  $id_user=$_SESSION['user'];
    if($_FILES['imgInp']['error'] == 0)
    {
        //lay phan mo rong cua file
        $imageFileType = pathinfo($_FILES['imgInp']['name'],PATHINFO_EXTENSION);
        //cac kieu file hop le
        $allowtypes = array('jpg', 'png');
        if (in_array($imageFileType,$allowtypes ))
        {
            $file = $_FILES['imgInp']['tmp_name'];
            $pathav = "../upload/image/imgvideo/".$_FILES['imgInp']['name'];
            move_uploaded_file($file, $pathav);
            $pathav =  $domain."/upload/image/imgvideo/".$_FILES['imgInp']['name'];
        }else{
            echo '<script>alert("ảnh đại diện phải có định dạng JPG, PNG")</script>';
        }
    }
    $tailieu='0';
    if($_FILES['tailieu']['error'] == 0)
    {
        //lay phan mo rong cua file
     //   $imageFileType = pathinfo($_FILES['tailieu']['name'],PATHINFO_EXTENSION);
        //cac kieu file hop le
      //  $allowtypes = array('jpg', 'png');
       // if (in_array($imageFileType,$allowtypes ))
      //  {
            $file = $_FILES['tailieu']['tmp_name'];
         $tailieu = "../upload/tailieu/".$_FILES['tailieu']['name'];
         move_uploaded_file($file, $tailieu);
         $tailieu =  $domain."/upload/tailieu/".$_FILES['tailieu']['name'];
      //  }else{
       //     echo '<script>alert("Tài liệu không hợp lệ")</script>';
      //  }
    }
    if($_SESSION['loginadmin'] === '2') $sql = "INSERT INTO list_book values(null,'$theloai','$tenvideo', '$pathav', '$id_user','$tailieu',0)";
    else $sql = "INSERT INTO list_book values(null,'$theloai','$tenvideo', '$pathav', '$id_user','$tailieu',1)";
    mysqli_query($conn, $sql);
    echo '<script>alert("Sách đã được thêm thành công")</script>';
    echo '<script>window.location="'.$domain.'/admin/?chucnang=themsach";</script>';
}
?>

<div style="background: #0056b3; height: 33px; color: #f2f2f2; font-size: 18px; padding-left: 10px; line-height: 33px; ">
    <i class="fas fa-plus-square"></i>
    Thêm sách mới
</div>
<div style="display: block;  padding: 10px" id="editinfo" >
    <form method="post" action="#"  enctype="multipart/form-data">
        <div style="background: #fff; padding-bottom: 20px; margin-left: 25px; width: 500px; padding: 15px; box-shadow: 0px 0px 6px 0px #123">

            <input style="display: none" type="text" value="userpage" name="see">
            <div style="background: #f2f2f2; padding: 10px">
                <div class="form-group">
                    <label id="tenvideo">Tên sách</label>
                    <input type="text" class="form-control"    id="name" required="" placeholder="" name="name">
                </div>
                <div style="background: #f2f2f2; padding: 10px">
                    <div class="form-group">
                        <label id="tenvideo">File mềm sách</label><br>
                        <input type='file' name="tailieu" id="tailieu" />
                    </div>
                <div class="form-group">
                    <label for="">Thể loại</label>
                    <select name="theloai" style="border: solid 1px #117a8b; border-radius: 2px">
                        <?php
                        $data = mysqli_query($conn,"SELECT * FROM theloai");
                        while ($getdata = mysqli_fetch_assoc($data)){
                            echo '<option value="'.$getdata['id'].'">'.$getdata['tentheloai'].'</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="">Ảnh đại diện</label><br>
                    <img id="blah" src="" alt="Ảnh đại diện" style="height: 140px; width: 200px;" /><br><br>
                    <input type='file' name="imgInp" id="imgInp" />
                </div>
                <div style="text-align: center"><button  class="btn-edituser">THÊM</button></div>
            </div>
        </div>
    </form>
</div>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp").change(function(){
        readURL(this);
    });
</script>
