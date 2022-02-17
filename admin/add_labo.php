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
                
                if (!empty($_POST['labo']) && !empty($_POST['hopital'])) {
                
                    $labo = htmlspecialchars($_POST['labo']);
                    $hopital = htmlspecialchars($_POST['hopital']);
                    $ajoutLabo = $db -> prepare("INSERT INTO labo (nom_labo, id_hop) VALUES (?, ?)");
                    $ajoutLabo -> execute(array($labo, $hopital));
                    $success ="Félicitation, Nouveau laboratoire ajouté ! ";

                }else{
                    
                    $erreur ="Veuillez compléter tous ces champs !";
                }

            }

    ?>
    <!DOCTYPE html>
    <html>
    <!--Head-->
    <?php
    $logo = "index.php";
    $nav = "composante";
    $title="Nouvel enregistrement d'un labo";
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
                            <h3>Nouveau laboratoire</h3>
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
                                    <label for="labo" class="col-sm-3 col-form-label">Laboratoire</label>
                                    <div class="col-sm-9">
                                    <input type="text" name="labo" class="form-control" id="labo" placeholder="Hombo Labo">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="hopital" class="col-sm-3 col-form-label">Hopital</label>
                                    <div class="col-sm-9">
                                    <select class="form-control" id="hopital" name="hopital">
                                        <option value="">Selectionnez un hopital</option>
                                        <?php
                                            $seleHop = $db->query('SELECT * FROM hopital');
                                            while ($data = $seleHop->fetch()) {
                                                ?>
                                                <option value="<?= $data['id_hopital'] ?>"><?= $data['nom_hopit'] ?></option>
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
                                    <input type="submit" name="submit" class="form-control" value="Ajouter un labo">
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