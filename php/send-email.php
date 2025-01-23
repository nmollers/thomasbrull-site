<?php
// Zet error reporting aan voor debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verbinding maken met de database
$servername = "localhost";
$username = "root";  // Dit is de standaard MySQL gebruikersnaam in XAMPP
$password = "";      // Dit is het standaard wachtwoord (leeg) in XAMPP
$dbname = "contact_form";  // De naam van je database

// Verbinding maken
$conn = new mysqli($servername, $username, $password, $dbname);

// Controleren op fouten bij de verbinding
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Controleren of het formulier is verzonden
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verkrijg de gegevens van het formulier
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Controleer of alle velden zijn ingevuld
    if (empty($name) || empty($phone) || empty($email) || empty($message)) {
        echo "Alle velden moeten ingevuld worden.";
        exit;  // Stop verdere uitvoering als er lege velden zijn
    }

    // Prepared statement om de gegevens in de database in te voegen
    $stmt = $conn->prepare("INSERT INTO messages (name, phone, email, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $phone, $email, $message);

    // Waarden binden en query uitvoeren
    if ($stmt->execute()) {
        // Als de gegevens succesvol zijn opgeslagen, verstuur dan de e-mail
        $to = "noah.mollers@live.nl";  // Vervang dit met je eigen e-mailadres
        $subject = "Nieuw contactformulier bericht";
        $body = "Naam: $name\nTelefoonnummer: $phone\nE-mail: $email\nBericht: $message";
        $headers = "From: $email";

        // Verstuur de e-mail en geef feedback
        if (mail($to, $subject, $body, $headers)) {
            echo "Bedankt voor je bericht! Het is zowel opgeslagen als verzonden.";
        } else {
            echo "Er is een fout opgetreden bij het versturen van je bericht.";
        }
    } else {
        echo "Er is een fout opgetreden bij het opslaan van je bericht: " . $stmt->error;
    }

    // Verbinding sluiten
    $stmt->close();
    $conn->close();
}
?>