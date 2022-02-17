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

            if (isset($_GET['action'])) {
                $id_produit = htmlspecialchars($_GET['id_produit']);
                $select_produit = $db->query("SELECT p.*, m.*, f.* FROM produit p 
                                                LEFT JOIN modalite_paiement m ON p.id_modalite = m.id_modalite
                                                LEFT JOIN fournisseur f ON p.id_fourni = f.id_fourni
                                                WHERE id_produit='$id_produit'");
                $data = $select_produit->fetch();
    
            if (isset($_POST['submit'])) {
                
                if (!empty($_POST['nom_produit']) && !empty($_POST['quantite_produit']) && !empty($_POST['prix_achat']) && !empty($_POST['modalite']) && !empty($_POST['date_achat']) && !empty($_POST['seuille'])) {
                
                    $nom_produit = htmlspecialchars($_POST['nom_produit']);
                    $quantite_produit = htmlspecialchars($_POST['quantite_produit']);
                    $prix_achat = htmlspecialchars($_POST['prix_achat']);
                    $date_achat = htmlspecialchars($_POST['date_achat']);
                    $id_modalite = htmlspecialchars($_POST['modalite']);
                

                    $seuille = htmlspecialchars($_POST['seuille']);

                    $prix_unitaire = $prix_achat/$quantite_produit;
                    $quantite_cons = 0;
                    
                    $select = $db->prepare('SELECT * FROM produit WHERE nom_produit=? ');
                    $select ->execute(array($nom_produit));
                    $produitexiste=$select->rowCount();
                    $donne = $select->fetch();
                    $quantite_restante_init = $donne['quantite_restante'];
                    $montant_init = $donne['prix_achat'];
                    $id_produit_affecter = $donne['id_produit'];
                    $prix_unit = $donne['prix_unitaire'];
                    $quantite_conso = $donne['quantite_cons'];
                    $montant_consomme = $prix_unit* $quantite_conso;
                    $montant_restant = $montant_init - $montant_consomme;
                    $montant_final = $montant_restant + $prix_achat;
                    $quantite_restante_final = $quantite_produit + $quantite_restante_init;

                    //Verification d'un produit existant dans la table affectation
                    $select_verify = $db->query("SELECT * FROM affectation WHERE id_produit_affecter='$id_produit_affecter' ");
                    $produit_affecter_existe = $select_verify->rowCount();
                        
                    if ($produitexiste == 0) {
                        $erreur = "Ce produit n'existe pas sur la liste. Veuillez l'ajouter à la <a href='ajouter_produit.php'>page d'enregistrement</a>";
                    }else if ($produitexiste == 1 || $produit_affecter_existe == 1){

                        if (isset($_POST['num_cheque']) && isset($_POST['date_cheque'])) {

                            $num_cheque = htmlspecialchars($_POST['num_cheque']);
                            $date_cheque = htmlspecialchars($_POST['date_cheque']);
                            $update = $db->prepare("UPDATE produit SET quantite_produit='$quantite_restante_final', prix_achat = '$montant_final', date_achat='$date_achat', date_enreg=NOW(), prix_unitaire='$prix_unitaire', quantite_restante='$quantite_restante_final', quantite_cons='$quantite_cons', id_modalite='$id_modalite', seuille='$seuille', num_cheque='$num_cheque', date_cheque='$date_cheque' WHERE id_produit='$id_produit' ");
                            $update->execute();
                            $success = "Félicitation, la quantité a été bien rajoutée !";

                        }elseif (isset($_POST['num_compte'])) {

                            $num_compte = htmlspecialchars($_POST['num_compte']);
                            $update = $db->prepare("UPDATE produit SET quantite_produit='$quantite_restante_final', prix_achat = '$montant_final', date_achat='$date_achat', date_enreg=NOW(), prix_unitaire='$prix_unitaire', quantite_restante='$quantite_restante_final', quantite_cons='$quantite_cons', id_modalite='$id_modalite', seuille='$seuille', num_compte='$num_compte' WHERE id_produit='$id_produit' ");
                            $update->execute();
                            $success = "Félicitation, la quantité a été bien rajoutée !";
                        }else {
                            $update = $db->prepare("UPDATE produit SET quantite_produit='$quantite_restante_final', prix_achat = '$montant_final', date_achat='$date_achat', date_enreg=NOW(), prix_unitaire='$prix_unitaire', quantite_restante='$quantite_restante_final', quantite_cons='$quantite_cons', id_modalite='$id_modalite', seuille='$seuille' WHERE id_produit='$id_produit' ");
                            $update->execute();
                            $success = "Félicitation, la quantité a été bien rajoutée !";
                        }
                    }

                }else{
                    $erreur ="Tout les champs doivent être complétée";
                }
            }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <!--Head-->
    <?php
        $logo = "index.php";
        $nav = "produit";
        $title = "Rajout d'une quantitè"; 
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
                                <h3>Rajout d'une quantitè</h3>
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
                                        <label for="nom_produit" class="col-sm-4 col-form-label">Nom du produit</label>
                                        <div class="col-sm-8">
                                        <input type="text" readonly name="nom_produit" class="form-control" id="nom_produit" value="<?php echo $data['nom_produit'];?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="quantite_produit" class="col-sm-4 col-form-label">Quantité du produit acheté</label>
                                        <div class="col-sm-8">
                                        <input type="number" name="quantite_produit" class="form-control" id="quantite_produit" value="<?php echo $data['quantite_restante'];?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="seuille" class="col-sm-4 col-form-label">Fixer une seuille</label>
                                        <div class="col-sm-8">
                                        <input type="number" name="seuille" class="form-control" id="seuille" min="0" value="<?php echo $data['seuille'];?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="modalite" class="col-sm-4 col-form-label">Modalité paiement</label>
                                        <div class="col-sm-8">
                                        <select class="form-control" id="modalite" name="modalite" onchange="charge_mod()">
                                            <option value="">Selectionnez une modalité</option>
                                            <?php
                                                $seleMod = $db->query('SELECT * FROM modalite_paiement');
                                                while ($modalite = $seleMod->fetch()) {
                                                    if ($modalite['id_modalite'] == $data['id_modalite']) {
                                                
                                                        ?>
                                                        <option selected value="<?= $modalite['id_modalite'] ?>"><?= $modalite['nom_modalite'] ?></option>
                                                        <?php
                                                        }else {
                                                        ?>
                                                        <option value="<?= $modalite['id_modalite'] ?>"><?= $modalite['nom_modalite'] ?></option>
                                                        <?php
                                                        }
                                                }
                                            ?>
                                        </select>
                                        </div>
                                    </div>
                                    <div id="calque_mod">
                                        
                                    </div>
                                    <div class="form-group row">
                                        <label for="date_achat" class="col-sm-4 col-form-label">Date d'achat</label>
                                        <div class="col-sm-8">
                                        <input type="date" name="date_achat" class="form-control" id="date_achat" value="<?php echo $data['date_achat'];?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                        <input type="reset" class="form-control" value="Annuler">
                                        </div>
                                        <div class="col-sm-6">
                                        <input type="submit" name="submit" class="form-control" value="Rajouter">
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
    <script type="text/javascript" language="javascript">
        function charge_mod() {
            var modalite = document.getElementById("modalite").value;
            if(modalite == "1"){
                show = '<div class="form-group row">';
                show += '<label for="prix_achat" class="col-sm-4 col-form-label">Prix d\'achats</label>';
                show += '<div class="col-sm-8">';
                show += '<input type="number" name="prix_achat" class="form-control" id="prix_achat" value="<?php echo $data['prix_achat'];?>" min="0">';
                show += '</div>';
                show += '</div>';

                document.getElementById("calque_mod").innerHTML = show;
            }else if (modalite == "2" || modalite == "3") {
                show = '<div class="form-group row">';
                show +='<label for="num_cheque" class="col-sm-4 col-form-label">par cheque : num cheque</label>';
                show += '<div class="col-sm-8">';
                show += '<input type="number" name="num_cheque" class="form-control" id="num_cheque" value="<?php echo $data['num_cheque'];?>" min="0">';
                show += '</div>';
                show += '</div>';

                show += '<div class="form-group row">';
                show +='<label for="date_cheque" class="col-sm-4 col-form-label">Date du cheque</label>';
                show += '<div class="col-sm-8">';
                show += '<input type="date" name="date_cheque" class="form-control" id="date_cheque" value="<?php echo $data['date_cheque'];?>">';
                show += '</div>';
                show += '</div>';
                
                show += '<div class="form-group row">';
                show += '<label for="prix_achat" class="col-sm-4 col-form-label">Prix d\'achats</label>';
                show += '<div class="col-sm-8">';
                show += '<input type="number" name="prix_achat" class="form-control" id="prix_achat" value="<?php echo $data['prix_achat'];?>" min="0">';
                show += '</div>';
                show += '</div>';
                
                document.getElementById("calque_mod").innerHTML = show;
            }else if(modalite == "4"){
                show = '<div class="form-group row">';
                show +='<label for="num_compte" class="col-sm-4 col-form-label">Numero de compte de destinataire</label>';
                show += '<div class="col-sm-8">';
                show += '<input type="number" name="num_compte" class="form-control" id="num_compte" value="<?php echo $data['num_compte'];?>" min="0">';
                show += '</div>';
                show += '</div>';

                show += '<div class="form-group row">';
                show += '<label for="prix_achat" class="col-sm-4 col-form-label">Prix d\'achats</label>';
                show += '<div class="col-sm-8">';
                show += '<input type="number" name="prix_achat" class="form-control" id="prix_achat" value="<?php echo $data['prix_achat'];?>" min="0">';
                show += '</div>';
                show += '</div>';

                document.getElementById("calque_mod").innerHTML = show;
            }else{
                show = '<div class="col-sm-12">';
                show += '<p style="color:red; text-align:right;">Veuillez selectionner une modalité!</p>';
                show += '</div>';
                document.getElementById("calque_mod").innerHTML = show;
            }
        }
    </script>
    <?php include('../include/js_footer.php');?>    
    </html>
<?php 
     }else {
         header('Location: liste_produit.php');
     }

    }else {
        header('Location: ../index.php');
    }

}else{
    header('Location: ../index.php');
}
?> 