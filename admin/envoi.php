<?php 
    session_start();
    include('../include/connexion.php');
    if (isset($_SESSION['id_user'])) {

        if ($_SESSION['id_categorie'] == 1) {

            $id_user = $_SESSION['id_user'];
            $selct = $db->prepare('SELECT u.*, c.libelle, cp.nom_comp FROM user u
                                    LEFT JOIN categorie c ON u.id_categorie = c.id_cat
                                    LEFT JOIN composante cp ON u.id_composant = cp.id_comp
                                    WHERE id_user = ?');
            $selct ->execute(array($id_user));
            $affiche = $selct->fetch();
    
        if (isset($_POST['envoi_message'])) {
            
            if (isset($_POST['destinataire'], $_POST['message'], $_POST['objectif']) AND !empty($_POST['destinataire']) AND !empty($_POST['message']) AND !empty($_POST['objectif'])) {
                
                $destinataire = htmlspecialchars($_POST['destinataire']);
                $messages = htmlspecialchars($_POST['message']);
                $objectif = htmlspecialchars($_POST['objectif']);

                $id_destinataire = $db->prepare('SELECT id_user FROM user WHERE login = ? ');
                $id_destinataire->execute(array($destinataire));
                $des_exist = $id_destinataire ->rowCount();

                if ($des_exist == 1) {

                    $id_destinataire = $id_destinataire->fetch();
                    $id_destinataire = $id_destinataire['id_user'];
                    $insert  = $db->prepare("INSERT INTO messages(id_expediteur,id_destinataire,messageries,date_envoye,objectif) VALUES(?, ?, ?, NOW(),?)");
                    $insert -> execute(array($_SESSION['id_user'], $id_destinataire, $messages, $objectif));

                    $success = "Votre message a bien été envoyé !";
                }else{

                    $erreur = "Cet utilisateur n'existe pas ... ";
                }

                
            }else{

                $erreur = "Veuillez compléter tous les champs ";
            }
        }
        // LEFT JOIN composante c ON u.id_composant = c.id_comp
        $destinataires = $db->query('SELECT u.login,u.nom,u.prenom,c.abreviation,Ct.libelle FROM user u 
                                        LEFT JOIN categorie Ct ON u.id_categorie = Ct.id_cat
                                        LEFT JOIN composante c ON u.id_composant = c.id_comp
                                        ORDER BY login');
    ?>
    <!DOCTYPE html>
    <html>
    <!--Head-->
    <?php
        $logo = "index.php";
        $nav = "envoi";
        $title = "Envoi de message";
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
                                <h3>Nouveau messager</h3>
                                <?php if (isset($erreur)) { ?>
                                    <div class="container">
                                        <div class="row">
                                        <div class="alert alert-danger col-sm-12" role="alert" style="text-align:center;">
                                            <p><?= '<span style ="color:red">'.$erreur.'</pan>'; ?></p>
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
                                        <label for="destinataire" class="col-sm-4 col-form-label">Destinataire :</label>
                                        <div class="col-sm-8">
                                            <select class="form-control" id="destinataire" name="destinataire">
                                            <?php
                                                while ($d = $destinataires->fetch()) {
                                                    ?>
                                                    <option value="<?= $d['login']?>"><?= $d['nom'].' '.$d['prenom'].' ( '. $d['libelle'] .' '. $d['abreviation'] .') ' ?></option>
                                                    <?php
                                                }
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="objectif" class="col-sm-4 col-form-label">Objectif</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="objectif" class="form-control" id="objectif" placeholder="Ram A4">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="message" class="col-sm-4 col-form-label">Message envoyer</label>
                                        <div class="col-sm-8">
                                            <textarea name="message" id="message" cols="50" rows="3"  placeholder="Votre message"></textarea>
                                            <!-- <input type="text" name="adresse_fournisseur" class="form-control" id="adresse_fournisseur"> -->
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <input type="reset" class="form-control" value="Annuler">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="submit" name="envoi_message" class="form-control" value="Envoyer le message">
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