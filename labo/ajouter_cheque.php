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
    
        if (isset($_POST['submit'])) {
            
            if (!empty($_POST['num_cheque']) && !empty($_POST['date_cheque']) && !empty($_POST['libelle']) && !empty($_POST['beneficiaire']) && !empty($_POST['montant'])) {
            
                $num_cheque = htmlspecialchars($_POST['num_cheque']);
                $date_cheque = htmlspecialchars($_POST['date_cheque']);
                $libelle = htmlspecialchars($_POST['libelle']);
                $beneficiaire = htmlspecialchars($_POST['beneficiaire']);
                $montant = htmlspecialchars($_POST['montant']);
                    
                    $insert = $db->prepare("INSERT INTO cheque (num_cheque, date_cheque, libelle_cheque, beneficiaire, montant, date_enreg) VALUES ('$num_cheque', '$date_cheque', '$libelle', '$beneficiaire', '$montant', NOW())");
                    $insert->execute();

                    $alert = '<div class="alert alert-success" role="alert">
                          <h4 class="alert-heading">Félicitation !</h4>
                          <p>Le chèque du numero '.$num_cheque.' est bien enregistré !</p>
                          <h5 class="alert-heading">Merci !</h5>
                        </div>';

            }else{
                $erreur ="Tout les champs doivent être complétée";
            }
        }
    ?>
    <!DOCTYPE html>
    <html>
    <!--Head-->
    <?php
        $nav = "cheque";
        $title = "Nouvelle chèque";
        include('../include/head.php');
    ?>
    <body>
            <!--Header-->
            <?php include('../include/header.php');?>
            <?php include('menu/menu.php');?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                        <div class="col-sm-3"></div>
                            <div class=" col-sm-6" style="text-align: center; ">
                                <div id="alert">
                                    <p><?php if (isset($alert)) {
                                        echo $alert;
                                    } ?></p>
                                </div>
                            </div>
                        </div>
                        <div id="login">
                            <div id="admin">
                                <h3>Nouveau chèque</h3>
                                <div id="erreur">
                                    <p><?php if (isset($erreur)) {
                                        echo $erreur;
                                    } ?></p>
                                </div>
                                <form method="post" >
                                    <div class="form-group row">
                                        <label for="num_cheque" class="col-sm-4 col-form-label">Numero chèque</label>
                                        <div class="col-sm-8">
                                        <input type="number" name="num_cheque" class="form-control" id="num_cheque" required min="0">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="date_cheque" class="col-sm-4 col-form-label">Date du chèque </label>
                                        <div class="col-sm-8">
                                        <input type="date" name="date_cheque" class="form-control" required id="date_cheque">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="libelle" class="col-sm-4 col-form-label">Libelle du chèque </label>
                                        <div class="col-sm-8">
                                        <input type="text" name="libelle" class="form-control" required id="libelle" min="0">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="beneficiaire" class="col-sm-4 col-form-label">Beneficiaire</label>
                                        <div class="col-sm-8">
                                        <input type="text" name="beneficiaire" class="form-control" required id="beneficiaire">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="montant" class="col-sm-4 col-form-label">Montant</label>
                                        <div class="col-sm-8">
                                        <input type="number" name="montant" class="form-control" required id="montant" min="0">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                          <input type="reset" class="form-control" value="Annuler">
                                        </div>
                                        <div class="col-sm-6">
                                          <input type="submit" name="submit" class="form-control" value="Ajouter">
                                        </div>
                                    </div>
                                </form>
                            </div>
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