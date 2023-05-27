<header>
    <nav style="background: #2c3034; height: 55px; align-items: center; display: flex;">
        <!-- profile pic with user name, it is als oa link to the profile page -->
        <a href="profile.php" style="padding:10px;font-size: 20px; color: white;">
            <?php
            include 'src/user_id_getter.php';
            $user_details = $user->get_user_img_url($_SESSION['user']);
            echo '  <div style="display: flex; flex-direction: row; align-items: center;">
                        <img src="' . $user_details . '" style="width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;">
                        <p style="margin: 0;">' . $_SESSION['user'] . '</p>
                    </div>';
            ?>
            <a href="dashboard.php" style="padding:10px;font-size: 20px; color: white;">Dashboard</a>
            <a href="src/logout.php" style="padding:10px;font-size: 20px; color: white;">Logout</a>
    </nav>
</header>