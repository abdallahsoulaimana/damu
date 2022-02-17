<?php 
    session_start();
    include('../include/connexion.php');
    if (isset($_SESSION['id_user'])) {
        if ($_SESSION['id_categorie']==3){

        $id_user = $_SESSION['id_user'];
        $id_composant = $_SESSION['id_composant'];
        $nom_composante = $_SESSION['nom_composante'];
        
        if (isset($_SESSION['id_user_gestionnair'])) {
            $id_gestionnair = $_SESSION['id_user_gestionnair'];
        }else {
            $id_gestionnair = 0;
        }
        $selct = $db->prepare('SELECT u.*, c.libelle, cp.nom_comp FROM user u
                                LEFT JOIN categorie c ON u.id_categorie = c.id_cat
                                LEFT JOIN composante cp ON u.id_composant = cp.id_comp
                                WHERE id_user = ?');
        $selct ->execute(array($id_user));
        $affiche = $selct->fetch();

        // $id_composante = $db->prepare('SELECT id_composante_affecter FROM affectation WHERE id_user_affecte = ?');
        // $id_composante ->execute(array($id_user));
        // $userexiste = $id_composante->fetch();
        // $id_composante_affecter = $userexiste['id_composante_affecter'];

        // $id_composante_affecter = 5;
        $selectproduit = $db->prepare("SELECT p.*, a.* FROM affectation a 
        LEFT JOIN produit p ON p.id_produit = a.id_produit_affecter
        LEFT JOIN user u ON a.id_user_affecte = u.id_user
        LEFT JOIN composante c ON u.id_composant = c.id_comp
        WHERE a.id_user_affecte = ? AND u.id_composant = ?");
        $selectproduit ->execute(array($id_gestionnair, $id_composant));
    ?>
    <!DOCTYPE html>
    <html>
    <!--Head-->
    <?php
        $logo = "index.php";
        $nav = 'synthese';
        $title = "Fiche de stock ".$nom_composante;
        include('../include/head.php');
     ?>
    <body>
    <!--Header-->
    <?php include('../include/header.php');?>
    <?php include('menu/menu.php');?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12" id="liste_show">
                <div id='sectionAimprimer' >
                    <div style="width:100%; border:1px solid black; padding:20px 20px 20px 20px ; margin-bottom:20px; background-color:white;">
                        <!--Entete du feuille-->
                        <?php include('../include/entete.php');?>
                        <h3 style="margin-top:10px; margin-bottom:30px;text-align:center;">Fiche de stock de <strong><?php echo $nom_composante; ?></strong></h3>
                        <div class="table-responsive" id="liste_table">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="table table-success">
                                        <th>#</th>
                                        <th>Nom produit</th>
                                        <th>Quantité stockée</th>
                                        <th>Quantité consommée</th>
                                        <th>Quantité retante</th>
                                        <th>Montant</th>
                                        <th>Montant consommé</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i=0;
                                while ($data = $selectproduit->fetch()) {
                                    $i++;
                                ?>
                                    <tr class="table table-light">
                                        <td><?php echo $i; ?></td>
                                        <td><a href="consultation_produit_distribu.php?id_affectation=<?php echo $data['id_affectation']; ?>" style="color:black; text-decoration:none;"><?php echo $data['nom_produit']; ?></a></td>
                                        <td><?php echo $data['quantite_affecter']; ?></td>
                                        <td>
                                            <?php
                                            $id_affectation = $data['id_affectation']; 
                                            $select_gest = $db->query("SELECT SUM(quantite_sortir) AS qtes FROM produit_gestionnair WHERE id_affectation = '$id_affectation'");
                                                while ($dat1 = $select_gest->fetch()) {
                                                    ?>
                                                    <p><?php echo $dat1['qtes']; ?></p>
                                                    <?php
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                $id_affectation = $data['id_affectation']; 
                                                $select_gest = $db->query("SELECT SUM(quantite_sortir) AS qtes FROM produit_gestionnair WHERE id_affectation = '$id_affectation'");
                                                    while ($dat1 = $select_gest->fetch()) {
                                                        ?>
                                                        <p><?php echo $data['quantite_affecter']-$dat1['qtes']; ?></p>
                                                        <?php
                                                    }
                                                ?>
                                        </td>
                                        <td><?php echo $data['depense']; ?> KMF</td>
                                        <td>
                                            <?php
                                            $id_affectation = $data['id_affectation']; 
                                            $select_gest = $db->query("SELECT SUM(pg.quantite_sortir) AS qtes, p.prix_unitaire FROM produit_gestionnair pg
                                                                        LEFT JOIN affectation a ON pg.id_affectation = a.id_affectation 
                                                                        LEFT JOIN produit p ON a.id_produit_affecter = p.id_produit
                                                                        WHERE pg.id_affectation = '$id_affectation'");
                                                while ($dat1 = $select_gest->fetch()) {
                                                    ?>
                                                    <p><?php echo $dat1['qtes'] * $dat1['prix_unitaire']; ?> KMF</p>
                                                    <?php
                                                }
                                            ?>
                                        </td>
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
                        Imprimer
                    </a>
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
        header('Location: ../index.php');
    }

}else{
    header('Location: ../index.php');
}
?> 