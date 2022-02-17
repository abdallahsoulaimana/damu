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
            $id_comp = htmlspecialchars($_GET['id_comp']);
            $_SESSION['id_composant'] = htmlspecialchars($_GET['id_comp']);
            $_SESSION['nom_composante'] = htmlspecialchars($_GET['nom_comp']);
            $nom_comp = htmlspecialchars($_GET['nom_comp']);

    ?>
    <!DOCTYPE html>
    <html>
    <!--Head-->
    <?php
        $logo = "index.php";
        $nav = "synthese";
        $title = "Consommation de ".$nom_comp;
        include('../include/head.php');
     ?>
    <body>
    <!--Header-->
    <?php include('../include/header.php');?>
    <?php include('menu/menu.php');?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12" id="liste_show">
                <a href="Lister_stock.php">Voir la fiche de stock</a>
                <div id="login">
                    <div id="admin" style="width:100%;">
                        <div id='sectionAimprimer'>
                            <div style="border:1px solid black; padding:20px 20px 20px 20px ; margin-bottom:20px; background-color:white;">
                                <!--Entete du feuille-->
                                <?php include('../include/entete.php');?> 
                                <h3 style="margin-top:10px; margin-bottom:30px;text-align:center;">Consommation de <strong><?php echo $nom_comp; ?></strong> </h3>
                                <div class="table-responsive" id="liste_synthese">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr class="table table-success">
                                                <th style="width:20px;">#</th>
                                                <th style="width:250px;">Nom produit</th>
                                                <th style="width:50px;">Quantité produit</th>
                                                <th style="width:50px;">Quantité consommée</th>
                                                <th style="width:50px;">Quantité restante</th>
                                                <th style="width:150px;">Prix unitaire</th>
                                                <th style="width:150px;">Dépense</th>
                                                <th style="width:150px;">Montant initial</th>
                                                <th style="width:150px;">Date affectée</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $i=0;
                                            if (isset($_GET['mois'])) {
                                                $mois = $_GET['mois'];
                                                $select_produit_affecter = $db->query("SELECT a.*, p.*, DATE_FORMAT(dat_actuel ,'%d-%m-%Y') AS dat_actuel FROM affectation a 
                                                                                        LEFT JOIN produit p ON a.id_produit_affecter = p.id_produit
                                                                                        LEFT JOIN user u ON a.id_user_affecte = u.id_user 
                                                                                        WHERE u.id_composant = '$id_comp' AND MONTH(dat_actuel) = '$mois'");
                                            }else {
                                                $mois = date('m');
                                                $select_produit_affecter = $db->query("SELECT a.*, p.*, DATE_FORMAT(dat_actuel ,'%d-%m-%Y') AS dat_actuel FROM affectation a 
                                                                                    LEFT JOIN produit p ON a.id_produit_affecter = p.id_produit
                                                                                    LEFT JOIN user u ON a.id_user_affecte = u.id_user 
                                                                                     WHERE u.id_composant = '$id_comp' AND MONTH(dat_actuel) = '$mois'");
                                            }
                                            
                                            while ($data = $select_produit_affecter->fetch()) {
                                                $id_produit = $data['id_produit'];
                                                $id_user_affecte = $data['id_user_affecte'];
                                                $_SESSION['id_user_gestionnair'] = $data['id_user_affecte'];
                                                $i++;
                                            ?>
                                            <tr class="table table-light">
                                                <td><?php echo $i; ?></td>
                                                <td style="width:250px; font-size:15px;"><p><?php echo $data['nom_produit']; ?></p></td>
                                                <td style="width:50px;"><?php echo $data['quantite_produit']; ?></td>
                                                <td style="width:50px;"><?php echo $data['quantite_affecter']; ?></td>
                                                <td style="width:50px;"><?php echo ($data['quantite_produit']-$data['quantite_affecter']); ?></td>
                                                <td><?php echo $data['prix_unitaire']; ?> KMF</td>
                                                <td><?php echo $data['depense']; ?> KMF</td>
                                                <td><?php echo $data['prix_achat']; ?> KMF</td>
                                                <td><?php echo $data['dat_actuel']; ?></td>
                                            </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
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
    <?php include('../include/imprimer.php');?>  
    <?php include('../include/js_footer.php');?>    
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