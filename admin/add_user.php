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
            
            if ($_POST['categorie'] == 1) {
                
                if (!empty($_POST['login']) && !empty($_POST['pass']) && !empty($_POST['pass2']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['tel']) && !empty($_POST['categorie'])) {
            
                    $login = htmlspecialchars($_POST['login']);
                    $prenom = htmlspecialchars($_POST['prenom']);
                    $nom = htmlspecialchars($_POST['nom']);
                    $tel = htmlspecialchars($_POST['tel']);
                    $categorie = htmlspecialchars($_POST['categorie']);
                    $pass = sha1($_POST['pass']);
                    $pass2 = sha1($_POST['pass2']);
    
                    if ($pass == $pass2) {
                        
                        $select = $db->prepare('SELECT * FROM user WHERE login=? ');
                        $select ->execute(array($login));
                        $userexiste=$select->rowCount();
    
                        if ($userexiste == 1) {
    
                            $erreurlog = "Désolé, ce login existe déjà !";       
                        }
                        else
                        {
                            $insert = $db->prepare("INSERT INTO user (nom, prenom, tel_user, login, passwod,id_cat) VALUES ('$nom', '$prenom', '$tel', '$login', '$pass', '$categorie')");
                            $insert->execute();
    
                            $success = 'Félicitation, Nouveau utilisateur ajouté !';
                        }
    
                    }else{
    
                        $erreur_mdp = "Mauvaise mot de passe !";
                    }
    
                }else{
                    
                    $erreur ="Tout les champs doivent être complétée";
                }

            }else {
                
                if (!empty($_POST['login']) && !empty($_POST['pass']) && !empty($_POST['pass2']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['tel']) && !empty($_POST['labo']) && !empty($_POST['categorie'])) {
            
                    $login = htmlspecialchars($_POST['login']);
                    $prenom = htmlspecialchars($_POST['prenom']);
                    $nom = htmlspecialchars($_POST['nom']);
                    $tel = htmlspecialchars($_POST['tel']);
                    $categorie = htmlspecialchars($_POST['categorie']);
                    $labo = htmlspecialchars($_POST['labo']);
                    $pass = sha1($_POST['pass']);
                    $pass2 = sha1($_POST['pass2']);
    
                    if ($pass == $pass2) {
                        
                        $select = $db->prepare('SELECT * FROM user WHERE login=? ');
                        $select ->execute(array($login));
                        $userexiste=$select->rowCount();
    
                        if ($userexiste == 1) {
    
                            $erreurlog = "Désolé, ce login existe déjà !";       
                        }
                        else
                        {
                            $insert = $db->prepare("INSERT INTO user (nom, prenom, tel_user, login, passwod,id_cat, id_labo) VALUES ('$nom', '$prenom', '$tel', '$login', '$pass', '$categorie', '$labo')");
                            $insert->execute();
    
                            $success = 'Félicitation, Nouveau utilisateur ajouté !';
                        }
    
                    }else{
    
                        $erreur_mdp = "Mauvaise mot de passe !";
                    }
    
                }else{
                    
                    $erreur ="Tout les champs doivent être complétée";
                }

            }
        }
    ?>
    <!DOCTYPE html>
    <html>
    <!--Head-->
    <?php
    $logo = "index.php";
    $nav = "user";
    $title="Ajout d'un nouveau utilisateur";
     include('../include/head.php');
     ?>
    <body>
        <!--Header-->
        <?php include('../include/header.php');?>

        <!--Navigation-->
        <?php include('menu/menu.php');?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div id="login">
                        <div id="admin">
                            <h3>Création d'un compte utilisateur</h3>
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
                                    <label for="prenom" class="col-sm-4 col-form-label">Prénom</label>
                                    <div class="col-sm-8">
                                    <input type="text" name="prenom" class="form-control" id="prenom">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nom" class="col-sm-4 col-form-label">Nom</label>
                                    <div class="col-sm-8">
                                    <input type="text" name="nom" class="form-control" id="nom">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tel" class="col-sm-4 col-form-label">Téléphone</label>
                                    <div class="col-sm-8">
                                    <input type="tel" name="tel" class="form-control" id="tel">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-4 col-form-label">Username</label>
                                    <div class="col-sm-8">
                                    <input type="text" name="login" class="form-control" id="staticEmail" placeholder="admin">
                                    </div>
                                </div>
                                <div id="erreur">
                                    <p><?php if (isset($erreurlog)) {
                                        echo $erreurlog;
                                    } ?></p>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword" class="col-sm-4 col-form-label">Mot de passe</label>
                                    <div class="col-sm-8">
                                    <input type="password" name="pass" class="form-control" id="inputPassword">
                                    </div>
                                </div>
                                <div id="erreur">
                                    <p><?php if (isset($erreur_mdp)) {
                                        echo $erreur_mdp;
                                    } ?></p>
                                </div>
                                <div class="form-group row">
                                    <label for="conf" class="col-sm-4 col-form-label">Confirmer le mot de passe</label>
                                    <div class="col-sm-8">
                                    <input type="password" name="pass2" class="form-control" id="conf">
                                    </div>
                                </div>
                                <div id="erreur">
                                    <p><?php if (isset($erreur_mdp)) {
                                        echo $erreur_mdp;
                                    } ?></p>
                                </div>
                                <div class="form-group row">
                                    <label for="cat" class="col-sm-4 col-form-label">Catégorie</label>
                                    <div class="col-sm-8">
                                    <select class="form-control" id="cat" name="categorie">
                                        <option value="">Selectionnez une catégorie</option>
                                        <?php
                                            $seleCat = $db->query('SELECT * FROM categorie');
                                            while ($data = $seleCat->fetch()) {
                                                ?>
                                                <option value="<?= $data['id_cat'] ?>"><?= $data['nom_cat'] ?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="labo" class="col-sm-4 col-form-label">Laboratoire</label>
                                    <div class="col-sm-8">
                                    <select class="form-control" id="labo" name="labo">
                                        <option value="">Selectionnez un labo</option>
                                        <?php
                                            $seleCat = $db->query('SELECT * FROM labo');
                                            while ($data = $seleCat->fetch()) {
                                                ?>
                                                <option value="<?= $data['id_labo'] ?>"><?= $data['nom_labo'] ?></option>
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
                                    <input type="submit" name="submit" class="form-control" value="Créer un compte">
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