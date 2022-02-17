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

        if (isset($_GET['search'])) {
            if (!empty($_GET['search'])) {
                $search = htmlspecialchars($_GET['search']);
                $selectproduit = $db->prepare("SELECT p.*, f.nom_fournisseur FROM produit p LEFT JOIN fournisseur f ON p.id_fourni=f.id_fourni WHERE nom_produit LIKE '%".$search."%' ORDER BY date_achat DESC");
                $selectproduit ->execute();
                $produit_exist = $selectproduit->rowCount();
                if ($produit_exist==0) {
                    $erreur = "Aucun produit trouvé !";
                }else {
                    $controle = 1;
                }
            }else {
                $erreur = "Aucun produit saisi !";
            }
        }else {
            $selectproduit = $db->prepare("SELECT p.*, DATE_FORMAT(p.date_achat, '%d-%m-%Y') AS date_achat, f.nom_fournisseur FROM produit p LEFT JOIN fournisseur f ON p.id_fourni=f.id_fourni ORDER BY date_achat DESC");
            $selectproduit ->execute();
            $controle = 1;
        }
    ?>
    <!DOCTYPE html>
    <html>
    <!--Head-->
    <?php
        $logo = "index.php";
        $nav = "produit";
        $title = "Liste de tous les produits";
        include('../include/head.php');
     ?>
    <body>
    <!--Header-->
    <?php include('../include/header.php');?>
    <?php include('menu/menu.php');?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12" id="liste_show">
            <div id="search">
                <form method="get">
                    <div class="form-group row">
                        <div class="col-sm-3">
                        <input type="search" name="search" class="form-control" id="search" placeholder="Recherchez un produit">
                        </div>
                    </div>
                </form>
            </div>
            <?php if (isset($erreur)) { ?>
                <div class="container">
                    <div class="row">
                    <div class="alert alert-danger col-sm-12" role="alert" style="text-align:center;">
                        <p><?= $erreur ?></p>
                    </div>
                    </div>
                </div>
            <?php } ?>
            <?php if (isset($controle)) { ?>
                <div id='sectionAimprimer'>
                    <div style="border:1px solid black; padding:20px 20px 20px 20px ; margin-bottom:20px; background-color:white;">
                        <!--Entete du feuille-->
                        <?php include('../include/entete.php');?>
                        <h3 style="margin-top:10px; margin-bottom:30px;text-align:center;">Liste de tous les produits</h3>
                        <div class="table-responsive" id="liste_table">
                            <table class="table table-hover">
                                <thead>
                                    <tr class="table table-success">
                                        <th>#</th>
                                        <th>Nom produit</th>
                                        <th>Fournisseur</th>
                                        <th>Quantite produit</th>
                                        <th>Quantite restante</th>
                                        <th>Prix achat</th>
                                        <th>Prix unitaire</th>
                                        <th>Date achat</th>
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
                                        <td><a href="detail_produit.php?action=detail&amp;id_produit=<?php echo $data['id_produit']; ?>&amp;nom_produit=<?php echo $data['nom_produit']; ?>" style="color:black; text-decoration:none;"><?php echo $data['nom_produit']; ?></a></td>
                                        <td><?php echo $data['nom_fournisseur']; ?></td>
                                        <td style="width:100px;"><?php echo $data['quantite_produit']; ?></td>
                                        <td style="width:100px;"><?php echo $data['quantite_restante']; ?></td>
                                        <td><?php echo $data['prix_achat']; ?> KMF</td>
                                        <td><?php echo $data['prix_unitaire']; ?> KMF</td>
                                        <td><?php echo $data['date_achat']; ?></td>
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
                        Imprimer la liste
                    </a>
                </div>
                <?php } ?>
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