<?php 
    session_start();
    include('../include/connexion.php');
    if (isset($_SESSION['id_user'])) {

        if ($_SESSION['id_categorie']== 1) {

            $id_user = $_SESSION['id_user'];
            $selct = $db->prepare('SELECT u.*, c.libelle, cp.nom_comp FROM user u
                                    LEFT JOIN categorie c ON u.id_categorie = c.id_cat
                                    LEFT JOIN composante cp ON u.id_composant = cp.id_comp
                                    WHERE id_user = ?');
            $selct ->execute(array($id_user));
            $affiche = $selct->fetch();

            if (isset($_GET['id_message']) && isset($_GET['id_Exp']) && !empty($_GET['id_message']) && !empty($_GET['id_Exp'])) {
                
                $id_message = htmlspecialchars($_GET['id_message']);
            $id_Exp = htmlspecialchars($_GET['id_Exp']);
            $msg = $db->prepare('SELECT *,DATE_FORMAT(date_envoye, "Le %d/%m/%Y à %hH : %imin") AS date_envoye
                                FROM messages WHERE id_expediteur = ? AND id = ? ORDER BY date_envoye DESC');
            $msg ->execute(array($id_Exp, $id_message));

            // ON COMPTE LE NOMBRE DE MESSAGE ENVOYER
            $msg_nbr = $msg ->rowCount();
            //Reglage de notification
        $lu = 1;
        $message_lu = $db->query("UPDATE messages SET lu ='$lu' WHERE id = '$id_message'");
            if (isset($_POST['repond_message'])) {
                
                if (isset($_POST['message'], $_POST['objectif']) AND !empty($_POST['message']) AND !empty($_POST['objectif'])) {
                    
                    $messages = htmlspecialchars($_POST['message']);
                    $objectif = htmlspecialchars($_POST['objectif']);


                    $insert  = $db->prepare("INSERT INTO messages(id_expediteur,id_destinataire,messageries,date_envoye,objectif) VALUES(?, ?, ?, NOW(),?)");
                    $insert -> execute(array($_SESSION['id_user'], $id_Exp, $messages, $objectif));

                    $success = "Votre message a bien été envoyé !";

                    
                }else{

                    $erreur = "Veuillez compléter tous les champs ";
                }
            }
            
    ?>
    <!DOCTYPE html>
    <html>
    <!--Head-->
    <?php
        $logo = "index.php";
        $nav = "reception_msg";
        $title = "Boîte de réception";
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
                                <h3>Boîte de réception</h3>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <?php
                                                
                                                $m = $msg->fetch();
                                                $login_Exp = $db->prepare("SELECT nom,prenom,id_user FROM user WHERE id_user = ?");
                                                $login_Exp -> execute(array($id_Exp));
                                                $login_Exp = $login_Exp -> fetch();
                                                $id_Expe = $login_Exp['id_user'];

                                                $nom_Exp = $login_Exp['nom'];
                                                $prenom_Exp = $login_Exp['prenom'];
                                        ?>
                                        <div style="margin: 15px 0px;">
                                         
                                        <b><h4><?= $nom_Exp.' '.$prenom_Exp ?></h4></b> Vous a envoyé : <br>
                                            <div style="background: #808080; color: #FFFFFF; padding: 5px 8px;border-radius: 10px;">
                                                <p>
                                                    <?= nl2br($m['messageries']).' </br> </br> '.'<span style="float:right; margin: -10px 5px;">'.
                                                    $m['date_envoye'].'
                                                </span>'  ?>
                                                </p>
                                            </div>
                                        </div>
                                        <!-- FORMULAIRE DE REPOND -->
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
                                        <h4>Répondre à ce message</h4>

                                        <form method="post">
                                            <div class="form-group row">
                                                <label for="objectif" class="col-sm-4 col-form-label">Objectif</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="objectif" class="form-control" id="objectif" placeholder="Ram A4">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="message" class="col-sm-4 col-form-label">Message</label>
                                                <div class="col-sm-8">
                                                    <textarea name="message" id="message" cols="50" rows="5"  placeholder="Votre message"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-6">
                                                    <input type="reset" class="form-control" value="Annuler">
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="submit" name="repond_message" class="form-control" value="Envoyer le message">
                                                </div>
                                            </div>
                                        </form>   
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <!-- actualise les messages -->
             
    </body>
    <!--Js Footer-->
    <?php include('../include/js_footer.php');?>    
    </html>
<?php 
         } else {
            header('Location: reception_msg.php');
        }
    }else {
        header('Location: ../index.php');
    }

}else{
    header('Location: ../index.php');
}
?> 