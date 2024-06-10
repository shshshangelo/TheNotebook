<?php
session_start();
include('includes/config.php');

$error = "";

if (isset($_POST['signin'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5(mysqli_real_escape_string($conn, $_POST['password']));

    $sql = "SELECT * FROM register WHERE email = '$email' AND password = '$password'";
    $query = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
        $_SESSION['entera'] = $row['user_ID'];
        echo "<script type='text/javascript'> document.location = 'notebook.php'; </script>";
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="bg-dark">
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="css/animate.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/font.css" type="text/css">
    <link rel="stylesheet" href="css/app.css" type="text/css">
    
    <style>
        .error {
            color: red;
            margin-top: 10px;
        }
        .navbar-brand {
            font-size: 5rem; /* Adjust the font size as needed */
            text-align: center;
            margin: 20px 0;
            font-weight: bold; /* Make it bold for emphasis */
        }
        .password-toggle {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 65%;
            transform: translateY(-50%);
            cursor: pointer;
            display: none;
        }
        .password-toggle.focus .toggle-password {
            display: block;
        }
    </style>
</head>
<body>
    <section id="content" class="m-t-lg wrapper-md animated fadeInUp">
        <div class="container aside-xxl">
            <br><br><br><br><br>
            <a class="navbar-brand block" href="index.php">The Notebook</a>
            <section class="panel panel-default bg-white m-t-lg">
                <header class="panel-heading text-center">
                    <h3><strong>Login</strong></h3>
                </header>
                <form name="signin" method="post">
                    <div class="panel-body wrapper-lg">
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <input name="email" type="email" placeholder="sample@example.com" class="form-control input-lg" value="<?php echo isset($email) ? $email : ''; ?>" required>
                            </div>
                        <div class="form-group password-toggle" id="password-toggle">
                            <label class="control-label">Password</label>
                            <input name="password" type="password" placeholder="Password" class="form-control input-lg" id="password" required>
                            <i class="fa fa-eye-slash toggle-password" id="toggle-password"></i>
                        </div>
                        <?php if ($error): ?>
                            <div class="error"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <div class="line line-dashed"></div>
                        <button name="signin" type="submit" class="btn btn-primary btn-block">Login</button>
                        <div class="line line-dashed"></div>
                        <a href="signup.php" class="btn btn-default btn-block">Create new account</a>
                    </div>
                </form>
            </section>
        </div>
    </section>
    <!-- footer -->
    <footer id="footer">
        <div class="text-center padder">
            <p>
                <small>ALM Final Project by Michael Angelo Entera<br>&copy; 2024</small>
            </p>
        </div>
    </footer>
    <!-- / footer -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/app.js"></script>
    <script src="js/app.plugin.js"></script>
    <script src="js/slimscroll/jquery.slimscroll.min.js"></script>
    <script>
        const passwordField = document.getElementById('password');
        const togglePassword = document.getElementById('toggle-password');
        const passwordToggle = document.getElementById('password-toggle');

        passwordField.addEventListener('focus', function() {
            passwordToggle.classList.add('focus');
        });

        passwordField.addEventListener('blur', function() {
            if (!passwordField.value) {
                passwordToggle.classList.remove('focus');
            }
        });

        togglePassword.addEventListener('click', function() {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
            this.classList.toggle('fa-eye');
        });
    </script>
</body>
</html>