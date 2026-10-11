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
<div style="margin:0;padding:0;background-color:#f7efdd;">
  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color:#f7efdd;">
    <tr>
      <td align="center" style="padding:36px 14px;">
        <table role="presentation" width="520" cellspacing="0" cellpadding="0" border="0" style="width:100%;max-width:520px;background-color:#ffffff;border:1px solid #e2c88b;border-radius:12px;overflow:hidden;">
          <tr>
            <td style="background-color:#252525;padding:22px 34px;">
              <p style="margin:0;font-size:19px;color:#c89b3c;letter-spacing:1px;">&#9737; वैदिक ज्योतिष सिकाइ</p>
            </td>
          </tr>
          <tr>
            <td style="padding:34px 34px 8px;">
              <h1 style="margin:0 0 12px;font-size:23px;color:#252525;">पासवर्ड रिसेट OTP</h1>
              <p style="margin:0 0 26px;font-size:15px;line-height:1.7;color:#666666;">नमस्ते! उहाँको खाताको पासवर्ड रिसेट गर्न तल दिइएको ६ अंकको OTP प्रयोग गर्नुहोस्।</p>
              <div style="background-color:#f7efdd;border:1px dashed #c89b3c;border-radius:8px;text-align:center;padding:22px 10px;">
                <span style="font-family:monospace,'Courier New',sans-serif;font-size:36px;font-weight:bold;letter-spacing:10px;color:#8a6a21;">{$otp}</span>
              </div>
              <p style="margin:24px 0 0;font-size:14px;color:#666666;">यो OTP <b style="color:#252525;">१० मिनेट</b> भित्र मात्र मान्य छ र एक पटक मात्र प्रयोग हुन्छ।</p>
            </td>
          </tr>
          <tr>
            <td style="padding:20px 34px 30px;">
              <p style="margin:0;font-size:12.5px;line-height:1.7;color:#8d8a84;border-top:1px solid #f0e6d2;padding-top:18px;">यो इमेल तपाईंले अनुरोध नगरेको हो भने बेवास्ता गर्नुहोस्।<br>— वैदिक ज्योतिष सिकाइ</p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</div>
HTML;

        $mail->send();
        return true;
    } catch (Throwable $e) {
        error_log('OTP mail failed: ' . $e->getMessage());
        return false;
    }
}
