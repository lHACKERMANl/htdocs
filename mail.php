<?php
    require __DIR__ . '/lib/autoload.php';

    $source = file_get_contents('php://input');
    $requestBody = json_decode($source, true);

    use YandexCheckout\Model\Notification\NotificationSucceeded;
    use YandexCheckout\Model\Notification\NotificationWaitingForCapture;
    use YandexCheckout\Model\Notification\NotificationCanceled;
    use YandexCheckout\Model\NotificationEventType;
    use YandexCheckout\Model\PaymentStatus;
    try {
        $notification = ($requestBody['event'] === NotificationEventType::PAYMENT_SUCCEEDED)
            ? new NotificationSucceeded($requestBody)
            : new NotificationCanceled($requestBody);
        } catch (Exception $e) {
    // Обработка ошибок при неверных данных
        }
    
    $payment = $notification->getObject();
    
    $info = $payment->description;
    parse_str($info, $infoOut);
    $art = $infoOut['Кар'];
    $phone = $infoOut['Тел'];
    $mail = $infoOut['Поч'];
    $location = $infoOut['Мест'];
    $names = $infoOut['ФИО'];
    $adress = "";
    $date = $infoOut['Дата'];
    
    
    $connect = mysqli_connect('localhost','u1125416_default', 't_YR8j2y','u1125416_default')or die("Ошибка " . mysqli_error($connect));
        
    mysqli_query($connect,"SET NAMES 'utf-8'");
    mysqli_query($connect,"SET CHARACTER SET 'utf8';");
    mysqli_query($connect,"SET SESSION collation_connection = 'utf8_general_ci';");
    
    if($payment->getStatus() === PaymentStatus::SUCCEEDED) {
        
        $connect->query("
             UPDATE artsection SET confirm = 1 WHERE phone = '$phone' AND art = '$art';
        ");
        $id = $connect->query("SELECT id FROM artsection WHERE phone = '$phone' AND art = '$art';")
        $connect->query("
            DELETE FROM artsection WHERE confirm = 0 AND id < '$id';
        ");
       if($location == "Лампа")
       {
        $adress = "https://go.2gis.com/ez611";
       }
       if($location == "Культура")
       {
        $adress = "https://go.2gis.com/0szrfv";
       }
       if($location == "Другая история")
       {
        $adress = "https://go.2gis.com/7n3na";
       }

        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "To: <$mail>\r\n";
        $headers .= "From: < letsartparty@lap.ru>\r\n";
        
        $subject = '=?utf-8?b?'. base64_encode("Регистрация на мероприятие") .'?=';
        
        $message = "<body style='    background:
        radial-gradient(#655197 2px, transparent 3px),
        radial-gradient(#655197 2px, transparent 3px),
        #fff;
    background-position: 0 0, 20px 20px;
    background-size: 40px 40px;'>
        .<div style = 'font-family: 'Aeroport';border: 1px solid #777777;width: 35%;background-color: white;position: absolute;top: 50%;left: 50%;margin-right: -50%;transform: translate(-50%, -50%);'>
        .<p style = 'text-align: center;color: black;'><a style='text-decoration: none;font-family: 'Aeroport';font-size: 25px;' href='https://letsartparty.ru/' class='Logo'>LET'S ART PARTY</a></p>
        .<h1 style = 'text-align: center;'>Поздравялем, ".  $names."!</h1>
        .<h3 style = 'text-align: center';box-shadow: 0 0 10px rgba(0,0,0,0.5);>Вы успешно зарегестрированы на картину ". $art . ".<br>
        .". $date. ' в заведении <a href = "'.$adress.' ">'. $location."</h3>
        </div>
        </body>";
    
        mail($mailTo, $subject, $message, $headers);
    }
        $connect->query("
            DELETE FROM artsection WHERE confirm = 0;
        ");
    
    if($payment->getStatus() === PaymentStatus::CANCELED){
        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "To: <$mail>\r\n";
        $headers .= "From: <letsartparty@lap.com>\r\n";
        $subject = "Acess";
        $message = "Вы не были зарегестрированы(";
    
        mail($mailTo, $subject, $message, $headers);
        
        $connect->query("
             DELETE FROM artsection WHERE phone = '$phone' AND art = '$art';
        ");
    }
    
    mysqli_close($connect); 
?>