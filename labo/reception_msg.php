<?php 
    session_start();
    include('../include/connexion.php');
    if (isset($_SESSION['id_user'])) {

        if ($_SESSION['id_categorie']== 3) {

            $id_user = $_SESSION['id_user'];
            $selct = $db->prepare('SELECT u.*, c.libelle, cp.nom_comp FROM user u
                                    LEFT JOIN categorie c ON u.id_categorie = c.id_cat
                                    LEFT JOIN composante cp ON u.id_composant = cp.id_comp
                                    WHERE id_user = ?');
            $selct ->execute(array($id_user));
            $affiche = $selct->fetch();
        $msg = $db->prepare('SELECT *,DATE_FORMAT(date_envoye, "Le %d/%m/%Y à %hH : %imin") AS date_envoye FROM messages WHERE id_destinataire = ? ORDER BY id DESC');
        $msg ->execute(array($id_user));

        // ON COMPTE LE NOMBRE DE MESSAGE ENVOYER
        $msg_nbr = $msg ->rowCount();

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
                                    <div class="col-sm-12" id="message">
                                        <?php
                                        
                                            if ($msg_nbr == 0) {
                                                echo "Vous n'avez aucune message reuçu ...";
                                            }
                                            while ($m = $msg->fetch()) {
                                                $login_Exp = $db->prepare("SELECT nom,prenom,id_user FROM user WHERE id_user = ?");
                                                $login_Exp -> execute(array($m['id_expediteur']));
                                                $login_Exp = $login_Exp -> fetch();
                                                $id_mseg = $m['id'];
                                                $lu = $m['lu'];
                                                $id_Expe = $login_Exp['id_user'];

                                                $nom_Exp = $login_Exp['nom'];
                                                $prenom_Exp = $login_Exp['prenom'];
                                        ?>
                                        <div style="margin: 5px 0px; border-bottom: 1px dashed #808080">
                                         
                                        <p><b <?php if($lu==0){ ?> style="color:rgb(22, 196, 22);" <?php } ?>><?= $nom_Exp.' '.$prenom_Exp ?></b>&numsp;&numsp; Objectif : <b><?= $m['objectif'] ?></b>&numsp; Vous a envoyé : </p>
                                            <div style="background: #808080; color: #FFFFFF; padding: 5px 8px;border-radius: 10px;">
                                                <p>
                                                    <?= nl2br($m['messageries']).' </br> </br> '.'<span style="float:right; margin: -10px 5px;">'.
                                                    $m['date_envoye'].'
                                                </span>'  ?>
                                                </p>
                                            </div>
                                            <p><a href="envoi_select.php?id_Exp=<?= $id_Expe ?>&id_message=<?= $id_mseg ?>"><h5 style="float: right;">Répondre</h5></a></p>
                                            <br>
                                        </div>
                                        <br>
                                        <?php
                                            }
                                        ?>    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- actualise les messages -->
            <?php include('../include/actualise_page.php');?>    
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