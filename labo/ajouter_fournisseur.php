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
            
            if (!empty($_POST['nom_fournisseur']) && !empty($_POST['adresse_fournisseur']) && !empty($_POST['garantie']) && !empty($_POST['telephone'])) {
            
                $nom_fournisseur = htmlspecialchars($_POST['nom_fournisseur']);
                $adresse_fournisseur = htmlspecialchars($_POST['adresse_fournisseur']);
                $garantie = htmlspecialchars($_POST['garantie']);
                $telephone = htmlspecialchars($_POST['telephone']);
                $email = htmlspecialchars($_POST['email']);
                
                $select = $db->prepare('SELECT * FROM fournisseur WHERE nom_fournisseur=? ');
                $select ->execute(array($nom_fournisseur));
                $produitexiste=$select->rowCount();
                    
                if ($produitexiste == 1) {
                    $erreur = 'Ce fournisseur existe déja';
                }else {
                    
                    $insert = $db->prepare("INSERT INTO fournisseur (nom_fournisseur, adresse_fournisseur, garantie, telephone, e_mail, id_user, date_enreg) VALUES ('$nom_fournisseur', '$adresse_fournisseur', '$garantie', '$telephone', '$email', '$id_user',NOW())");
                    $insert->execute();
                    $success = "Félicitation, Nouveau fournisseur ajouté !";
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
        $nav = "fournisseur";
        $title = "Nouveau enregistrement d'un fournisseur";
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
                                <h3>Nouveau Fournisseur</h3>
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
                                        <label for="nom_fournisseur" class="col-sm-4 col-form-label">Nom Fournisseur</label>
                                        <div class="col-sm-8">
                                        <input type="text" name="nom_fournisseur" class="form-control" id="nom_fournisseur">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="adresse_fournisseur" class="col-sm-4 col-form-label">Adresse Fournisseur</label>
                                        <div class="col-sm-8">
                                        <input type="text" name="adresse_fournisseur" class="form-control" id="adresse_fournisseur">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="email" class="col-sm-4 col-form-label">Adresse E-mail</label>
                                        <div class="col-sm-8">
                                        <input type="email" name="email" class="form-control" id="email">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="garantie" class="col-sm-4 col-form-label">Garantie</label>
                                        <div class="col-sm-8">
                                        <input type="text" name="garantie" class="form-control" id="garantie">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="telephone" class="col-sm-4 col-form-label">Numero télephone</label>
                                        <div class="col-sm-8">
                                        <input type="tel" name="telephone" class="form-control" id="telephone">
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