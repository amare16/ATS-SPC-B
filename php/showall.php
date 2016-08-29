<!DOCTYPE html>
<html>

<?php include '../header.inc.php'; ?>

<body>
    <div id="showall-page">
        <?php
        if (isset($_POST['Validate'])) {
            $surname_s = $_POST['surname_s'];
            $user_id = $_POST['user_id'];
            $Month_in = $_POST['Month_in'];
            $errors = array();
            if (empty($user_id) || empty($Month_in)) {
                $errors[] = 'Tous les champs sont obligatoires';
            } else {
                require 'conn.php';

                $sql = "SELECT * FROM checkins WHERE user_id = '$user_id' && surname = '$surname_s'";

                $stmt=$conn->prepare($sql);
	             	$stmt->bindParam(1,$user_id,PDO::PARAM_INT);
		            $stmt->execute();
                $count = $stmt->rowcount();

                if ($user_id==0) {
                    $errors[] = 'Utilisateur_id incorrect';
                }
                else {
                $id = 1;$j=1;$k=1;$l=1;
                $late = 'en retard';
                $in_time = 'à l heure';
                $absent="absent";

                      if ($count) {
                ?>
                <script>
                $(document).ready(function(){$("tr:odd").addClass("odd");});
                </script>
                <table class="table">
                     <tr>
                        <td></td>

                        <td>Utilisateur_id</td>
                        <td>Nom</td>
                        <td>Heure d'arrivée</td>
                     </tr>
                    <?php
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                        $ARRIVAL_TIME = $row['arrival_time'];
                        $user=$row['user_id'];
                        $name=$row['surname'];
                        $Hour = strtotime($ARRIVAL_TIME);
                        $Hour = date("H", $Hour);
                        $month = strtotime($ARRIVAL_TIME);
                        $month = date("m", $month);

                        if ($month==$Month_in){
                              if ($Hour <10){
                                  echo"
                                      <tr>
                                      <td>".$id++."</td>
                                      <td>$user</td>
                                      <td>$name</td>
                                      <td>$ARRIVAL_TIME</td>
                                      <td>$in_time</td>
                                      </tr>
                                      ";
                             }
                             elseif ($Hour<12){

                             echo"
                                <tr>
                                <td>".$id++."</td>
                                <td>$user</td>
                                <td>$name</td>
                                <td>$ARRIVAL_TIME</td>
                                <td>$late</td>
                                </tr>
                                ";
                            }
                            else {
                            echo"
                          <tr>
                          <td>".$id++."</td>
                          <td>$user</td>
                          <td>$name</td>
                          <td>$ARRIVAL_TIME</td>
                          <td>$absent</td>
                          </tr>
                          ";
                                }
                        }
                 }
                ?>
                </table>
                <?php
                 }
               else {
                    $errors[] = 'Il n y a pas enregistrer aujourd hui';
                }
              }
            }
        }

        if (isset($errors)) {
            foreach ($errors as $error) {
                echo '<div class="alert alert-danger">'.$error.'</div>';
            }
        }
        ?>
        <?php
        if (isset($_POST['Validate1'])) {


                require 'conn.php';

                $sql = "SELECT * FROM checkins ORDER BY 'id'";

                $stmt=$conn->prepare($sql);
	             	$stmt->bindParam(1,$user_id,PDO::PARAM_INT);
		            $stmt->execute();
                $count = $stmt->rowcount();

$id=1;
$j=0;
                $late = 'en retard';
                $in_time = 'à lheure';
                $absent="absent";

                      if ($count) {
                ?>
                <script>
                $(document).ready(function(){$("tr:odd").addClass("odd");});
                </script>
                <table class="table">
                     <tr>
                        <td></td>

                        <td>Utilisateur_id</td>
                        <td>Nom</td>
                        <td>Heure d'arrivée</td>
                     </tr>
                    <?php
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                        $ARRIVAL_TIME = $row['arrival_time'];
                        $user=$row['user_id'];
                        $name=$row['surname'];
                        $Hour = strtotime($ARRIVAL_TIME);
                        $Hour = date("H", $Hour);
                        $month = strtotime($ARRIVAL_TIME);
                        $month = date("m", $month);
                        $day = strtotime($ARRIVAL_TIME);
                        $day = date('Y-m-d', $day);
                        $current_day = date('Y-m-d');
                        if ($day==$current_day){
                              if ($Hour <10){
                                  echo"
                                      <tr>
                                      <td>".$id++."</td>
                                      <td>$user</td>
                                      <td>$name</td>
                                      <td>$ARRIVAL_TIME</td>
                                      <td>$in_time</td>
                                      </tr>
                                      ";
                             }
                             elseif ($Hour<12){

                             echo"
                                <tr>
                                <td>".$id++."</td>
                                <td>$user</td>
                                <td>$name</td>
                                <td>$ARRIVAL_TIME</td>
                                <td>$late</td>
                                </tr>
                                ";
                            }
                            else {
                            echo"
                          <tr>
                          <td>".$id++."</td>
                          <td>$user</td>
                          <td>$name</td>
                          <td>$ARRIVAL_TIME</td>
                          <td>$absent</td>
                          </tr>
                          ";
                                }
                              }
                                else {
                                  $j=$j+1;
                                }
                        }

                ?>
                </table>
                <?php
                 }
               else {
                    $errors[] = 'Il n y a pas utilisateur dans le tableau';
                }

if ($j==0) {
//$errors[] = 'Il n y a pas enregistrer aujourd hui';
}
}
        if (isset($errors)) {
            foreach ($errors as $error) {
                echo '<div class="alert alert-danger">'.$error.'</div>';
            }
        }
        ?>
        <form class="form-horizontal" action="" method="POST">

             <div class="control-group">
                 <div class="controls">
                   <p>pour la daily raport</p>
                     <button id="singlebutton-0" name="Validate1" class="btn btn-primary" onclick="newDoc()">Valider</button>
                 </div></br></br>
             </div>
             <div class="control-group">

                <label class="control-label" for="textinput-1">surname</label>
               <div class="controls">
                    <input id="textinput-1" name="surname_s" type="text" placeholder="surname" class="input-xlarge">
                </div>
                </div>
           <div class="control-group">
               <label id="showall-label1" class="control-label" for="textinput-1">Utilisateur_id</label></br></br>
           <div class="controls">
                   <input id="textinput-1" name="user_id" type="text" placeholder="Utilisateur_id" class="input-xlarge">
               </div>
           </div>
           <br />
           <div class="control-group">
           <label class="control-label" for="selectbasic-0">Choisissez le mois</label>
           <div class="controls">
              <select id="selectbasic-0" name="Month_in" class="input-mini">
      <option value="01">01</option>
      <option value="02">02</option>
      <option value="03">03</option>
      <option value="04">04</option>
      <option value="05">05</option>
      <option value="06">06</option>
      <option value="07">07</option>
      <option value="08">08</option>
      <option value="09">09</option>
      <option value="10">10</option>
      <option value="11">11</option>
      <option value="12">12</option>
    </select>
</div></br>
</div>
            <div class="control-group">
                <div class="controls">
                    <button id="singlebutton-0" name="Validate" class="btn btn-primary" onclick="newDoc()">Valider</button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>
