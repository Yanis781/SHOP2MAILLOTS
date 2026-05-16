<header class="entete-principale">
    <div class="boite-logo">
        <a href="../shop/home.php">SHOP2MAILLOTS</a>
    </div>
    
    <nav class="navigation-principale">
        <a href="../shop/catalog.php">CATALOGUE</a>
        <a href="../shop/cart.php">PANIER</a>
        
        <div class="menu-deroulant">
            <span class="bouton-compte"><?php echo $_SESSION['user']; ?> ▼</span>
            
            <div class="contenu-deroulant">
                <p>Salut, <strong><?php echo $_SESSION['user']; ?></strong></p>
                <a href="../user/settings.php">Paramètres</a>
                <a href="../auth/logout.php">Déconnexion</a>
            </div>
        </div>
    </nav>
</header>