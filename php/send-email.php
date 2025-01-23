<?php
// Zet error reporting aan voor debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Autoload PHPMailer via Composer
require 'vendor/autoload.php';

// Maak een nieuwe instantie van PHPMailer
$mail = new PHPMailer(true);

try {
    // Serverinstellingen voor Gmail SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';  // Gmail SMTP-server
    $mail->SMTPAuth = true;
    $mail->Username = 'makkelijkmailsturentest@gmail.com';  // Je Gmail-adres
    $mail->Password = 'ebypjmoglaluutpe';  // Je Gmail-wachtwoord
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Gebruik STARTTLS voor veilige verbinding
    $mail->Port = 587;  // Poort 587 voor STARTTLS

    // Ontvanger en afzender
    $mail->setFrom('jouw_gmail_adres@gmail.com', 'Noah Mollers');  // Je Gmail-adres en naam
    $mail->addAddress('noah.mollers@live.nl', 'Noah Mollers');  // Het e-mailadres van de ontvanger (je eigen e-mail)

    // Verkrijg de gegevens van het contactformulier
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // E-mailinhoud
    $mail->isHTML(true);
    $mail->Subject = 'Nieuw contactformulier bericht';
    $mail->Body    = "<b>Naam:</b> $name<br><b>Telefoonnummer:</b> $phone<br><b>E-mail:</b> $email<br><b>Bericht:</b><br>$message";

    // Verstuur de e-mail
    if ($mail->send()) {
        echo "<script>alert('Bedankt voor je bericht! Het is zowel opgeslagen als verzonden.'); window.location.href='../index.html';</script>";
    } else {
        echo "<script>alert('Er is een fout opgetreden bij het versturen van je bericht.'); window.location.href='../index.html';</script>";
    }
} catch (Exception $e) {
    echo "<script>alert('Er is een fout opgetreden bij het versturen van je bericht: {$mail->ErrorInfo}'); window.location.href='../index.html';</script>";
}
?>
