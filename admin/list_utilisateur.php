<?php 
    session_start();
    include('../include/connexion.php');
    if (isset($_SESSION['id_user'])) {
        if ($_SESSION['id_categorie']==1) {

        $id_user = $_SESSION['id_user'];
        $selct = $db->prepare('SELECT u.*, c.libelle, cp.nom_comp FROM user u
                                LEFT JOIN categorie c ON u.id_categorie = c.id_cat
                                LEFT JOIN composante cp ON u.id_composant = cp.id_comp
                                WHERE id_user = ? ');
        $selct ->execute(array($id_user));
        $affiche = $selct->fetch();

        $selectUtilisateur = $db->prepare("SELECT *, DATE_FORMAT(date_enr, '%d-%m-%Y') AS date_enr FROM user U
                                            LEFT JOIN categorie C ON U.id_categorie=C.id_cat
                                            LEFT JOIN composante CP ON U.id_composant = CP.id_comp ORDER BY login ASC");
        $selectUtilisateur ->execute(array($id_user));
     
    ?>
    <!DOCTYPE html>
    <html>
    <!--Head-->
    <?php
    $logo = "index.php";
    $nav = "user";
    $title="Liste des utilisateurs";
     include('../include/head.php');
     ?>
    <body>
    <!--Header-->
    <?php include('../include/header.php');?>
    <?php include('menu/menu.php');?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <h3 style="text-align: center; margin-top: 20px;">Liste de tous les utilisateurs crées</h3>
                <div class="table-responsive" id="liste_synthese">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr class="table table-success">
                                <th style="text-align: center;">#</th>
                                <th style="text-align: center;">Login</th>
                                <th style="text-align: center;">Pénom</th>
                                <th style="text-align: center;">Nom</th>
                                <th style="text-align: center;">Téléphone</th>
                                <th style="text-align: center;">Catégorie</th>
                                <th style="text-align: center;">Composante</th>
                                <th style="text-align: center;">Date enregistrer</th>
                                <th style="text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i=0;
                        while ($afficheUtilisateur = $selectUtilisateur->fetch()) {
                            $i++;
                        ?>
                            <tr class="table table-light">
                                <td><?php echo $i; ?></td>
                                <td><?php echo '<strong>'.$afficheUtilisateur['login'].'</strong>'; ?></td>
                                <td><?php echo $afficheUtilisateur['prenom']; ?></td>
                                <td><?php echo $afficheUtilisateur['nom']; ?></td>
                                <td><?php echo $afficheUtilisateur['tel']; ?></td>
                                <td><?php echo $afficheUtilisateur['libelle']; ?></td>
                                <td style="width:15%;"><?php echo $afficheUtilisateur['abreviation']; ?></td>
                                <td><?php echo $afficheUtilisateur['date_enr']; ?></td>
                                <td style="font-size:12px">
                                    <p>
                                    <a href="modifier_user.php?action=update&amp;id_user=<?php echo $afficheUtilisateur['id_user']; ?>&amp;user=<?php echo $afficheUtilisateur['login'];?>">
                                    <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M11.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z"/>
                                        <path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 0 0 .5.5H4v.5a.5.5 0 0 0 .5.5H5v.5a.5.5 0 0 0 .5.5H6v-1.5a.5.5 0 0 0-.5-.5H5v-.5a.5.5 0 0 0-.5-.5H3z"/>
                                    </svg>
                                    Modifier
                                    </a>|<a href="supprimer_user.php?action=delete&amp;id_user=<?php echo $afficheUtilisateur['id_user']; ?>&amp;user=<?php echo $afficheUtilisateur['login'];?>">
                                    <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                    </svg>
                                    Supprimer
                                    </a>|<a href="modifier_passe_user.php?action=change&amp;id_user=<?php echo $afficheUtilisateur['id_user'];?>&amp;user=<?php echo $afficheUtilisateur['login'];?>">
                                    <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M11.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z"/>
                                        <path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 0 0 .5.5H4v.5a.5.5 0 0 0 .5.5H5v.5a.5.5 0 0 0 .5.5H6v-1.5a.5.5 0 0 0-.5-.5H5v-.5a.5.5 0 0 0-.5-.5H3z"/>
                                    </svg>
                                    Changer mot de passe
                                    </a>
                                    </p>
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