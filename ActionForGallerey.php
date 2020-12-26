<?php
    require __DIR__ . '/lib/autoload.php'; 
    use YandexCheckout\Client;
    use YandexCheckout\Model\Notification\NotificationSucceeded;
    use YandexCheckout\Model\Notification\NotificationWaitingForCapture;
    use YandexCheckout\Model\NotificationEventType;
    use YandexCheckout\Model\PaymentStatus;
    use YandexCheckout\Model\Notification\NotificationCanceled;

        if(!$_REQUEST['name']){
            echo("Write name");
            die(header("refresh: 3; url=https://letsartparty.ru/"));// Change adress
        }
        if(!$_REQUEST['phone']){
            echo("Write phone");
            die(header("refresh: 3; url=https://letsartparty.ru/"));// Change adress
        }
        if(!$_REQUEST['mail']){
            echo("Write mail");
            die(header("refresh: 3; url=https://letsartparty.ru/"));// Change adress
        }
        $art = htmlspecialchars($_POST["art_name"]);
        $names = htmlspecialchars($_POST["name"]);
        $phone = htmlspecialchars($_POST["phone"]);
        $mail = htmlspecialchars($_POST["mail"]);
        $date = htmlspecialchars($_POST["date"]);
        $location = htmlspecialchars($_POST["location"]);
        $num = htmlspecialchars($_POST["num"]);
        $price = htmlspecialchars($_POST["price"]);
        $price = (int)$price;
        $artCount = (int)$num;
        
        

//echo $location;

      if(str_word_count($names, 0,'ёйцукенгшщзхъэждлорпавыфячсмитьбюЁЙЦУКЕНГШЩЗХЪЭЖДЛОРПАВЫФЯЧСМИТЬБЮqazxswedcvfrtgbnhyujmkiolpQAZXSWEDCVFRTGBNHYUJMKILOP') != 3)
      {
            $code = "<link rel='stylesheet' href='PhpStyle.css'>
                     <link href='https://fonts.googleapis.com/css?family=Oswald&display=swap' rel='stylesheet'>
                     <link href='https://fonts.googleapis.com/css2?family=Pacifico&display=swap' rel='stylesheet'>
                     <div class='outer'><div class='inner'>Не корректное ФИО </div><div class='inner_s'> </div></div>";
            echo $code;
            die('<div class="inner_s"><a href="http://letsartparty.ru/">Назад</a> </div>');// Change adress
      }

      //if(mb_substr($phone,0,2) != "89" || mb_substr($phone,0,2) != "+79")
      {
        if(!preg_match("/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/", $phone))
        {
            echo "<link rel='stylesheet' href='PhpStyle.css'>";
            echo '<link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet">';
            echo '<link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">';
            echo '<div class="outer"><div class="inner">Не корректный номер </div><div class="inner_s"> </div></div>';
            die('<div class="inner_s"><a href="http://letsartparty.ru/">Назад</a> </div>');// Change adress
        }
      }
      /*if(strlen($phone) < 11 || strlen($phone) > 12)
      {
            echo "<link rel='stylesheet' href='PhpStyle.css'>";
            echo '<link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet">';
            echo '<link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">';
            echo '<div class="outer"><div class="inner">Не корректный номер </div><div class="inner_s">Вы вернетесь обратно через 3 секунды </div></div>';
            die(header("refresh: 3; url=https://letsartparty.ru/"));// Change adress
      }*/

