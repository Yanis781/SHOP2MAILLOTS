<?php 
    session_start();

    /* -----  VERIF ET REDIRECTION DU USER POUR VOIR SI C L'ADMIN OU PAS ----- */
     
    if ( !isset( $_SESSION['user'] ) ) {

        header('location: ../index.php');
        exit();

    }

    /* -----  SI USER = ADMIN, ON LE REDIRIGE VERS LE DASHBORAD (LA PAGE D'ADMINISTRATION DU SITE) ----- */

    if ( isset( $_SESSION['role'] ) && $_SESSION['role'] == 'admin' ) {

        header('location: ../admin/dashboard.php');
        exit();

    }

    /* ------------------------------------------------------------------------ */

    require_once("../bdd/connect_db.php");

    /* ----- MISE EN PLACE DU SYSTEME DE RECHERCHE DANS LE CATALOGUE ----- */

    $titre_page = "CATALOGUE";
    $valeur_recherche = ""; 

    if ( isset( $_GET['recherche'] ) && !empty( trim( $_GET['recherche'] ) ) ) {
        
        $valeur_recherche = htmlspecialchars( $_GET['recherche'] );
        
        $mot_cle = mysqli_real_escape_string( $con, trim( $_GET['recherche'] ) );
        
        $req = "SELECT id_maillot, nom_maillot, fichier_image FROM Maillot WHERE nom_maillot LIKE '%$mot_cle%'";
        
        $titre_page = "RÉSULTATS POUR : " . htmlspecialchars( $mot_cle );

    } else {
        $req = "SELECT id_maillot, nom_maillot, fichier_image FROM Maillot";
    }

    $result = mysqli_query( $con, $req );

?>

<!DOCTYPE html>
<html>

    <head>
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>SHOP2MAILLOTS { Catalogue }</title>

        <link rel="stylesheet" href="../ressources/css/styles.css">
        <link rel="icon" type="image/x-icon" href="../ressources/images/favicon.ico">

    </head>

    <body>

        <!---- AFFICHAGE DE L'ENTETE DE PAGE  ---->
        
        <?php require_once("../includes/header.php"); ?>

        <!------ AFFICHAGE DU TITRE VARIABLE EN FONCTION DES RECHERCHES ----->

        <div class="conteneur-catalogue">

            <h1 class="titre-page"><?php echo $titre_page; ?></h1>

            <!---- BARRE DE RECHERCHE DE MAILLOT---->

            <div class="zone-recherche-catalogue">

                <form method="GET" action="catalogue.php" class="barre-recherche">
                    
                    <input type="text" name="recherche" class="input-recherche" placeholder="Rechercher un autre maillot..." value="<?php echo $valeur_recherche; ?>">
                    
                    <button type="submit" class="bouton-recherche">Chercher</button>
                
                </form>
            
            </div>

            <!---- AFFICHAGE DES MAILLOTS DANS LE CATALOGUE ---->

            <div class="grille-produits">

                <?php 

                    if ( mysqli_num_rows( $result ) > 0 ) {

                        /* ----- AFFICHAGE DES MAILLOTS EN FONCTION DE LA RECHERCHE ----- */

                        while ( $maillot = mysqli_fetch_array( $result ) ) {

                            echo '<div class="carte-produit">';
                            echo '  <img src="../ressources/images/' . $maillot['fichier_image'] . '" class="image-produit" alt="' . $maillot['nom_maillot'] . '">';
                            echo '  <h3 class="nom-produit">' . $maillot['nom_maillot'] .'</h3>';

                            echo '  <p class="prix">29,99 &euro;</p>';
                            echo '  <a href="product.php?id-maillot=' . $maillot['id_maillot'] . '" class="bouton-voir">Voir le maillot</a>';
                            echo '</div>';

                        }

                    /* ------- SI LE MAILLOIT RECHERCHER N'EXISTE PAS, ON AFFICHE UN MESSAGE D'ERREUR AVEC UN BOUTON POUR RETOURNER AU CATALOGUE ------- */

                    } else {

                        echo '<div class="conteneur-catalogue-vide">';
                        echo '  <p class="message-vide">Désolé, nous n\'avons pas trouvé de maillot correspondant.</p>';
                        echo "  <a class='lien-catalogue-retour' href='catalogue.php'>Voir les maillots disponibles</a>";
                        echo '</div>';

                    }

                ?>
            
            </div>

        </div>

        <?php require_once("../includes/footer.php"); ?>

    </body>

</html>