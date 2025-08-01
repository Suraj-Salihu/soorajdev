<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = new PHPMailer(true);

    try {
        // ✅ SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'sovex.technologies@gmail.com'; // sender email
        $mail->Password = 'dvdbdphmxhwwusjx'; // ✅ new app password (no spaces)
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // ✅ Allow insecure certs for local AWebServer testing
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
        ];

        // ✅ Sender info
        $mail->setFrom('sovex.technologies@gmail.com', 'SOVEX Portfolio');
        $mail->addReplyTo($_POST["email"], $_POST["name"]); // sender info

        // ✅ Recipient
        $mail->addAddress('sovex.technologies@gmail.com');

        // ✅ Email content
        $mail->isHTML(true);
        $mail->Subject = '📨 New Contact Message from ' . htmlspecialchars($_POST["name"]);
        $mail->Body = '
        <div style="font-family: Arial, sans-serif; color: #222; padding: 10px;">
            <h2 style="color: #0066cc;">New Contact from SOVEX Portfolio</h2>
            <p><strong>Name:</strong> ' . htmlspecialchars($_POST["name"]) . '</p>
            <p><strong>Email:</strong> ' . htmlspecialchars($_POST["email"]) . '</p>
            <p><strong>Message:</strong></p>
            <div style="background: #f2f2f2; padding: 10px; border-radius: 5px; font-style: italic;">
                ' . nl2br(htmlspecialchars($_POST["message"])) . '
            </div>
            <hr>
            <p style="font-size: 12px; color: #888;">This message was submitted from your SOVEX Portfolio website.</p>
        </div>
        ';

        // ✅ Send it
        $mail->send();

        // ✅ Styled success message
        echo '
        <div style="
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            font-family: Arial, sans-serif;
        ">
            <div>
                <h2 style="color: green; font-size: 28px;">
                    ✅ Message Sent Successfully!
                </h2>
                <p style="font-size: 20px; color: #333;">
                    Thank you! SOVEX Technologies has received your message.
                </p>
            </div>
        </div>
        ';
    } catch (Exception $e) {
        // ❌ Styled error message
        echo '
        <div style="
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            font-family: Arial, sans-serif;
        ">
            <div>
                <h2 style="color: red; font-size: 26px;">
                    ❌ Message Failed
                </h2>
                <p style="font-size: 18px; color: #555;">
                    Error: ' . $mail->ErrorInfo . '
                </p>
            </div>
        </div>
        ';
    }
}
?>