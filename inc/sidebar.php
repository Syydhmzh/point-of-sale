<?php
$id_user = isset($_SESSION['ID_USER']) ? $_SESSION['ID_USER'] : '';
$querymainmenu = mysqli_query($config, "SELECT DISTINCT menus.*  FROM menus
JOIN menu_roles ON menus.id = menu_roles.id_menus
JOIN user_roles ON user_roles.id_role = menu_roles.id_roles
WHERE user_roles.id_user = '$id_user'
AND parent_id = 0 OR parent_id='' ORDER BY urutan ASC");

$rowmainmenu = mysqli_fetch_all($querymainmenu, MYSQLI_ASSOC);

?>


<!-- ===== Sidebar ===== -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <!-- <li class="nav-item">
            <a class="nav-link collapsed" href="home.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li> -->
        <?php foreach ($rowmainmenu as $mainmenu): ?>
            <?php
            $id_menu = $mainmenu['id'];
            $querysubmenu = mysqli_query($config, "SELECT DISTINCT menus.* FROM menus 
            JOIN menu_roles ON menus.id = menu_roles.id_menus
            JOIN user_roles ON user_roles.id_role = menu_roles.id_roles
            WHERE user_roles.id_user = '$id_user' AND
            parent_id = '$id_menu' ORDER BY urutan ASC");
            // $rowsubmenu = mysqli_fetch_all($querysubmenu, MYSQLI_ASSOC);
            ?>

            <?php if (mysqli_num_rows($querysubmenu) > 0): ?>
                <li class="nav-item">
                    <a class="nav-link collapsed" data-bs-target="#menu-<?php echo $mainmenu['id'] ?>" data-bs-toggle="collapse" href="#">
                        <i class="<?php echo $mainmenu['icon'] ?>"></i><span><?php echo $mainmenu['name'] ?></span><i class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul id="menu-<?php echo $mainmenu['id'] ?>" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                        <?php while ($rowsubmenu = mysqli_fetch_assoc($querysubmenu)): ?>
                            <li>
                                <a href="?page=<?php echo $rowsubmenu['url'] ?>">
                                    <i class="<?php echo $rowsubmenu['icon'] ?>"></i><span><?php echo $rowsubmenu['name'] ?></span>
                                </a>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </li>
                <!-- End Components Nav -->
            <?php elseif (!empty($mainmenu['url'])): ?>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="<?php echo $mainmenu['url'] ?>">
                        <i class="<?php echo $mainmenu['icon'] ?>"></i>
                        <span><?php echo $mainmenu['name'] ?></span>
                    </a>
                </li>

            <?php endif; ?>

        <?php endforeach; ?>




    </ul>

</aside><!-- End Sidebar-->