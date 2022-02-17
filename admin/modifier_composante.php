<?php 
    session_start();
    include('../include/connexion.php');
    if (isset($_SESSION['id_user'])) {

        if ($_SESSION['id_categorie']==1) {

            $id_user = $_SESSION['id_user'];
            $selct = $db->prepare('SELECT u.*, c.libelle, cp.nom_comp FROM user u
                                    LEFT JOIN categorie c ON u.id_categorie = c.id_cat
                                    LEFT JOIN composante cp ON u.id_composant = cp.id_comp
                                    WHERE id_user = ?');
            $selct ->execute(array($id_user));
            $affiche = $selct->fetch();

            if (isset($_GET['action']) && isset($_GET['id_comp'])) {
                $composant = htmlspecialchars($_GET['composante']);
                $id = htmlspecialchars($_GET['id_comp']);
                $select_composante = $db->query("SELECT * FROM composante WHERE id_comp = '$id'");
                $data = $select_composante->fetch();
    
            if (isset($_POST['submit'])) {
                
                if (!empty($_POST['composante'])) {
                
                    $composante = htmlspecialchars($_POST['composante']);
                    $abreviation = htmlspecialchars($_POST['abreviation']);
                    $updateComp = $db -> prepare("UPDATE composante SET nom_comp='$composante', abreviation='$abreviation' WHERE id_comp='$id'");
                    $updateComp -> execute();
                    $success ="Félicitation, Modification de composante réussie ! ";

                }else{
                    
                    $erreur ="Veuillez compléter ce champs !";
                }

            }

    ?>
    <!DOCTYPE html>
    <html>
    <!--Head-->
    <?php
    $logo = "index.php";
    $nav = "composante";
    $title="Modification du composante ".$composant;;
     include('../include/head.php');
     ?>
    <body>
        <!--Header-->
        <?php include('../include/header.php');?>

        <!--Navigation-->
        <?php include('menu/menu.php');?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div id="login">
                        <div id="admin">
                            <h3>Modification du composante <strong><?php echo $composant; ?></strong></h3>
                            <?php if (isset($erreur)) { ?>
                                <div class="container">
                                    <div class="row">
                                    <div class="alert alert-danger col-sm-12" role="alert" style="text-align:center;">
                                        <p><?= $erreur ?></p>
                                    </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if (isset($success)) { ?>
                                <div class="alert alert-success col-sm-12" role="alert" style="text-align:center;">
                                    <p> <?= $success ?></p>
                                </div>
                            <?php } ?>

                            <form method="post">
                                <div class="form-group row">
                                    <label for="composante" class="col-sm-3 col-form-label">Composante</label>
                                    <div class="col-sm-9">
                                    <input type="text" name="composante" class="form-control" id="composante" value="<?php echo $data['nom_comp']; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="abreviation" class="col-sm-3 col-form-label">Abreviation</label>
                                    <div class="col-sm-9">
                                    <input type="text" name="abreviation" class="form-control" id="abreviation" value="<?php echo $data['abreviation']; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                    <input type="reset" class="form-control" value="Annuler">
                                    </div>
                                    <div class="col-sm-6">
                                    <input type="submit" name="submit" class="form-control" value="Modifier une composante">
                                    </div>
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
            header('Location: liste_composante.php');
        }

    }else {
        header('Location: ../index.php');
    }

}else{
    header('Location: ../index.php');
}
?> 