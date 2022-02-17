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

        if (isset($_GET['action']) && isset($_GET['id_cheque']) && $_GET['action'] == "delete") {
            $id_cheque = htmlspecialchars($_GET['id_cheque']);
            $num_cheque = htmlspecialchars($_GET['num_cheque']);
    ?>
    <!DOCTYPE html>
    <html>
    <!--Head-->
    <?php
        $logo = "index.php";
        $nav = 'cheque';
        $title = "Suppression d'un chèque";
        include('../include/head.php');
     ?>
    <body>
    <!--Header-->
    <?php include('../include/header.php');?>
    <?php include('menu/menu.php');?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12" id="supprimer_show">
                <h5>Voulez vous supprimer le chèque  <?php echo $num_cheque; ?> ?</h5>
                <h6><a href="?action=del&amp;id=<?php echo $id_cheque; ?>">Oui</a> ou <a href="liste_cheque.php">Non</a></h6>
            </div>
        </div>
    </div>

    </body>
    <!--Js Footer-->
    <?php include('../include/js_footer.php');?>    
    </html>
<?php 
        }elseif (isset($_GET['action'])) {
            if ($_GET['action']=='del') {
                $id = $_GET['id'];
                
                $delete = $db->query("DELETE FROM cheque WHERE id_cheque='$id'");
                header('Location: liste_cheque.php');
            }else {
                header('Location: liste_cheque.php');
            }
        }else {
            header('Location: liste_cheque.php');
        }

    }else {
        header('Location: ../index.php');
    }

}else{
    header('Location: ../index.php');
}
?> 