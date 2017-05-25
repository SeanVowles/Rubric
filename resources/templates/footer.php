        <div id="footer">
            <div class="container">
                <?php
                    if (!$user->is_logged_in()) {
                        echo '<a href="login.php" class="btn btn-default">Login</a>';
                    } else {
                        echo '<a href="logout.php?logout=true" class="btn btn-default">Logout</a>';
                    }
                 ?>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="resources/content/css/overrides.min.css" />
    </body>
</html>
