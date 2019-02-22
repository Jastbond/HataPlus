<?php
if (isset($_POST['emailFrom'])) {

    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "captainneo777@gmail.com";
    $email_subject = "New client";

    function died($error)
    {
        // your error code can go here
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error . "<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }


    // validation expected data exists
    if (!isset($_POST['name']) ||
        !isset($_POST['phone']) ||
        !isset($_POST['emailFrom']) ||
        !isset($_POST['text'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');
    }


    $name = $_POST['name']; // required
    $phone = $_POST['phone']; // required
    $email_from = $_POST['emailFrom']; // required
    $text = $_POST['text']; // not required


    $error_message = "";
    $email_exp = "/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/";
    $string_exp = "/^[A-Za-z .'-]+$/";
    $phone_exp = "/^[+]380+[0-9]{9}$/";

    if (!preg_match($email_exp, $email_from)) {
        $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
    }

    if (!preg_match($string_exp, $name)) {
        $error_message .= 'The Name you entered does not appear to be valid.<br />';
    }

    if (!preg_match($phone_exp, $phone)) {
        $error_message .= 'The Phone you entered does not appear to be valid.<br />';
    }

    if (strlen($text) < 2) {
        $error_message .= 'The Comments you entered do not appear to be valid.<br />';
    }

    if (strlen($error_message) > 0) {
        died($error_message);
    }

    $email_message = "Form details below.\n\n";


    function clean_string($string)
    {
        $bad = array("content-type", "bcc:", "to:", "cc:", "href");
        return str_replace($bad, "", $string);
    }


    $email_message .= "Name: " . clean_string($name) . "<br>";
    $email_message .= "Phone: " . clean_string($phone) . "<br>";
    $email_message .= "Email: " . clean_string($email_from) . "<br>";
    $email_message .= "Text message: " . clean_string($text) . "<br>";


// create email headers
    $headers = 'From: ' . $email_from . "\r\n" .
        'Reply-To: ' . $email_from . "\r\n" .
        'content-type: text/html; charset=utf-8' . "\r\n" .
        'X-Mailer: PHP/' . phpversion(7.2);
    mail($email_to, $email_subject, $email_message, $headers);

// send email to submitted user who checked checkbox
    $want = $_POST['news'];
    if ($want == true) {
        $adressee = $_POST['emailFrom'];
        $subj = "HataPlus.ua news";
        $message = file_get_contents("email.html");
        mail($adressee, $subj, $message, $headers);
    }
    echo "Thank you for contacting us. We will be in touch with you very soon.";
}
?>