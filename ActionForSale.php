<?php
    $names = htmlspecialchars($_POST["name"]);
    $phone = htmlspecialchars($_POST["phone"]);
    
    if(!preg_match("/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/", $phone))
    {
        echo "<link rel='stylesheet' href='PhpStyle.css'>";
        echo '<link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet">';
        echo '<link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">';
        echo '<div class="outer"><div class="inner">Не корректный номер </div><div class="inner_s"> </div></div>';
        die('<div class="inner_s"><a style="text-decoration: none;" href="http://letsartparty.ru/">Назад</a> </div>');// Change adress
    }
    
        if(str_word_count($names, 0,'ёйцукенгшщзхъэждлорпавыфячсмитьбюЁЙЦУКЕНГШЩЗХЪЭЖДЛОРПАВЫФЯЧСМИТЬБЮqazxswedcvfrtgbnhyujmkiolpQAZXSWEDCVFRTGBNHYUJMKILOP') > 4)
      {
            $code = "<link rel='stylesheet' href='PhpStyle.css'>
                     <link href='https://fonts.googleapis.com/css?family=Oswald&display=swap' rel='stylesheet'>
                     <link href='https://fonts.googleapis.com/css2?family=Pacifico&display=swap' rel='stylesheet'>
                     <div class='outer'><div class='inner'>Не корректное название </div><div class='inner_s'> </div></div>";
            echo $code;
            die('<div class="inner_s"><a href="http://letsartparty.ru/">Назад</a> </div>');// Change adress
      }

    $connect = mysqli_connect('localhost','u1125416_default', 't_YR8j2y','u1125416_default')or die("Ошибка " . mysqli_error($connect)); // change host

    mysqli_query($connect,"SET NAMES 'utf-8'");
    mysqli_query($connect,"SET CHARACTER SET 'utf8';");
    mysqli_query($connect,"SET SESSION collation_connection = 'utf8_general_ci';");

    $connect->query("
             INSERT INTO individual (name, phone)
             (
                select '$names','$phone'
                where '$phone' not in (select phone from individual)
             )
        ");
        if ($connect->affected_rows == 0) {
            echo "<link rel='stylesheet' href='PhpStyle.css'>";
            echo '<link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet">';
            echo '<link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">';
            echo '<div class="outer"><div class="inner">Не корректные данные </div></div>';
            mysqli_close($connect);
            die('<div class="inner_s"><a style="text-decoration: none;" href="http://letsartparty.ru/">Назал</a></div>');// Change adress
        }
       else{

       }
            echo "<link rel='stylesheet' href='PhpStyle.css'>";
            echo '<link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet">';
            echo '<link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">';
            echo '<div class="outer"><div class="inner">Данные отправлены </div></div>';
    mysqli_close($connect);
    die('<div class="inner_s"><a style="text-decoration: none;" href="http://letsartparty.ru/">Назад</a></div>');// Change adress
?>