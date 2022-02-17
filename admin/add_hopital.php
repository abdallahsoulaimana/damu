<?php 
    session_start();
    include('../include/connexion.php');
    if (isset($_SESSION['id_user'])) {

        if ($_SESSION['id_categorie']==1) {

            $id_user = $_SESSION['id_user'];
            $selct = $db->prepare('SELECT u.*, c.nom_cat, l.nom_labo FROM user u
                                    LEFT JOIN categorie c ON u.id_cat = c.id_cat
                                    LEFT JOIN labo l ON u.id_labo = l.id_labo
                                    WHERE id_user = ?');
            $selct ->execute(array($id_user));
            $affiche = $selct->fetch();
    
            if (isset($_POST['submit'])) {
                
                if (!empty($_POST['hopital']) && !empty($_POST['lieu'] && !empty($_POST['ile']))) {
                
                    $hopital = htmlspecialchars($_POST['hopital']);
                    $lieu = htmlspecialchars($_POST['lieu']);
                    $ile = htmlspecialchars($_POST['ile']);
                    $ajoutHop = $db -> prepare("INSERT INTO hopital (nom_hopit, lieu, id_ile) VALUES (?, ?, ?)");
                    $ajoutHop -> execute(array($hopital, $lieu, $ile));
                    $success ="Félicitation, Nouvelle hopital ajouté ! ";

                }else{
                    
                    $erreur ="Veuillez compléter Tous ces champs !";
                }

            }

    ?>
    <!DOCTYPE html>
    <html>
    <!--Head-->
    <?php
    $logo = "index.php";
    $nav = "composante";
    $title="Nouvel enregistrement d'un hopital";
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
                            <h3>Nouveau Hopital</h3>
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
                                    <label for="hopital" class="col-sm-3 col-form-label">Hopital</label>
                                    <div class="col-sm-9">
                                    <input type="text" name="hopital" class="form-control" id="hopital" placeholder="El-Manrouf">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="lieu" class="col-sm-3 col-form-label">Emplacement</label>
                                    <div class="col-sm-9">
                                    <input type="text" name="lieu" class="form-control" id="lieu" placeholder="Moroni">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="ile" class="col-sm-3 col-form-label">Île</label>
                                    <div class="col-sm-9">
                                    <select class="form-control" id="ile" name="ile">
                                        <option value="">Selectionnez un île</option>
                                        <?php
                                            $seleIle = $db->query('SELECT * FROM ile');
                                            while ($data = $seleIle->fetch()) {
                                                ?>
                                                <option value="<?= $data['id_ile'] ?>"><?= $data['nom_ile'] ?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                    <input type="reset" class="form-control" value="Annuler">
                                    </div>
                                    <div class="col-sm-6">
                                    <input type="submit" name="submit" class="form-control" value="Ajouter un Hopital">
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
        header('Location: ../index.php');
    }

}else{
    header('Location: ../index.php');
}
?> 