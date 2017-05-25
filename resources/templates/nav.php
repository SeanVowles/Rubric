<div id="site_nav">
    <div class="navbar navbar-default">
        <div class="container">
            <ul class="nav navbar-nav">
                <li>
                    <a href="users.php">users</a>
                </li>
                <li>
                    <a href="modules.php">modules</a>
                </li>
                <li>
                    <a href="rubric.php">rubrics</a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <?php
                        if (!$user->is_logged_in()) {
                            echo '<a href="login.php">Login</a>';
                        } else {
                            echo '<a href="logout.php?logout=true">Logout</a>';
                        }
                     ?>
                </li>
            </ul>
        </div>
    </div>
</div>
