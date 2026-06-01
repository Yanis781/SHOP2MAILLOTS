<header class="entete-principale">
    <div class="boite-logo">
        <a href="../shop/home.php">SHOP2MAILLOTS</a>
    </div>
    
    <div class="logo-central">
        <img src="../ressources/images/logo.png" alt="Logo Shop2Maillots">
    </div>

    <nav class="navigation-principale">

        <?php 
            if ($_SESSION['user'] != 'Admin') {
                echo "<a href='../shop/catalogue.php'>CATALOGUE</a>";
                echo "<a href='../shop/panier.php'>PANIER</a>";
            }
        ?>
        
        <div class="menu-deroulant">
            <span class="bouton-compte"><?php echo $_SESSION['user']; ?> ▼</span>
            
            <div class="contenu-deroulant">
                <p>Salut, <strong><?php echo $_SESSION['user']; ?></strong></p>

            <?php 
            if ($_SESSION['user'] != 'Admin') {
                echo "<a href='../user/settings.php'>Paramètres</a>";
            }
            ?>

                <a href="../auth/logout.php">Déconnexion</a>
            </div>
        </div>
    </nav>
</header>