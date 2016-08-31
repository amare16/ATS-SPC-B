<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>

<?php include '../header.inc.php'; ?>

<body>
  <div id="header">
      <img id="logo" alt="accenture" src="../image/logo-accenture.png">
  </div>
    <?php
    if (isset($_POST['add-new'])) {
        $username = $_POST['name'];
        $surname = $_POST['surname'];
        $email= $mail = $_POST['mail'];

        $errors = array();
        if (empty($username) || empty($surname) || empty($mail)) {
            $errors[] = 'Tous les champs sont obligatoires';
        } else {
            include 'conn.php';
            function generateRandomString($length = 6) {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
                return $randomString;
            }
            $passcode =  generateRandomString();
            $sql = 'INSERT INTO users(name,surname,mail,passcode) VALUES (?,?,?,?)';
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $username, PDO::PARAM_STR);
            $stmt->bindParam(2, $surname, PDO::PARAM_STR);
            $stmt->bindParam(3, $mail, PDO::PARAM_STR);
            $stmt->bindParam(4, $passcode, PDO::PARAM_STR);
            $stmt->execute();

            $success="Le collaborateur a été enregistré et le mot de passe est ";
            $message= " Vous êtes bien enregistré et votre mot de passe est ".$passcode;
            //send email
            function send_email($email,$message)
                {
                  require_once '../phpmailer/class.phpmailer.php';
                  $mail = new PHPMailer();
                  $mail->IsSMTP();
                  $mail->SMTPDebug = 0;
                  $mail->SMTPAuth = true;
                  $mail->SMTPSecure = 'ssl';
                  $mail->Host = 'smtp.gmail.com';
                  $mail->Port = 465;
                  $mail->AddAddress($email);
                  $mail->Username = 'emailforaccenture@gmail.com';
                  $mail->Password = 'ACCENTURE123';
                  $mail->Subject = 'confirmation de enregistrement' ;
                  $mail->MsgHTML($message);
                  $mail->Send();
                }
                send_email($email,$message);
        }
    }
    ?>
    <div id="page">
        <div id="page_header">
            <h1><strong>Projet SPC</strong></h1>
            <h2>(Suivi de Présence du Collaborateur)</h2>
        </div>
        <ul class="nav nav-pills">
            <li role="presentation" class="active"><a href="../php/dashbord.php"><span class="glyphicon glyphicon-asterisk"></span>Tableau de bord</a></li>
            <li role="presentation" class="active"><a href="../php/addnew.php"><span class="glyphicon glyphicon-asterisk"></span>Ajouter collaborateur</a></li>
            <li role="presentation" class="active"><a href="../php/showall.php"><span class="glyphicon glyphicon-asterisk"></span>Rapport</a></li>
        </ul>
        <div class = "control-group">
        <form class="form-horizontal" action="" method="POST">
            <br />
            <?php
            if ($success) {
                echo '<div class="alert alert-success">'.$success.$passcode.'</div>';
            }
            if (isset($errors)) {
                foreach ($errors as $error) {
                    echo '<div class="alert alert-danger">'.$error.'</div>';
                }
            }
            ?>

            <div class="control-group">
                <label class="control-label" for="textinput-1">Prénom</label>
                <div class="controls">
                    <input id="textinput-1" name="name" type="text" placeholder="Prénom" class="input-xlarge">
                </div>
            </div>

            <!-- Text input-->
            <div class="control-group">
                <label class="control-label" for="textinput-1">Nom</label>
                <div class="controls">
                    <input id="textinput-1" name="surname" type="text" placeholder="Nom" class="input-xlarge">
                </div>
            </div>

            <!-- Text input-->
            <div class="control-group">
                <label class="control-label" for="textinput-1">Mail</label>
                <div class="controls">
                    <input id="textinput-1" name="mail" type="email" placeholder="Mail" class="input-xlarge">
                </div>
            </div>


            <!-- Button -->
            <div class="control-group">
                <div class="controls">
                    <button id="singlebutton-5" name="add-new" class="btn btn-primary">Enregistrer</button>
                </div>
            </div>
        </form>
      </div>
    </div>
</body>

</html>
