<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Dr. Jadhav Multi-specialty Hospital</title>

    <!-- Stylesheets -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">

    <!--Color Themes-->
    <link id="theme-color-file" href="css/color-themes/default-theme.css" rel="stylesheet">

    <!--Color Switcher Mockup-->
    <link href="css/color-switcher-design.css" rel="stylesheet">

    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <link rel="icon" href="images/favicon.png" type="image/x-icon">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.1.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.1.0/uicons-bold-straight/css/uicons-bold-straight.css'>

    <!-- Responsive -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script><![endif]-->
    <!--[if lt IE 9]><script src="js/respond.js"></script><![endif]-->

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
<?php
// Load reCAPTCHA keys from environment when available (fallback to existing values)
$recaptcha_secret = getenv('RECAPTCHA_SECRET') ?: '6Lfmq_YrAAAAAIHYygdyZtk_dUV-8pOfSQVFLKCy';
$recaptcha_sitekey = getenv('RECAPTCHA_SITEKEY') ?: '6Lfmq_YrAAAAAM8IuetBWz1Qdj9sbEuB-UvYcax7';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recaptcha_response = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '';

    // sanitize inputs
    $name = isset($_POST['username']) ? trim($_POST['username']) : '';
    $user_email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone = isset($_POST['phone_no']) ? trim($_POST['phone_no']) : '';
    $message_text = isset($_POST['contact_message']) ? trim($_POST['contact_message']) : '';

    // Verify the response with Google (simple check)
    $verify = @file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptcha_secret}&response={$recaptcha_response}");
    $response_data = $verify ? json_decode($verify) : null;

    $to = "vanita@webnetdigitalmedia.com";
    $subject = "Enquiry From Dr. Jadhav Multi-specialty Hospital";

    $message = '<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><title>Enquiry</title></head><body style="margin:0; padding:0">';
    $message .= '<div style="width:600px; margin:0 auto; padding:10px;">';
    $message .= '<h2 style="color:#333; text-align:center;">Enquiry From Website</h2>';
    $message .= '<table border="0" cellpadding="8" cellspacing="0" width="100%">';
    $message .= '<tr><td style="width:35%;">Customer Name :</td><td>' . htmlspecialchars($name) . '</td></tr>';
    $message .= '<tr><td>Email :</td><td>' . htmlspecialchars($user_email) . '</td></tr>';
    $message .= '<tr><td>Contact No.:</td><td>' . htmlspecialchars($phone) . '</td></tr>';
    $message .= '<tr><td>Message :</td><td>' . nl2br(htmlspecialchars($message_text)) . '</td></tr>';
    $message .= '</table></div></body></html>';

    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1" . "\r\n";
    $headers .= "Bcc: vanita@webnetdigitalmedia.com" . "\r\n";
    if (!empty($user_email)) {
        $headers .= "From: " . htmlspecialchars($name) . " <" . $user_email . ">" . "\r\n";
    }

    $mail_sent = mail($to, $subject, $message, $headers);

    if (($response_data && !empty($response_data->success) && $response_data->success) || $mail_sent) {
        echo "<script>alert('Your message has been successfully sent');</script>";
        echo "<script>window.location.assign('index.php');</script>";
    } else {
        echo "reCAPTCHA verification failed or message not sent. Please try again.";
    }
}
?>

<div class="page-wrapper">
    <?php include 'header.php'; ?>

    <!--Page Title-->
    <section class="page-title" style="background-image: url(images/background/8.jpg);">
        <div class="auto-container">
            <div class="title-outer">
                <h1>Contact Us</h1>
                <ul class="page-breadcrumb">
                    <li><a href="index.php">Home</a></li>
                    <li>Contact</li>
                </ul>
            </div>
        </div>
    </section>
    <!--End Page Title-->

    <?php // header.php already provides $rowcontact ?>

    <!-- Map Section -->
    <section class="map-section">
        <div class="auto-container">
            <?php echo $rowcontact['map']; ?>
        </div>
    </section>
    <!-- End Map Section -->

    <!-- Contact Section -->
    <section class="contact-section" id="contact">
        <div class="small-container">
            <div class="sec-title text-center">
                <span class="sub-title">Contact Now</span>
                <h2>Write us a Message !</h2>
                <span class="divider"></span>
            </div>

            <!-- Contact box -->
            <div class="contact-box">
                <div class="row">
                    <div class="contact-info-block col-lg-6 col-md-6 col-sm-12">
                        <div class="inner">
                            <span class="icon flaticon-worldwide"></span>
                            <h4><strong>Address</strong></h4>
                            <p><?php echo $rowcontact['address']; ?></p>
                        </div>
                    </div>

                    <div class="contact-info-block col-lg-6 col-md-6 col-sm-12">
                        <div class="inner">
                            <span class="icon flaticon-phone"></span>
                            <h4><strong>For booking appointment and other enquiries</strong></h4>
                            <p><a href="tel:<?php echo $rowcontact['enquiry_number']; ?>"><?php echo $rowcontact['enquiry_number']; ?></a></p>
                            <h4><strong>For emergency</strong></h4>
                            <p><a href="tel:<?php echo $rowcontact['phone_no']; ?>"><?php echo $rowcontact['phone_no']; ?></a></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form box -->
            <div class="form-box">
                <div class="contact-form">
                    <form action="contact.php" method="post">
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <div class="response"></div>
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <input type="text" name="username" class="username" placeholder="Full Name *">
                                </div>

                                <div class="form-group">
                                    <input type="email" name="email" class="email" placeholder="Email Address *">
                                </div>

                                <div class="form-group">
                                    <input type="text" name="phone_no" class="username" placeholder="Your Phone">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <textarea name="contact_message" class="message" placeholder="Massage"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="g-recaptcha" data-sitekey="<?php echo htmlspecialchars($recaptcha_sitekey); ?>"></div>
                            </div>

                            <div class="form-group col-lg-12 text-center pt-3">
                                <button class="theme-btn btn-style-one" type="submit" id="submit" name="submit-form"><span class="btn-title">Send Message</span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!--End Contact Section -->

    <?php include 'footer.php'; ?>
</div>
</body>
</html>
