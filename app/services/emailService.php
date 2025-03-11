<?php 
require_once __DIR__ . '/../helpers/email.php';
require_once __DIR__ . '/../../lib/phpmailer/Exception.php';
require_once __DIR__ . '/../../lib/phpmailer/PHPMailer.php';
require_once __DIR__ . '/../../lib/phpmailer/SMTP.php';

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class EmailService {

    private static function send(string $mailAddress, string $mailSubject, string $mailAltBody, string $message): bool{
        if (isset($GLOBALS['emails'][$mailAddress]) || !isset($GLOBALS['emails'][$_SERVER['SERVER_NAME']])) {
            return true;
        } 
        
        $USER_PORT = $GLOBALS['emails'][$_SERVER['SERVER_NAME']]['port'];
        $USER_CERT = $GLOBALS['emails'][$_SERVER['SERVER_NAME']]['cert'];
        $USER_HOST = $GLOBALS['emails'][$_SERVER['SERVER_NAME']]['host'];
        $USER_NAME = $GLOBALS['emails'][$_SERVER['SERVER_NAME']]['email'];
        $USER_PASS = $GLOBALS['emails'][$_SERVER['SERVER_NAME']]['pass'];
        $FROM_NAME = $GLOBALS['emails'][$_SERVER['SERVER_NAME']]['name'];
        $FROM_EMAIL = $USER_NAME;
 
        try {
            $mail = new PHPMailer();

            $mail->isSMTP();
            $mail->SMTPDebug = 0;
            $mail->Timeout = 20;
            $mail->CharSet = 'UTF-8';

            $mail->Port = $USER_PORT;
            $mail->Host = $USER_HOST;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = $USER_CERT;       
            $mail->Username = $USER_NAME;
            $mail->Password = $USER_PASS;
           
            $mail->setFrom($FROM_EMAIL, $FROM_NAME);
            $mail->addAddress($mailAddress);
           
            $mail->isHTML(true);
            $mail->Subject = $mailSubject;
            $mail->Body    = $message;
            $mail->AltBody = $mailAltBody;
     
            if (!$mail->send()) {
                throw new Exception($mail->ErrorInfo);
            } return true;
        } catch (Exception $e) {
            return false;
        }
    }
    
    // SEND ----------------------------------------------------------

    public static function sendLogin(string $email, string $name): bool {
        $message = self::loginTemplate($email, $name);
        $subject = $GLOBALS['lang-email']['login']['mail-subject'];
        $altBody = $GLOBALS['lang-email']['login']['mail-description'];
        $altBody = str_replace('[[user-name]]', $name, $altBody);
        return self::send($email, $subject, $altBody, $message);
    }

    public static function sendLoginCode(string $email, string $name, string $code): bool {
        $message = self::loginCodeTemplate($email, $name, $code);
        $subject = $GLOBALS['lang-email']['loginCode']['mail-subject'];
        $altBody = $GLOBALS['lang-email']['loginCode']['mail-description'];
        $altBody = str_replace('[[user-name]]', $name, $altBody);
        $altBody = str_replace('[[user-code]]', $code, $altBody);
        return self::send($email, $subject, $altBody, $message);
    }

    // -------------------------

    public static function sendRegister(string $email, string $name): bool {
        $message = self::registerTemplate($email, $name);
        $subject = $GLOBALS['lang-email']['register']['mail-subject'];
        $altBody = $GLOBALS['lang-email']['register']['mail-description'];
        $altBody = str_replace('[[user-name]]', $name, $altBody);
        return self::send($email, $subject, $altBody, $message);
    }

    public static function sendRegisterCode(string $email, string $code): bool {
        $message = self::registerCodeTemplate($email, $code);
        $subject = $GLOBALS['lang-email']['registerCode']['mail-subject'];
        $altBody = $GLOBALS['lang-email']['registerCode']['mail-description'];
        $altBody = str_replace('[[user-code]]', $code, $altBody);
        return self::send($email, $subject, $altBody, $message);
    }

    // -------------------------
    
    public static function sendRecoverCode(string $email, string $name, string $code): bool {
        $message = self::recoverCodeTemplate($email, $name, $code);
        $subject = $GLOBALS['lang-email']['recoverCode']['mail-subject'];
        $altBody = $GLOBALS['lang-email']['recoverCode']['mail-description'];
        $altBody = str_replace('[[user-name]]', $name, $altBody);
        $altBody = str_replace('[[user-code]]', $code, $altBody);
        return self::send($email, $subject, $altBody, $message);
    }

    // TEMPLATES ----------------------------------------------------------

    public static function loginTemplate(string $email, string $name): string {
        require_once __DIR__ . "/../lang/{$GLOBALS['lang']}/emails/loginLang.php";
        require_once __DIR__ . "/../helpers/geoip.php";

        $ip = GeoIP::getClientIP();
        $geo = GeoIP::getInfo($ip);
        
        if ($geo && $geo->city && $geo->state && $geo->country && $geo->continent && $geo->timezone) {
            $location = "{$geo->city}, {$geo->state}, {$geo->country}";
        } else {
            $location = $GLOBALS['lang-email']['login']['text-unknown'];
        }

        if ($geo && $geo->timezone) {
            $now = new Date('now', $geo->timezone);
            $datetime = $now->formatLarge();
        } else {
            $now = new Date();
            $datetime = $now->format('c');
        }

        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($userAgent, 'Chrome') !== false) {
            $browser = $GLOBALS['lang-email']['login']['browser-chrome'];
        } elseif (strpos($userAgent, 'Firefox') !== false) {
            $browser = $GLOBALS['lang-email']['login']['browser-firefox'];
        } elseif (strpos($userAgent, 'Safari') !== false) {
            $browser = $GLOBALS['lang-email']['login']['browser-safari'];
        } elseif (strpos($userAgent, 'Edge') !== false) {
            $browser = $GLOBALS['lang-email']['login']['browser-edge'];
        } else {
            $browser = null;
        }

        if ($browser) {
            $auxDevice = preg_match('/mobile/i', $userAgent)
            ? $GLOBALS['lang-email']['login']['device-mobile']
            : $GLOBALS['lang-email']['login']['device-desktop'];
            $device = str_replace("[[browser]]", $browser,
                str_replace("[[device]]", $auxDevice,
                $GLOBALS['lang-email']['login']['device']));
        } else {
            $device = $GLOBALS['lang-email']['login']['device-unknown'];
        }

        $template = templateEmail('login');
        $template = str_replace('[[user-name]]', $name, $template);
        $template = str_replace('[[user-device]]', $device, $template);
        $template = str_replace('[[user-datetime]]', $datetime, $template);
        $template = str_replace('[[user-location]]', $location, $template);

        return $template;
    }

    public static function loginCodeTemplate(string $email, string $name, string $code): string {
        require_once __DIR__ . '/../lang/' . $GLOBALS['lang'] . '/emails/loginCodeLang.php';
        
        $template = templateEmail('loginCode');
        $template = str_replace('[[user-name]]', $name, $template);
        $template = str_replace('[[user-code]]', $code, $template);
        return $template;
    }

    // -------------------------

    public static function registerTemplate(string $email, string $name): string {
        require_once __DIR__ . '/../lang/' . $GLOBALS['lang'] . '/emails/registerLang.php';

        $template = templateEmail('register');
        $template = str_replace('[[user-name]]', $name, $template);
        return $template;
    }

    public static function registerCodeTemplate(string $email, string  $code): string {
        require_once __DIR__ . '/../lang/' . $GLOBALS['lang'] . '/emails/registerCodeLang.php';

        $template = templateEmail('registerCode');
        $template = str_replace('[[user-code]]', $code, $template);
        return $template;
    }

    // -------------------------

    public static function recoverCodeTemplate(string $email, string $name, string $code): string {
        require_once __DIR__ . '/../lang/' . $GLOBALS['lang'] . '/emails/recoverCodeLang.php';

        $template = templateEmail('recoverCode');
        $template = str_replace('[[user-name]]', $name, $template);
        $template = str_replace('[[user-code]]', $code, $template);
        return $template;
    }

}