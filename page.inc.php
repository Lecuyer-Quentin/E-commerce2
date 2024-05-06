<?php

function set_session($name, $data) {
    foreach ($data as $key => $value) {
        $_SESSION[$name][$key] = $value;
    }
}

function autoload() {
    spl_autoload_register(function ($class) {
        $class = str_replace('\\', '/', $class);
        require_once __DIR__ . '/models/' . $class . '.php';
    });
}
autoload();


function get_JSON($path, $name, $sub) {
    $json = json_decode(file_get_contents($path), true);
    if ($json === null) {
        return [];
    }
    if (isset($json[$name][$sub])) {
        return $json[$name][$sub];
    } else {
        return [];
    }
}

function errorMSG($msg) {
    $data = get_JSON('config.json', 'message', 'error');
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            if (preg_match($key, $msg)) {
                return $value;
            }
        }
    }
}

function successMSG($msg) {
    $data = get_JSON('config.json', 'message', 'success');
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            if (preg_match($key, $msg)) {
                return $value;
            }
        }
    }
}

$project_root = $_SERVER['DOCUMENT_ROOT'] . '/NFA021/E-commerce2/';
function get_directory($path) {
    global $project_root;
    $dir = $project_root . $path;
    if(!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
    return $dir;
}

function upload_images($file, $path) {
    $target_dir = get_directory($path);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $check = getimagesize($file['tmp_name']);
    $target_file = $target_dir . uniqid() . '.' . $imageFileType;
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }
    if(file_exists($target_file)) {
        $uploadOk = 0;
    }
    if($file['size'] > 500000) {
        $uploadOk = 0;
    }
    if($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg' && $imageFileType != 'gif') {
        $uploadOk = 0;
    }
    if($uploadOk == 0) {
        return false;
    } else {
        if(move_uploaded_file($file['tmp_name'], $target_file)) {
            return $target_file;
        } else {
            return false;
        }
    }
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
function send_mail($email, $subject, $body) {
    $mail = new PHPMailer(true);
    try {
        //Paramètres du serveur SMTP
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = '';
        $mail->Password = '';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        //Paramètres de l'email
        $mail->setFrom('', 'E-commerce');

        //Destinataire
        $mail->addAddress($email);

        //Contenu de l'email
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        //Envoi de l'email
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

    