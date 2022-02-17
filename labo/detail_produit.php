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
        if (isset($_GET['action'])) {
            $id_produit = htmlspecialchars($_GET['id_produit']);
            $nom_produit = htmlspecialchars($_GET['nom_produit']);

        $selectproduit = $db->prepare("SELECT p.*, DATE_FORMAT(date_achat, '%d-%m-%Y') AS date_achat, f.*, mp.nom_modalite FROM produit p LEFT JOIN fournisseur f ON p.id_fourni=f.id_fourni LEFT JOIN modalite_paiement mp ON p.id_modalite=mp.id_modalite WHERE id_produit='$id_produit'");
        $selectproduit ->execute();
        $data = $selectproduit->fetch()
    ?>
    <!DOCTYPE html>
    <html>
    <!--Head-->
    <?php
        $logo = "index.php";
        $nav = "produit";
        $title = "Toutes les informations du produit ".$nom_produit;
        include('../include/head.php');
     ?>
    <body>
    <!--Header-->
    <?php include('../include/header.php');?>
    <?php include('menu/menu.php');?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12" id="liste_show">
                <div id="login">
                    <div id="admin" style="width: 80%;">
                        <div id='sectionAimprimer'>
                            <div style="border:1px solid black; padding:20px 20px 20px 20px ; margin-bottom:20px; background-color:white;">
                                <!--Entete du feuille-->
                                <?php include('../include/entete.php');?> 
                                <h3 style="margin-top:10px; margin-bottom:30px;text-align:center;">Toutes les informations du produit <strong><?php echo $nom_produit; ?></strong> </h3>
                                <div class="row">
                                    <div class="col-sm-4"><strong>Nom du produit</strong></div>
                                    <div class="col-sm-8"><h5><?php echo $data['nom_produit']; ?></h5></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><strong>Fournisseur</strong></div>
                                    <div class="col-sm-8"><h5><?php echo $data['nom_fournisseur']; ?></h5></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><strong>Garantie</strong></div>
                                    <div class="col-sm-8"><h5><?php echo $data['garantie']; ?></h5></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><strong>Quantité produit</strong></div>
                                    <div class="col-sm-8"><h5><?php echo $data['quantite_produit']; ?></h5></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><strong>Quantité restante</strong></div>
                                    <div class="col-sm-8"><h5><?php echo $data['quantite_restante']; ?></h5></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><strong>Prix d'achat</strong></div>
                                    <div class="col-sm-8"><h5><?php echo $data['prix_achat']; ?> KMF</h5></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><strong>Prix unitaire</strong></div>
                                    <div class="col-sm-8"><h5><?php echo $data['prix_unitaire']; ?> KMF</h5></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><strong>Date achat</strong></div>
                                    <div class="col-sm-8"><h5><?php echo $data['date_achat']; ?></h5></div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4"><strong>Modalité de paiement</strong></div>
                                    <div class="col-sm-8"><h5><?php echo $data['nom_modalite']; ?></h5></div>
                                </div>
                                <?php
                                    if ($data['num_cheque']>0) {
                                        ?>
                                    <div class="row">
                                        <div class="col-sm-4"><strong>Numero de cheque</strong></div>
                                        <div class="col-sm-8"><h5><?php echo $data['num_cheque']; ?></h5></div>
                                    </div>
                                        <?php
                                    }
                                ?>
                                <?php
                                    if ($data['date_cheque']>0) {
                                        ?>
                                    <div class="row">
                                        <div class="col-sm-4"><strong>Date du cheque</strong></div>
                                        <div class="col-sm-8"><h5><?php echo $data['date_cheque']; ?></h5></div>
                                    </div>
                                        <?php
                                    }
                                ?>
                                <?php
                                if ($data['num_compte']>0) {
                                ?>
                                    <div class="row">
                                        <div class="col-sm-4"><strong>Numero de compte destinataire</strong></div>
                                        <div class="col-sm-8"><h5><?php echo $data['num_compte']; ?></h5></div>
                                    </div>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                        <div id="fiche_imprimer">
                            <a href="" onClick="imprimer('sectionAimprimer')">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-printer" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11 2H5a1 1 0 0 0-1 1v2H3V3a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2h-1V3a1 1 0 0 0-1-1zm3 4H2a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h1v1H2a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1z"/>
                                <path fill-rule="evenodd" d="M11 9H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1zM5 8a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H5z"/>
                                <path d="M3 7.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/>
                            </svg>
                                Imprimer ces informations
                            </a>
                    </div>
                    </div>
                </div>    
            </div>
        </div>
    </div>

    </body>
    <!--Js Footer-->
    <?php 
        include('../include/imprimer.php');
        include('../include/js_footer.php');
     ?>    
    </html>
<?php 
        }else {
            header('Location: liste_produit.php');
        }

    }else {
        header('Location: ../index.php');
    }

}else{
    header('Location: ../index.php');
}
?> 