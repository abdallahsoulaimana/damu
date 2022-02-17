<?php
    session_start();
    include('include/connexion.php');

    //Insertion d'une nouvelle année dans la table annee
    // $year = date('Y');
    // $annee_select = $db->query("SELECT * FROM annee WHERE annee = '$year'");
    // $annee_exist = $annee_select->rowCount();
    // if ($annee_exist == 0) {
    //     $insert_annee = $db->query("INSERT INTO annee (annee) VALUES ('$year')");
    // }

    //Fin de l'insertion de l'année
    if (isset($_POST['submit'])) {
        
        if (!empty($_POST['login']) && !empty($_POST['pass'])) {
        
            $login = htmlspecialchars($_POST['login']);
            $pass = sha1($_POST['pass']);

            $select = $db->prepare('SELECT * FROM user WHERE login=? AND passwod=? ');
            $select ->execute(array($login, $pass));
            $userexiste=$select->rowCount();

            if ($userexiste == 1) {
                
                $useraffiche=$select->fetch();
                $id_categorie = $useraffiche['id_cat'];

                switch ($id_categorie) {
                    case 1:
                        
                        $_SESSION['id_user']=$useraffiche['id_user'];
                        $_SESSION['id_categorie'] = $useraffiche['id_cat'];
                        $_SESSION['login']=$useraffiche['login'];
                        $login = $_SESSION['login'];
                            // $select_login = $db->query("SELECT * FROM enligne WHERE user_login = '$login'");
                            // $exist = $select_login->rowCount();
                            // if ($exist == 0) {
                            //     $insert = $db->query("INSERT INTO enligne (user_login) VALUES('$login')");
                            // }
                        header('Location: admin/index.php');
                       break;

                    case 2:
                        
                        $_SESSION['id_user']=$useraffiche['id_user'];
                        $_SESSION['login']=$useraffiche['login'];
                        $login = $_SESSION['login'];
                        $_SESSION['id_categorie'] = $useraffiche['id_cat'];
                        // $select_login = $db->query("SELECT * FROM enligne WHERE user_login = '$login'");
                        // $exist = $select_login->rowCount();
                        // if ($exist == 0) {
                        //     $insert = $db->query("INSERT INTO enligne (user_login) VALUES('$login')");
                        // }
                        header('Location: labo/index.php');
                       break;

                   
                    default:
                        $erreur = "Votre login ou mot de passe ne correspond pas.";
                       break;
                }               
            }
            else
            {
                $erreur = "Votre login ou mot de passe ne correspond pas.";
            }
        }else{
            $erreur ="Tous les champs doivent être complétés.";
        }
    }
?>
<!DOCTYPE html>
<html>
<!--Head-->
<head>
    <title>Damu</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/bootstrap.min.css">
  
    <link rel="stylesheet" href="css/style.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>


<body>
       
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Formulaire d'authentification blanc -->
                    <div id="login">
                        <div id="log">
                            <h3>Bienvenue</h3>
                            <h4>Damu</h4>
                            <div id="erreur">
                                <p><?php if (isset($erreur)) {
                                    echo $erreur;
                                } ?></p>
                            </div>
                            <form method="post">
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                    <input type="text" name="login" class="form-control" id="staticEmail" placeholder="Nom d'utilisateur">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                    <input type="password" name="pass" class="form-control" id="inputPassword" placeholder="Mot de passe">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                    <input type="submit" name="submit" class="form-control" value="Connexion">
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <div class="oublie">
                                                <p><a href="">Mot de passe oublié ?</a></p>
                                            </div>
                                        </div>
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
<?php include('include/js_footer.php');?>    
</html>