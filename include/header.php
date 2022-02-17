<?php
  require_once '../include/config.php';
?>
<div class="container-fluid">
    <div class="row">
      <div class="col-sm-12 order-md-12 col-12" id="intendant">
         <div id="hot">
           <div class="row">
             <div class="col-sm-2">
                <div class="logouniv">
                    <a href="<?php if(isset($logo)): echo $logo; endif;?> ">
                    <img src="../images/images.jpeg" class="rounded float-left" alt="Logo de l'université">
                    <h3>Université<br><span>des Comores</span></h3>
                    </a>
                </div>
             </div>
             <div class="col-sm-6">
                <div class="union">
                  <h3><?= $affiche['nom_labo'] ?></h3><hr>
                  <h2>Bienvenue dans votre espace de travail</h2><hr>
                  <?php
                    $date = '';
                    foreach(JOURS as $j => $jours):
                      foreach(MOIS as $m => $mois):
                        if ($j + 1 === (int)date('N') AND $m + 1 === (int)date('n')) {
                          $date = $jours .' '.date('d').' '.$mois.' '.date('Y'); 
                        }
                  ?>
                     <?php endforeach; ?>
                  <?php endforeach; ?>
                  <p><?= $date ?></p>
                </div>
             </div>
             <div class="col-sm-4">
                <div id="profil">
                    <div id="icon">
                      <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-person-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                      </svg>
                      <h4><span><?= $affiche['nom_cat'] ?></span> : <?= $affiche['nom'] ?> <?= $affiche['prenom'] ?></h4>
                    </div>
                    <a href="modifierMDP.php">
                      <div id="icon">
                      <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-pencil" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M11.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z"/>
                        <path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 0 0 .5.5H4v.5a.5.5 0 0 0 .5.5H5v.5a.5.5 0 0 0 .5.5H6v-1.5a.5.5 0 0 0-.5-.5H5v-.5a.5.5 0 0 0-.5-.5H3z"/>
                      </svg>
                        <h5>Changer mon mot de passe</h5>
                      </div>
                    </a>
                    <a href="../include/deconnection.php">
                      <div id="icon">
                      <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-power" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5.578 4.437a5 5 0 1 0 4.922.044l.5-.866a6 6 0 1 1-5.908-.053l.486.875z"/>
                        <path fill-rule="evenodd" d="M7.5 8V1h1v7h-1z"/>
                      </svg>
                        <h5>Déconnexion</h5>
                      </div>
                    </a>
                </div>
             </div>
           </div>
         </div>
      </div>
    </div>
  </div>