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

        $select = $db->prepare("SELECT *, DATE_FORMAT(date_enreg, '%d-%m-%Y') AS date_enreg FROM fournisseur WHERE id_user='$id_user'");
        $select ->execute();
    ?>
    <!DOCTYPE html>
    <html>
    <!--Head-->
    <?php
        $logo = "index.php";
        $nav = 'fournisseur';
        $title = "Liste de tous les fournisseurs";
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
                        <h3 style="margin-top:10px; margin-bottom:30px;text-align:center;">Liste de tous les Fournisseurs</h3>
                        <div class="table-responsive" id="liste_table">
                            <table class="table table-hover">
                                <thead>
                                    <tr class="table table-success">
                                        <th>#</th>
                                        <th>Nom Fournisseur</th>
                                        <th>Adresse</th>
                                        <th>Garantie</th>
                                        <th>Téléphone</th>
                                        <th>E-mail</th>
                                        <th>Date enregistré</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $i=0;
                                while ($data = $select->fetch()) {
                                $i++;
                                ?>
                                    <tr class="table table-light">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $data['nom_fournisseur']; ?></td>
                                        <td><?php echo $data['adresse_fournisseur']; ?></td>
                                        <td><?php echo $data['garantie']; ?></td>
                                        <td><?php echo $data['telephone']; ?></td>
                                        <td><?php echo $data['e_mail']; ?></td>
                                        <td><?php echo $data['date_enreg']; ?></td>
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