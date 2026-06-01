<?php
// 1. Inclusion manuelle des fichiers de la bibliothèque PHPMailer
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Fonction d'envoi d'email anonyme via le SMTP sécurisé d'OVH
 */
function sendTracksidaAlert(string $toEmail) {
    $mail = new PHPMailer(true);

    try {
        // --- CONFIGURATION DU SERVEUR SMTP OVH ---
        $mail->isSMTP();
        $mail->Host       = 'ssl0.ovh.net';               // Serveur SMTP mutualisé d'OVH
        $mail->SMTPAuth   = true;                         // Activer l'authentification
        $mail->Username   = 'tracksida@hidia.fr';         // Ton adresse email complète
        $mail->Password   = 'TON_MOT_DE_PASSE_ICI';       // /!\ METS LE VRAI MOT DE PASSE DE LA BOÎTE ICI
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;   // Sécurisation SSL obligatoire pour le port 465
        $mail->Port       = 465;                          // Port SSL d'OVH
        $mail->CharSet    = 'UTF-8';                      // Évite les bugs d'accents

        // --- EXPÉDITEUR ET DESTINATAIRE ---
        $mail->setFrom('tracksida@hidia.fr', 'Tracksida');
        $mail->addAddress($toEmail);
        $mail->addReplyTo('tracksida@hidia.fr', 'Tracksida');

        // --- CONTENU DU MAIL (Charte Bleu-Violet Pastel) ---
        $mail->isHTML(true);
        $mail->Subject = "=?UTF-8?B?" . base64_encode("Message de prévention important concernant votre santé") . "?=";
        
        $mail->Body = '
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
        </head>
        <body style="font-family: Arial, sans-serif; margin: 0; padding: 20px 10px; background-color: #f3f2fa; color: #333333;">
            <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 15px rgba(110, 107, 202, 0.05); border: 1px solid #e6e4f4;">
                
                <div style="background: linear-gradient(135deg, #7b73e6, #6055cd); padding: 35px 20px; text-align: center;">
                    <h1 style="color: #ffffff; margin: 0; font-size: 26px; letter-spacing: 2px; text-transform: uppercase; font-weight: 800;">TRACKSIDA</h1>
                    <p style="color: #e3e1f8; margin: 5px 0 0 0; font-size: 13px; font-weight: 300;">Ton espace santé</p>
                </div>

                <div style="padding: 30px 25px;">
                    <h2 style="color: #4a3eb8; font-size: 18px; margin-top: 0; margin-bottom: 20px; line-height: 1.4;">
                        Message de prévention important concernant votre santé
                    </h2>
                    
                    <p style="font-size: 14px; line-height: 1.6; color: #4A4A4A;">Bonjour,</p>
                    
                    <p style="font-size: 14px; line-height: 1.6; color: #4A4A4A;">
                        Vous recevez ce message automatique et strictement anonyme via la plateforme de prévention <strong>Tracksida</strong>.
                    </p>
                    
                    <p style="font-size: 14px; line-height: 1.6; color: #4A4A4A;">
                        Un ou une partenaire récent(e) a malheureusement été testé(e) positif(ve) à une Infection Sexuellement Transmissible (IST) et a souhaité vous en informer de manière responsable afin de veiller sur votre santé.
                    </p>
                    
                    <div style="background-color: #f7f6fd; border-left: 4px solid #7b73e6; padding: 15px 20px; border-radius: 4px; margin: 25px 0;">
                        <p style="margin: 0 0 8px 0; font-size: 14px; line-height: 1.5; color: #4A4A4A;">
                            <strong>Pas de panique :</strong> Cela ne signifie pas obligatoirement que vous êtes contaminé(e). Cependant, la démarche la plus sûre et recommandée est de réaliser un test de contrôle.
                        </p>
                        <p style="margin: 0; font-size: 14px; line-height: 1.5; color: #4A4A4A;">
                            Beaucoup d\'IST sont courantes, se soignent très facilement et sont parfois totalement asymptomatiques.
                        </p>
                    </div>
                    
                    <p style="font-size: 14px; line-height: 1.6; color: #4A4A4A; font-weight: bold; margin-bottom: 5px;">
                        Ce que vous devez faire :
                    </p>
                    
                    <div style="text-align: center; margin: 30px 0 20px 0;">
                        <a href="https://hidia.fr/tracksida" style="display: inline-block; background-color: #6e6bca; color: #ffffff !important; text-decoration: none; padding: 14px 30px; font-size: 14px; font-weight: bold; border-radius: 50px; box-shadow: 0 4px 10px rgba(110, 107, 202, 0.2);">
                            Inscrivez-vous sur Tracksida
                        </a>
                    </div>
                    
                    <p style="text-align: center; font-size: 13px; color: #5c53be; font-weight: bold; margin-top: 0; margin-bottom: 30px;">
                        et trouvez les centres de dépistage près de chez vous
                    </p>
                    
                    <div style="background-color: #faf9fe; border: 1px dashed #d1cee7; border-radius: 8px; padding: 12px 15px;">
                        <span style="font-size: 12px; font-weight: bold; color: #5c53be; display: block; margin-bottom: 4px;">
                            🛡️ Garantie d\'anonymat absolu
                        </span>
                        <p style="font-size: 12px; color: #666666; margin: 0; line-height: 1.4;">
                            Ce service est 100% anonyme. Aucune coordonnée (ni la vôtre, ni celle de la personne qui vous prévient) n\'est conservée, tracée ou partagée.
                        </p>
                    </div>
                </div>

                <div style="text-align: center; padding: 20px; border-top: 1px solid #f0eef9; font-size: 11px; color: #8c89a8; background-color: #faf9fe;">
                    Prenez soin de vous.<br>
                    &copy; 2026 Tracksida &bull; Plateforme de prévention et de santé
                </div>
            </div>
        </body>
        </html>
        ';

        // Version texte brut alternative pour les vieux clients mail
        $mail->AltBody = "Bonjour, un ou une partenaire récent(e) a été testé(e) positif(ve) à une IST. Inscrivez-vous sur Tracksida et trouvez les centres de dépistage près de chez vous.";

        $mail->send();
        return true;

    } catch (Exception $e) {
        return false;
    }
}

?>