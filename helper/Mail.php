<?php

namespace Helper;

use Config\EMail;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Mail
{
    /**
     * @throws Exception
     */
    public static function confirm(string $name, string $email, string $random)
    {
        self::send($name, $email, "Confirmation E-mail", "confirmation", [
            'name' => $name,
            'random' => $random
        ]);
    }

    /**
     * @throws Exception
     */
    private static function send(string $name, string $email, string $subject, string $message, array $data)
    {
        $message = file_get_contents(__DIR__ . "/../templates/email/$message.html");

        $data = array_merge([
            'root' => Route::root()
        ], $data);
        foreach ($data as $key => $value) {
            $message = str_replace("%$key%", $value, $message);
        }

        require __DIR__ . '/../phpmailer/PHPMailer.php';
        require __DIR__ . '/../phpmailer/SMTP.php';
        require __DIR__ . '/../phpmailer/Exception.php';

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->CharSet = "UTF-8";
        $mail->SMTPAuth = true;

        $mail->Host = EMail::HOST;
        $mail->Username = EMail::USERNAME;
        $mail->Password = EMail::PASSWORD;
        $mail->SMTPSecure = EMail::SMTP_SECURE;
        $mail->Port = EMail::PORT;
        $mail->setFrom(EMail::FROM_ADDRESS, EMail::FROM_NAME);

        $mail->addAddress($email, $name);

        $mail->isHTML(true);

        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
    }

    /**
     * @throws Exception
     */
    public static function recover(string $name, string $email, string $random)
    {
        self::send($name, $email, "Recover Account", "recover", [
            'name' => $name,
            'random' => $random
        ]);
    }
}
