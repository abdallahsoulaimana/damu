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

        if(isset($_POST['annee'])){
            $annee = $_POST['annee'];

            //requetes de depense pour dynamiser les courbes
            //Requete de l'AC par chque mois
            $select_janvier_ac = $db->query("SELECT SUM(a.depense) AS depense_ac_janvier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=1 AND MONTH(dat_actuel) = 1 AND YEAR(dat_actuel) = '$annee'");
            $data_janvier_ac = $select_janvier_ac->fetch();

            $select_fevrier_ac = $db->query("SELECT SUM(a.depense) AS depense_ac_fevrier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=1 AND MONTH(dat_actuel) = 2 AND YEAR(dat_actuel) = '$annee'");
            $data_fevrier_ac = $select_fevrier_ac->fetch();

            $select_mars_ac = $db->query("SELECT SUM(a.depense) AS depense_ac_mars FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=1 AND MONTH(dat_actuel) = 3 AND YEAR(dat_actuel) = '$annee'");
            $data_mars_ac = $select_mars_ac->fetch();

            $select_avril_ac = $db->query("SELECT SUM(a.depense) AS depense_ac_avril FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=1 AND MONTH(dat_actuel) = 4 AND YEAR(dat_actuel) = '$annee'");
            $data_avril_ac = $select_avril_ac->fetch();

            $select_mai_ac = $db->query("SELECT SUM(a.depense) AS depense_ac_mai FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=1 AND MONTH(dat_actuel) = 5 AND YEAR(dat_actuel) = '$annee'");
            $data_mai_ac = $select_mai_ac->fetch();

            $select_juin_ac = $db->query("SELECT SUM(a.depense) AS depense_ac_juin FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=1 AND MONTH(dat_actuel) = 6 AND YEAR(dat_actuel) = '$annee'");
            $data_juin_ac = $select_juin_ac->fetch();

            $select_juillet_ac = $db->query("SELECT SUM(a.depense) AS depense_ac_juillet FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=1 AND MONTH(dat_actuel) = 7 AND YEAR(dat_actuel) = '$annee'");
            $data_juillet_ac = $select_juillet_ac->fetch();

            $select_aout_ac = $db->query("SELECT SUM(a.depense) AS depense_ac_aout FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=1 AND MONTH(dat_actuel) = 8 AND YEAR(dat_actuel) = '$annee'");
            $data_aout_ac = $select_aout_ac->fetch();

            $select_septembre_ac = $db->query("SELECT SUM(a.depense) AS depense_ac_septembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=1 AND MONTH(dat_actuel) = 9 AND YEAR(dat_actuel) = '$annee'");
            $data_septembre_ac = $select_septembre_ac->fetch();

            $select_octobre_ac = $db->query("SELECT SUM(a.depense) AS depense_ac_octobre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=1 AND MONTH(dat_actuel) = 10 AND YEAR(dat_actuel) = '$annee'");
            $data_octobre_ac = $select_octobre_ac->fetch();

            $select_novembre_ac = $db->query("SELECT SUM(a.depense) AS depense_ac_novembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=1 AND MONTH(dat_actuel) = 11 AND YEAR(dat_actuel) = '$annee'");
            $data_novembre_ac = $select_novembre_ac->fetch();

            $select_decembre_ac = $db->query("SELECT SUM(a.depense) AS depense_ac_decembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=1 AND MONTH(dat_actuel) = 12 AND YEAR(dat_actuel) = '$annee'");
            $data_decembre_ac = $select_decembre_ac->fetch();

            //Requete de la FST par chaque mois
            $select_janvier_fst = $db->query("SELECT SUM(a.depense) AS depense_fst_janvier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=2 AND MONTH(dat_actuel) = 1 AND YEAR(dat_actuel) = '$annee'");
            $data_janvier_fst = $select_janvier_fst->fetch();

            $select_fevrier_fst = $db->query("SELECT SUM(a.depense) AS depense_fst_fevrier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=2 AND MONTH(dat_actuel) = 2 AND YEAR(dat_actuel) = '$annee'");
            $data_fevrier_fst = $select_fevrier_fst->fetch();

            $select_mars_fst = $db->query("SELECT SUM(a.depense) AS depense_fst_mars FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=2 AND MONTH(dat_actuel) = 3 AND YEAR(dat_actuel) = '$annee'");
            $data_mars_fst = $select_mars_fst->fetch();

            $select_avril_fst = $db->query("SELECT SUM(a.depense) AS depense_fst_avril FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=2 AND MONTH(dat_actuel) = 4 AND YEAR(dat_actuel) = '$annee'");
            $data_avril_fst = $select_avril_fst->fetch();

            $select_mai_fst = $db->query("SELECT SUM(a.depense) AS depense_fst_mai FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=2 AND MONTH(dat_actuel) = 5 AND YEAR(dat_actuel) = '$annee'");
            $data_mai_fst = $select_mai_fst->fetch();

            $select_juin_fst = $db->query("SELECT SUM(a.depense) AS depense_fst_juin FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=2 AND MONTH(dat_actuel) = 6 AND YEAR(dat_actuel) = '$annee'");
            $data_juin_fst = $select_juin_fst->fetch();

            $select_juillet_fst = $db->query("SELECT SUM(a.depense) AS depense_fst_juillet FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=2 AND MONTH(dat_actuel) = 7 AND YEAR(dat_actuel) = '$annee'");
            $data_juillet_fst = $select_juillet_fst->fetch();

            $select_aout_fst = $db->query("SELECT SUM(a.depense) AS depense_fst_aout FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=2 AND MONTH(dat_actuel) = 8 AND YEAR(dat_actuel) = '$annee'");
            $data_aout_fst = $select_aout_fst->fetch();

            $select_septembre_fst = $db->query("SELECT SUM(a.depense) AS depense_fst_septembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=2 AND MONTH(dat_actuel) = 9 AND YEAR(dat_actuel) = '$annee'");
            $data_septembre_fst = $select_septembre_fst->fetch();

            $select_octobre_fst = $db->query("SELECT SUM(a.depense) AS depense_fst_octobre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=2 AND MONTH(dat_actuel) = 10 AND YEAR(dat_actuel) = '$annee'");
            $data_octobre_fst = $select_octobre_fst->fetch();

            $select_novembre_fst = $db->query("SELECT SUM(a.depense) AS depense_fst_novembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=2 AND MONTH(dat_actuel) = 11 AND YEAR(dat_actuel) = '$annee'");
            $data_novembre_fst = $select_novembre_fst->fetch();

            $select_decembre_fst = $db->query("SELECT SUM(a.depense) AS depense_fst_decembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=2 AND MONTH(dat_actuel) = 12 AND YEAR(dat_actuel) = '$annee'");
            $data_decembre_fst = $select_decembre_fst->fetch();

            //Requetes de l'iut par chaque mois
            $select_janvier_iut = $db->query("SELECT SUM(a.depense) AS depense_iut_janvier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=3 AND MONTH(dat_actuel) = 1 AND YEAR(dat_actuel) = '$annee'");
            $data_janvier_iut = $select_janvier_iut->fetch();

            $select_fevrier_iut = $db->query("SELECT SUM(a.depense) AS depense_iut_fevrier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=3 AND MONTH(dat_actuel) = 2 AND YEAR(dat_actuel) = '$annee'");
            $data_fevrier_iut = $select_fevrier_iut->fetch();

            $select_mars_iut = $db->query("SELECT SUM(a.depense) AS depense_iut_mars FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=3 AND MONTH(dat_actuel) = 3 AND YEAR(dat_actuel) = '$annee'");
            $data_mars_iut = $select_mars_iut->fetch();

            $select_avril_iut = $db->query("SELECT SUM(a.depense) AS depense_iut_avril FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=3 AND MONTH(dat_actuel) = 4 AND YEAR(dat_actuel) = '$annee'");
            $data_avril_iut = $select_avril_iut->fetch();

            $select_mai_iut = $db->query("SELECT SUM(a.depense) AS depense_iut_mai FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=3 AND MONTH(dat_actuel) = 5 AND YEAR(dat_actuel) = '$annee'");
            $data_mai_iut = $select_mai_iut->fetch();

            $select_juin_iut = $db->query("SELECT SUM(a.depense) AS depense_iut_juin FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=3 AND MONTH(dat_actuel) = 6 AND YEAR(dat_actuel) = '$annee'");
            $data_juin_iut = $select_juin_iut->fetch();

            $select_juillet_iut = $db->query("SELECT SUM(a.depense) AS depense_iut_juillet FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=3 AND MONTH(dat_actuel) = 7 AND YEAR(dat_actuel) = '$annee'");
            $data_juillet_iut = $select_juillet_iut->fetch();

            $select_aout_iut = $db->query("SELECT SUM(a.depense) AS depense_iut_aout FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=3 AND MONTH(dat_actuel) = 8 AND YEAR(dat_actuel) = '$annee'");
            $data_aout_iut = $select_aout_iut->fetch();

            $select_septembre_iut = $db->query("SELECT SUM(a.depense) AS depense_iut_septembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=3 AND MONTH(dat_actuel) = 9 AND YEAR(dat_actuel) = '$annee'");
            $data_septembre_iut = $select_septembre_iut->fetch();

            $select_octobre_iut = $db->query("SELECT SUM(a.depense) AS depense_iut_octobre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=3 AND MONTH(dat_actuel) = 10 AND YEAR(dat_actuel) = '$annee'");
            $data_octobre_iut = $select_octobre_iut->fetch();

            $select_novembre_iut = $db->query("SELECT SUM(a.depense) AS depense_iut_novembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=3 AND MONTH(dat_actuel) = 11 AND YEAR(dat_actuel) = '$annee'");
            $data_novembre_iut = $select_novembre_iut->fetch();

            $select_decembre_iut = $db->query("SELECT SUM(a.depense) AS depense_iut_decembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=3 AND MONTH(dat_actuel) = 12 AND YEAR(dat_actuel) = '$annee'");
            $data_decembre_iut = $select_decembre_iut->fetch();

            //Requete de CUFOP par chaque mois 
            $select_janvier_cufop = $db->query("SELECT SUM(a.depense) AS depense_cufop_janvier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=4 AND MONTH(dat_actuel) = 1 AND YEAR(dat_actuel) = '$annee'");
            $data_janvier_cufop = $select_janvier_cufop->fetch();

            $select_fevrier_cufop = $db->query("SELECT SUM(a.depense) AS depense_cufop_fevrier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=4 AND MONTH(dat_actuel) = 2 AND YEAR(dat_actuel) = '$annee'");
            $data_fevrier_cufop = $select_fevrier_cufop->fetch();

            $select_mars_cufop = $db->query("SELECT SUM(a.depense) AS depense_cufop_mars FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=4 AND MONTH(dat_actuel) = 3 AND YEAR(dat_actuel) = '$annee'");
            $data_mars_cufop = $select_mars_cufop->fetch();

            $select_avril_cufop = $db->query("SELECT SUM(a.depense) AS depense_cufop_avril FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=4 AND MONTH(dat_actuel) = 4 AND YEAR(dat_actuel) = '$annee'");
            $data_avril_cufop = $select_avril_cufop->fetch();

            $select_mai_cufop = $db->query("SELECT SUM(a.depense) AS depense_cufop_mai FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=4 AND MONTH(dat_actuel) = 5 AND YEAR(dat_actuel) = '$annee'");
            $data_mai_cufop = $select_mai_cufop->fetch();

            $select_juin_cufop = $db->query("SELECT SUM(a.depense) AS depense_cufop_juin FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=4 AND MONTH(dat_actuel) = 6 AND YEAR(dat_actuel) = '$annee'");
            $data_juin_cufop = $select_juin_cufop->fetch();

            $select_juillet_cufop = $db->query("SELECT SUM(a.depense) AS depense_cufop_juillet FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=4 AND MONTH(dat_actuel) = 7 AND YEAR(dat_actuel) = '$annee'");
            $data_juillet_cufop = $select_juillet_cufop->fetch();

            $select_aout_cufop = $db->query("SELECT SUM(a.depense) AS depense_cufop_aout FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=4 AND MONTH(dat_actuel) = 8 AND YEAR(dat_actuel) = '$annee'");
            $data_aout_cufop = $select_aout_cufop->fetch();

            $select_septembre_cufop = $db->query("SELECT SUM(a.depense) AS depense_cufop_septembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=4 AND MONTH(dat_actuel) = 9 AND YEAR(dat_actuel) = '$annee'");
            $data_septembre_cufop = $select_septembre_cufop->fetch();

            $select_octobre_cufop = $db->query("SELECT SUM(a.depense) AS depense_cufop_octobre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=4 AND MONTH(dat_actuel) = 10 AND YEAR(dat_actuel) = '$annee'");
            $data_octobre_cufop = $select_octobre_cufop->fetch();

            $select_novembre_cufop = $db->query("SELECT SUM(a.depense) AS depense_cufop_novembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=4 AND MONTH(dat_actuel) = 11 AND YEAR(dat_actuel) = '$annee'");
            $data_novembre_cufop = $select_novembre_cufop->fetch();

            $select_decembre_cufop = $db->query("SELECT SUM(a.depense) AS depense_cufop_decembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=4 AND MONTH(dat_actuel) = 12 AND YEAR(dat_actuel) = '$annee'");
            $data_decembre_cufop = $select_decembre_cufop->fetch();

            //Requete de la FIC par chaque mois
            $select_janvier_fic = $db->query("SELECT SUM(a.depense) AS depense_fic_janvier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=5 AND MONTH(dat_actuel) = 1 AND YEAR(dat_actuel) = '$annee'");
            $data_janvier_fic = $select_janvier_fic->fetch();

            $select_fevrier_fic = $db->query("SELECT SUM(a.depense) AS depense_fic_fevrier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=5 AND MONTH(dat_actuel) = 2 AND YEAR(dat_actuel) = '$annee'");
            $data_fevrier_fic = $select_fevrier_fic->fetch();

            $select_mars_fic = $db->query("SELECT SUM(a.depense) AS depense_fic_mars FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=5 AND MONTH(dat_actuel) = 3 AND YEAR(dat_actuel) = '$annee'");
            $data_mars_fic = $select_mars_fic->fetch();

            $select_avril_fic = $db->query("SELECT SUM(a.depense) AS depense_fic_avril FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=5 AND MONTH(dat_actuel) = 4 AND YEAR(dat_actuel) = '$annee'");
            $data_avril_fic = $select_avril_fic->fetch();

            $select_mai_fic = $db->query("SELECT SUM(a.depense) AS depense_fic_mai FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=5 AND MONTH(dat_actuel) = 5 AND YEAR(dat_actuel) = '$annee'");
            $data_mai_fic = $select_mai_fic->fetch();

            $select_juin_fic = $db->query("SELECT SUM(a.depense) AS depense_fic_juin FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=5 AND MONTH(dat_actuel) = 6 AND YEAR(dat_actuel) = '$annee'");
            $data_juin_fic = $select_juin_fic->fetch();

            $select_juillet_fic = $db->query("SELECT SUM(a.depense) AS depense_fic_juillet FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=5 AND MONTH(dat_actuel) = 7 AND YEAR(dat_actuel) = '$annee'");
            $data_juillet_fic = $select_juillet_fic->fetch();

            $select_aout_fic = $db->query("SELECT SUM(a.depense) AS depense_fic_aout FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=5 AND MONTH(dat_actuel) = 8 AND YEAR(dat_actuel) = '$annee'");
            $data_aout_fic = $select_aout_fic->fetch();

            $select_septembre_fic = $db->query("SELECT SUM(a.depense) AS depense_fic_septembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=5 AND MONTH(dat_actuel) = 9 AND YEAR(dat_actuel) = '$annee'");
            $data_septembre_fic = $select_septembre_fic->fetch();

            $select_octobre_fic = $db->query("SELECT SUM(a.depense) AS depense_fic_octobre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=5 AND MONTH(dat_actuel) = 10 AND YEAR(dat_actuel) = '$annee'");
            $data_octobre_fic = $select_octobre_fic->fetch();

            $select_novembre_fic = $db->query("SELECT SUM(a.depense) AS depense_fic_novembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=5 AND MONTH(dat_actuel) = 11 AND YEAR(dat_actuel) = '$annee'");
            $data_novembre_fic = $select_novembre_fic->fetch();

            $select_decembre_fic = $db->query("SELECT SUM(a.depense) AS depense_fic_decembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=5 AND MONTH(dat_actuel) = 12 AND YEAR(dat_actuel) = '$annee'");
            $data_decembre_fic = $select_decembre_fic->fetch();

            //Requete de l'IFERE par chaque mois
            $select_janvier_ifere = $db->query("SELECT SUM(a.depense) AS depense_ifere_janvier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=6 AND MONTH(dat_actuel) = 1 AND YEAR(dat_actuel) = '$annee'");
            $data_janvier_ifere = $select_janvier_ifere->fetch();

            $select_fevrier_ifere = $db->query("SELECT SUM(a.depense) AS depense_ifere_fevrier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=6 AND MONTH(dat_actuel) = 2 AND YEAR(dat_actuel) = '$annee'");
            $data_fevrier_ifere = $select_fevrier_ifere->fetch();

            $select_mars_ifere = $db->query("SELECT SUM(a.depense) AS depense_ifere_mars FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=6 AND MONTH(dat_actuel) = 3 AND YEAR(dat_actuel) = '$annee'");
            $data_mars_ifere = $select_mars_ifere->fetch();

            $select_avril_ifere = $db->query("SELECT SUM(a.depense) AS depense_ifere_avril FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=6 AND MONTH(dat_actuel) = 4 AND YEAR(dat_actuel) = '$annee'");
            $data_avril_ifere = $select_avril_ifere->fetch();

            $select_mai_ifere = $db->query("SELECT SUM(a.depense) AS depense_ifere_mai FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=6 AND MONTH(dat_actuel) = 5 AND YEAR(dat_actuel) = '$annee'");
            $data_mai_ifere = $select_mai_ifere->fetch();

            $select_juin_ifere = $db->query("SELECT SUM(a.depense) AS depense_ifere_juin FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=6 AND MONTH(dat_actuel) = 6 AND YEAR(dat_actuel) = '$annee'");
            $data_juin_ifere = $select_juin_ifere->fetch();

            $select_juillet_ifere = $db->query("SELECT SUM(a.depense) AS depense_ifere_juillet FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=6 AND MONTH(dat_actuel) = 7 AND YEAR(dat_actuel) = '$annee'");
            $data_juillet_ifere = $select_juillet_ifere->fetch();

            $select_aout_ifere = $db->query("SELECT SUM(a.depense) AS depense_ifere_aout FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=6 AND MONTH(dat_actuel) = 8 AND YEAR(dat_actuel) = '$annee'");
            $data_aout_ifere = $select_aout_ifere->fetch();

            $select_septembre_ifere = $db->query("SELECT SUM(a.depense) AS depense_ifere_septembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=6 AND MONTH(dat_actuel) = 9 AND YEAR(dat_actuel) = '$annee'");
            $data_septembre_ifere = $select_septembre_ifere->fetch();

            $select_octobre_ifere = $db->query("SELECT SUM(a.depense) AS depense_ifere_octobre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=6 AND MONTH(dat_actuel) = 10 AND YEAR(dat_actuel) = '$annee'");
            $data_octobre_ifere = $select_octobre_ifere->fetch();

            $select_novembre_ifere = $db->query("SELECT SUM(a.depense) AS depense_ifere_novembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=6 AND MONTH(dat_actuel) = 11 AND YEAR(dat_actuel) = '$annee'");
            $data_novembre_ifere = $select_novembre_ifere->fetch();

            $select_decembre_ifere = $db->query("SELECT SUM(a.depense) AS depense_ifere_decembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=6 AND MONTH(dat_actuel) = 12 AND YEAR(dat_actuel) = '$annee'");
            $data_decembre_ifere = $select_decembre_ifere->fetch();

            //Requete de la FLSH par chaque mois
            $select_janvier_flsh = $db->query("SELECT SUM(a.depense) AS depense_flsh_janvier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=7 AND MONTH(dat_actuel) = 1 AND YEAR(dat_actuel) = '$annee'");
            $data_janvier_flsh = $select_janvier_flsh->fetch();

            $select_fevrier_flsh = $db->query("SELECT SUM(a.depense) AS depense_flsh_fevrier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=7 AND MONTH(dat_actuel) = 2 AND YEAR(dat_actuel) = '$annee'");
            $data_fevrier_flsh = $select_fevrier_flsh->fetch();

            $select_mars_flsh = $db->query("SELECT SUM(a.depense) AS depense_flsh_mars FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=7 AND MONTH(dat_actuel) = 3 AND YEAR(dat_actuel) = '$annee'");
            $data_mars_flsh = $select_mars_flsh->fetch();

            $select_avril_flsh = $db->query("SELECT SUM(a.depense) AS depense_flsh_avril FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=7 AND MONTH(dat_actuel) = 4 AND YEAR(dat_actuel) = '$annee'");
            $data_avril_flsh = $select_avril_flsh->fetch();

            $select_mai_flsh = $db->query("SELECT SUM(a.depense) AS depense_flsh_mai FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=7 AND MONTH(dat_actuel) = 5 AND YEAR(dat_actuel) = '$annee'");
            $data_mai_flsh = $select_mai_flsh->fetch();

            $select_juin_flsh = $db->query("SELECT SUM(a.depense) AS depense_flsh_juin FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=7 AND MONTH(dat_actuel) = 6 AND YEAR(dat_actuel) = '$annee'");
            $data_juin_flsh = $select_juin_flsh->fetch();

            $select_juillet_flsh = $db->query("SELECT SUM(a.depense) AS depense_flsh_juillet FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=7 AND MONTH(dat_actuel) = 7 AND YEAR(dat_actuel) = '$annee'");
            $data_juillet_flsh = $select_juillet_flsh->fetch();

            $select_aout_flsh = $db->query("SELECT SUM(a.depense) AS depense_flsh_aout FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=7 AND MONTH(dat_actuel) = 8 AND YEAR(dat_actuel) = '$annee'");
            $data_aout_flsh = $select_aout_flsh->fetch();

            $select_septembre_flsh = $db->query("SELECT SUM(a.depense) AS depense_flsh_septembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=7 AND MONTH(dat_actuel) = 9 AND YEAR(dat_actuel) = '$annee'");
            $data_septembre_flsh = $select_septembre_flsh->fetch();

            $select_octobre_flsh = $db->query("SELECT SUM(a.depense) AS depense_flsh_octobre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=7 AND MONTH(dat_actuel) = 10 AND YEAR(dat_actuel) = '$annee'");
            $data_octobre_flsh = $select_octobre_flsh->fetch();

            $select_novembre_flsh = $db->query("SELECT SUM(a.depense) AS depense_flsh_novembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=7 AND MONTH(dat_actuel) = 11 AND YEAR(dat_actuel) = '$annee'");
            $data_novembre_flsh = $select_novembre_flsh->fetch();

            $select_decembre_flsh = $db->query("SELECT SUM(a.depense) AS depense_flsh_decembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=7 AND MONTH(dat_actuel) = 12 AND YEAR(dat_actuel) = '$annee'");
            $data_decembre_flsh = $select_decembre_flsh->fetch();

            //Requete de la EMSP par chaque mois
            $select_janvier_emsp = $db->query("SELECT SUM(a.depense) AS depense_emsp_janvier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=8 AND MONTH(dat_actuel) = 1 AND YEAR(dat_actuel) = '$annee'");
            $data_janvier_emsp = $select_janvier_emsp->fetch();

            $select_fevrier_emsp = $db->query("SELECT SUM(a.depense) AS depense_emsp_fevrier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=8 AND MONTH(dat_actuel) = 2 AND YEAR(dat_actuel) = '$annee'");
            $data_fevrier_emsp = $select_fevrier_emsp->fetch();

            $select_mars_emsp = $db->query("SELECT SUM(a.depense) AS depense_emsp_mars FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=8 AND MONTH(dat_actuel) = 3 AND YEAR(dat_actuel) = '$annee'");
            $data_mars_emsp = $select_mars_emsp->fetch();

            $select_avril_emsp = $db->query("SELECT SUM(a.depense) AS depense_emsp_avril FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=8 AND MONTH(dat_actuel) = 4 AND YEAR(dat_actuel) = '$annee'");
            $data_avril_emsp = $select_avril_emsp->fetch();

            $select_mai_emsp = $db->query("SELECT SUM(a.depense) AS depense_emsp_mai FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=8 AND MONTH(dat_actuel) = 5 AND YEAR(dat_actuel) = '$annee'");
            $data_mai_emsp = $select_mai_emsp->fetch();

            $select_juin_emsp = $db->query("SELECT SUM(a.depense) AS depense_emsp_juin FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=8 AND MONTH(dat_actuel) = 6 AND YEAR(dat_actuel) = '$annee'");
            $data_juin_emsp = $select_juin_emsp->fetch();

            $select_juillet_emsp = $db->query("SELECT SUM(a.depense) AS depense_emsp_juillet FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=8 AND MONTH(dat_actuel) = 7 AND YEAR(dat_actuel) = '$annee'");
            $data_juillet_emsp = $select_juillet_emsp->fetch();

            $select_aout_emsp = $db->query("SELECT SUM(a.depense) AS depense_emsp_aout FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=8 AND MONTH(dat_actuel) = 8 AND YEAR(dat_actuel) = '$annee'");
            $data_aout_emsp = $select_aout_emsp->fetch();

            $select_septembre_emsp = $db->query("SELECT SUM(a.depense) AS depense_emsp_septembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=8 AND MONTH(dat_actuel) = 9 AND YEAR(dat_actuel) = '$annee'");
            $data_septembre_emsp = $select_septembre_emsp->fetch();

            $select_octobre_emsp = $db->query("SELECT SUM(a.depense) AS depense_emsp_octobre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=8 AND MONTH(dat_actuel) = 10 AND YEAR(dat_actuel) = '$annee'");
            $data_octobre_emsp = $select_octobre_emsp->fetch();

            $select_novembre_emsp = $db->query("SELECT SUM(a.depense) AS depense_emsp_novembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=8 AND MONTH(dat_actuel) = 11 AND YEAR(dat_actuel) = '$annee'");
            $data_novembre_emsp = $select_novembre_emsp->fetch();

            $select_decembre_emsp = $db->query("SELECT SUM(a.depense) AS depense_emsp_decembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=8 AND MONTH(dat_actuel) = 12 AND YEAR(dat_actuel) = '$annee'");
            $data_decembre_emsp = $select_decembre_emsp->fetch();

            //Requete de la FDSE par chaque mois
            $select_janvier_fdse = $db->query("SELECT SUM(a.depense) AS depense_fdse_janvier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=9 AND MONTH(dat_actuel) = 1 AND YEAR(dat_actuel) = '$annee'");
            $data_janvier_fdse = $select_janvier_fdse->fetch();

            $select_fevrier_fdse = $db->query("SELECT SUM(a.depense) AS depense_fdse_fevrier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=9 AND MONTH(dat_actuel) = 2 AND YEAR(dat_actuel) = '$annee'");
            $data_fevrier_fdse = $select_fevrier_fdse->fetch();

            $select_mars_fdse = $db->query("SELECT SUM(a.depense) AS depense_fdse_mars FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=9 AND MONTH(dat_actuel) = 3 AND YEAR(dat_actuel) = '$annee'");
            $data_mars_fdse = $select_mars_fdse->fetch();

            $select_avril_fdse = $db->query("SELECT SUM(a.depense) AS depense_fdse_avril FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=9 AND MONTH(dat_actuel) = 4 AND YEAR(dat_actuel) = '$annee'");
            $data_avril_fdse = $select_avril_fdse->fetch();

            $select_mai_fdse = $db->query("SELECT SUM(a.depense) AS depense_fdse_mai FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=9 AND MONTH(dat_actuel) = 5 AND YEAR(dat_actuel) = '$annee'");
            $data_mai_fdse = $select_mai_fdse->fetch();

            $select_juin_fdse = $db->query("SELECT SUM(a.depense) AS depense_fdse_juin FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=9 AND MONTH(dat_actuel) = 6 AND YEAR(dat_actuel) = '$annee'");
            $data_juin_fdse = $select_juin_fdse->fetch();

            $select_juillet_fdse = $db->query("SELECT SUM(a.depense) AS depense_fdse_juillet FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=9 AND MONTH(dat_actuel) = 7 AND YEAR(dat_actuel) = '$annee'");
            $data_juillet_fdse = $select_juillet_fdse->fetch();

            $select_aout_fdse = $db->query("SELECT SUM(a.depense) AS depense_fdse_aout FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=9 AND MONTH(dat_actuel) = 8 AND YEAR(dat_actuel) = '$annee'");
            $data_aout_fdse = $select_aout_fdse->fetch();

            $select_septembre_fdse = $db->query("SELECT SUM(a.depense) AS depense_fdse_septembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=9 AND MONTH(dat_actuel) = 9 AND YEAR(dat_actuel) = '$annee'");
            $data_septembre_fdse = $select_septembre_fdse->fetch();

            $select_octobre_fdse = $db->query("SELECT SUM(a.depense) AS depense_fdse_octobre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=9 AND MONTH(dat_actuel) = 10 AND YEAR(dat_actuel) = '$annee'");
            $data_octobre_fdse = $select_octobre_fdse->fetch();

            $select_novembre_fdse = $db->query("SELECT SUM(a.depense) AS depense_fdse_novembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=9 AND MONTH(dat_actuel) = 11 AND YEAR(dat_actuel) = '$annee'");
            $data_novembre_fdse = $select_novembre_fdse->fetch();

            $select_decembre_fdse = $db->query("SELECT SUM(a.depense) AS depense_fdse_decembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=9 AND MONTH(dat_actuel) = 12 AND YEAR(dat_actuel) = '$annee'");
            $data_decembre_fdse = $select_decembre_fdse->fetch();

            //Requete de la CUP par chaque mois
            $select_janvier_cup = $db->query("SELECT SUM(a.depense) AS depense_cup_janvier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=10 AND MONTH(dat_actuel) = 1 AND YEAR(dat_actuel) = '$annee'");
            $data_janvier_cup = $select_janvier_cup->fetch();

            $select_fevrier_cup = $db->query("SELECT SUM(a.depense) AS depense_cup_fevrier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=10 AND MONTH(dat_actuel) = 2 AND YEAR(dat_actuel) = '$annee'");
            $data_fevrier_cup = $select_fevrier_cup->fetch();

            $select_mars_cup = $db->query("SELECT SUM(a.depense) AS depense_cup_mars FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=10 AND MONTH(dat_actuel) = 3 AND YEAR(dat_actuel) = '$annee'");
            $data_mars_cup = $select_mars_cup->fetch();

            $select_avril_cup = $db->query("SELECT SUM(a.depense) AS depense_cup_avril FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=10 AND MONTH(dat_actuel) = 4 AND YEAR(dat_actuel) = '$annee'");
            $data_avril_cup = $select_avril_cup->fetch();

            $select_mai_cup = $db->query("SELECT SUM(a.depense) AS depense_cup_mai FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=10 AND MONTH(dat_actuel) = 5 AND YEAR(dat_actuel) = '$annee'");
            $data_mai_cup = $select_mai_cup->fetch();

            $select_juin_cup = $db->query("SELECT SUM(a.depense) AS depense_cup_juin FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=10 AND MONTH(dat_actuel) = 6 AND YEAR(dat_actuel) = '$annee'");
            $data_juin_cup = $select_juin_cup->fetch();

            $select_juillet_cup = $db->query("SELECT SUM(a.depense) AS depense_cup_juillet FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=10 AND MONTH(dat_actuel) = 7 AND YEAR(dat_actuel) = '$annee'");
            $data_juillet_cup = $select_juillet_cup->fetch();

            $select_aout_cup = $db->query("SELECT SUM(a.depense) AS depense_cup_aout FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=10 AND MONTH(dat_actuel) = 8 AND YEAR(dat_actuel) = '$annee'");
            $data_aout_cup = $select_aout_cup->fetch();

            $select_septembre_cup = $db->query("SELECT SUM(a.depense) AS depense_cup_septembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=10 AND MONTH(dat_actuel) = 9 AND YEAR(dat_actuel) = '$annee'");
            $data_septembre_cup = $select_septembre_cup->fetch();

            $select_octobre_cup = $db->query("SELECT SUM(a.depense) AS depense_cup_octobre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=10 AND MONTH(dat_actuel) = 10 AND YEAR(dat_actuel) = '$annee'");
            $data_octobre_cup = $select_octobre_cup->fetch();

            $select_novembre_cup = $db->query("SELECT SUM(a.depense) AS depense_cup_novembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=10 AND MONTH(dat_actuel) = 11 AND YEAR(dat_actuel) = '$annee'");
            $data_novembre_cup = $select_novembre_cup->fetch();

            $select_decembre_cup = $db->query("SELECT SUM(a.depense) AS depense_cup_decembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=10 AND MONTH(dat_actuel) = 12 AND YEAR(dat_actuel) = '$annee'");
            $data_decembre_cup = $select_decembre_cup->fetch();

            //Requete de la CUM par chaque mois
            $select_janvier_cum = $db->query("SELECT SUM(a.depense) AS depense_cum_janvier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=11 AND MONTH(dat_actuel) = 1 AND YEAR(dat_actuel) = '$annee'");
            $data_janvier_cum = $select_janvier_cum->fetch();

            $select_fevrier_cum = $db->query("SELECT SUM(a.depense) AS depense_cum_fevrier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=11 AND MONTH(dat_actuel) = 2 AND YEAR(dat_actuel) = '$annee'");
            $data_fevrier_cum = $select_fevrier_cum->fetch();

            $select_mars_cum = $db->query("SELECT SUM(a.depense) AS depense_cum_mars FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=11 AND MONTH(dat_actuel) = 3 AND YEAR(dat_actuel) = '$annee'");
            $data_mars_cum = $select_mars_cum->fetch();

            $select_avril_cum = $db->query("SELECT SUM(a.depense) AS depense_cum_avril FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=11 AND MONTH(dat_actuel) = 4 AND YEAR(dat_actuel) = '$annee'");
            $data_avril_cum = $select_avril_cum->fetch();

            $select_mai_cum = $db->query("SELECT SUM(a.depense) AS depense_cum_mai FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=11 AND MONTH(dat_actuel) = 5 AND YEAR(dat_actuel) = '$annee'");
            $data_mai_cum = $select_mai_cum->fetch();

            $select_juin_cum = $db->query("SELECT SUM(a.depense) AS depense_cum_juin FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=11 AND MONTH(dat_actuel) = 6 AND YEAR(dat_actuel) = '$annee'");
            $data_juin_cum = $select_juin_cum->fetch();

            $select_juillet_cum = $db->query("SELECT SUM(a.depense) AS depense_cum_juillet FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=11 AND MONTH(dat_actuel) = 7 AND YEAR(dat_actuel) = '$annee'");
            $data_juillet_cum = $select_juillet_cum->fetch();

            $select_aout_cum = $db->query("SELECT SUM(a.depense) AS depense_cum_aout FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=11 AND MONTH(dat_actuel) = 8 AND YEAR(dat_actuel) = '$annee'");
            $data_aout_cum = $select_aout_cum->fetch();

            $select_septembre_cum = $db->query("SELECT SUM(a.depense) AS depense_cum_septembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=11 AND MONTH(dat_actuel) = 9 AND YEAR(dat_actuel) = '$annee'");
            $data_septembre_cum = $select_septembre_cum->fetch();

            $select_octobre_cum = $db->query("SELECT SUM(a.depense) AS depense_cum_octobre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=11 AND MONTH(dat_actuel) = 10 AND YEAR(dat_actuel) = '$annee'");
            $data_octobre_cum = $select_octobre_cum->fetch();

            $select_novembre_cum = $db->query("SELECT SUM(a.depense) AS depense_cum_novembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=11 AND MONTH(dat_actuel) = 11 AND YEAR(dat_actuel) = '$annee'");
            $data_novembre_cum = $select_novembre_cum->fetch();

            $select_decembre_cum = $db->query("SELECT SUM(a.depense) AS depense_cum_decembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=11 AND MONTH(dat_actuel) = 12 AND YEAR(dat_actuel) = '$annee'");
            $data_decembre_cum = $select_decembre_cum->fetch();

            //Requete final pour totaliser la depense de l'UDC
            $depense_total_janvier = $data_janvier_ac['depense_ac_janvier'] + $data_janvier_iut['depense_iut_janvier'] + $data_janvier_ifere['depense_ifere_janvier'] + $data_janvier_fst['depense_fst_janvier'] + $data_janvier_fic['depense_fic_janvier'] + $data_janvier_flsh['depense_flsh_janvier'] + $data_janvier_cufop['depense_cufop_janvier'] + $data_janvier_emsp['depense_emsp_janvier'] + $data_janvier_fdse['depense_fdse_janvier'] + $data_janvier_cup['depense_cup_janvier'] + $data_janvier_cum['depense_cum_janvier'];
            $depense_total_fevrier = $data_fevrier_ac['depense_ac_fevrier'] + $data_fevrier_iut['depense_iut_fevrier'] + $data_fevrier_ifere['depense_ifere_fevrier'] + $data_fevrier_fst['depense_fst_fevrier'] + $data_fevrier_fic['depense_fic_fevrier'] + $data_fevrier_flsh['depense_flsh_fevrier'] + $data_fevrier_cufop['depense_cufop_fevrier'] + $data_fevrier_emsp['depense_emsp_fevrier'] + $data_fevrier_fdse['depense_fdse_fevrier'] + $data_fevrier_cup['depense_cup_fevrier'] + $data_fevrier_cum['depense_cum_fevrier'];
            $depense_total_mars = $data_mars_ac['depense_ac_mars'] + $data_mars_iut['depense_iut_mars'] + $data_mars_ifere['depense_ifere_mars'] + $data_mars_fst['depense_fst_mars'] + $data_mars_fic['depense_fic_mars'] + $data_mars_flsh['depense_flsh_mars'] + $data_mars_cufop['depense_cufop_mars'] + $data_mars_emsp['depense_emsp_mars'] + $data_mars_fdse['depense_fdse_mars'] + $data_mars_cup['depense_cup_mars'] + $data_mars_cum['depense_cum_mars'];
            $depense_total_avril = $data_avril_ac['depense_ac_avril'] + $data_avril_iut['depense_iut_avril'] + $data_avril_ifere['depense_ifere_avril'] + $data_avril_fst['depense_fst_avril'] + $data_avril_fic['depense_fic_avril'] + $data_avril_flsh['depense_flsh_avril'] + $data_avril_cufop['depense_cufop_avril'] + $data_avril_emsp['depense_emsp_avril'] + $data_avril_fdse['depense_fdse_avril'] + $data_avril_cup['depense_cup_avril'] + $data_avril_cum['depense_cum_avril'];
            $depense_total_mai = $data_mai_ac['depense_ac_mai'] + $data_mai_iut['depense_iut_mai'] + $data_mai_ifere['depense_ifere_mai'] + $data_mai_fst['depense_fst_mai'] + $data_mai_fic['depense_fic_mai'] + $data_mai_flsh['depense_flsh_mai'] + $data_mai_cufop['depense_cufop_mai'] + $data_mai_emsp['depense_emsp_mai'] + $data_mai_fdse['depense_fdse_mai'] + $data_mai_cup['depense_cup_mai'] + $data_mai_cum['depense_cum_mai'];
            $depense_total_juin = $data_juin_ac['depense_ac_juin'] + $data_juin_iut['depense_iut_juin'] + $data_juin_ifere['depense_ifere_juin'] + $data_juin_fst['depense_fst_juin'] + $data_juin_fic['depense_fic_juin'] + $data_juin_flsh['depense_flsh_juin'] + $data_juin_cufop['depense_cufop_juin'] + $data_juin_emsp['depense_emsp_juin'] + $data_juin_fdse['depense_fdse_juin'] + $data_juin_cup['depense_cup_juin'] + $data_juin_cum['depense_cum_juin'];
            $depense_total_juillet = $data_juillet_ac['depense_ac_juillet'] + $data_juillet_iut['depense_iut_juillet'] + $data_juillet_ifere['depense_ifere_juillet'] + $data_juillet_fst['depense_fst_juillet'] + $data_juillet_fic['depense_fic_juillet'] + $data_juillet_flsh['depense_flsh_juillet'] + $data_juillet_cufop['depense_cufop_juillet'] + $data_juillet_emsp['depense_emsp_juillet'] + $data_juillet_fdse['depense_fdse_juillet'] + $data_juillet_cup['depense_cup_juillet'] + $data_juillet_cum['depense_cum_juillet'];
            $depense_total_aout = $data_aout_ac['depense_ac_aout'] + $data_aout_iut['depense_iut_aout'] + $data_aout_ifere['depense_ifere_aout'] + $data_aout_fst['depense_fst_aout'] + $data_aout_fic['depense_fic_aout'] + $data_aout_flsh['depense_flsh_aout'] + $data_aout_cufop['depense_cufop_aout'] + $data_aout_emsp['depense_emsp_aout'] + $data_aout_fdse['depense_fdse_aout'] + $data_aout_cup['depense_cup_aout'] + $data_aout_cum['depense_cum_aout'];
            $depense_total_septembre = $data_septembre_ac['depense_ac_septembre'] + $data_septembre_iut['depense_iut_septembre'] + $data_septembre_ifere['depense_ifere_septembre'] + $data_septembre_fst['depense_fst_septembre'] + $data_septembre_fic['depense_fic_septembre'] + $data_septembre_flsh['depense_flsh_septembre'] + $data_septembre_cufop['depense_cufop_septembre'] + $data_septembre_emsp['depense_emsp_septembre'] + $data_septembre_fdse['depense_fdse_septembre'] + $data_septembre_cup['depense_cup_septembre'] + $data_septembre_cum['depense_cum_septembre'];
            $depense_total_octobre = $data_octobre_ac['depense_ac_octobre'] + $data_octobre_iut['depense_iut_octobre'] + $data_octobre_ifere['depense_ifere_octobre'] + $data_octobre_fst['depense_fst_octobre'] + $data_octobre_fic['depense_fic_octobre'] + $data_octobre_flsh['depense_flsh_octobre'] + $data_octobre_cufop['depense_cufop_octobre'] + $data_octobre_emsp['depense_emsp_octobre'] + $data_octobre_fdse['depense_fdse_octobre'] + $data_octobre_cup['depense_cup_octobre'] + $data_octobre_cum['depense_cum_octobre'];
            $depense_total_novembre = $data_novembre_ac['depense_ac_novembre'] + $data_novembre_iut['depense_iut_novembre'] + $data_novembre_ifere['depense_ifere_novembre'] + $data_novembre_fst['depense_fst_novembre'] + $data_novembre_fic['depense_fic_novembre'] + $data_novembre_flsh['depense_flsh_novembre'] + $data_novembre_cufop['depense_cufop_novembre'] + $data_novembre_emsp['depense_emsp_novembre'] + $data_novembre_fdse['depense_fdse_novembre'] + $data_novembre_cup['depense_cup_novembre'] + $data_novembre_cum['depense_cum_novembre'];
            $depense_total_decembre = $data_decembre_ac['depense_ac_decembre'] + $data_decembre_iut['depense_iut_decembre'] + $data_decembre_ifere['depense_ifere_decembre'] + $data_decembre_fst['depense_fst_decembre'] + $data_decembre_fic['depense_fic_decembre'] + $data_decembre_flsh['depense_flsh_decembre'] + $data_decembre_cufop['depense_cufop_decembre'] + $data_decembre_emsp['depense_emsp_decembre'] + $data_decembre_fdse['depense_fdse_decembre'] + $data_novembre_cup['depense_cup_novembre'] + $data_novembre_cum['depense_cum_novembre'];

        }else{
            $annee = date('Y');

            //requetes de depense pour dynamiser les courbes
            //Requete de l'AC par chque mois
            $select_janvier_ac = $db->query("SELECT SUM(a.depense) AS depense_ac_janvier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=1 AND MONTH(dat_actuel) = 1 AND YEAR(dat_actuel) = '$annee'");
            $data_janvier_ac = $select_janvier_ac->fetch();

            $select_fevrier_ac = $db->query("SELECT SUM(a.depense) AS depense_ac_fevrier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=1 AND MONTH(dat_actuel) = 2 AND YEAR(dat_actuel) = '$annee'");
            $data_fevrier_ac = $select_fevrier_ac->fetch();

            $select_mars_ac = $db->query("SELECT SUM(a.depense) AS depense_ac_mars FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=1 AND MONTH(dat_actuel) = 3 AND YEAR(dat_actuel) = '$annee'");
            $data_mars_ac = $select_mars_ac->fetch();

            $select_avril_ac = $db->query("SELECT SUM(a.depense) AS depense_ac_avril FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=1 AND MONTH(dat_actuel) = 4 AND YEAR(dat_actuel) = '$annee'");
            $data_avril_ac = $select_avril_ac->fetch();

            $select_mai_ac = $db->query("SELECT SUM(a.depense) AS depense_ac_mai FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=1 AND MONTH(dat_actuel) = 5 AND YEAR(dat_actuel) = '$annee'");
            $data_mai_ac = $select_mai_ac->fetch();

            $select_juin_ac = $db->query("SELECT SUM(a.depense) AS depense_ac_juin FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=1 AND MONTH(dat_actuel) = 6 AND YEAR(dat_actuel) = '$annee'");
            $data_juin_ac = $select_juin_ac->fetch();

            $select_juillet_ac = $db->query("SELECT SUM(a.depense) AS depense_ac_juillet FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=1 AND MONTH(dat_actuel) = 7 AND YEAR(dat_actuel) = '$annee'");
            $data_juillet_ac = $select_juillet_ac->fetch();

            $select_aout_ac = $db->query("SELECT SUM(a.depense) AS depense_ac_aout FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=1 AND MONTH(dat_actuel) = 8 AND YEAR(dat_actuel) = '$annee'");
            $data_aout_ac = $select_aout_ac->fetch();

            $select_septembre_ac = $db->query("SELECT SUM(a.depense) AS depense_ac_septembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=1 AND MONTH(dat_actuel) = 9 AND YEAR(dat_actuel) = '$annee'");
            $data_septembre_ac = $select_septembre_ac->fetch();

            $select_octobre_ac = $db->query("SELECT SUM(a.depense) AS depense_ac_octobre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=1 AND MONTH(dat_actuel) = 10 AND YEAR(dat_actuel) = '$annee'");
            $data_octobre_ac = $select_octobre_ac->fetch();

            $select_novembre_ac = $db->query("SELECT SUM(a.depense) AS depense_ac_novembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=1 AND MONTH(dat_actuel) = 11 AND YEAR(dat_actuel) = '$annee'");
            $data_novembre_ac = $select_novembre_ac->fetch();

            $select_decembre_ac = $db->query("SELECT SUM(a.depense) AS depense_ac_decembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=1 AND MONTH(dat_actuel) = 12 AND YEAR(dat_actuel) = '$annee'");
            $data_decembre_ac = $select_decembre_ac->fetch();

            //Requete de la FST par chaque mois
            $select_janvier_fst = $db->query("SELECT SUM(a.depense) AS depense_fst_janvier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=2 AND MONTH(dat_actuel) = 1 AND YEAR(dat_actuel) = '$annee'");
            $data_janvier_fst = $select_janvier_fst->fetch();

            $select_fevrier_fst = $db->query("SELECT SUM(a.depense) AS depense_fst_fevrier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=2 AND MONTH(dat_actuel) = 2 AND YEAR(dat_actuel) = '$annee'");
            $data_fevrier_fst = $select_fevrier_fst->fetch();

            $select_mars_fst = $db->query("SELECT SUM(a.depense) AS depense_fst_mars FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=2 AND MONTH(dat_actuel) = 3 AND YEAR(dat_actuel) = '$annee'");
            $data_mars_fst = $select_mars_fst->fetch();

            $select_avril_fst = $db->query("SELECT SUM(a.depense) AS depense_fst_avril FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=2 AND MONTH(dat_actuel) = 4 AND YEAR(dat_actuel) = '$annee'");
            $data_avril_fst = $select_avril_fst->fetch();

            $select_mai_fst = $db->query("SELECT SUM(a.depense) AS depense_fst_mai FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=2 AND MONTH(dat_actuel) = 5 AND YEAR(dat_actuel) = '$annee'");
            $data_mai_fst = $select_mai_fst->fetch();

            $select_juin_fst = $db->query("SELECT SUM(a.depense) AS depense_fst_juin FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=2 AND MONTH(dat_actuel) = 6 AND YEAR(dat_actuel) = '$annee'");
            $data_juin_fst = $select_juin_fst->fetch();

            $select_juillet_fst = $db->query("SELECT SUM(a.depense) AS depense_fst_juillet FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=2 AND MONTH(dat_actuel) = 7 AND YEAR(dat_actuel) = '$annee'");
            $data_juillet_fst = $select_juillet_fst->fetch();

            $select_aout_fst = $db->query("SELECT SUM(a.depense) AS depense_fst_aout FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=2 AND MONTH(dat_actuel) = 8 AND YEAR(dat_actuel) = '$annee'");
            $data_aout_fst = $select_aout_fst->fetch();

            $select_septembre_fst = $db->query("SELECT SUM(a.depense) AS depense_fst_septembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=2 AND MONTH(dat_actuel) = 9 AND YEAR(dat_actuel) = '$annee'");
            $data_septembre_fst = $select_septembre_fst->fetch();

            $select_octobre_fst = $db->query("SELECT SUM(a.depense) AS depense_fst_octobre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=2 AND MONTH(dat_actuel) = 10 AND YEAR(dat_actuel) = '$annee'");
            $data_octobre_fst = $select_octobre_fst->fetch();

            $select_novembre_fst = $db->query("SELECT SUM(a.depense) AS depense_fst_novembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=2 AND MONTH(dat_actuel) = 11 AND YEAR(dat_actuel) = '$annee'");
            $data_novembre_fst = $select_novembre_fst->fetch();

            $select_decembre_fst = $db->query("SELECT SUM(a.depense) AS depense_fst_decembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=2 AND MONTH(dat_actuel) = 12 AND YEAR(dat_actuel) = '$annee'");
            $data_decembre_fst = $select_decembre_fst->fetch();

            //Requetes de l'iut par chaque mois
            $select_janvier_iut = $db->query("SELECT SUM(a.depense) AS depense_iut_janvier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=3 AND MONTH(dat_actuel) = 1 AND YEAR(dat_actuel) = '$annee'");
            $data_janvier_iut = $select_janvier_iut->fetch();

            $select_fevrier_iut = $db->query("SELECT SUM(a.depense) AS depense_iut_fevrier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=3 AND MONTH(dat_actuel) = 2 AND YEAR(dat_actuel) = '$annee'");
            $data_fevrier_iut = $select_fevrier_iut->fetch();

            $select_mars_iut = $db->query("SELECT SUM(a.depense) AS depense_iut_mars FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=3 AND MONTH(dat_actuel) = 3 AND YEAR(dat_actuel) = '$annee'");
            $data_mars_iut = $select_mars_iut->fetch();

            $select_avril_iut = $db->query("SELECT SUM(a.depense) AS depense_iut_avril FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=3 AND MONTH(dat_actuel) = 4 AND YEAR(dat_actuel) = '$annee'");
            $data_avril_iut = $select_avril_iut->fetch();

            $select_mai_iut = $db->query("SELECT SUM(a.depense) AS depense_iut_mai FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=3 AND MONTH(dat_actuel) = 5 AND YEAR(dat_actuel) = '$annee'");
            $data_mai_iut = $select_mai_iut->fetch();

            $select_juin_iut = $db->query("SELECT SUM(a.depense) AS depense_iut_juin FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=3 AND MONTH(dat_actuel) = 6 AND YEAR(dat_actuel) = '$annee'");
            $data_juin_iut = $select_juin_iut->fetch();

            $select_juillet_iut = $db->query("SELECT SUM(a.depense) AS depense_iut_juillet FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=3 AND MONTH(dat_actuel) = 7 AND YEAR(dat_actuel) = '$annee'");
            $data_juillet_iut = $select_juillet_iut->fetch();

            $select_aout_iut = $db->query("SELECT SUM(a.depense) AS depense_iut_aout FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=3 AND MONTH(dat_actuel) = 8 AND YEAR(dat_actuel) = '$annee'");
            $data_aout_iut = $select_aout_iut->fetch();

            $select_septembre_iut = $db->query("SELECT SUM(a.depense) AS depense_iut_septembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=3 AND MONTH(dat_actuel) = 9 AND YEAR(dat_actuel) = '$annee'");
            $data_septembre_iut = $select_septembre_iut->fetch();

            $select_octobre_iut = $db->query("SELECT SUM(a.depense) AS depense_iut_octobre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=3 AND MONTH(dat_actuel) = 10 AND YEAR(dat_actuel) = '$annee'");
            $data_octobre_iut = $select_octobre_iut->fetch();

            $select_novembre_iut = $db->query("SELECT SUM(a.depense) AS depense_iut_novembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=3 AND MONTH(dat_actuel) = 11 AND YEAR(dat_actuel) = '$annee'");
            $data_novembre_iut = $select_novembre_iut->fetch();

            $select_decembre_iut = $db->query("SELECT SUM(a.depense) AS depense_iut_decembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=3 AND MONTH(dat_actuel) = 12 AND YEAR(dat_actuel) = '$annee'");
            $data_decembre_iut = $select_decembre_iut->fetch();

            //Requete de CUFOP par chaque mois 
            $select_janvier_cufop = $db->query("SELECT SUM(a.depense) AS depense_cufop_janvier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=4 AND MONTH(dat_actuel) = 1 AND YEAR(dat_actuel) = '$annee'");
            $data_janvier_cufop = $select_janvier_cufop->fetch();

            $select_fevrier_cufop = $db->query("SELECT SUM(a.depense) AS depense_cufop_fevrier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=4 AND MONTH(dat_actuel) = 2 AND YEAR(dat_actuel) = '$annee'");
            $data_fevrier_cufop = $select_fevrier_cufop->fetch();

            $select_mars_cufop = $db->query("SELECT SUM(a.depense) AS depense_cufop_mars FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=4 AND MONTH(dat_actuel) = 3 AND YEAR(dat_actuel) = '$annee'");
            $data_mars_cufop = $select_mars_cufop->fetch();

            $select_avril_cufop = $db->query("SELECT SUM(a.depense) AS depense_cufop_avril FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=4 AND MONTH(dat_actuel) = 4 AND YEAR(dat_actuel) = '$annee'");
            $data_avril_cufop = $select_avril_cufop->fetch();

            $select_mai_cufop = $db->query("SELECT SUM(a.depense) AS depense_cufop_mai FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=4 AND MONTH(dat_actuel) = 5 AND YEAR(dat_actuel) = '$annee'");
            $data_mai_cufop = $select_mai_cufop->fetch();

            $select_juin_cufop = $db->query("SELECT SUM(a.depense) AS depense_cufop_juin FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=4 AND MONTH(dat_actuel) = 6 AND YEAR(dat_actuel) = '$annee'");
            $data_juin_cufop = $select_juin_cufop->fetch();

            $select_juillet_cufop = $db->query("SELECT SUM(a.depense) AS depense_cufop_juillet FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=4 AND MONTH(dat_actuel) = 7 AND YEAR(dat_actuel) = '$annee'");
            $data_juillet_cufop = $select_juillet_cufop->fetch();

            $select_aout_cufop = $db->query("SELECT SUM(a.depense) AS depense_cufop_aout FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=4 AND MONTH(dat_actuel) = 8 AND YEAR(dat_actuel) = '$annee'");
            $data_aout_cufop = $select_aout_cufop->fetch();

            $select_septembre_cufop = $db->query("SELECT SUM(a.depense) AS depense_cufop_septembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=4 AND MONTH(dat_actuel) = 9 AND YEAR(dat_actuel) = '$annee'");
            $data_septembre_cufop = $select_septembre_cufop->fetch();

            $select_octobre_cufop = $db->query("SELECT SUM(a.depense) AS depense_cufop_octobre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=4 AND MONTH(dat_actuel) = 10 AND YEAR(dat_actuel) = '$annee'");
            $data_octobre_cufop = $select_octobre_cufop->fetch();

            $select_novembre_cufop = $db->query("SELECT SUM(a.depense) AS depense_cufop_novembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=4 AND MONTH(dat_actuel) = 11 AND YEAR(dat_actuel) = '$annee'");
            $data_novembre_cufop = $select_novembre_cufop->fetch();

            $select_decembre_cufop = $db->query("SELECT SUM(a.depense) AS depense_cufop_decembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=4 AND MONTH(dat_actuel) = 12 AND YEAR(dat_actuel) = '$annee'");
            $data_decembre_cufop = $select_decembre_cufop->fetch();

            //Requete de la FIC par chaque mois
            $select_janvier_fic = $db->query("SELECT SUM(a.depense) AS depense_fic_janvier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=5 AND MONTH(dat_actuel) = 1 AND YEAR(dat_actuel) = '$annee'");
            $data_janvier_fic = $select_janvier_fic->fetch();

            $select_fevrier_fic = $db->query("SELECT SUM(a.depense) AS depense_fic_fevrier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=5 AND MONTH(dat_actuel) = 2 AND YEAR(dat_actuel) = '$annee'");
            $data_fevrier_fic = $select_fevrier_fic->fetch();

            $select_mars_fic = $db->query("SELECT SUM(a.depense) AS depense_fic_mars FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=5 AND MONTH(dat_actuel) = 3 AND YEAR(dat_actuel) = '$annee'");
            $data_mars_fic = $select_mars_fic->fetch();

            $select_avril_fic = $db->query("SELECT SUM(a.depense) AS depense_fic_avril FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=5 AND MONTH(dat_actuel) = 4 AND YEAR(dat_actuel) = '$annee'");
            $data_avril_fic = $select_avril_fic->fetch();

            $select_mai_fic = $db->query("SELECT SUM(a.depense) AS depense_fic_mai FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=5 AND MONTH(dat_actuel) = 5 AND YEAR(dat_actuel) = '$annee'");
            $data_mai_fic = $select_mai_fic->fetch();

            $select_juin_fic = $db->query("SELECT SUM(a.depense) AS depense_fic_juin FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=5 AND MONTH(dat_actuel) = 6 AND YEAR(dat_actuel) = '$annee'");
            $data_juin_fic = $select_juin_fic->fetch();

            $select_juillet_fic = $db->query("SELECT SUM(a.depense) AS depense_fic_juillet FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=5 AND MONTH(dat_actuel) = 7 AND YEAR(dat_actuel) = '$annee'");
            $data_juillet_fic = $select_juillet_fic->fetch();

            $select_aout_fic = $db->query("SELECT SUM(a.depense) AS depense_fic_aout FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=5 AND MONTH(dat_actuel) = 8 AND YEAR(dat_actuel) = '$annee'");
            $data_aout_fic = $select_aout_fic->fetch();

            $select_septembre_fic = $db->query("SELECT SUM(a.depense) AS depense_fic_septembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=5 AND MONTH(dat_actuel) = 9 AND YEAR(dat_actuel) = '$annee'");
            $data_septembre_fic = $select_septembre_fic->fetch();

            $select_octobre_fic = $db->query("SELECT SUM(a.depense) AS depense_fic_octobre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=5 AND MONTH(dat_actuel) = 10 AND YEAR(dat_actuel) = '$annee'");
            $data_octobre_fic = $select_octobre_fic->fetch();

            $select_novembre_fic = $db->query("SELECT SUM(a.depense) AS depense_fic_novembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=5 AND MONTH(dat_actuel) = 11 AND YEAR(dat_actuel) = '$annee'");
            $data_novembre_fic = $select_novembre_fic->fetch();

            $select_decembre_fic = $db->query("SELECT SUM(a.depense) AS depense_fic_decembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=5 AND MONTH(dat_actuel) = 12 AND YEAR(dat_actuel) = '$annee'");
            $data_decembre_fic = $select_decembre_fic->fetch();

            //Requete de l'IFERE par chaque mois
            $select_janvier_ifere = $db->query("SELECT SUM(a.depense) AS depense_ifere_janvier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=6 AND MONTH(dat_actuel) = 1 AND YEAR(dat_actuel) = '$annee'");
            $data_janvier_ifere = $select_janvier_ifere->fetch();

            $select_fevrier_ifere = $db->query("SELECT SUM(a.depense) AS depense_ifere_fevrier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=6 AND MONTH(dat_actuel) = 2 AND YEAR(dat_actuel) = '$annee'");
            $data_fevrier_ifere = $select_fevrier_ifere->fetch();

            $select_mars_ifere = $db->query("SELECT SUM(a.depense) AS depense_ifere_mars FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=6 AND MONTH(dat_actuel) = 3 AND YEAR(dat_actuel) = '$annee'");
            $data_mars_ifere = $select_mars_ifere->fetch();

            $select_avril_ifere = $db->query("SELECT SUM(a.depense) AS depense_ifere_avril FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=6 AND MONTH(dat_actuel) = 4 AND YEAR(dat_actuel) = '$annee'");
            $data_avril_ifere = $select_avril_ifere->fetch();

            $select_mai_ifere = $db->query("SELECT SUM(a.depense) AS depense_ifere_mai FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=6 AND MONTH(dat_actuel) = 5 AND YEAR(dat_actuel) = '$annee'");
            $data_mai_ifere = $select_mai_ifere->fetch();

            $select_juin_ifere = $db->query("SELECT SUM(a.depense) AS depense_ifere_juin FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=6 AND MONTH(dat_actuel) = 6 AND YEAR(dat_actuel) = '$annee'");
            $data_juin_ifere = $select_juin_ifere->fetch();

            $select_juillet_ifere = $db->query("SELECT SUM(a.depense) AS depense_ifere_juillet FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=6 AND MONTH(dat_actuel) = 7 AND YEAR(dat_actuel) = '$annee'");
            $data_juillet_ifere = $select_juillet_ifere->fetch();

            $select_aout_ifere = $db->query("SELECT SUM(a.depense) AS depense_ifere_aout FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=6 AND MONTH(dat_actuel) = 8 AND YEAR(dat_actuel) = '$annee'");
            $data_aout_ifere = $select_aout_ifere->fetch();

            $select_septembre_ifere = $db->query("SELECT SUM(a.depense) AS depense_ifere_septembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=6 AND MONTH(dat_actuel) = 9 AND YEAR(dat_actuel) = '$annee'");
            $data_septembre_ifere = $select_septembre_ifere->fetch();

            $select_octobre_ifere = $db->query("SELECT SUM(a.depense) AS depense_ifere_octobre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=6 AND MONTH(dat_actuel) = 10 AND YEAR(dat_actuel) = '$annee'");
            $data_octobre_ifere = $select_octobre_ifere->fetch();

            $select_novembre_ifere = $db->query("SELECT SUM(a.depense) AS depense_ifere_novembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=6 AND MONTH(dat_actuel) = 11 AND YEAR(dat_actuel) = '$annee'");
            $data_novembre_ifere = $select_novembre_ifere->fetch();

            $select_decembre_ifere = $db->query("SELECT SUM(a.depense) AS depense_ifere_decembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=6 AND MONTH(dat_actuel) = 12 AND YEAR(dat_actuel) = '$annee'");
            $data_decembre_ifere = $select_decembre_ifere->fetch();

            //Requete de la FLSH par chaque mois
            $select_janvier_flsh = $db->query("SELECT SUM(a.depense) AS depense_flsh_janvier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=7 AND MONTH(dat_actuel) = 1 AND YEAR(dat_actuel) = '$annee'");
            $data_janvier_flsh = $select_janvier_flsh->fetch();

            $select_fevrier_flsh = $db->query("SELECT SUM(a.depense) AS depense_flsh_fevrier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=7 AND MONTH(dat_actuel) = 2 AND YEAR(dat_actuel) = '$annee'");
            $data_fevrier_flsh = $select_fevrier_flsh->fetch();

            $select_mars_flsh = $db->query("SELECT SUM(a.depense) AS depense_flsh_mars FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=7 AND MONTH(dat_actuel) = 3 AND YEAR(dat_actuel) = '$annee'");
            $data_mars_flsh = $select_mars_flsh->fetch();

            $select_avril_flsh = $db->query("SELECT SUM(a.depense) AS depense_flsh_avril FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=7 AND MONTH(dat_actuel) = 4 AND YEAR(dat_actuel) = '$annee'");
            $data_avril_flsh = $select_avril_flsh->fetch();

            $select_mai_flsh = $db->query("SELECT SUM(a.depense) AS depense_flsh_mai FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=7 AND MONTH(dat_actuel) = 5 AND YEAR(dat_actuel) = '$annee'");
            $data_mai_flsh = $select_mai_flsh->fetch();

            $select_juin_flsh = $db->query("SELECT SUM(a.depense) AS depense_flsh_juin FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=7 AND MONTH(dat_actuel) = 6 AND YEAR(dat_actuel) = '$annee'");
            $data_juin_flsh = $select_juin_flsh->fetch();

            $select_juillet_flsh = $db->query("SELECT SUM(a.depense) AS depense_flsh_juillet FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=7 AND MONTH(dat_actuel) = 7 AND YEAR(dat_actuel) = '$annee'");
            $data_juillet_flsh = $select_juillet_flsh->fetch();

            $select_aout_flsh = $db->query("SELECT SUM(a.depense) AS depense_flsh_aout FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=7 AND MONTH(dat_actuel) = 8 AND YEAR(dat_actuel) = '$annee'");
            $data_aout_flsh = $select_aout_flsh->fetch();

            $select_septembre_flsh = $db->query("SELECT SUM(a.depense) AS depense_flsh_septembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=7 AND MONTH(dat_actuel) = 9 AND YEAR(dat_actuel) = '$annee'");
            $data_septembre_flsh = $select_septembre_flsh->fetch();

            $select_octobre_flsh = $db->query("SELECT SUM(a.depense) AS depense_flsh_octobre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=7 AND MONTH(dat_actuel) = 10 AND YEAR(dat_actuel) = '$annee'");
            $data_octobre_flsh = $select_octobre_flsh->fetch();

            $select_novembre_flsh = $db->query("SELECT SUM(a.depense) AS depense_flsh_novembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=7 AND MONTH(dat_actuel) = 11 AND YEAR(dat_actuel) = '$annee'");
            $data_novembre_flsh = $select_novembre_flsh->fetch();

            $select_decembre_flsh = $db->query("SELECT SUM(a.depense) AS depense_flsh_decembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=7 AND MONTH(dat_actuel) = 12 AND YEAR(dat_actuel) = '$annee'");
            $data_decembre_flsh = $select_decembre_flsh->fetch();

            //Requete de la EMSP par chaque mois
            $select_janvier_emsp = $db->query("SELECT SUM(a.depense) AS depense_emsp_janvier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=8 AND MONTH(dat_actuel) = 1 AND YEAR(dat_actuel) = '$annee'");
            $data_janvier_emsp = $select_janvier_emsp->fetch();

            $select_fevrier_emsp = $db->query("SELECT SUM(a.depense) AS depense_emsp_fevrier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=8 AND MONTH(dat_actuel) = 2 AND YEAR(dat_actuel) = '$annee'");
            $data_fevrier_emsp = $select_fevrier_emsp->fetch();

            $select_mars_emsp = $db->query("SELECT SUM(a.depense) AS depense_emsp_mars FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=8 AND MONTH(dat_actuel) = 3 AND YEAR(dat_actuel) = '$annee'");
            $data_mars_emsp = $select_mars_emsp->fetch();

            $select_avril_emsp = $db->query("SELECT SUM(a.depense) AS depense_emsp_avril FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=8 AND MONTH(dat_actuel) = 4 AND YEAR(dat_actuel) = '$annee'");
            $data_avril_emsp = $select_avril_emsp->fetch();

            $select_mai_emsp = $db->query("SELECT SUM(a.depense) AS depense_emsp_mai FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=8 AND MONTH(dat_actuel) = 5 AND YEAR(dat_actuel) = '$annee'");
            $data_mai_emsp = $select_mai_emsp->fetch();

            $select_juin_emsp = $db->query("SELECT SUM(a.depense) AS depense_emsp_juin FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=8 AND MONTH(dat_actuel) = 6 AND YEAR(dat_actuel) = '$annee'");
            $data_juin_emsp = $select_juin_emsp->fetch();

            $select_juillet_emsp = $db->query("SELECT SUM(a.depense) AS depense_emsp_juillet FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=8 AND MONTH(dat_actuel) = 7 AND YEAR(dat_actuel) = '$annee'");
            $data_juillet_emsp = $select_juillet_emsp->fetch();

            $select_aout_emsp = $db->query("SELECT SUM(a.depense) AS depense_emsp_aout FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=8 AND MONTH(dat_actuel) = 8 AND YEAR(dat_actuel) = '$annee'");
            $data_aout_emsp = $select_aout_emsp->fetch();

            $select_septembre_emsp = $db->query("SELECT SUM(a.depense) AS depense_emsp_septembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=8 AND MONTH(dat_actuel) = 9 AND YEAR(dat_actuel) = '$annee'");
            $data_septembre_emsp = $select_septembre_emsp->fetch();

            $select_octobre_emsp = $db->query("SELECT SUM(a.depense) AS depense_emsp_octobre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=8 AND MONTH(dat_actuel) = 10 AND YEAR(dat_actuel) = '$annee'");
            $data_octobre_emsp = $select_octobre_emsp->fetch();

            $select_novembre_emsp = $db->query("SELECT SUM(a.depense) AS depense_emsp_novembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=8 AND MONTH(dat_actuel) = 11 AND YEAR(dat_actuel) = '$annee'");
            $data_novembre_emsp = $select_novembre_emsp->fetch();

            $select_decembre_emsp = $db->query("SELECT SUM(a.depense) AS depense_emsp_decembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=8 AND MONTH(dat_actuel) = 12 AND YEAR(dat_actuel) = '$annee'");
            $data_decembre_emsp = $select_decembre_emsp->fetch();

            //Requete de la FDSE par chaque mois
            $select_janvier_fdse = $db->query("SELECT SUM(a.depense) AS depense_fdse_janvier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=9 AND MONTH(dat_actuel) = 1 AND YEAR(dat_actuel) = '$annee'");
            $data_janvier_fdse = $select_janvier_fdse->fetch();

            $select_fevrier_fdse = $db->query("SELECT SUM(a.depense) AS depense_fdse_fevrier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=9 AND MONTH(dat_actuel) = 2 AND YEAR(dat_actuel) = '$annee'");
            $data_fevrier_fdse = $select_fevrier_fdse->fetch();

            $select_mars_fdse = $db->query("SELECT SUM(a.depense) AS depense_fdse_mars FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=9 AND MONTH(dat_actuel) = 3 AND YEAR(dat_actuel) = '$annee'");
            $data_mars_fdse = $select_mars_fdse->fetch();

            $select_avril_fdse = $db->query("SELECT SUM(a.depense) AS depense_fdse_avril FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=9 AND MONTH(dat_actuel) = 4 AND YEAR(dat_actuel) = '$annee'");
            $data_avril_fdse = $select_avril_fdse->fetch();

            $select_mai_fdse = $db->query("SELECT SUM(a.depense) AS depense_fdse_mai FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=9 AND MONTH(dat_actuel) = 5 AND YEAR(dat_actuel) = '$annee'");
            $data_mai_fdse = $select_mai_fdse->fetch();

            $select_juin_fdse = $db->query("SELECT SUM(a.depense) AS depense_fdse_juin FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=9 AND MONTH(dat_actuel) = 6 AND YEAR(dat_actuel) = '$annee'");
            $data_juin_fdse = $select_juin_fdse->fetch();

            $select_juillet_fdse = $db->query("SELECT SUM(a.depense) AS depense_fdse_juillet FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=9 AND MONTH(dat_actuel) = 7 AND YEAR(dat_actuel) = '$annee'");
            $data_juillet_fdse = $select_juillet_fdse->fetch();

            $select_aout_fdse = $db->query("SELECT SUM(a.depense) AS depense_fdse_aout FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=9 AND MONTH(dat_actuel) = 8 AND YEAR(dat_actuel) = '$annee'");
            $data_aout_fdse = $select_aout_fdse->fetch();

            $select_septembre_fdse = $db->query("SELECT SUM(a.depense) AS depense_fdse_septembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=9 AND MONTH(dat_actuel) = 9 AND YEAR(dat_actuel) = '$annee'");
            $data_septembre_fdse = $select_septembre_fdse->fetch();

            $select_octobre_fdse = $db->query("SELECT SUM(a.depense) AS depense_fdse_octobre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=9 AND MONTH(dat_actuel) = 10 AND YEAR(dat_actuel) = '$annee'");
            $data_octobre_fdse = $select_octobre_fdse->fetch();

            $select_novembre_fdse = $db->query("SELECT SUM(a.depense) AS depense_fdse_novembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=9 AND MONTH(dat_actuel) = 11 AND YEAR(dat_actuel) = '$annee'");
            $data_novembre_fdse = $select_novembre_fdse->fetch();

            $select_decembre_fdse = $db->query("SELECT SUM(a.depense) AS depense_fdse_decembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=9 AND MONTH(dat_actuel) = 12 AND YEAR(dat_actuel) = '$annee'");
            $data_decembre_fdse = $select_decembre_fdse->fetch();

            //Requete de la CUP par chaque mois
            $select_janvier_cup = $db->query("SELECT SUM(a.depense) AS depense_cup_janvier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=10 AND MONTH(dat_actuel) = 1 AND YEAR(dat_actuel) = '$annee'");
            $data_janvier_cup = $select_janvier_cup->fetch();

            $select_fevrier_cup = $db->query("SELECT SUM(a.depense) AS depense_cup_fevrier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=10 AND MONTH(dat_actuel) = 2 AND YEAR(dat_actuel) = '$annee'");
            $data_fevrier_cup = $select_fevrier_cup->fetch();

            $select_mars_cup = $db->query("SELECT SUM(a.depense) AS depense_cup_mars FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=10 AND MONTH(dat_actuel) = 3 AND YEAR(dat_actuel) = '$annee'");
            $data_mars_cup = $select_mars_cup->fetch();

            $select_avril_cup = $db->query("SELECT SUM(a.depense) AS depense_cup_avril FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=10 AND MONTH(dat_actuel) = 4 AND YEAR(dat_actuel) = '$annee'");
            $data_avril_cup = $select_avril_cup->fetch();

            $select_mai_cup = $db->query("SELECT SUM(a.depense) AS depense_cup_mai FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=10 AND MONTH(dat_actuel) = 5 AND YEAR(dat_actuel) = '$annee'");
            $data_mai_cup = $select_mai_cup->fetch();

            $select_juin_cup = $db->query("SELECT SUM(a.depense) AS depense_cup_juin FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=10 AND MONTH(dat_actuel) = 6 AND YEAR(dat_actuel) = '$annee'");
            $data_juin_cup = $select_juin_cup->fetch();

            $select_juillet_cup = $db->query("SELECT SUM(a.depense) AS depense_cup_juillet FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=10 AND MONTH(dat_actuel) = 7 AND YEAR(dat_actuel) = '$annee'");
            $data_juillet_cup = $select_juillet_cup->fetch();

            $select_aout_cup = $db->query("SELECT SUM(a.depense) AS depense_cup_aout FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=10 AND MONTH(dat_actuel) = 8 AND YEAR(dat_actuel) = '$annee'");
            $data_aout_cup = $select_aout_cup->fetch();

            $select_septembre_cup = $db->query("SELECT SUM(a.depense) AS depense_cup_septembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=10 AND MONTH(dat_actuel) = 9 AND YEAR(dat_actuel) = '$annee'");
            $data_septembre_cup = $select_septembre_cup->fetch();

            $select_octobre_cup = $db->query("SELECT SUM(a.depense) AS depense_cup_octobre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=10 AND MONTH(dat_actuel) = 10 AND YEAR(dat_actuel) = '$annee'");
            $data_octobre_cup = $select_octobre_cup->fetch();

            $select_novembre_cup = $db->query("SELECT SUM(a.depense) AS depense_cup_novembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=10 AND MONTH(dat_actuel) = 11 AND YEAR(dat_actuel) = '$annee'");
            $data_novembre_cup = $select_novembre_cup->fetch();

            $select_decembre_cup = $db->query("SELECT SUM(a.depense) AS depense_cup_decembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=10 AND MONTH(dat_actuel) = 12 AND YEAR(dat_actuel) = '$annee'");
            $data_decembre_cup = $select_decembre_cup->fetch();

            //Requete de la CUM par chaque mois
            $select_janvier_cum = $db->query("SELECT SUM(a.depense) AS depense_cum_janvier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=11 AND MONTH(dat_actuel) = 1 AND YEAR(dat_actuel) = '$annee'");
            $data_janvier_cum = $select_janvier_cum->fetch();

            $select_fevrier_cum = $db->query("SELECT SUM(a.depense) AS depense_cum_fevrier FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=11 AND MONTH(dat_actuel) = 2 AND YEAR(dat_actuel) = '$annee'");
            $data_fevrier_cum = $select_fevrier_cum->fetch();

            $select_mars_cum = $db->query("SELECT SUM(a.depense) AS depense_cum_mars FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=11 AND MONTH(dat_actuel) = 3 AND YEAR(dat_actuel) = '$annee'");
            $data_mars_cum = $select_mars_cum->fetch();

            $select_avril_cum = $db->query("SELECT SUM(a.depense) AS depense_cum_avril FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=11 AND MONTH(dat_actuel) = 4 AND YEAR(dat_actuel) = '$annee'");
            $data_avril_cum = $select_avril_cum->fetch();

            $select_mai_cum = $db->query("SELECT SUM(a.depense) AS depense_cum_mai FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=11 AND MONTH(dat_actuel) = 5 AND YEAR(dat_actuel) = '$annee'");
            $data_mai_cum = $select_mai_cum->fetch();

            $select_juin_cum = $db->query("SELECT SUM(a.depense) AS depense_cum_juin FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=11 AND MONTH(dat_actuel) = 6 AND YEAR(dat_actuel) = '$annee'");
            $data_juin_cum = $select_juin_cum->fetch();

            $select_juillet_cum = $db->query("SELECT SUM(a.depense) AS depense_cum_juillet FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=11 AND MONTH(dat_actuel) = 7 AND YEAR(dat_actuel) = '$annee'");
            $data_juillet_cum = $select_juillet_cum->fetch();

            $select_aout_cum = $db->query("SELECT SUM(a.depense) AS depense_cum_aout FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=11 AND MONTH(dat_actuel) = 8 AND YEAR(dat_actuel) = '$annee'");
            $data_aout_cum = $select_aout_cum->fetch();

            $select_septembre_cum = $db->query("SELECT SUM(a.depense) AS depense_cum_septembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=11 AND MONTH(dat_actuel) = 9 AND YEAR(dat_actuel) = '$annee'");
            $data_septembre_cum = $select_septembre_cum->fetch();

            $select_octobre_cum = $db->query("SELECT SUM(a.depense) AS depense_cum_octobre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=11 AND MONTH(dat_actuel) = 10 AND YEAR(dat_actuel) = '$annee'");
            $data_octobre_cum = $select_octobre_cum->fetch();

            $select_novembre_cum = $db->query("SELECT SUM(a.depense) AS depense_cum_novembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=11 AND MONTH(dat_actuel) = 11 AND YEAR(dat_actuel) = '$annee'");
            $data_novembre_cum = $select_novembre_cum->fetch();

            $select_decembre_cum = $db->query("SELECT SUM(a.depense) AS depense_cum_decembre FROM affectation a LEFT JOIN user u ON a.id_user_affecte = u.id_user WHERE u.id_composant=11 AND MONTH(dat_actuel) = 12 AND YEAR(dat_actuel) = '$annee'");
            $data_decembre_cum = $select_decembre_cum->fetch();

            //Requete final pour totaliser la depense de l'UDC
            $depense_total_janvier = $data_janvier_ac['depense_ac_janvier'] + $data_janvier_iut['depense_iut_janvier'] + $data_janvier_ifere['depense_ifere_janvier'] + $data_janvier_fst['depense_fst_janvier'] + $data_janvier_fic['depense_fic_janvier'] + $data_janvier_flsh['depense_flsh_janvier'] + $data_janvier_cufop['depense_cufop_janvier'] + $data_janvier_emsp['depense_emsp_janvier'] + $data_janvier_fdse['depense_fdse_janvier'] + $data_janvier_cup['depense_cup_janvier'] + $data_janvier_cum['depense_cum_janvier'];
            $depense_total_fevrier = $data_fevrier_ac['depense_ac_fevrier'] + $data_fevrier_iut['depense_iut_fevrier'] + $data_fevrier_ifere['depense_ifere_fevrier'] + $data_fevrier_fst['depense_fst_fevrier'] + $data_fevrier_fic['depense_fic_fevrier'] + $data_fevrier_flsh['depense_flsh_fevrier'] + $data_fevrier_cufop['depense_cufop_fevrier'] + $data_fevrier_emsp['depense_emsp_fevrier'] + $data_fevrier_fdse['depense_fdse_fevrier'] + $data_fevrier_cup['depense_cup_fevrier'] + $data_fevrier_cum['depense_cum_fevrier'];
            $depense_total_mars = $data_mars_ac['depense_ac_mars'] + $data_mars_iut['depense_iut_mars'] + $data_mars_ifere['depense_ifere_mars'] + $data_mars_fst['depense_fst_mars'] + $data_mars_fic['depense_fic_mars'] + $data_mars_flsh['depense_flsh_mars'] + $data_mars_cufop['depense_cufop_mars'] + $data_mars_emsp['depense_emsp_mars'] + $data_mars_fdse['depense_fdse_mars'] + $data_mars_cup['depense_cup_mars'] + $data_mars_cum['depense_cum_mars'];
            $depense_total_avril = $data_avril_ac['depense_ac_avril'] + $data_avril_iut['depense_iut_avril'] + $data_avril_ifere['depense_ifere_avril'] + $data_avril_fst['depense_fst_avril'] + $data_avril_fic['depense_fic_avril'] + $data_avril_flsh['depense_flsh_avril'] + $data_avril_cufop['depense_cufop_avril'] + $data_avril_emsp['depense_emsp_avril'] + $data_avril_fdse['depense_fdse_avril'] + $data_avril_cup['depense_cup_avril'] + $data_avril_cum['depense_cum_avril'];
            $depense_total_mai = $data_mai_ac['depense_ac_mai'] + $data_mai_iut['depense_iut_mai'] + $data_mai_ifere['depense_ifere_mai'] + $data_mai_fst['depense_fst_mai'] + $data_mai_fic['depense_fic_mai'] + $data_mai_flsh['depense_flsh_mai'] + $data_mai_cufop['depense_cufop_mai'] + $data_mai_emsp['depense_emsp_mai'] + $data_mai_fdse['depense_fdse_mai'] + $data_mai_cup['depense_cup_mai'] + $data_mai_cum['depense_cum_mai'];
            $depense_total_juin = $data_juin_ac['depense_ac_juin'] + $data_juin_iut['depense_iut_juin'] + $data_juin_ifere['depense_ifere_juin'] + $data_juin_fst['depense_fst_juin'] + $data_juin_fic['depense_fic_juin'] + $data_juin_flsh['depense_flsh_juin'] + $data_juin_cufop['depense_cufop_juin'] + $data_juin_emsp['depense_emsp_juin'] + $data_juin_fdse['depense_fdse_juin'] + $data_juin_cup['depense_cup_juin'] + $data_juin_cum['depense_cum_juin'];
            $depense_total_juillet = $data_juillet_ac['depense_ac_juillet'] + $data_juillet_iut['depense_iut_juillet'] + $data_juillet_ifere['depense_ifere_juillet'] + $data_juillet_fst['depense_fst_juillet'] + $data_juillet_fic['depense_fic_juillet'] + $data_juillet_flsh['depense_flsh_juillet'] + $data_juillet_cufop['depense_cufop_juillet'] + $data_juillet_emsp['depense_emsp_juillet'] + $data_juillet_fdse['depense_fdse_juillet'] + $data_juillet_cup['depense_cup_juillet'] + $data_juillet_cum['depense_cum_juillet'];
            $depense_total_aout = $data_aout_ac['depense_ac_aout'] + $data_aout_iut['depense_iut_aout'] + $data_aout_ifere['depense_ifere_aout'] + $data_aout_fst['depense_fst_aout'] + $data_aout_fic['depense_fic_aout'] + $data_aout_flsh['depense_flsh_aout'] + $data_aout_cufop['depense_cufop_aout'] + $data_aout_emsp['depense_emsp_aout'] + $data_aout_fdse['depense_fdse_aout'] + $data_aout_cup['depense_cup_aout'] + $data_aout_cum['depense_cum_aout'];
            $depense_total_septembre = $data_septembre_ac['depense_ac_septembre'] + $data_septembre_iut['depense_iut_septembre'] + $data_septembre_ifere['depense_ifere_septembre'] + $data_septembre_fst['depense_fst_septembre'] + $data_septembre_fic['depense_fic_septembre'] + $data_septembre_flsh['depense_flsh_septembre'] + $data_septembre_cufop['depense_cufop_septembre'] + $data_septembre_emsp['depense_emsp_septembre'] + $data_septembre_fdse['depense_fdse_septembre'] + $data_septembre_cup['depense_cup_septembre'] + $data_septembre_cum['depense_cum_septembre'];
            $depense_total_octobre = $data_octobre_ac['depense_ac_octobre'] + $data_octobre_iut['depense_iut_octobre'] + $data_octobre_ifere['depense_ifere_octobre'] + $data_octobre_fst['depense_fst_octobre'] + $data_octobre_fic['depense_fic_octobre'] + $data_octobre_flsh['depense_flsh_octobre'] + $data_octobre_cufop['depense_cufop_octobre'] + $data_octobre_emsp['depense_emsp_octobre'] + $data_octobre_fdse['depense_fdse_octobre'] + $data_octobre_cup['depense_cup_octobre'] + $data_octobre_cum['depense_cum_octobre'];
            $depense_total_novembre = $data_novembre_ac['depense_ac_novembre'] + $data_novembre_iut['depense_iut_novembre'] + $data_novembre_ifere['depense_ifere_novembre'] + $data_novembre_fst['depense_fst_novembre'] + $data_novembre_fic['depense_fic_novembre'] + $data_novembre_flsh['depense_flsh_novembre'] + $data_novembre_cufop['depense_cufop_novembre'] + $data_novembre_emsp['depense_emsp_novembre'] + $data_novembre_fdse['depense_fdse_novembre'] + $data_novembre_cup['depense_cup_novembre'] + $data_novembre_cum['depense_cum_novembre'];
            $depense_total_decembre = $data_decembre_ac['depense_ac_decembre'] + $data_decembre_iut['depense_iut_decembre'] + $data_decembre_ifere['depense_ifere_decembre'] + $data_decembre_fst['depense_fst_decembre'] + $data_decembre_fic['depense_fic_decembre'] + $data_decembre_flsh['depense_flsh_decembre'] + $data_decembre_cufop['depense_cufop_decembre'] + $data_decembre_emsp['depense_emsp_decembre'] + $data_decembre_fdse['depense_fdse_decembre'] + $data_novembre_cup['depense_cup_novembre'] + $data_novembre_cum['depense_cum_novembre'];

        }
        
    ?>
    <!DOCTYPE html>
    <html>
    <!--Head-->
    <?php
        $logo = "index.php";
        $nav = "statistique";
        $title = "Statistiques";
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
                <div id="login">
                    <div id="admin" style="width:100%; margin-top:-30px;">
                        <div id='sectionAimprimer'> 
                            <div style="width:100%; border:1px solid black; padding:20px 20px 20px 20px ; margin-bottom:20px; background-color:white;">
                                <h3 style="margin-top:10px; margin-bottom:30px;text-align:center;">Statistiques de dépense</h3>
                                <div class="chart-container" style="position: relative; height:80vh; width:100%">
                                    <canvas id="myChart"></canvas>
                                </div>
                                <script>
                                    var ctx = document.getElementById('myChart').getContext('2d');
                                    var chart = new Chart(ctx, {
                                    // The type of chart we want to create
                                    type: 'line',

                                    // The data for our dataset
                                    data: {
                                        labels: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre','Decembre'],
                                        datasets: [
                                            {
                                            label: 'AC',
                                            backgroundColor: 'rgb(255, 255, 255, 0.1)',
                                            borderColor: 'rgb(255, 99, 132)',
                                            data: [<?php echo $data_janvier_ac['depense_ac_janvier']; ?>, <?php echo $data_fevrier_ac['depense_ac_fevrier']; ?>, <?php echo $data_mars_ac['depense_ac_mars']; ?>, <?php echo $data_avril_ac['depense_ac_avril']; ?>, <?php echo $data_mai_ac['depense_ac_mai']; ?>, <?php echo $data_juin_ac['depense_ac_juin']; ?>, <?php echo $data_juillet_ac['depense_ac_juillet']; ?>, <?php echo $data_aout_ac['depense_ac_aout']; ?>, <?php echo $data_septembre_ac['depense_ac_septembre']; ?>, <?php echo $data_octobre_ac['depense_ac_octobre']; ?>, <?php echo $data_novembre_ac['depense_ac_novembre']; ?>, <?php echo $data_decembre_ac['depense_ac_decembre']; ?>]
                                            },
                                            {
                                            label: 'IUT',
                                            backgroundColor: 'rgb(255, 255, 255, 0.1)',
                                            borderColor: 'rgb(0, 74, 255)',
                                            borderDash : [3],
                                            borderWidth : 1,
                                            data: [<?php echo $data_janvier_iut['depense_iut_janvier']; ?>, <?php echo $data_fevrier_iut['depense_iut_fevrier']; ?>, <?php echo $data_mars_iut['depense_iut_mars']; ?>, <?php echo $data_avril_iut['depense_iut_avril']; ?>, <?php echo $data_mai_iut['depense_iut_mai']; ?>, <?php echo $data_juin_iut['depense_iut_juin']; ?>, <?php echo $data_juillet_iut['depense_iut_juillet']; ?>, <?php echo $data_aout_iut['depense_iut_aout']; ?>, <?php echo $data_septembre_iut['depense_iut_septembre']; ?>, <?php echo $data_octobre_iut['depense_iut_octobre']; ?>, <?php echo $data_novembre_iut['depense_iut_novembre']; ?>, <?php echo $data_decembre_iut['depense_iut_decembre']; ?>]
                                            },
                                            {
                                            label: 'IFERE',
                                            backgroundColor: 'rgb(255, 255, 255, 0.1)',
                                            borderColor: 'rgb(207, 3, 255)',
                                            borderWidth : 2,
                                            data: [<?php echo $data_janvier_ifere['depense_ifere_janvier']; ?>, <?php echo $data_fevrier_ifere['depense_ifere_fevrier']; ?>, <?php echo $data_mars_ifere['depense_ifere_mars']; ?>, <?php echo $data_avril_ifere['depense_ifere_avril']; ?>, <?php echo $data_mai_ifere['depense_ifere_mai']; ?>, <?php echo $data_juin_ifere['depense_ifere_juin']; ?>, <?php echo $data_juillet_ifere['depense_ifere_juillet']; ?>, <?php echo $data_aout_ifere['depense_ifere_aout']; ?>, <?php echo $data_septembre_ifere['depense_ifere_septembre']; ?>, <?php echo $data_octobre_ifere['depense_ifere_octobre']; ?>, <?php echo $data_novembre_ifere['depense_ifere_novembre']; ?>, <?php echo $data_decembre_ifere['depense_ifere_decembre']; ?>]
                                            },
                                            {
                                            label: 'FST',
                                            backgroundColor: 'rgb(255, 255, 255, 0.1)',
                                            borderColor: 'rgb(196, 206, 58)',
                                            borderDash : [3],
                                            borderWidth : 2,
                                            data: [<?php echo $data_janvier_fst['depense_fst_janvier']; ?>, <?php echo $data_fevrier_fst['depense_fst_fevrier']; ?>, <?php echo $data_mars_fst['depense_fst_mars']; ?>, <?php echo $data_avril_fst['depense_fst_avril']; ?>, <?php echo $data_mai_fst['depense_fst_mai']; ?>, <?php echo $data_juin_fst['depense_fst_juin']; ?>, <?php echo $data_juillet_fst['depense_fst_juillet']; ?>, <?php echo $data_aout_fst['depense_fst_aout']; ?>, <?php echo $data_septembre_fst['depense_fst_septembre']; ?>, <?php echo $data_octobre_fst['depense_fst_octobre']; ?>, <?php echo $data_novembre_fst['depense_fst_novembre']; ?>, <?php echo $data_decembre_fst['depense_fst_decembre']; ?>]
                                            },
                                            {
                                            label: 'UDC',
                                            backgroundColor: 'rgb(255, 255, 255, 0.1)',
                                            borderColor: 'rgb(42, 165, 93)',
                                            borderWidth : 2,
                                            data: [<?php echo $depense_total_janvier; ?>, <?php echo $depense_total_fevrier; ?>, <?php echo $depense_total_mars; ?>, <?php echo $depense_total_avril; ?>, <?php echo $depense_total_mai; ?>, <?php echo $depense_total_juin; ?>, <?php echo $depense_total_juillet; ?>, <?php echo $depense_total_aout; ?>, <?php echo $depense_total_septembre; ?>, <?php echo $depense_total_octobre; ?>, <?php echo $depense_total_novembre; ?>, <?php echo $depense_total_decembre; ?>]
                                            },
                                            {
                                            label: 'FIC',
                                            backgroundColor: 'rgb(255, 255, 255, 0.1)',
                                            borderColor: 'rgb(54, 27, 88)',
                                            borderWidth : 2,
                                            data: [<?php echo $data_janvier_fic['depense_fic_janvier']; ?>, <?php echo $data_fevrier_fic['depense_fic_fevrier']; ?>, <?php echo $data_mars_fic['depense_fic_mars']; ?>, <?php echo $data_avril_fic['depense_fic_avril']; ?>, <?php echo $data_mai_fic['depense_fic_mai']; ?>, <?php echo $data_juin_fic['depense_fic_juin']; ?>, <?php echo $data_juillet_fic['depense_fic_juillet']; ?>, <?php echo $data_aout_fic['depense_fic_aout']; ?>, <?php echo $data_septembre_fic['depense_fic_septembre']; ?>, <?php echo $data_octobre_fic['depense_fic_octobre']; ?>, <?php echo $data_novembre_fic['depense_fic_novembre']; ?>, <?php echo $data_decembre_fic['depense_fic_decembre']; ?>]
                                            },
                                            {
                                            label: 'EMSP',
                                            backgroundColor: 'rgb(255, 255, 255, 0.1)',
                                            borderColor: 'rgb(32, 178, 170)',
                                            borderWidth : 2,
                                            data: [<?php echo $data_janvier_emsp['depense_emsp_janvier']; ?>, <?php echo $data_fevrier_emsp['depense_emsp_fevrier']; ?>, <?php echo $data_mars_emsp['depense_emsp_mars']; ?>, <?php echo $data_avril_emsp['depense_emsp_avril']; ?>, <?php echo $data_mai_emsp['depense_emsp_mai']; ?>, <?php echo $data_juin_emsp['depense_emsp_juin']; ?>, <?php echo $data_juillet_emsp['depense_emsp_juillet']; ?>, <?php echo $data_aout_emsp['depense_emsp_aout']; ?>, <?php echo $data_septembre_emsp['depense_emsp_septembre']; ?>, <?php echo $data_octobre_emsp['depense_emsp_octobre']; ?>, <?php echo $data_novembre_emsp['depense_emsp_novembre']; ?>, <?php echo $data_decembre_emsp['depense_emsp_decembre']; ?>]
                                            },
                                            {
                                            label: 'FLSH',
                                            backgroundColor: 'rgb(255, 255, 255, 0.1)',
                                            borderColor: 'rgb(88, 54, 255)',
                                            borderWidth : 2,
                                            data: [<?php echo $data_janvier_flsh['depense_flsh_janvier']; ?>, <?php echo $data_fevrier_flsh['depense_flsh_fevrier']; ?>, <?php echo $data_mars_flsh['depense_flsh_mars']; ?>, <?php echo $data_avril_flsh['depense_flsh_avril']; ?>, <?php echo $data_mai_flsh['depense_flsh_mai']; ?>, <?php echo $data_juin_flsh['depense_flsh_juin']; ?>, <?php echo $data_juillet_flsh['depense_flsh_juillet']; ?>, <?php echo $data_aout_flsh['depense_flsh_aout']; ?>, <?php echo $data_septembre_flsh['depense_flsh_septembre']; ?>, <?php echo $data_octobre_flsh['depense_flsh_octobre']; ?>, <?php echo $data_novembre_flsh['depense_flsh_novembre']; ?>, <?php echo $data_decembre_flsh['depense_flsh_decembre']; ?>]
                                            },
                                            {
                                            label: 'FDSE',
                                            backgroundColor: 'rgb(255, 255, 255, 0.1)',
                                            borderColor: 'rgb(150, 150, 150)',
                                            borderWidth : 2,
                                            data: [<?php echo $data_janvier_fdse['depense_fdse_janvier']; ?>, <?php echo $data_fevrier_fdse['depense_fdse_fevrier']; ?>, <?php echo $data_mars_fdse['depense_fdse_mars']; ?>, <?php echo $data_avril_fdse['depense_fdse_avril']; ?>, <?php echo $data_mai_fdse['depense_fdse_mai']; ?>, <?php echo $data_juin_fdse['depense_fdse_juin']; ?>, <?php echo $data_juillet_fdse['depense_fdse_juillet']; ?>, <?php echo $data_aout_fdse['depense_fdse_aout']; ?>, <?php echo $data_septembre_fdse['depense_fdse_septembre']; ?>, <?php echo $data_octobre_fdse['depense_fdse_octobre']; ?>, <?php echo $data_novembre_fdse['depense_fdse_novembre']; ?>, <?php echo $data_decembre_fdse['depense_fdse_decembre']; ?>]
                                            },
                                            {
                                            label: 'CUFOP',
                                            backgroundColor: 'rgb(255, 255, 255, 0.1)',
                                            borderColor: 'rgb(23, 140, 255)',
                                            borderWidth : 2,
                                            data: [<?php echo $data_janvier_cufop['depense_cufop_janvier']; ?>, <?php echo $data_fevrier_cufop['depense_cufop_fevrier']; ?>, <?php echo $data_mars_cufop['depense_cufop_mars']; ?>, <?php echo $data_avril_cufop['depense_cufop_avril']; ?>, <?php echo $data_mai_cufop['depense_cufop_mai']; ?>, <?php echo $data_juin_cufop['depense_cufop_juin']; ?>, <?php echo $data_juillet_cufop['depense_cufop_juillet']; ?>, <?php echo $data_aout_cufop['depense_cufop_aout']; ?>, <?php echo $data_septembre_cufop['depense_cufop_septembre']; ?>, <?php echo $data_octobre_cufop['depense_cufop_octobre']; ?>, <?php echo $data_novembre_cufop['depense_cufop_novembre']; ?>, <?php echo $data_decembre_cufop['depense_cufop_decembre']; ?>]
                                            },
                                            {
                                            label: 'CUP',
                                            backgroundColor: 'rgb(255, 255, 255, 0.1)',
                                            borderColor: 'rgb(245, 48, 12)',
                                            borderWidth : 2,
                                            data: [<?php echo $data_janvier_cup['depense_cup_janvier']; ?>, <?php echo $data_fevrier_cup['depense_cup_fevrier']; ?>, <?php echo $data_mars_cup['depense_cup_mars']; ?>, <?php echo $data_avril_cup['depense_cup_avril']; ?>, <?php echo $data_mai_cup['depense_cup_mai']; ?>, <?php echo $data_juin_cup['depense_cup_juin']; ?>, <?php echo $data_juillet_cup['depense_cup_juillet']; ?>, <?php echo $data_aout_cup['depense_cup_aout']; ?>, <?php echo $data_septembre_cup['depense_cup_septembre']; ?>, <?php echo $data_octobre_cup['depense_cup_octobre']; ?>, <?php echo $data_novembre_cup['depense_cup_novembre']; ?>, <?php echo $data_decembre_cup['depense_cup_decembre']; ?>]
                                            },
                                            {
                                            label: 'CUM',
                                            backgroundColor: 'rgb(255, 255, 255, 0.1)',
                                            borderColor: 'rgb(255, 255, 0)',
                                            borderWidth : 2,
                                            data: [<?php echo $data_janvier_cum['depense_cum_janvier']; ?>, <?php echo $data_fevrier_cum['depense_cum_fevrier']; ?>, <?php echo $data_mars_cum['depense_cum_mars']; ?>, <?php echo $data_avril_cum['depense_cum_avril']; ?>, <?php echo $data_mai_cum['depense_cum_mai']; ?>, <?php echo $data_juin_cum['depense_cum_juin']; ?>, <?php echo $data_juillet_cum['depense_cum_juillet']; ?>, <?php echo $data_aout_cum['depense_cum_aout']; ?>, <?php echo $data_septembre_cum['depense_cum_septembre']; ?>, <?php echo $data_octobre_cum['depense_cum_octobre']; ?>, <?php echo $data_novembre_cum['depense_cum_novembre']; ?>, <?php echo $data_decembre_cum['depense_cum_decembre']; ?>]
                                            }
                                        ]
                                    },

                                    // Configuration options go here
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false
                                    }
                                    });
                                    function beforePrintHandler () {
                                        for (var id in Chart.instances) {
                                            Chart.instances[id].resize();
                                        }
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="fiche_imprimer">
                    <a href="" onClick="printImage('myChart')">
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
    <script>
    function printImage(idCanvas) {
        // récup. de l'élément <canvas>
        const canvas = document.getElementById(idCanvas);
        // récup. des données de l'image du <canvas>
        const dataImage = canvas.toDataURL("image/png");
        // ouverture d'une nouvelle fenêtre
        const fen = window.open();
        // ouverture du document pour écriture
        fen.document.open();
        // insére un élément "<img> avec l'attribut src contenant les données de l'image
        fen.document.write('<link rel="stylesheet" href="../css/bootstrap.min.css">');
        fen.document.write('<link rel="stylesheet" href="../css/style.css">');
        fen.document.write('<div class="row">');
        fen.document.write('<div class="col-sm-3">');
        fen.document.write('<div class="logouniv" style="display:inline-block;">');
        fen.document.write('<img style="width:100px; height:100px;" src="../images/images.jpeg" class="rounded float-left" alt="Logo de l\'université">');
        fen.document.write('<h3 style = "font-size:16px; margin-left:5px; text-align:left;">Université<br><span style="font-size:12px;">des Comores</span></h3>');
        fen.document.write('</div>');
        fen.document.write('</div>');
        fen.document.write('<div class="col-sm-5" style="text-align:center;">');
        fen.document.write('<h4>Union des Comores</h4>');
        fen.document.write('<p>Unité-Solidarité-Développement</p>');
        fen.document.write('<h3>Université des Comores</h3>');
        fen.document.write('</div>');
        fen.document.write('</div>');
        fen.document.write('<h3 style="margin-top:10px; margin-bottom:30px;text-align:center;">Statistiques de dépense</h3>');
        fen.document.write("<img src='" + dataImage + "'>");
        // fermeture du document
        fen.document.close();
        // lance l'impression dès que chargé
        fen.onload = setTimeout(function() {
            fen.print();
            fen.close();
        }, 100);
    }

    </script>
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