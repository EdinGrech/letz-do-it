<html lang="en">
<?php
include 'components/head.php';
?>

<body>
    <!-- center div to center of screen -->
    <div class="auth-cont">
        <h1>Sign Up</h1>
        <form action="src/auth.php" method="post" class="auth-form" id="signup-form">
            <div class="form-group">
                <input class="form-control" type="email" name="email" placeholder="email@domain.com" required />
            </div>
            <div class="form-group">
                <input class="form-control" type="password" name="password" placeholder="Password" required />
            </div>
            <div class="form-group">
                <input class="btn btn-primary" type="submit" name="signup" value="Signup" disabled />
            </div>
        </form>
        <a href="login.php">Login</a>
    </div>
    <script>
        $(document).ready(function () {
            $('#signup-form').validator().on('input', function (e) {
                if (e.isDefaultPrevented()) {
                    // Form validation failed
                    $('#signup-form').find('input[type="submit"]').prop('disabled', true);
                } else {
                    // Form validation passed
                    $('#signup-form').find('input[type="submit"]').prop('disabled', false);
                }
            });
        });
    </script>
</body>

</html>