<?php
session_start();
include('../admininc/config.php');

$error = "";

if(isset($_POST['signup'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $query = mysqli_query($conn, "SELECT * FROM admin WHERE email = '$email'") or die(mysqli_error());
    $count = mysqli_num_rows($query);

    if($count > 0) { 
        $error = "Data Already Exists.";
    } else {
        mysqli_query($conn, "INSERT INTO admin(fullName, email, password) VALUES ('$name', '$email', '$password')") or die(mysqli_error());
        echo "<script>alert('Records Successfully Added');</script>";
        echo "<script>window.location = '../admin/index.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="bg-dark">
<head>
    <meta charset="utf-8">
    <title>Admin - Sign Up</title>
    <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="../css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="../css/animate.css" type="text/css">
    <link rel="stylesheet" href="../css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="../css/font.css" type="text/css">
    <link rel="stylesheet" href="../css/app.css" type="text/css">

    <style>
        .error {
            color: red;
            margin-top: 10px;
        }
        .navbar-brand {
            font-size: 5rem;
            color: black;
            text-align: center;
            margin: 5px 0;
            font-weight: bold;
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
    <!--[if lt IE 9]>
        <script src="js/ie/html5shiv.js"></script>
        <script src="js/ie/respond.min.js"></script>
        <script src="js/ie/excanvas.js"></script>
    <![endif]-->
</head>
<body>
    <section id="content" class="m-t-lg wrapper-md animated fadeInDown">
        <div class="container aside-xxl">              <br><br><br>
        <br><br><br>

            <a class="navbar-brand block" href="signup.php">The Notebook</a>
            <section class="panel panel-default m-t-lg bg-white">
                <header class="panel-heading text-center">
                <h3><strong>Admin - Sign Up</strong></h3>
                </header>
                <form name="signup" method="POST">
                    <div class="panel-body wrapper-lg">
                    <div class="form-group">
                        <label class="control-label">Name</label>
                        <input name="name" type="text" placeholder="Full Name" class="form-control input-lg" value="<?php echo isset($name) ? $name : ''; ?>" oninput="validateFirstNameInput(this)" required>
                        </div>
                    <div class="form-group">
                        <label class="control-label">Email</label>
                        <input name="email" type="email" placeholder="test@example.com" class="form-control input-lg" value="<?php echo isset($email) ? $email : ''; ?>" required>
                        </div>
                    <div class="form-group password-toggle" id="password-toggle">
                        <label class="control-label">Password</label>
                        <input name="password" type="password" id="inputPassword" placeholder="Type a password" class="form-control input-lg" required>
                        <i class="fa fa-eye-slash toggle-password" id="toggle-password"></i>
                    </div>
                    <?php if ($error): ?>
                        <div class="error"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <div class="line line-dashed"></div>
                    <button name="signup" type="submit" class="btn btn-primary btn-block">Sign up</button>
                    <div class="line line-dashed"></div>
                 <!--   <h4><p class="text-muted text-center"><small>Already have an account?</small></p></h4>
                    <a href="../admin/index.php" class="btn btn-default btn-block">Login</a> -->
                    </div>
                </form>
            </section>
        </div>
    </section>
    <!-- footer -->
    <footer id="footer">
        <div class="text-center padder clearfix">
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
document.getElementById("inputPassword").addEventListener("input", function () {
    var password = this.value;
    var isValid = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{6,}$/.test(password);
    if (!isValid) {
        this.setCustomValidity("Password must contain at least one number, one uppercase letter, one lowercase letter, one special character, and be at least 6 characters long");
    } else {
        this.setCustomValidity("");
    }
});
</script>

<script>
function validateFirstNameInput(input) {
    // Trim leading and trailing spaces
    input.value = input.value.trim();
    
    // Check if the input contains only letters
    if (/[^A-Za-z\s]+/.test(input.value)) {
        input.setCustomValidity("Letters only.");
    } else {
        input.setCustomValidity("");
    }
}
</script>

<script>
// Toggle password visibility
document.addEventListener('DOMContentLoaded', (event) => {
    const passwordField = document.getElementById('inputPassword');
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
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
});
</script>

</body>
</html>
