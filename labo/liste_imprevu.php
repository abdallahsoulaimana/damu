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

        $selectproduit = $db->prepare("SELECT *, DATE_FORMAT(date_imprevu, '%d-%m-%Y') AS date_imprevu FROM imprevue");
        $selectproduit ->execute();
    ?>
    <!DOCTYPE html>
    <html>
    <!--Head-->
    <?php
        $nav = "imprevu";
        $title = "Liste des imprevus";
        include('../include/head.php');
     ?>
    <body>
    <!--Header-->
    <?php include('../include/header.php');?>
    <?php include('menu/menu.php');?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12" id="liste_show">
            <h3>Liste des imprevus</h3>
                <div class="table-responsive" id="liste_table">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr class="table table-success">
                                <th>#</th>
                                <th style="width:120px;">Numero pv</th>
                                <th style="width:130px;">Nom du responsable</th>
                                <th>Nom du produit</th>
                                <th style="width:110px;">Quantite consome</th>
                                <th>Prix unitaire</th>
                                <th>Montant</th>
                                <th>Date imprevue</th>
                                <th>Action</th>
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
                                <td style="width:120px;"><?php echo $data['num_pv']; ?></td>
                                <td><?php echo $data['nom_autorisation']; ?></td>
                                <td><?php echo $data['produit_nom']; ?></td>
                                <td style="width:110px;"><?php echo $data['quantite_cons']; ?></td>
                                <td><?php echo $data['prix_unitaire']; ?> KMF</td>
                                <td><?php echo $data['montant']; ?> KMF</td>
                                <td><?php echo $data['date_imprevu']; ?></td>
                                <td>
                                    <a href="modifier_imprevu.php?action=update&amp;id_imprevu=<?php echo $data['id_imprevue']; ?>">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M11.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z"/>
                                        <path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 0 0 .5.5H4v.5a.5.5 0 0 0 .5.5H5v.5a.5.5 0 0 0 .5.5H6v-1.5a.5.5 0 0 0-.5-.5H5v-.5a.5.5 0 0 0-.5-.5H3z"/>
                                    </svg>
                                    Modifier
                                    </a>|
                                    <a href="supprimer_imprevu.php?action=delete&amp;id_imprevu=<?php echo $data['id_imprevue']; ?>&amp;num_pv=<?php echo $data['num_pv']; ?>">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                    </svg>
                                    Supprimer
                                    </a>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody> 
                    </table>
                </div>
                <div id="fiche_imprimer">
                    <a href="consultation_imprevu.php">
                    <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-eye" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 0 0 1.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0 0 14.828 8a13.133 13.133 0 0 0-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 0 0 1.172 8z"/>
                        <path fill-rule="evenodd" d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                    </svg>
                        Consulter la liste
                    </a>
                </div>
            </div>
        </div>
    </div>

    </body>
    <!--Js Footer-->
    <?php include('../include/js_footer.php');?>    
    </html>
<?php 
    }else{
        header('Location: ../index.php');
    }

}else{
    header('Location: ../index.php');
}
?> 