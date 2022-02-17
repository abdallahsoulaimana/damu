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

        if (isset($_GET['action']) && $_GET['action']=="update") {
            $id_affectation = htmlspecialchars($_GET['id_affectation']);
            $select_affectation = $db->query("SELECT a.*, c.*, p.*, u.* FROM affectation a  
                                            LEFT JOIN produit p ON p.id_produit = a.id_produit_affecter
                                            LEFT JOIN user u ON u.id_user = a.id_user_affecte
                                            LEFT JOIN composante c ON u.id_composant = c.id_comp
                                            WHERE id_affectation='$id_affectation'");
            $affectation = $select_affectation->fetch();
    
        if (isset($_POST['affecte'])) {
            
            if (!empty($_POST['user']) && !empty($_POST['produit']) && !empty($_POST['quantite_affecte'])) {
            
                $produit = htmlspecialchars($_POST['produit']);
                $quantite_affecte = htmlspecialchars($_POST['quantite_affecte']);
                $user = htmlspecialchars($_POST['user']);
                $quantite_affecte_init = $affectation['quantite_affecter'];
                $quantite_restante_init = $affectation['quantite_restante'];
                $quantite_conso_init = $affectation['quantite_cons'];
                $prix_unitaire = $affectation['prix_unitaire'];
            
                if ($quantite_affecte <= $quantite_affecte_init) {
                    $moins = $quantite_affecte_init-$quantite_affecte;
                    $quantite_restante_final = $quantite_restante_init + $moins;
                    $quantite_conso_final = $quantite_conso_init - $moins;
                    $depense = $quantite_conso_final * $prix_unitaire;
                    $update_produit = $db->query("UPDATE produit SET quantite_restante = '$quantite_restante_final', quantite_cons='$quantite_conso_final' WHERE id_produit='$produit'");

                    //Mis à jour de la table affectation
                    $update = $db->prepare("UPDATE affectation SET id_produit_affecter='$produit', dat_actuel=NOW(), quantite_affecter='$quantite_affecte', depense='$depense', id_user_affecte='$user' WHERE id_affectation='$id_affectation'");
                    $update ->execute();
                    $success = "Felicitation, votre affectation a été bien modifiée !";

                }elseif ($quantite_affecte > $quantite_affecte_init) {
                    $moins = $quantite_affecte - $quantite_affecte_init;
                    $quantite_restante_final = $quantite_restante_init - $moins;
                    $quantite_conso_final = $quantite_conso_init + $moins;
                    $depense = $quantite_conso_final * $prix_unitaire;
                    $update_produit = $db->query("UPDATE produit SET quantite_restante = '$quantite_restante_final', quantite_cons='$quantite_conso_final' WHERE id_produit='$produit'");

                    //Mis à jour de la table affectation
                    $update = $db->prepare("UPDATE affectation SET id_produit_affecter='$produit', dat_actuel=NOW(), quantite_affecter='$quantite_affecte', depense='$depense', id_user_affecte='$user' WHERE id_affectation='$id_affectation'");
                    $update ->execute();
                    $success = "Felicitation, votre affectation a été bien modifiée !";
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
        $title = "Modification d'une afffectation";
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
                            <h3>Modification d'une afffectation</h3>
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
                                    <label for="nom_autorisation" class="col-sm-4 col-form-label">Produits</label>
                                    <div class="col-sm-8">
                                    <select class="form-control" id="modalite" name="produit">
                                        <option value="">selectionner un produit</option>
                                        <?php
                                            $seleProduit = $db->query('SELECT p.*, f.* FROM produit p LEFT JOIN fournisseur f ON p.id_fourni = f.id_fourni');
                                            while ($data = $seleProduit->fetch()) {
                                                if ($affectation['id_produit_affecter']== $data['id_produit']) {
                                                    ?>
                                                    <option selected value="<?= $data['id_produit'] ?>"><?= $data['nom_produit'] ?> ( <?= $data['nom_fournisseur'] ?> )</option>
                                                    <?php
                                                    } else {
                                                    ?>
                                                    <option value="<?= $data['id_produit'] ?>"><?= $data['nom_produit'] ?> ( <?= $data['nom_fournisseur'] ?> )</option>
                                                    <?php
                                                    }
                                            }
                                        ?>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nom_autorisation" class="col-sm-4 col-form-label">Gestionnaires</label>
                                    <div class="col-sm-8">
                                    <select class="form-control" id="modalite" name="user">
                                        <option value="">selectionner un gestionnaire</option>
                                        <?php
                                            $seleUtilisate = $db->query('SELECT u.*, c.abreviation FROM user u LEFT JOIN composante c ON u.id_composant = c.id_comp WHERE id_categorie = 4');
                                            while ($data = $seleUtilisate->fetch()) {

                                                if ($affectation['id_user_affecte']== $data['id_user']) {
                                                    ?>
                                                    <option selected value="<?= $data['id_user'] ?>"><?= $data['nom'].' '.$data['prenom'] ?> ( <?= $data['abreviation'] ?> )</option>
                                                    <?php
                                                    } else {
                                                    ?>
                                                    <option value="<?= $data['id_user'] ?>"><?= $data['nom'].' '.$data['prenom'] ?> ( <?= $data['abreviation'] ?> )</option>
                                                    <?php
                                                    }
                                            }
                                        ?>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="produit_nom" class="col-sm-4 col-form-label">Quantité affectée</label>
                                    <div class="col-sm-8">
                                    <input type="number" name="quantite_affecte" value="<?php echo $affectation['quantite_affecter']; ?>" class="form-control" id="produit_nom" min="0">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                      <input type="reset" class="form-control" value="Annuler">
                                    </div>
                                    <div class="col-sm-6">
                                      <input type="submit" name="affecte" class="form-control" value="Modifier">
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
            header('Location: liste_affectation.php');
        }

    }else {
        header('Location: ../index.php');
    }

}else{
    header('Location: ../index.php');
}
?> 