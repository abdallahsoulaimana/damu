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

            if (isset($_GET['action']) && $_GET['action'] == "update" && isset($_GET['id_imprevu'])) {
                $id_imprevu = htmlspecialchars($_GET['id_imprevu']);
                $select_imprevu = $db->query("SELECT * FROM imprevue WHERE id_imprevue = '$id_imprevu'");
                $data = $select_imprevu->fetch();
            }
    
        if (isset($_POST['submit'])) {
            
            if (!empty($_POST['num_pv']) && !empty($_POST['nom_autorisation']) && !empty($_POST['produit_nom']) && !empty($_POST['date_imprevu'])) {
            
                $num_pv = htmlspecialchars($_POST['num_pv']);
                $nom_autorisation = htmlspecialchars($_POST['nom_autorisation']);
                $produit_nom = htmlspecialchars($_POST['produit_nom']);
                $date_imprevu = htmlspecialchars($_POST['date_imprevu']);
                //Verification du saisi des valeurs quantite consomme et prix unitaire
                if (isset($_POST['quantite_cons']) && isset($_POST['prix_unitaire'])) {
                    if (!empty($_POST['quantite_cons']) && $_POST['prix_unitaire']) {
                        $quantite_cons = htmlspecialchars($_POST['quantite_cons']);
                        $prix_unitaire = htmlspecialchars($_POST['prix_unitaire']);
                        $montant = $prix_unitaire*$quantite_cons;
                    }else {
                        $quantite_cons = 0;
                        $prix_unitaire = 0;
                        $montant = htmlspecialchars($_POST['montant']);
                    }
                }
                    
                    $update = $db->prepare("UPDATE imprevue SET num_pv='$num_pv', nom_autorisation='$nom_autorisation', date_imprevu='$date_imprevu', produit_nom='$produit_nom', quantite_cons='$quantite_cons', prix_unitaire='$prix_unitaire', montant='$montant' WHERE id_imprevue='$id_imprevu'");
                    $update->execute();

                    $alert = '<div class="alert alert-success" role="alert">
                          <h4 class="alert-heading">Félicitation !</h4>
                          <p>L\'imprevu du numero pv '.$num_pv.' est bien modifié avec succès !</p>
                        </div>';

            }else{
                $erreur ="Tout les champs doivent être complétée";
            }
        }
    ?>
    <!DOCTYPE html>
    <html>
    <!--Head-->
    <?php
        $nav = "imprevu";
        $title = "Modification d'un imprevu";
        include('../include/head.php');
    ?>
    <body>
            <!--Header-->
            <?php include('../include/header.php');?>
            <?php include('menu/menu.php');?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                        <div class="col-sm-3"></div>
                            <div class=" col-sm-6" style="text-align: center; ">
                                <div id="alert">
                                    <p><?php if (isset($alert)) {
                                        echo $alert;
                                    } ?></p>
                                </div>
                            </div>
                        </div>
                        <div id="login">
                            <div id="admin">
                                <h3>Modification d'un imprevu</h3>
                                <p style="text-align:center;">Tous les champs marqués par un (*) sont obligatoires.</p>
                                <div id="erreur">
                                    <p><?php if (isset($erreur)) {
                                        echo $erreur;
                                    } ?></p>
                                </div>
                                <form method="post">
                                    <div class="form-group row">
                                        <label for="num_pv" class="col-sm-4 col-form-label">Numero du pv *</label>
                                        <div class="col-sm-8">
                                        <input type="text" name="num_pv" class="form-control" value="<?php echo $data['num_pv']; ?>" id="num_pv" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nom_autorisation" class="col-sm-4 col-form-label">Nom du responsable *</label>
                                        <div class="col-sm-8">
                                        <input type="text" name="nom_autorisation" class="form-control" value="<?php echo $data['nom_autorisation']; ?>" required id="nom_autorisation" min="0">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="produit_nom" class="col-sm-4 col-form-label">Nom du produit *</label>
                                        <div class="col-sm-8">
                                        <input type="text" name="produit_nom" class="form-control" value="<?php echo $data['produit_nom']; ?>" required id="produit_nom" min="0">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="quantite_cons" class="col-sm-4 col-form-label">Quantité consommée</label>
                                        <div class="col-sm-8">
                                        <input type="number" name="quantite_cons" class="form-control" value="<?php echo $data['quantite_cons']; ?>" id="quantite_cons" min="0">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="prix_unitaire" class="col-sm-4 col-form-label">Prix unitaire</label>
                                        <div class="col-sm-8">
                                        <input type="number" name="prix_unitaire" class="form-control" value="<?php echo $data['prix_unitaire']; ?>" id="prix_unitaire" min="0">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="montant" class="col-sm-4 col-form-label">Montant</label>
                                        <div class="col-sm-8">
                                        <input type="number" name="montant" class="form-control" value="<?php echo $data['montant']; ?>" id="montant" min="0">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="date_imprevu" class="col-sm-4 col-form-label">Date d'enregistrement *</label>
                                        <div class="col-sm-8">
                                        <input type="date" name="date_imprevu" class="form-control" value="<?php echo $data['date_imprevu']; ?>" required id="date_imprevu">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                          <input type="reset" class="form-control" value="Annuler">
                                        </div>
                                        <div class="col-sm-6">
                                          <input type="submit" name="submit" class="form-control" value="Ajouter">
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