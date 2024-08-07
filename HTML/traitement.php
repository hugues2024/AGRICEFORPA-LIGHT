<?php

if (!(isset($_POST["name"]) && isset($_POST["surname"]) && isset($_POST["email"]) && isset($_POST["number"]) && isset($_POST["country"]) && isset($_POST["message"]))) {?>
<script>
alert('VOUS DEVEZ RENSEIGNER TOUS LES CHAMPS!!!')
</script>
<?php header('Location:index.php'); 
}
if ($_POST["number"] < 0 ){
?> <script>
alert('Comment pouvez-vous mettre le signe "-" devant votre numéro?')
</script>
<?php header('Location:index.php'); }
$_POST["name"] = htmlspecialchars($_POST["name"]);
$_POST["surname"] = htmlspecialchars($_POST["surname"]);
$_POST["email"] = htmlspecialchars($_POST["email"]);
$_POST["number"] = htmlspecialchars($_POST["number"]);
$_POST["number"] = (int)($_POST["number"]);
$_POST["country"] = htmlspecialchars($_POST["country"]);
$_POST["message"] = htmlspecialchars($_POST["message"]);
$subject = "Nouveau message de " . $_POST['name'] . " " . $_POST['surname'] . " provenant de la plateforme AGRICEFORPA LIGHT SARL faite par HDH Sarl";
$body = <<<HTML
    <p>
        <strong>Nom:</strong> $_POST[name]<br>
        <strong>Prénom:</strong> $_POST[surname]<br>
        <strong>Email:</strong> $_POST[email]<br>
        <strong>Numéro:</strong> $_POST[number]<br>
        <strong>Pays:</strong> $_POST[country]<br>
        <strong>Message:</strong> $_POST[message]<br>
        <h3 style="font-style:italic;color:blue"><a href="https://wa.me/22946097120" style="text-decoration:none">HDH Sarl</a></h3>
    </p>        
    HTML;
$message_à_afficher = <<<HTML
                    <body style="font-family: Arial, sans-serif;background-color: #f4f4f4;margin: 0;padding: 0;display: flex;justify-content: center;align-items: center;height: 100vh; background:#A0D2DB">
                        <div class="container" style="text-align: center;background: #ffffff;padding: 20px;border-radius: 8px;box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                            <div class="message">
                                <h1 style="color: #28a745;margin-bottom: 10px;">Message envoyé avec succès !</h1>
                                <p style="font-size: 18px;color: #333;margin-bottom: 20px;">$_POST[name] $_POST[surname], merci pour votre message. Nous vous répondrons dès que possible.</p>
                                <a href="index.php" class="button"style="display: inline-block;padding: 10px 20px;font-size: 16px;color: #ffffff;background-color: #007bff;text-decoration: none;border-radius: 4px;">Retour à l'accueil</a>
                            </div>
                        </div>
                    </body>
                    HTML  ;


//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'huguesmariehounkpatin1@gmail.com';                     //SMTP username
    $mail->Password   = 'zijl dsyb qxyp lklk';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('from@example.com', 'AGRICEFORPA Light Sarl');
    $mail->addAddress('agriceforpalightsarl@gmail.com');     //Add a Recipients
    
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $body;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo $message_à_afficher;
} catch (Exception $e) {
    echo "Votre message n'a pas été envoyé Erreur: {$mail->ErrorInfo}";
}

?>