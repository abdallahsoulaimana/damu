<?php 
    session_start();
    include('../include/connexion.php'); 
    require_once '../include/config.php';
    if (isset($_SESSION['id_user'])) {
        if ($_SESSION['id_categorie']==3) {

        $id_user = $_SESSION['id_user'];
        $selct = $db->prepare('SELECT u.*, c.libelle, cp.nom_comp FROM user u
                                LEFT JOIN categorie c ON u.id_categorie = c.id_cat
                                LEFT JOIN composante cp ON u.id_composant = cp.id_comp
                                WHERE id_user = ?');
        $selct ->execute(array($id_user));
        $affiche = $selct->fetch();

        $select_composante = $db->prepare("SELECT * FROM composante");
        $select_composante ->execute();

    ?>
    <!DOCTYPE html>
    <html>
    <!--Head-->
    <?php
        $logo = "index.php";
        $nav = 'synthese';
        $title = "Fiche de synthèse";
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
                <form method="POST">
                    <div class="form-group row">
                        <div class="col-sm-2">
                            <select class="form-control" id="mois" name="mois">
                                <option value="0">Mois</option>
                                <?php foreach(MOIS as $m => $mois):?>

                                    <option value="<?php echo $m + 1; ?>"><?php echo $mois; ?></option>

                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <select class="form-control" id="annee" name="annee">
                                <option value="0">Année</option>
                                <?php
                                $select_annee = $db->query('SELECT * FROM annee');
                                    while($annee = $select_annee->fetch()){
                                ?>
                                    <option value="<?php echo $annee['annee'] ;?>"><?php echo$annee['annee'] ; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-2">
                          <input type="submit" name="search" class="form-control" value="Recherchez">
                        </div>
                    </div>
                </form>
            </div>
            <div id='sectionAimprimer'>
                <div style="border:1px solid black; padding:20px 20px 20px 20px ; margin-bottom:20px; background-color:white;">
                    <!--Entete du feuille-->
                    <?php include('../include/entete.php');?>
                    <!--debut-->
                    <h3 style="margin-top:10px; margin-bottom:30px;text-align:center;">Fiche de synthèse</h3>
                    <div class="table-responsive" id="liste_synthese">
                        <table class="table table-hover">
                            <thead>
                                <tr class="table table-success">
                                    <th style="width:80px;">#</th>
                                    <th style="width:80px;">Composante</th>
                                    <th style="width:150px;">Produits</th>
                                    <th style="width:80px;">Quantité produit</th>
                                    <th style="width:80px;">Stock consommé</th>
                                    <th style="width:80px;">Quantité restante</th>
                                    <th style="width:80px;">Dépenses</th>
                                    <th style="width:80px;">Montant initial</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i=0;
                            while ($data = $select_composante->fetch()) {
                                $id_comp = $data['id_comp'];
                                $i++;
                            ?>
                                <tr class="table table-light">
                                    <td style="width:80px;"><?php echo $i; ?></td>
                                    <?php
                                        if (isset($_POST['mois']) && isset($_POST['search'])) {
                                            $mois = $_POST['mois'];
                                    ?>
                                    <td style="width:80px; font-size:14px; color:black;"><a href="detail_composante.php?action=detail&amp;id_comp=<?php echo $id_comp; ?>&amp;nom_comp=<?php echo $data['nom_comp']; ?>&amp;mois=<?php echo $mois; ?>" style="color:black; text-decoration:none;"><p><?php echo $data['abreviation']; ?></p></a></td>
                                    <?php
                                    }else{
                                        ?>
                                        <td style="width:80px; font-size:14px; color:black;"><a href="detail_composante.php?action=detail&amp;id_comp=<?php echo $id_comp; ?>&amp;nom_comp=<?php echo $data['nom_comp']; ?>" style="color:black; text-decoration:none;"><p><?php echo $data['abreviation']; ?></p></a></td>
                                        <?php
                                    }
                                    ?>
                                    <td style="width:80px; font-size:14px;">
                                        <?php
                                        if (isset($_POST['mois']) && isset($_POST['search'])) {
                                            $mois = $_POST['mois'];
                                            $annee = $_POST['annee'];
                                            $select_produit_affecter = $db->query("SELECT a.*, p.* FROM affectation a 
                                                                                    LEFT JOIN produit p ON a.id_produit_affecter = p.id_produit
                                                                                    LEFT JOIN user u ON a.id_user_affecte = u.id_user  
                                                                                    WHERE u.id_composant = '$id_comp' AND MONTH(dat_actuel) = '$mois' AND YEAR(dat_actuel) = '$annee'");
                                            while ($datp = $select_produit_affecter->fetch()) {
                                            ?>
                                            <p><?php echo $datp['nom_produit']; ?></p>
                                            <?php
                                            }
                                        }else {
                                            $mois = date('m');
                                            $annee = date('Y');
                                            $select_produit_affecter = $db->query("SELECT a.*, p.* FROM affectation a 
                                                                                    LEFT JOIN produit p ON a.id_produit_affecter = p.id_produit 
                                                                                    LEFT JOIN user u ON a.id_user_affecte = u.id_user 
                                                                                    WHERE u.id_composant = '$id_comp' AND MONTH(dat_actuel) = '$mois' AND YEAR(dat_actuel) = '$annee'");
                                            while ($datp = $select_produit_affecter->fetch()) {
                                            ?>
                                            <p><?php echo $datp['nom_produit']; ?></p>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td style="width:80px;">
                                        <?php
                                        if (isset($_POST['mois']) && isset($_POST['search'])) {
                                            $mois = $_POST['mois'];
                                            $annee = $_POST['annee'];
                                            $select_quantite_produit = $db->query("SELECT a.*, p.* FROM affectation a 
                                                                                    LEFT JOIN produit p ON a.id_produit_affecter = p.id_produit
                                                                                    LEFT JOIN user u ON a.id_user_affecte = u.id_user  
                                                                                    WHERE u.id_composant = '$id_comp' AND MONTH(dat_actuel) = '$mois' AND YEAR(dat_actuel) = '$annee'");
                                            while ($datq = $select_quantite_produit->fetch()) {
                                            ?>
                                            <p><?php echo $datq['quantite_produit']; ?></p>
                                            <?php
                                            }
                                        }else {
                                            $mois = date('m');
                                            $annee = date('Y');
                                            $select_quantite_produit = $db->query("SELECT a.*, p.* FROM affectation a 
                                                                                    LEFT JOIN produit p ON a.id_produit_affecter = p.id_produit
                                                                                    LEFT JOIN user u ON a.id_user_affecte = u.id_user  
                                                                                    WHERE u.id_composant = '$id_comp' AND MONTH(dat_actuel) = '$mois' AND YEAR(dat_actuel) = '$annee'");
                                            while ($datq = $select_quantite_produit->fetch()) {
                                            ?>
                                            <p><?php echo $datq['quantite_produit']; ?></p>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td style="width:80px;">
                                        <?php
                                        if (isset($_POST['mois']) && isset($_POST['search'])) {
                                            $mois = $_POST['mois'];
                                            $annee = $_POST['annee'];
                                            $select_quantite_affecter = $db->query("SELECT * FROM affectation a
                                                                                    LEFT JOIN user u ON a.id_user_affecte = u.id_user
                                                                                    WHERE u.id_composant = '$id_comp' AND MONTH(dat_actuel) = '$mois' AND YEAR(dat_actuel) = '$annee'");
                                            while ($datc = $select_quantite_affecter->fetch()) {
                                            ?>
                                            <p><?php echo $datc['quantite_affecter']; ?></p>
                                            <?php
                                            }
                                        }else {
                                            $mois = date('m');
                                            $annee = date('Y');
                                            $select_quantite_affecter = $db->query("SELECT * FROM affectation a 
                                                                                    LEFT JOIN user u ON a.id_user_affecte = u.id_user
                                                                                    WHERE u.id_composant = '$id_comp' AND MONTH(dat_actuel) = '$mois' AND YEAR(dat_actuel) = '$annee'");
                                            while ($datc = $select_quantite_affecter->fetch()) {
                                            ?>
                                            <p><?php echo $datc['quantite_affecter']; ?></p>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td style="width:80px;">
                                        <?php
                                        if (isset($_POST['mois']) && isset($_POST['search'])) {
                                            $mois = $_POST['mois'];
                                            $annee = $_POST['annee'];
                                            $select_quantite_restante = $db->query("SELECT a.*, p.* FROM affectation a 
                                                                                    LEFT JOIN user u ON a.id_user_affecte = u.id_user
                                                                                    LEFT JOIN produit p ON a.id_produit_affecter = p.id_produit  
                                                                                    WHERE u.id_composant = '$id_comp' AND MONTH(dat_actuel) = '$mois' AND YEAR(dat_actuel) = '$annee'");
                                            while ($datr = $select_quantite_restante->fetch()) {
                                            ?>
                                            <p><?php echo $datr['quantite_restante']; ?></p>
                                            <?php
                                            }
                                        }else {
                                            $mois = date('m');
                                            $annee = date('Y');
                                            $select_quantite_restante = $db->query("SELECT a.*, p.* FROM affectation a 
                                                                                    LEFT JOIN produit p ON a.id_produit_affecter = p.id_produit 
                                                                                    LEFT JOIN user u ON a.id_user_affecte = u.id_user
                                                                                     WHERE u.id_composant = '$id_comp' AND MONTH(dat_actuel) = '$mois' AND YEAR(dat_actuel) = '$annee'");
                                            while ($datr = $select_quantite_restante->fetch()) {
                                            ?>
                                            <p><?php echo $datr['quantite_restante']; ?></p>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td style="width:80px;">
                                        <?php
                                        if (isset($_POST['mois']) && isset($_POST['search'])) {
                                            $mois = $_POST['mois'];
                                            $annee = $_POST['annee'];
                                            $select_depense = $db->query("SELECT a.*, p.* FROM affectation a 
                                                                            LEFT JOIN produit p ON a.id_produit_affecter = p.id_produit 
                                                                            LEFT JOIN user u ON a.id_user_affecte = u.id_user 
                                                                            WHERE u.id_composant = '$id_comp' AND MONTH(dat_actuel) = '$mois' AND YEAR(dat_actuel) = '$annee'");
                                            while ($datd = $select_depense->fetch()) {
                                                $depense = $datd['depense'];
                                            ?>
                                            <p><?php echo $depense.' '; ?>KMF</p>
                                            <?php
                                            }
                                        }else {
                                            $mois = date('m');
                                            $annee = date('Y');
                                            $select_depense = $db->query("SELECT a.*, p.* FROM affectation a 
                                                                        LEFT JOIN produit p ON a.id_produit_affecter = p.id_produit
                                                                        LEFT JOIN user u ON a.id_user_affecte = u.id_user 
                                                                        WHERE u.id_composant = '$id_comp' AND MONTH(dat_actuel) = '$mois' AND YEAR(dat_actuel) = '$annee'");
                                            while ($datd = $select_depense->fetch()) {
                                                $depense = $datd['depense'];
                                            ?>
                                            <p><?php echo $depense.' '; ?>KMF</p>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td style="width:80px;">
                                        <?php
                                        if (isset($_POST['mois']) && isset($_POST['search'])) {
                                            $mois = $_POST['mois'];
                                            $annee = $_POST['annee'];
                                            $select_montant = $db->query("SELECT a.*, p.* FROM affectation a 
                                                                            LEFT JOIN produit p ON a.id_produit_affecter = p.id_produit
                                                                            LEFT JOIN user u ON a.id_user_affecte = u.id_user  
                                                                            WHERE u.id_composant = '$id_comp' AND MONTH(dat_actuel) = '$mois' AND YEAR(dat_actuel) = '$annee'");
                                            while ($datm = $select_montant->fetch()) {
                                            ?>
                                            <p><?php echo $datm['prix_achat'].' KMF'; ?></p>
                                            <?php
                                            }
                                        }else {
                                            $mois = date('m');
                                            $annee = date('Y');
                                            $select_montant = $db->query("SELECT a.*, p.* FROM affectation a 
                                                                        LEFT JOIN produit p ON a.id_produit_affecter = p.id_produit
                                                                        LEFT JOIN user u ON a.id_user_affecte = u.id_user  
                                                                        WHERE u.id_composant = '$id_comp' AND MONTH(dat_actuel) = '$mois' AND YEAR(dat_actuel) = '$annee'");
                                            while ($datm = $select_montant->fetch()) {
                                            ?>
                                            <p><?php echo $datm['prix_achat'].' KMF'; ?></p>
                                            <?php
                                            }
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>
                                <tr class="table table-light">
                                    <td style="width:80px;"><strong>Chèque</strong></td>
                                    <td style="width:80px;" colspan="5"></td>
                                    <?php
                                        if (isset($_POST['mois']) && isset($_POST['search'])) {
                                            $mois = $_POST['mois'];
                                            $annee = $_POST['annee'];
                                            $select_cheque_total = $db->query("SELECT SUM(c.montant) as montant FROM cheque c WHERE MONTH(c.date_enreg) = '$mois' AND YEAR(c.date_enreg) = '$annee'");
                                            $data_cheque_total = $select_cheque_total->fetch();
                                        }else {
                                            $mois = date('m');
                                            $annee = date('Y');
                                            $select_cheque_total = $db->query("SELECT SUM(c.montant) as montant FROM cheque c WHERE MONTH(c.date_enreg) = '$mois' AND YEAR(c.date_enreg) = '$annee'");
                                            $data_cheque_total = $select_cheque_total->fetch();
                                        }
                                    ?>
                                    <td style="width:80px;"><?php echo $data_cheque_total['montant']; ?> KMF</td>
                                    <td style="width:80px;" ></td>
                                </tr>
                                <tr class="table table-light">
                                    <td style="width:80px;"><strong>Imprevus</strong></td>
                                    <td style="width:80px;" colspan="5"></td>
                                    <?php
                                        if (isset($_POST['mois']) && isset($_POST['search'])) {
                                            $mois = $_POST['mois'];
                                            $annee = $_POST['annee'];
                                            $select_imprevu_total = $db->query("SELECT SUM(i.montant) as montant FROM imprevue i WHERE MONTH(i.date_imprevu) = '$mois' AND YEAR(i.date_imprevu) = '$annee'");
                                            $data_imprevu_total = $select_imprevu_total->fetch();
                                        }else {
                                            $mois = date('m');
                                            $annee = date('Y');
                                            $select_imprevu_total = $db->query("SELECT SUM(i.montant) as montant FROM imprevue i WHERE MONTH(i.date_imprevu) = '$mois' AND YEAR(i.date_imprevu) = '$annee'");
                                            $data_imprevu_total = $select_imprevu_total->fetch();
                                        }
                                    ?>
                                    <td style="width:80px;"><?php echo $data_imprevu_total['montant']; ?> KMF</td>
                                    <td style="width:80px;" ></td>
                                </tr>
                                <tr class="table table-light">
                                    <?php
                                        if (isset($_POST['mois']) && isset($_POST['search'])) {
                                            $mois = $_POST['mois'];
                                            $annee = $_POST['annee'];
                                            $select_total = $db->query("SELECT COUNT(a.id_produit_affecter) as total_produit, SUM(p.quantite_produit) as qta_produit_total, SUM(a.quantite_affecter) as qta_produit_af_total, SUM(p.quantite_restante) as qta_produit_rest_total, SUM(p.prix_achat) as prix_total, SUM(a.depense) as depense FROM affectation a  LEFT JOIN produit p ON a.id_produit_affecter = p.id_produit WHERE MONTH(dat_actuel) = '$mois' AND YEAR(dat_actuel) = '$annee'");
                                            $data_total = $select_total->fetch();
                                            $select_imprevu_total = $db->query("SELECT SUM(i.montant) as montant FROM imprevue i WHERE MONTH(i.date_imprevu) = '$mois' AND YEAR(i.date_imprevu) = '$annee'");
                                            $data_imprevu_total = $select_imprevu_total->fetch();
                                            $select_cheque_total = $db->query("SELECT SUM(c.montant) as montant FROM cheque c WHERE MONTH(c.date_enreg) = '$mois' AND YEAR(c.date_enreg) = '$annee'");
                                            $data_cheque_total = $select_cheque_total->fetch();
                                        }else {
                                            $mois = date('m');
                                            $annee = date('Y');
                                            $select_total = $db->query("SELECT COUNT(a.id_produit_affecter) as total_produit, SUM(p.quantite_produit) as qta_produit_total, SUM(a.quantite_affecter) as qta_produit_af_total, SUM(p.quantite_restante) as qta_produit_rest_total, SUM(p.prix_achat) as prix_total, SUM(a.depense) as depense FROM affectation a LEFT JOIN produit p ON a.id_produit_affecter = p.id_produit WHERE MONTH(dat_actuel) = '$mois' AND YEAR(dat_actuel) = '$annee'");
                                            $data_total = $select_total->fetch();
                                            $select_imprevu_total = $db->query("SELECT SUM(i.montant) as montant FROM imprevue i WHERE MONTH(i.date_imprevu) = '$mois' AND YEAR(i.date_imprevu) = '$annee'");
                                            $data_imprevu_total = $select_imprevu_total->fetch();
                                            $select_cheque_total = $db->query("SELECT SUM(c.montant) as montant FROM cheque c WHERE MONTH(c.date_enreg) = '$mois' AND YEAR(c.date_enreg) = '$annee'");
                                            $data_cheque_total = $select_cheque_total->fetch();
                                        }

                                        $select_total_composante = $db->query("SELECT COUNT(nom_comp) AS total_composante FROM composante");
                                        $data_comp_total = $select_total_composante->fetch();
                                    ?>
                                    
                                    <td style="width:80px;"><strong>Total</strong></td>
                                    <td style="width:80px;"><?php echo $data_comp_total['total_composante']; ?></td>
                                    <td style="width:80px;"><?php echo $data_total['total_produit']; ?></td>
                                    <td style="width:80px;"><?php echo $data_total['qta_produit_total']; ?></td>
                                    <td style="width:80px;"><?php echo $data_total['qta_produit_af_total']; ?></td>
                                    <td style="width:80px;"><?php echo $data_total['qta_produit_rest_total']; ?></td>
                                    <td style="width:80px;"><?php  echo $data_cheque_total['montant']+$data_imprevu_total['montant']+$data_total['depense']; ?> KMF</td>
                                    <td style="width:80px;"><?php echo $data_total['prix_total']; ?> KMF</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
                <!--fin-->
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