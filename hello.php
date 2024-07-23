<?php
    $servername = "localhost:3307"; # localhost:portnumber
    $usernadme = "bigcom"; # 설정한 user명
    $password = "bigcomlab12!@"; # 설정한 비밀번호
    $dbname = "sample";

    # mysql과 connection 여부
    $conn = mysqli_connect(
        $servername, 
        $usernadme,
        $password,
        $dbname
    );
?>