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
    
        if (isset($_POST['affecte'])) {
            
            if (!empty($_POST['user']) && !empty($_POST['produit']) && !empty($_POST['quantite_affecte'])) {
            
                $produit = htmlspecialchars($_POST['produit']);
                $quantite_affecte = htmlspecialchars($_POST['quantite_affecte']);
                $user = htmlspecialchars($_POST['user']);

                $select_produit_un = $db->query("SELECT * FROM produit WHERE id_produit='$produit'");
                $dat1 = $select_produit_un->fetch();
                $id_pro = $dat1['id_produit'];
                $quantite_restante = $dat1['quantite_restante'];
                $quantite_cons_intial = $dat1['quantite_cons'];
                $prix_unitaire = $dat1['prix_unitaire'];
                //Reglage de la quantite consommé
                $qantite_cons_final = $quantite_affecte + $quantite_cons_intial;
                $depense = $quantite_affecte * $prix_unitaire;
                if ($quantite_restante>=$quantite_affecte) {
                    $quantite_final2 = $quantite_restante - $quantite_affecte;

                    //insertion de la table affectation
                    $insert = $db->prepare("INSERT INTO affectation (id_produit_affecter, dat_actuel, quantite_affecter, depense, id_user_affecte)
                    VALUES ('$produit', NOW(), '$quantite_affecte', $depense,'$user')");
                    $insert ->execute();
                    if ($insert == true) {
                        $update_produit = $db->query("UPDATE produit SET quantite_restante = '$quantite_final2', quantite_cons='$qantite_cons_final' WHERE id_produit='$id_pro'");
                    }else {
                        $erreur = "Erreur d'affectation !";
                    }
                    $success = "Felicitation, votre affectation a été bien réussie !";

                }else{
                    $erreur ="Quantité du produit insufsisante au produit demandé !";
                }
                

            }else{

                $erreur ="Tout les champs doivent être complétée";
            }
        }
    ?>
    <!DOCTYPE html>
    <html>
    <!--Head-->
    <?php
        $logo = "index.php";
        $nav = "produit";
        $title = "Affectation d'un produit à une composante";
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
                            <h3>Affecter un produit</h3>
                            <?php if (isset($success)) { ?>
                                <div class="alert alert-success col-sm-12" role="alert" style="text-align:center;">
                                    <p> <?= $success ?></p>
                                </div>
                            <?php } ?>

                            <?php if (isset($erreur)) { ?>
                                    <div class="container">
                                        <div class="row">
                                        <div class="alert alert-danger col-sm-12" role="alert" style="text-align:center;">
                                            <p><?= $erreur ?></p>
                                        </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <form method="post">
                                <div class="form-group row">
                                    <label for="nom_autorisation" class="col-sm-4 col-form-label">Selection un produit</label>
                                    <div class="col-sm-8">
                                    <select class="form-control" id="modalite" name="produit" onchange="charge_mod()">
                                        <option value="0">Selection un produit</option>
                                        <?php
                                            $seleProduit = $db->query('SELECT p.*, f.* FROM produit p LEFT JOIN fournisseur f ON p.id_fourni = f.id_fourni');
                                            while ($data = $seleProduit->fetch()) {
                                                ?>
                                                <option value="<?= $data['id_produit'] ?>"><?= $data['nom_produit'] ?> ( <?= $data['nom_fournisseur'] ?> )</option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="user" class="col-sm-4 col-form-label">Selection un gestionnaire</label>
                                    <div class="col-sm-8">
                                    <select class="form-control" id="user" name="user" onchange="charge_mod()">
                                        <option value="0">Selection un gestionnaire</option>
                                        <?php
                                            // $id_categorie = 4;
                                            $seleUtilisate = $db->query('SELECT u.*, c.abreviation FROM user u LEFT JOIN composante c ON u.id_composant = c.id_comp WHERE id_categorie = 4');
                                            while ($data = $seleUtilisate->fetch()) {
                                                ?>
                                                <option value="<?= $data['id_user'] ?>"><?= $data['nom'].' '.$data['prenom'] ?> ( <?= $data['abreviation'] ?> )</option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="produit_nom" class="col-sm-4 col-form-label">Quantité affectée</label>
                                    <div class="col-sm-8">
                                    <input type="number" name="quantite_affecte" class="form-control" id="produit_nom" min="0">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                      <input type="reset" class="form-control" value="Annuler">
                                    </div>
                                    <div class="col-sm-6">
                                      <input type="submit" name="affecte" class="form-control" value="Affecter">
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