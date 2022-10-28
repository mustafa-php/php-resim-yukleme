<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resim Yükleme</title>
</head>

<body>
    <?php
    $deneme = new PDO("mysql:host=mustafa;dbname=mustafa", "mustafa", "");


    if (!empty($_FILES["resim"])) {

        $dizin = "resim/";
        $resim_isim = $_POST["resim_isim"];
        $resim_yolu = "resim/" . $resim_isim . ".jpg";

        $yuklenecekresim = $dizin . $_FILES["resim"]["name"];
        if (move_uploaded_file($_FILES["resim"]["tmp_name"], $yuklenecekresim)) {
            rename($dizin . $_FILES["resim"]["name"], $resim_yolu);
            echo "Resim Başarıyla Yüklendi";
            $onay = true;
        } else {
            echo "Resim Yüklenemedi";
        }

        if (isset($onay)) {
            $resimkyt = $deneme->prepare("INSERT INTO resim SET resim_isim=:resim_isim, resim_yolu=:resim_yolu");

            $resimkyt->execute(array(
                "resim_isim" => $resim_isim,
                "resim_yolu" => $resim_yolu,
            ));
        }
     
    }
    ?>
    <style>
        body {
            background: #1D2D3B;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
        }

        form {
            flex: 0 0 auto;
            display: flex;
            flex-direction: column;
            margin: 1rem 0;
        }

        input {
            margin: .5rem 0;
            font-size: 1.2rem;
            border: none;
            outline: none;
            padding: .5rem;
        }

        button {
            font-size: 1.2rem;
            padding: .5rem;
            border: none;
            outline: none;
            cursor: pointer;
        }

        img {
            height: 15rem;
            margin: 1rem;
        }

        div {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            font-size: 1.5rem;
            width: 25rem;
        }
    </style>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="resim">
        <input type="text" name="resim_isim" autocomplete="off">
        <button type="submit">Kayıt Et</button>
    </form>
    <?php

    $resimlis = $deneme->prepare('SELECT *FROM resim order by id desc');
    $resimlis->execute();
    $resimcek = $resimlis->fetchAll(PDO::FETCH_OBJ);
    foreach ($resimcek as $resim) {
    ?>
        <div>
            <img src="<?php echo $resim->resim_yolu ?>" alt="">
            <span><?php echo $resim->resim_isim; ?>.jpg</span>
        </div>

    <?php
    }

    ?>
</body>

</html>