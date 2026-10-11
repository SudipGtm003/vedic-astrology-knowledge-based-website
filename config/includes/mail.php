<?php

declare(strict_types=1);

// ===== Gmail SMTP कन्फिग =====
const SMTP_HOST = 'smtp.gmail.com';
const SMTP_PORT = 465;
const SMTP_USER = 'sudipgautam210@gmail.com'; // आफ्नो Gmail ठेगाना
const SMTP_PASS = 'abtpquccwwuwvbig'; // Gmail App Password (१६ अक्षर, space बिना)

require_once __DIR__ . '/../../lib/phpmailer/src/Exception.php';
require_once __DIR__ . '/../../lib/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../../lib/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;

/** OTP इमेल पठाउँछ — सफल भए true, नत्रे false */
function send_otp_email(string $to, string $otp): bool
{
    if (SMTP_USER === '' || SMTP_PASS === '') {
        return false;
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->Port = SMTP_PORT;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USER;
        $mail->Password = SMTP_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->CharSet = 'UTF-8';

        $mail->setFrom(SMTP_USER, 'वैदिक ज्योतिष सिकाइ');
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = 'वैदिक ज्योतिष सिकाइ — पासवर्ड रिसेट OTP';

        $mail->AltBody = "पासवर्ड रिसेट OTP: {$otp}\n\n"
            . "यो OTP १० मिनेटभित्र मात्र मान्य छ।\n"
            . "यो इमेल तपाईंले अनुरोध नगरेको हो भने बेवास्ता गर्नुहोस्।";

        $mail->Body = <<<HTML
<div style="font-family:Arial,'Helvetica Neue',sans-serif;max-width:520px;margin:0 auto;padding:28px 16px;color:#222222;">
  <p style="margin:0;font-size:15px;font-weight:bold;color:#222222;">वैदिक ज्योतिष सिकाइ</p>
  <hr style="border:0;border-top:1px solid #dddddd;margin:12px 0 22px;">
  <h1 style="margin:0 0 12px;font-size:20px;font-weight:bold;color:#222222;">पासवर्ड रिसेट OTP</h1>
  <p style="margin:0 0 20px;font-size:15px;line-height:1.7;color:#444444;">नमस्ते! उहाँको खाताको पासवर्ड रिसेट गर्न तल दिइएको ६ अंकको OTP प्रयोग गर्नुहोस्।</p>
  <p style="margin:0 0 20px;padding:14px;text-align:center;background-color:#f5f5f5;border:1px solid #dddddd;font-family:monospace,'Courier New',sans-serif;font-size:28px;font-weight:bold;letter-spacing:8px;color:#222222;">{$otp}</p>
  <p style="margin:0 0 20px;font-size:14px;line-height:1.7;color:#555555;">यो OTP <b style="color:#222222;">१० मिनेट</b> भित्र मात्र मान्य छ र एक पटक मात्र प्रयोग हुन्छ।</p>
  <p style="margin:0;font-size:13px;line-height:1.7;color:#888888;">यो इमेल तपाईंले अनुरोध नगरेको हो भने बेवास्ता गर्नुहोस्।<br>— वैदिक ज्योतिष सिकाइ</p>
</div>
HTML;

        $mail->send();
        return true;
    } catch (Throwable $e) {
        error_log('OTP mail failed: ' . $e->getMessage());
        return false;
    }
}
