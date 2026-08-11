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
        $header = 'MIME-Version: 1.0' . "\r\n";
        $header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $header .= 'From: Yesautomation ' . "\r\n";

        $message = '
<div style="background:#e5e5e5; padding:2% 6%">
<div style="padding:15px; background:#e7e7e7;text-align: center;  border-bottom:solid 5px #9dc33b">
<div><img src="https://www.yesautomation.ae/images/logo.png"  alt="Yesautomation" /></div>
</div>
<div style="margin-top: -6%;">
<div style="padding:15px 15px 35px 15px; background:white;text-align: center; ">
<H1>Enquiry from Yesautomation Website</H1>
<div style="padding-bottom:5px; height: 30px; border-top:dashed 1px #e5e5e5; padding-top:20px;">
<div > Name:  <a style="color:#999">' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '</a></div>
</div>
<div style="padding-bottom:5px; height: 30px;">
<div > Mail:  <a style="color:#999">' . htmlspecialchars($mail, ENT_QUOTES, 'UTF-8') . '</a></div>
</div>
<div style="padding-bottom:5px; height: 30px;">
<div > Phone:  <a style="color:#999">' . htmlspecialchars($phone, ENT_QUOTES, 'UTF-8') . '</a></div>
</div>
<div style="padding-bottom:5px; height: 30px;">
<div > Subject:  <a style="color:#999">' . htmlspecialchars($subject, ENT_QUOTES, 'UTF-8') . '</a></div>
</div>
<div style="padding-bottom:5px; height: 30px;">
<div > Message:  <a style="color:#999">' . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . '</a></div>
</div>
</div>
';

        $result = mail('saneshbigleap@gmail.com', 'Enquiry From Yesautomation website', $message, $header);

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

    <section id="contact-content">
        <div class="container-fluid">
            <!-- contact-address start -->
            <div class="row contact-address">
                <div class="col-md-12 contact-address__intro">
                    <h2>Our Location</h2>
                    <p>If you would like to find out more about how YES Automation can help your business, we will be more than happy to speak with you and set up a meeting to identify your requirement and provide you our proposal</p>
                </div>

                <div class="col-md-5 col-sm-5 contact-address__info">
                    <h4>Head office</h4>
                    <address>
                        <p>YES AUTOMATION LLC</p>
                        <p>BLOCK NO. 7, WAREHOUSE NO 3</p>
                        <p>UM LAOB REGION, PLOT NO. 1628</p>
                        <p>UMM AL QUWAIN, UAE</p>
                    </address>
                    <div class="contact-address__details">
                        <p><span>TEL :</span> <a href="tel:+97165264382">+971 6 526 4382</a></p>
                        <p><span>MOB :</span> <a href="tel:+971565388502">+971 56 538 8502</a></p>
                        <p><span>FAX :</span> +971 6 5264384</p>
                        <p><span>Mail :</span> <a href="mailto:sales@yesautomation.ae">sales@yesautomation.ae</a></p>
                    </div>
                </div>

                <div class="col-md-7 col-sm-7 contact-address__form" id="contact-form">
                    <h2>Quick Enquiry</h2>
                    <p>Brief us your requirements below, and let's connect</p>

                    <form action="" method="post" id="contactEnquiryForm" novalidate>
                        <div class="row">
                            <div class="col-md-6 form-field">
                                <input type="text" id="fname" name="firstname" placeholder="First Name" required
                                    pattern="[A-Za-z][A-Za-z '\-]*"
                                    autocomplete="given-name"
                                    class="<?php echo trim(contact_field_class($field_errors, 'firstname')); ?>"
                                    value="<?php echo $show_posted && isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                                <div class="field-error" id="fname-error"<?php echo $field_errors['firstname'] ? '' : ' hidden'; ?>><?php echo htmlspecialchars($field_errors['firstname'], ENT_QUOTES, 'UTF-8'); ?></div>
                            </div>
                            <div class="col-md-6 form-field">
                                <input type="email" id="email" name="email" placeholder="E-Mail" required
                                    pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}"
                                    class="<?php echo trim(contact_field_class($field_errors, 'email')); ?>"
                                    value="<?php echo $show_posted && isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                                <div class="field-error" id="email-error"<?php echo $field_errors['email'] ? '' : ' hidden'; ?>><?php echo htmlspecialchars($field_errors['email'], ENT_QUOTES, 'UTF-8'); ?></div>
                            </div>
                            <div class="col-md-6 form-field">
                                <input type="tel" id="phone" name="mobile" placeholder="Phone" required
                                    inputmode="tel" autocomplete="tel"
                                    class="<?php echo trim(contact_field_class($field_errors, 'mobile')); ?>"
                                    value="<?php echo $show_posted && isset($_POST['mobile']) ? htmlspecialchars($_POST['mobile'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                                <div class="field-error" id="phone-error"<?php echo $field_errors['mobile'] ? '' : ' hidden'; ?>><?php echo htmlspecialchars($field_errors['mobile'], ENT_QUOTES, 'UTF-8'); ?></div>
                            </div>
                            <div class="col-md-6 form-field">
                                <input type="text" id="subject" name="subject" placeholder="Subject"
                                    value="<?php echo $show_posted && isset($_POST['subject']) ? htmlspecialchars($_POST['subject'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                            </div>
                            <div class="col-md-12 form-field">
                                <textarea id="msg" name="msg" placeholder="Message" required
                                    class="<?php echo trim(contact_field_class($field_errors, 'msg')); ?>"><?php echo $show_posted && isset($_POST['msg']) ? htmlspecialchars($_POST['msg'], ENT_QUOTES, 'UTF-8') : ''; ?></textarea>
                                <div class="field-error" id="msg-error"<?php echo $field_errors['msg'] ? '' : ' hidden'; ?>><?php echo htmlspecialchars($field_errors['msg'], ENT_QUOTES, 'UTF-8'); ?></div>
                            </div>
                            <div class="col-md-4 col-sm-5 col-xs-6">
                                <input type="submit" value="SEND MAIL" name="subc">
                            </div>
                        </div>
                    </form>

                    <?php if ($mail_error) : ?>
                        <div class="contact-address__error" role="alert">
                            Something went wrong while sending your message. Please try again or email us at <a href="mailto:sales@yesautomation.ae">sales@yesautomation.ae</a>.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <!-- contact-address end -->
        </div>
    </section>

    <div class="video-f">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3599.311212703181!2d55.66114237522392!3d25.561310877478412!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ef5fda30b10c7a9%3A0x1281e5103fcbf1dd!2sYES%20Automation%20LLC!5e0!3m2!1sen!2sin!4v1786424587655!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
    </div>

    <?php include 'footer.php'; ?>
    <script>
        (function () {
            var form = document.getElementById('contactEnquiryForm');
            var fname = document.getElementById('fname');
            var phone = document.getElementById('phone');
            var email = document.getElementById('email');
            var msg = document.getElementById('msg');
            if (!form || !fname || !phone || !email || !msg) return;

            var nameBlocked = /[0-9]/g;
            var phoneAllowed = /[^0-9+() ./#*-]/g;
            var emailPattern = /^[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$/;
            var namePattern = /^[A-Za-z][A-Za-z '\-]*$/;

            function cleanNameValue(value) {
                return String(value || '').replace(nameBlocked, '');
            }

            function cleanPhoneValue(value) {
                return String(value || '').replace(phoneAllowed, '');
            }

            function digitCount(value) {
                return String(value || '').replace(/\D+/g, '').length;
            }

            function setFieldError(input, errorEl, message) {
                if (message) {
                    input.classList.add('is-invalid');
                    errorEl.textContent = message;
                    errorEl.hidden = false;
                } else {
                    input.classList.remove('is-invalid');
                    errorEl.textContent = '';
                    errorEl.hidden = true;
                }
            }

            function applyCleanOnPaste(input, cleanFn, e) {
                e.preventDefault();
                var text = (e.clipboardData || window.clipboardData).getData('text') || '';
                var start = input.selectionStart;
                var end = input.selectionEnd;
                var cleaned = cleanFn(text);
                input.value = input.value.slice(0, start) + cleaned + input.value.slice(end);
                input.setSelectionRange(start + cleaned.length, start + cleaned.length);
            }

            function validateName() {
                var value = fname.value.trim();
                var error = '';
                if (!value) {
                    error = 'First name is required.';
                } else if (!namePattern.test(value)) {
                    error = 'First name may only contain letters (no numbers).';
                }
                setFieldError(fname, document.getElementById('fname-error'), error);
                return !error;
            }

            function validateEmail() {
                var value = email.value.trim();
                var error = '';
                if (!value) {
                    error = 'Email is required.';
                } else if (!emailPattern.test(value)) {
                    error = 'Please enter a valid email address.';
                }
                setFieldError(email, document.getElementById('email-error'), error);
                return !error;
            }

            function validatePhone() {
                var value = phone.value.trim();
                var digits = digitCount(value);
                var error = '';
                if (!value) {
                    error = 'Phone number is required.';
                } else if (digits < 10 || digits > 15) {
                    error = 'Please enter a valid phone number (10–15 digits).';
                }
                setFieldError(phone, document.getElementById('phone-error'), error);
                return !error;
            }

            function validateMessage() {
                var value = msg.value.trim();
                var error = value ? '' : 'Message is required.';
                setFieldError(msg, document.getElementById('msg-error'), error);
                return !error;
            }

            fname.addEventListener('input', function () {
                var cleaned = cleanNameValue(this.value);
                if (cleaned !== this.value) this.value = cleaned;
                validateName();
            });
            fname.addEventListener('paste', function (e) {
                applyCleanOnPaste(this, cleanNameValue, e);
                validateName();
            });
            fname.addEventListener('blur', validateName);

            email.addEventListener('input', validateEmail);
            email.addEventListener('blur', validateEmail);

            phone.addEventListener('input', function () {
                var cleaned = cleanPhoneValue(this.value);
                if (cleaned !== this.value) this.value = cleaned;
                validatePhone();
            });
            phone.addEventListener('paste', function (e) {
                applyCleanOnPaste(this, cleanPhoneValue, e);
                validatePhone();
            });
            phone.addEventListener('blur', validatePhone);

            msg.addEventListener('input', validateMessage);
            msg.addEventListener('blur', validateMessage);

            form.addEventListener('submit', function (e) {
                var okName = validateName();
                var okEmail = validateEmail();
                var okPhone = validatePhone();
                var okMsg = validateMessage();
                if (!(okName && okEmail && okPhone && okMsg)) {
                    e.preventDefault();
                    var firstInvalid = form.querySelector('.is-invalid');
                    if (firstInvalid) firstInvalid.focus();
                }
            });
        })();
    </script>
</body>

</html>
