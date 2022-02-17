<?php 
    session_start();
    include('../include/connexion.php');
    if (isset($_SESSION['id_user'])) {

        if ($_SESSION['id_categorie']==3) {

            $id_user = $_SESSION['id_user'];
            $selct = $db->prepare('SELECT u.*, c.libelle, cp.nom_comp FROM user u
                                    LEFT JOIN categorie c ON u.id_categorie = c.id_cat
                                    LEFT JOIN composante cp ON u.id_composant = cp.id_comp
                                    WHERE id_user = ?');
            $selct ->execute(array($id_user));
            $affiche = $selct->fetch();

    if (isset($_POST['modifierMotPASSE'])) {

        if (!empty($_POST['ancienMdp']) && !empty($_POST['nouveauMdp']) && !empty($_POST['nouveauMdp1'])) {
          $ancienMdp = sha1($_POST['ancienMdp']);
          $nouveauMdp = sha1($_POST['nouveauMdp']);
          $nouveauMdp1 = sha1($_POST['nouveauMdp1']);

              $encienmotdepass = $affiche['pass'];

              if ($ancienMdp == $encienmotdepass ) {

                if ($nouveauMdp == $nouveauMdp1) {
                  
                  $changeMDP = $db->prepare("UPDATE user SET pass = ?  WHERE id_user = ?");
                  $changeMDP ->execute(array($nouveauMdp, $id_user ));
                  $success = "Votre mot de passe a été bien modifié !";
                  
                }else{

                  $erreur = "Vos deux neauveaux mot de passe ne corréspondent pas ";
                }

                
              }else{

                $erreur = "Ceux-ci ne corréspond pas au mot de passe actuel ";
              }


        }else{

          $erreur = "Tous les champs doivent être complétées ";
        }

    }
        
    ?>
    <!DOCTYPE html>
    <html>
    <!--Head-->
    <?php
    $logo = "index.php";
    $nav = "";
    $title="Modification du mot de passe";
     include('../include/head.php');
     ?>
    <body>
            <!--Header-->
            <?php include('../include/header.php');?>
            <?php include('menu/menu.php');?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div id="login">
                            <div id="admin">
                                <h3>Modifier le mot de passe</h3>

                                        <?php if (isset($erreur)) {
                                        ?>
                                        <div class="alert alert-danger col-sm-12" role="alert" style="text-align:center;">
                                          <p><?= $erreur ?></p>
                                        </div>
                                        <?php
                                        } ?>
                                    
                                    
                                      <?php if (isset($success)) {
                                        ?>
                                            <div class="alert alert-success col-sm-12" role="alert" style="text-align:center;">
                                                <p> <?= $success ?></p>
                                            </div>
                                          <?php
                                      } ?>
                                    
                                <form method="POST">
                                    <div class="form-group">
                                      <label for="ancienMdp" class="col-form-label">Mot de passe actuel </label>
                                      <input type="password" class="form-control" id="ancienMdp" name="ancienMdp">
                                    </div>
                                    <div class="form-group">
                                      <label for="nouveauMdp" class="col-form-label">Nouveau mot de passe</label>
                                      <input type="password" class="form-control" id="nouveauMdp" name="nouveauMdp">
                                    </div>
                                    <div class="form-group">
                                      <label for="nouveauMdp1" class="col-form-label">Confirmez le nouveau mot de passe</label>
                                      <input type="password" class="form-control" id="nouveauMdp1" name="nouveauMdp1">
                                    </div>
                                    <div>
                                      <input type="submit" name="modifierMotPASSE" value="Enregistrer les modifications" class="btn btn-primary">
                                    </div> 
                                </form>
                                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </body>
    <!--Js Footer-->
    <?php include('../include/js_footer.php');?>    
    </html>
<?php 
    }else {
        header('Location: ../index.php');
    }

}else{
    header('Location: ../index.php');
}
?> 