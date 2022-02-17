<?php 
    session_start();
    include('../include/connexion.php');
    if (isset($_SESSION['id_user'])) {
        if ($_SESSION['id_categorie']==2) {

        $id_user = $_SESSION['id_user'];
        $selct = $db->prepare('SELECT u.*, c.libelle, cp.nom_comp FROM user u
                                LEFT JOIN categorie c ON u.id_categorie = c.id_cat
                                LEFT JOIN composante cp ON u.id_composant = cp.id_comp
                                WHERE id_user = ?');
        $selct ->execute(array($id_user));
        $affiche = $selct->fetch();

        $select_produit = $db->query("SELECT COUNT(nom_produit) AS nbrproduit, SUM(quantite_produit) AS qut_total, SUM(prix_achat) AS montant FROM produit");
        $select_produit->execute();
        $data = $select_produit->fetch();

        $select_tproduit = $db->query("SELECT p.*,f.nom_fournisseur FROM produit p LEFT JOIN fournisseur f ON p.id_fourni = f.id_fourni WHERE p.seuille > p.quantite_restante ");
        $select_tproduit->execute();

    ?>
    <!DOCTYPE html>
    <html>
    <!--Head-->
    <?php
        $logo = "index.php";
        $nav = "";
        $title = "Service comptabilité";
        include('../include/head.php');
     ?>
    <body>
            <!--Header-->
            <?php include('../include/header.php');?>
            <!--Navigation-->
            <?php include('menu/menu.php');?>
            <div class="container-fluid" id="index_titre">
                <h2>Bienvenue dans <strong>Alpha</strong></h2>
                <div class="row" id="index_show">
                    <div class="col-sm-4">
                        <div id="lot">
                            <div>
                                <svg width="2.8em" height="2.8em" viewBox="0 0 16 16" class="bi bi-list-ol" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5z"/>
                                    <path d="M1.713 11.865v-.474H2c.217 0 .363-.137.363-.317 0-.185-.158-.31-.361-.31-.223 0-.367.152-.373.31h-.59c.016-.467.373-.787.986-.787.588-.002.954.291.957.703a.595.595 0 0 1-.492.594v.033a.615.615 0 0 1 .569.631c.003.533-.502.8-1.051.8-.656 0-1-.37-1.008-.794h.582c.008.178.186.306.422.309.254 0 .424-.145.422-.35-.002-.195-.155-.348-.414-.348h-.3zm-.004-4.699h-.604v-.035c0-.408.295-.844.958-.844.583 0 .96.326.96.756 0 .389-.257.617-.476.848l-.537.572v.03h1.054V9H1.143v-.395l.957-.99c.138-.142.293-.304.293-.508 0-.18-.147-.32-.342-.32a.33.33 0 0 0-.342.338v.041zM2.564 5h-.635V2.924h-.031l-.598.42v-.567l.629-.443h.635V5z"/>
                                </svg>
                            </div>
                            <div>
                                <h5>Nombre Total produit</h5>
                                <h3><?php echo $data['nbrproduit'];?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div id="lot">
                            <div>
                               <svg width="2.8em" height="2.8em" viewBox="0 0 16 16" class="bi bi-sort-numeric-up-alt" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M4 14a.5.5 0 0 0 .5-.5v-11a.5.5 0 0 0-1 0v11a.5.5 0 0 0 .5.5z"/>
                                    <path fill-rule="evenodd" d="M6.354 4.854a.5.5 0 0 0 0-.708l-2-2a.5.5 0 0 0-.708 0l-2 2a.5.5 0 1 0 .708.708L4 3.207l1.646 1.647a.5.5 0 0 0 .708 0z"/>
                                    <path d="M9.598 5.82c.054.621.625 1.278 1.761 1.278 1.422 0 2.145-.98 2.145-2.848 0-2.05-.973-2.688-2.063-2.688-1.125 0-1.972.688-1.972 1.836 0 1.145.808 1.758 1.719 1.758.69 0 1.113-.351 1.261-.742h.059c.031 1.027-.309 1.856-1.133 1.856-.43 0-.715-.227-.773-.45H9.598zm2.757-2.43c0 .637-.43.973-.933.973-.516 0-.934-.34-.934-.98 0-.625.407-1 .926-1 .543 0 .941.375.941 1.008zM12.438 14V8.668H11.39l-1.262.906v.969l1.21-.86h.052V14h1.046z"/>
                                </svg>
                            </div>
                            <div>
                                <h5>Quantité Total produit</h5>
                                <h3><?php echo $data['qut_total'];?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div id="lot">
                            <div id="dolar">
                                <h3>$</h3>
                            </div>
                            <div id="montant">
                                <h5>Montant Total Produits</h5>
                                <h4><?php echo $data['montant'];?> KMF</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                <?php 
                $compte = $select_tproduit->rowCount();
                if ($compte > 0) {
                
                 ?>
                    <h2>Produits en etat de seuille</h2>
                        <div class="row" id="index_sho">
                            <?php
                                while ($datat = $select_tproduit->fetch()) {
                                    
                                ?>
                                <div class="col-sm-3 col-sm-offset-1" id="index_seuille">
                                    <h5><?php echo $datat['nom_produit']; ?></h5>
                                    <h6>Quantité : <?php echo $datat['quantite_produit']; ?></h6>
                                    <h6>Quantite restante : <span style="font-size:18px; font-weight:800;"><?php echo $datat['quantite_restante']; ?></span></h6>
                                    <h6>Montant : <?php echo $datat['prix_achat']; ?> KMF</h6>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                <?php 
                }
                 ?>
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