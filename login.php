<html lang="en">

<?php
include 'components/head.php';
?>

<body>
    <div class="auth-cont">
        <h1>Login</h1>
        <form action="dashboard.php" method="post" class="auth-form" id="login-form">
            <div class="form-group">
                <input class="form-control" type="email" name="email" placeholder="email@domain.com" required />
            </div>
            <div class="form-group">
                <input class="form-control" type="password" name="password" placeholder="Password" required />
            </div>
            <div class="form-group">
                <input class="btn btn-primary" type="submit" name="signup" value="Login" disabled />
            </div>
        </form>
        <a href="index.php">Sign Up</a>
    </div>
    <script>
        $(document).ready(function () {
            $('#login-form').validator().on('input', function (e) {
                if (e.isDefaultPrevented()) {
                    // Form validation failed
                    $('#login-form').find('input[type="submit"]').prop('disabled', true);
                } else {
                    // Form validation passed
                    $('#login-form').find('input[type="submit"]').prop('disabled', false);
                }
            });
        });
    </script>
</body>

</html>