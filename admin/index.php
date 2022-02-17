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

            // $select_produit = $db->query("SELECT  COUNT(id_comp) AS totalcompo FROM composante");
            // $select_produit->execute();
            // $data = $select_produit->fetch();

            // $select_produit = $db->query("SELECT  COUNT(id_user) AS nbradmin FROM user ");
            // $select_produit->execute();
            // $datas = $select_produit->fetch();

            // $select_tproduit = $db->query("SELECT * FROM user ORDER BY date_enr LIMIT 0,3");
            // $select_tproduit->execute();


            // $select_login = $db->query("SELECT * FROM enligne");
            // $exist = $select_login->rowCount();
    
    ?>
    <!DOCTYPE html>
    <html>
    <!--Head-->
    <?php
    $logo = "index.php";
    $nav = "";
    $title="Welcome in administration";
     include('../include/head.php');
     ?>
    <body>
            <!--Header-->
            <?php include('../include/header.php');?>
            <?php include('menu/menu.php');?>
            <div class="container-fluid" id="index_titre">
                <h2>Bienvenue dans <strong>Alpha</strong></h2>
                <div class="row" id="index_show">
                    <div class="col-sm-4">
                        <div id="lot">
                            <div>
                               <svg width="2.8em" height="2.8em" viewBox="0 0 16 16" class="bi bi-sort-numeric-up-alt" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                               <path fill-rule="evenodd" d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                                </svg>
                            </div>
                            <div>
                                <h5>Nombre d' Utilisateurs</h5>
                                <h3><?php echo $datas['nbradmin'];?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div id="lot">
                            <div>
                                <svg width="2.8em" height="2.8em" viewBox="0 0 16 16" class="bi bi-sort-numeric-up-alt" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                   <path fill-rule="evenodd" d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                                </svg>
                            </div>
                            <div>
                                <h5>Utilisateurs connectés</h5>
                                <h3><?php echo $exist;?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                    <div id="lot">
                            <div>
                               <svg width="2.8em" height="2.8em" viewBox="0 0 16 16" class="bi bi-sort-numeric-up-alt" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                               <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5z"/>
                                    <path d="M1.713 11.865v-.474H2c.217 0 .363-.137.363-.317 0-.185-.158-.31-.361-.31-.223 0-.367.152-.373.31h-.59c.016-.467.373-.787.986-.787.588-.002.954.291.957.703a.595.595 0 0 1-.492.594v.033a.615.615 0 0 1 .569.631c.003.533-.502.8-1.051.8-.656 0-1-.37-1.008-.794h.582c.008.178.186.306.422.309.254 0 .424-.145.422-.35-.002-.195-.155-.348-.414-.348h-.3zm-.004-4.699h-.604v-.035c0-.408.295-.844.958-.844.583 0 .96.326.96.756 0 .389-.257.617-.476.848l-.537.572v.03h1.054V9H1.143v-.395l.957-.99c.138-.142.293-.304.293-.508 0-.18-.147-.32-.342-.32a.33.33 0 0 0-.342.338v.041zM2.564 5h-.635V2.924h-.031l-.598.42v-.567l.629-.443h.635V5z"/>
                                </svg>
                            </div>
                            <div>
                                <h5>Total Composante</h5>
                                <h3><?php echo $data['totalcompo'];?></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <?php
                        $seuille = 5;
                            while ($datat = $select_tproduit->fetch()) {
                                ?>
                                <div class="col-sm-3 col-sm-offset-1" id="index_produit">
                                    <h5>Login: <strong><?php echo $datat['login']; ?></strong></h5>
                                    <h6>Prenom: <?php echo $datat['nom']; ?></h6>
                                    <h6>Nom: <?php echo $datat['prenom']; ?> </h6>
                                    
                                </div>
                                <?php
                            }
                        ?>
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