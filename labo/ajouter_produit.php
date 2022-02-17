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
    
        if (isset($_POST['submit'])) {
            
            if (!empty($_POST['nom_produit']) && !empty($_POST['quantite_produit']) && !empty($_POST['modalite']) && !empty($_POST['prix_achat']) && !empty($_POST['fournisseur']) && !empty($_POST['date_achat']) && !empty($_POST['seuille'])) {
            
                $nom_produit = htmlspecialchars($_POST['nom_produit']);
                $quantite_produit = htmlspecialchars($_POST['quantite_produit']);
                $prix_achat = htmlspecialchars($_POST['prix_achat']);
                $fournisseur = htmlspecialchars($_POST['fournisseur']);
                $date_achat = htmlspecialchars($_POST['date_achat']);
                $id_modalite = htmlspecialchars($_POST['modalite']);

                $seuille = htmlspecialchars($_POST['seuille']);

                $quantite_restante = $quantite_produit;
                $quantite_cons = 0;
                $prix_unitaire = $prix_achat/$quantite_produit;
                
                $select = $db->prepare('SELECT * FROM produit WHERE nom_produit=? AND id_fourni=?');
                $select ->execute(array($nom_produit, $fournisseur));
                $produitexiste=$select->rowCount();
                    
                if ($produitexiste == 1) {
                    $erreur = '<p> Ce produit avec ce fournisseur existe déjà.<br>Veuillez ajouter sa quantité seulment sur <a href="liste_produit.php">la liste des produits</a> ! </p>';
                }else {

                    if (isset($_POST['num_cheque']) && isset($_POST['date_cheque'])) {

                        $num_cheque = htmlspecialchars($_POST['num_cheque']);
                        $date_cheque = htmlspecialchars($_POST['date_cheque']);
                        $insert = $db->prepare("INSERT INTO produit (nom_produit, quantite_produit, prix_achat, id_fourni, date_achat, date_enreg, prix_unitaire, quantite_restante, quantite_cons, id_modalite, seuille, num_cheque, date_cheque) VALUES ('$nom_produit', '$quantite_produit', '$prix_achat', '$fournisseur', '$date_achat', NOW(), '$prix_unitaire', '$quantite_restante', '$quantite_cons', '$id_modalite', '$seuille', '$num_cheque', '$date_cheque')");
                        $insert->execute();
                        $success = "Félicitation, Nouveau produit enregistré !";

                    }elseif (isset($_POST['num_compte'])) {

                        $num_compte = htmlspecialchars($_POST['num_compte']);
                        $insert = $db->prepare("INSERT INTO produit (nom_produit, quantite_produit, prix_achat, id_fourni, date_achat, date_enreg, prix_unitaire, quantite_restante, quantite_cons, id_modalite, seuille, num_compte) VALUES ('$nom_produit', '$quantite_produit', '$prix_achat', '$fournisseur', '$date_achat', NOW(), '$prix_unitaire', '$quantite_restante', '$quantite_cons', '$id_modalite', '$seuille', '$num_compte')");
                        $insert->execute();
                        $success = "Félicitation, Nouveau produit enregistré !";

                    }else{

                        $insert = $db->prepare("INSERT INTO produit (nom_produit, quantite_produit, prix_achat, id_fourni, date_achat, date_enreg, prix_unitaire, quantite_restante, quantite_cons, id_modalite, seuille) VALUES ('$nom_produit', '$quantite_produit', '$prix_achat', '$fournisseur', '$date_achat', NOW(), '$prix_unitaire', '$quantite_restante', '$quantite_cons', '$id_modalite', '$seuille')");
                        $insert->execute();
                        $success = "Félicitation, Nouveau produit enregistré !";

                    }
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
        $title = "Ajout d'un produit";
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
                                <h3>Nouveau produit</h3>
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
                                        <input type="text" name="nom_produit" class="form-control" id="nom_produit">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="quantite_produit" class="col-sm-4 col-form-label">Quantité du produit acheté</label>
                                        <div class="col-sm-8">
                                        <input type="number" name="quantite_produit" class="form-control" id="quantite_produit" min="0">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="seuille" class="col-sm-4 col-form-label">Fixer une seuille</label>
                                        <div class="col-sm-8">
                                        <input type="number" name="seuille" class="form-control" id="seuille" min="0">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="modalite" class="col-sm-4 col-form-label">Modalité paiement</label>
                                        <div class="col-sm-8">
                                        <select class="form-control" id="modalite" name="modalite" onchange="charge_mod()">
                                            <option value="0">Selectionnez une modalité</option>
                                            <?php
                                                $seleMod = $db->query('SELECT * FROM modalite_paiement');
                                                while ($data = $seleMod->fetch()) {
                                                    ?>
                                                    <option value="<?= $data['id_modalite'] ?>"><?= $data['nom_modalite'] ?></option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                        </div>
                                    </div>
                                    <div id="calque_mod">
                                        
                                    </div>
                                    <div class="form-group row">
                                        <label for="fournisseur" class="col-sm-4 col-form-label">Fournisseurs</label>
                                        <div class="col-sm-8">
                                        <select class="form-control" id="fournisseur" name="fournisseur">
                                            <option value="">Selectionnez une fournisseur</option>
                                            <?php
                                                $seleCat = $db->query("SELECT * FROM fournisseur WHERE id_user='$id_user'");
                                                while ($data = $seleCat->fetch()) {
                                                    ?>
                                                    <option value="<?= $data['id_fourni'] ?>"><?= $data['nom_fournisseur'] ?></option>
                                                    <?php
                                                }
                                            ?>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="date_achat" class="col-sm-4 col-form-label">Date d'achat</label>
                                        <div class="col-sm-8">
                                        <input type="date" name="date_achat" class="form-control" id="date_achat">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                        <input type="reset" class="form-control" value="Annuler">
                                        </div>
                                        <div class="col-sm-6">
                                        <input type="submit" name="submit" class="form-control" value="Enregistrer">
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
                show += '<input type="number" name="prix_achat" class="form-control" id="prix_achat" min="0">';
                show += '</div>';
                show += '</div>';

                document.getElementById("calque_mod").innerHTML = show;
            }else if (modalite == "2" || modalite == "3") {
                show = '<div class="form-group row">';
                show +='<label for="num_cheque" class="col-sm-4 col-form-label">par cheque : num cheque</label>';
                show += '<div class="col-sm-8">';
                show += '<input type="number" name="num_cheque" class="form-control" id="num_cheque" min="0">';
                show += '</div>';
                show += '</div>';

                show += '<div class="form-group row">';
                show +='<label for="date_cheque" class="col-sm-4 col-form-label">Date du cheque</label>';
                show += '<div class="col-sm-8">';
                show += '<input type="date" name="date_cheque" class="form-control" id="date_cheque" min="0">';
                show += '</div>';
                show += '</div>';
                
                show += '<div class="form-group row">';
                show += '<label for="prix_achat" class="col-sm-4 col-form-label">Prix d\'achats</label>';
                show += '<div class="col-sm-8">';
                show += '<input type="number" name="prix_achat" class="form-control" id="prix_achat" min="0">';
                show += '</div>';
                show += '</div>';
                
                document.getElementById("calque_mod").innerHTML = show;
            }else if(modalite == "4"){
                show = '<div class="form-group row">';
                show +='<label for="num_compte" class="col-sm-4 col-form-label">Numero de compte de destinataire</label>';
                show += '<div class="col-sm-8">';
                show += '<input type="number" name="num_compte" class="form-control" id="num_compte" min="0">';
                show += '</div>';
                show += '</div>';

                show += '<div class="form-group row">';
                show += '<label for="prix_achat" class="col-sm-4 col-form-label">Prix d\'achats</label>';
                show += '<div class="col-sm-8">';
                show += '<input type="number" name="prix_achat" class="form-control" id="prix_achat" min="0">';
                show += '</div>';
                show += '</div>';

                document.getElementById("calque_mod").innerHTML = show;
            }else{
                show = '<p style="color:red;"> Veuillez selectionner une modalité </p>';
                document.getElementById("calque_mod").innerHTML = show;
            }
        }
    </script>
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