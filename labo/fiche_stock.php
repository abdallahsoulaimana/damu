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

        $selectproduit = $db->prepare('SELECT p.*, f.nom_fournisseur FROM produit p LEFT JOIN fournisseur f ON p.id_fourni=f.id_fourni ORDER BY nom_produit ASC');
        $selectproduit ->execute();
    ?>
    <!DOCTYPE html>
    <html>
    <!--Head-->
    <?php
        $logo = "index.php";
        $nav = 'fiche';
        $title = "Fiche de stock";
        include('../include/head.php');
     ?>
    <body>
    <!--Header-->
    <?php include('../include/header.php');?>
    <?php include('menu/menu.php');?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12" id="liste_show">
            <div id='sectionAimprimer'>
                <div style="border:1px solid black; padding:20px 20px 20px 20px ; margin-bottom:20px; background-color:white;">
                    <!--Entete du feuille-->
                    <?php include('../include/entete.php');?> 
                    <h3 style="text-align:center;">Fiche de stock</h3>
                    <div class="table-responsive" id="liste_table">
                        <table class="table table-hover" style="border:1px solid black">
                            <thead>
                                <tr class="table table-success" style="border:1px solid black">
                                    <th style="border:1px solid black">#</th>
                                    <th style="border:1px solid black">Nom produit</th>
                                    <th style="border:1px solid black">Etat de stock</th>
                                    <th style="border:1px solid black">Quantité achetée</th>
                                    <th style="border:1px solid black">Stock consommé</th>
                                    <th style="border:1px solid black">Quantité restante</th>
                                    <th style="border:1px solid black">Prix unitaire</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i=0;
                            while ($data = $selectproduit->fetch()) {
                                $seuille = $data['seuille'];
                                $quantite_cons = $data['quantite_produit']-$data['quantite_restante'];
                                $i++;
                            ?>
                                <tr class="table table-light" style="border:1px solid black">
                                    <td style="border:1px solid black"><?php echo $i; ?></td>
                                    <td style="border:1px solid black"><a href="detail_cons_produit.php?action=detail&amp;id_produit=<?php echo $data['id_produit'] ?>&amp;nom_produit=<?php echo $data['nom_produit']; ?>" style="color:black; text-decoration:none;"><?php echo $data['nom_produit']; ?></a></td>
                                    <td style="border:1px solid black">
                                    <?php
                                            if ($data['quantite_restante']<$seuille) {
                                                ?>
                                                <h6 style="color:rgb(202, 24, 24);">Etat de produit à acheter ! (<?php echo $seuille; ?>)</h6>
                                                <?php
                                            }else {
                                                ?>
                                                <h6 style="color:green;">Etat de produit suffisant ! (<?php echo $seuille; ?>)</h6>
                                                <?php
                                            }
                                        ?>
                                        </td>
                                    <td style="border:1px solid black"><?php echo $data['quantite_produit']; ?></td>
                                    <td style="border:1px solid black"><?php echo $quantite_cons; ?></td>
                                    <td style="border:1px solid black"><?php echo $data['quantite_restante']; ?></td>
                                    <td style="border:1px solid black"><?php echo $data['prix_unitaire']; ?> KMF</td>
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
                        Imprimer la fiche
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