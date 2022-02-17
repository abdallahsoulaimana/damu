<?php
    session_start();
    include('../include/connexion.php'); 
    $id_user = $_SESSION['id_user'];
    $msg = $db->prepare('SELECT *,DATE_FORMAT(date_envoye, "Le %d/%m/%Y à %hH : %imin") AS date_envoye FROM messages WHERE id_destinataire = ? ORDER BY id DESC');
        $msg ->execute(array($id_user));
    while ($m = $msg->fetch()) {
        $login_Exp = $db->prepare("SELECT nom,prenom,id_user FROM user WHERE id_user = ?");
        $login_Exp -> execute(array($m['id_expediteur']));
        $login_Exp = $login_Exp -> fetch();
        $id_Expe = $login_Exp['id_user'];
        $id_mseg = $m['id'];
        $lu = $m['lu'];

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
<?php
    }
?> 