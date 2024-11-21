<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tài khoản</title>
    <link rel="stylesheet" href="cssfolder/account.css">
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
            <section>
                <form action="account.php" method="POST">
                    
                </form>
            </section>
        </div>                
    </main>
    <?php include "giaodien/footer.php"; ?>

</body>
</html>
