<?php
session_start();
?>
<header class="header">
    <div class="logo">
        <h1><a href="home.html">JobDz</a></h1>
    </div>
    
    <nav class="nav-container">
        <ul class="nav-links">
            <li><a href="home.html">Home</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="services.html">Services</a></li>
            <li><a href="contact.html">Contact</a></li>
            <?php if(isset($_SESSION['user_id'])): ?>
                <li><a href="dashboard.php">Dashboard</a></li>
            <?php else: ?>
                <li><a href="joinus.html">Login/Signup</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    
    <div class="menu-toggle">
        <i class="fas fa-bars"></i>
    </div>
</header>
