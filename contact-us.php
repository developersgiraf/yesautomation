<?php
$mail_error = false;
$field_errors = [
    'firstname' => '',
    'email' => '',
    'mobile' => '',
    'msg' => '',
];

if (isset($_POST['subc'])) {
    $name = isset($_POST['firstname']) ? trim($_POST['firstname']) : '';
    $mail = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone = isset($_POST['mobile']) ? trim($_POST['mobile']) : '';
    $msg = isset($_POST['msg']) ? trim($_POST['msg']) : '';
    $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';

    $email_ok = (bool) filter_var($mail, FILTER_VALIDATE_EMAIL);
    $name_ok = (bool) preg_match("/^[A-Za-z][A-Za-z '\\-]*$/", $name);
    $phone_digits = preg_replace('/\D+/', '', $phone);
    $phone_ok = (bool) preg_match('/^[0-9+\-() .\/#*]+$/', $phone)
        && strlen($phone_digits) >= 10
        && strlen($phone_digits) <= 15;

    if ($name === '') {
        $field_errors['firstname'] = 'First name is required.';
    } elseif (!$name_ok) {
        $field_errors['firstname'] = 'First name may only contain letters (no numbers).';
    }

    if ($mail === '') {
        $field_errors['email'] = 'Email is required.';
    } elseif (!$email_ok) {
        $field_errors['email'] = 'Please enter a valid email address.';
    }

    if ($phone === '') {
        $field_errors['mobile'] = 'Phone number is required.';
    } elseif (!$phone_ok) {
        $field_errors['mobile'] = 'Please enter a valid phone number (10–15 digits).';
    }

    if ($msg === '') {
        $field_errors['msg'] = 'Message is required.';
    }

    $has_field_error = (bool) array_filter($field_errors);

    if (!$has_field_error) {
        // Must use domain mailbox as From. Gmail From + -f is blocked by hosting.
        $from_email = 'sales@yesautomation.ae';
        $from_name = 'Yes Automation';
        $to = 'sales@yesautomation.ae';
        $mail_subject = 'Enquiry From Yesautomation website';

        $safe_name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
        $safe_mail = htmlspecialchars($mail, ENT_QUOTES, 'UTF-8');
        $safe_phone = htmlspecialchars($phone, ENT_QUOTES, 'UTF-8');
        $safe_subject = htmlspecialchars($subject, ENT_QUOTES, 'UTF-8');
        $safe_msg = htmlspecialchars($msg, ENT_QUOTES, 'UTF-8');

        $reply_name = str_replace(["\r", "\n"], '', $name);
        $reply_mail = str_replace(["\r", "\n"], '', $mail);

        $header = 'MIME-Version: 1.0' . "\r\n";
        $header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $header .= 'From: ' . $from_name . ' <' . $from_email . '>' . "\r\n";
        $header .= 'Reply-To: ' . $reply_name . ' <' . $reply_mail . '>' . "\r\n";
        $header .= 'X-Mailer: PHP/' . phpversion() . "\r\n";

        $message = '
<div style="background:#e5e5e5; padding:2% 6%">
<div style="padding:15px; background:#e7e7e7;text-align: center;  border-bottom:solid 5px #9dc33b">
<div><img src="https://www.yesautomation.ae/images/logo.png"  alt="Yesautomation" /></div>
</div>
<div style="margin-top: -6%;">
<div style="padding:15px 15px 35px 15px; background:white;text-align: center; ">
<H1>Enquiry from Yesautomation Website</H1>
<div style="padding-bottom:5px; height: 30px; border-top:dashed 1px #e5e5e5; padding-top:20px;">
<div > Name:  <a style="color:#999">' . $safe_name . '</a></div>
</div>
<div style="padding-bottom:5px; height: 30px;">
<div > Mail:  <a style="color:#999">' . $safe_mail . '</a></div>
</div>
<div style="padding-bottom:5px; height: 30px;">
<div > Phone:  <a style="color:#999">' . $safe_phone . '</a></div>
</div>
<div style="padding-bottom:5px; height: 30px;">
<div > Subject:  <a style="color:#999">' . $safe_subject . '</a></div>
</div>
<div style="padding-bottom:5px; height: 30px;">
<div > Message:  <a style="color:#999">' . $safe_msg . '</a></div>
</div>
</div>
';

        $result = @mail($to, $mail_subject, $message, $header);

        if ($result) {
            header('Location: thank-you.php');
            exit;
        }

        $mail_error = true;
    }
}

$show_posted = isset($_POST['subc']);
function contact_field_class($errors, $key)
{
    return !empty($errors[$key]) ? ' is-invalid' : '';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Contact us | yesautomation.ae</title>
    <link rel="shortcut icon" href="images/favicon.png">
    <meta name="description"
        content="Get in touch with the leading machinery equipment Rental company in UAE. For more details contact yesautomation.ae and Give us a call, let's talk.">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="main/bootstrap.min.css">
    <link rel="stylesheet" href="main/layout.css">
    <link rel="stylesheet" href="main/contact.css">
    <link rel="stylesheet" href="main/menu.css">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <style>
        .video-f iframe {
            width: 100%;
        }
    </style>
</head>

<body>
    <?php $page = 'contact';
    include 'header.php'; ?>

    <section id="contact-banner">
        <div class="slide-desc">
            <div class="cap-one">
                <h1> Contact Us </h1>
            </div>
        </div>
    </section>

 

    <?php include 'footer.php'; ?>

</body>

</html>