//'127.0.0.1','root', '','clientspecial'
//'a336530.mysql.mchost.ru','a336530_1', 'e33xuX239LBC','a336530_1'
        $connect = mysqli_connect('localhost','u1125416_default', 't_YR8j2y','u1125416_default')or die("Ошибка " . mysqli_error($connect));
        
        mysqli_query($connect,"SET NAMES 'utf-8'");
        mysqli_query($connect,"SET CHARACTER SET 'utf8';");
        mysqli_query($connect,"SET SESSION collation_connection = 'utf8_general_ci';");

        $sql_count = "SELECT art, count(*) FROM artsection GROUP BY art";
        $res = mysqli_query($connect, $sql_count);  

        $sql_count_phone = "SELECT phone FROM artsection"; 
        $sql_count_art = "SELECT art FROM artsection WHERE art!='' GROUP BY art HAVING count(art)<=21";
        $res_num = mysqli_query($connect, $sql_count_phone);
        $res_art = mysqli_query($connect, $sql_count_art);

         if($res_num && $res_art){
            $flag_art = false;
            $flag_num = false;
            $rows_num = mysqli_num_rows($res_num);
            $rows_art = mysqli_num_rows($res_art);

            for($i = 0; $i < $rows_num; ++$i){
                $row_num = mysqli_fetch_row($res_num);
              for($j =0; $j<1;++$j){
                    if($row_num[$j] == $phone){
                      // echo $row_num[$i]."----".$phone."---<br>";
                        $flag_num = true;
                    }
                }
            }
            for($i = 0;$i <$rows_art; ++$i){
                $row_art = mysqli_fetch_row($res_art);
              for($j=0;$j<1/*$rows_art*/;++$j){
                    if($row_art[$j] == $art){
                      //echo $row_art[$i]."---".$art."<br>";
                        $flag_art = true;
                    }
                  }
            }
            if($flag_art && $flag_num){
                echo "<link rel='stylesheet' href='PhpStyle.css'>";
                echo '<link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet">';
                echo '<link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">';
                echo '<div class="outer"><div class="inner">Вы уже зарегестрировались </div><div class="inner_s"> </div></div>';
                die('<div class="inner_s"><a href="http://letsartparty.ru/">Назад</a> </div>');// Change adress
            }
        }

        if($res){
            $rows =  mysqli_num_rows($res);
            //echo $rows;
            for ($i = 0 ; $i < $rows ; ++$i)
            {
               $row = mysqli_fetch_row($res);
                   for ($j = 0 ; $j < 2 ; ++$j) 
                   {
                        //echo $row[$j];
                        if ($row[$j] == $art)
                            if($row[$j+1] > 21)
                            {
                                echo "<link rel='stylesheet' href='PhpStyle.css'>";
                                echo '<link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet">';
                                echo '<link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">';
                                echo '<div class="outer"><div class="inner">Все места заняты </div><div class="inner_s"> </div></div>';
                                die('<div class="inner_s"><a href="http://letsartparty.ru/">Назад</a> </div>');// Change adress
                            }
                    }
            }
        }
        else{
die("Connect Error");
        }
        $connect->query("
             INSERT INTO artsection (art ,name, phone, mail, date, location, artCount, confirm)
             (
                select '$art','$names','$phone','$mail','$date','$location','$artCount', 0
                 where $phone not in (select phone from artsection where art = '$art')
                    and ((select COALESCE(sum(artCount),0) from artsection where art = '$art') + $artCount ) < 21
             )
        ");
        if ($connect->affected_rows == 0) {
            $diffirents = mysqli_query($connect, "(select COALESCE(sum(artCount),0) from artsection where art = '$art') + $artCount");
            $diffirents = $diffirents - 21;
            $diffirents = 21 + $diffirents;
            echo "<link rel='stylesheet' href='PhpStyle.css'>";
            echo '<link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet">';
            echo '<link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">';
            echo '<div class="outer"><div class="inner">Простите, но осталось мест: '.$diffirents.'</div><div class="inner_s"> </div></div>';
            die('<div class="inner_s"><a href="http://letsartparty.ru/">Назад</a> </div>');// Change adress
        }
       else{
        $client = new Client();
        $client->setAuth('737203', 'live_hVa4VxBccRvbP4poQKBMybMwrS3iPhnv7Uj--NaGELk');

        if($num == 1){
            $sum = $price;
        }
        if($num == 2){
            $sum = $price * 2;
        }
        if($num == 3){
            $sum = $price * 3;
        }
        if($num == 4){
            $sum = $price * 4;
        }
        $names = explode(' ',trim($names));
        $payment = $client->createPayment(
            array(
                'amount' => array(
                    'value' => $sum,
                    'currency' => 'RUB',
                ),
                'confirmation' => array(
                    'type' => 'redirect',
                    'return_url' => 'https://www.letsartparty.ru',
                ),
                'capture' => true,
                'description' => 'ФИО='.$names[1].'&Поч='.$mail.'&Тел='.$phone.'&Кар='.$art.'&Дата='.$date.'&Мест='.$location,
            ),
        uniqid('', true)
    );
            
        header('Location: ' . $payment["confirmation"]["confirmation_url"]);
        
        mysqli_close($connect); 
        /*$confirmationUrl = $payment->getConfirmation()->getConfirmationUrl();
        header("Location: $confirmationUrl");*/
        
       }

       /*if($location == "Лампа")
       {
        $adress = "https://go.2gis.com/ez611";
       }
       else
       {
        $adress = "https://go.2gis.com/0szrfv";
       }

        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "To: <$mail>\r\n";
        $headers .= "From: <Let'sArtParty@example.com>\r\n";
        $subject = "Регистрация на мероприятие";
        $message = "Поздравляем, ".  $names."!<br>Вы успешно зарегестрированы на картину ". $art . ".<br>Мы ждем вас ". $date. ' в 
        <a href = "'.$adress.' ">'. $location;
        if(mail ($mail ,  $subject ,  $message , $headers))
        {
          //echo 'Подтвердите на почте';
        }
        else
        {
                                echo "<link rel='stylesheet' href='PhpStyle.css'>";
                                echo '<link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet">';
                                echo '<link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">';
                                echo '<div class="outer"><div class="inner">Сообщение не было отправлено. </div><div class="inner_s">Вы вернетесь обратно через 3 секунды </div></div>';
                                die(header("refresh: 3; url=https://letsartparty.ru/"));// Change adress
        }*/

        echo "<link rel='stylesheet' href='PhpStyle.css'>";
        echo '<link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet">';
        echo '<link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">';
        echo '<div class="outer"><div class="inner_s">Поздравляем! Проверьте почту </div></div>';
        die('<div class="inner_s"><a href="http://letsartparty.ru/">Назад</a> </div>');
        
        //header('Location: /#Cur');// Change adress
?>