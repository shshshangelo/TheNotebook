<?php
session_start();
include('includes/config.php');

$error = "";

if(isset($_POST['signup'])) {
    $firstName = $_POST['first_name'];
    $middleName = $_POST['middle_name'];
    $lastName = $_POST['last_name'];
    
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $confirmPassword = md5($_POST['confirm_password']);

    if($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        $query = mysqli_query($conn, "SELECT * FROM register WHERE email = '$email'") or die(mysqli_error());
        $count = mysqli_num_rows($query);

        if($count > 0) { 
            $error = "Data Already Exists.";
        } else {
            mysqli_query($conn, "INSERT INTO register(firstName, middleName, lastName, email, password, confirm_password) VALUES ('$firstName', '$middleName', '$lastName', '$email', '$password', '$confirmPassword')") or die(mysqli_error());
            $_SESSION['entera'] = mysqli_insert_id($conn); // Get the last inserted user ID
            header("Location: index.php"); // Redirect to index.php after successful signup
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="bg-dark">
<head>
    <meta charset="utf-8">
    <title>Sign Up</title>
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
            font-size: 3rem;
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
        <div class="container aside-xxl">
            <a class="navbar-brand block" href="index.php">The Notebook</a>
            <section class="panel panel-default m-t-lg bg-white">
                <header class="panel-heading text-center">
                <h3><strong>Sign Up Form</strong></h3>
                </header>
                <form name="signup" method="POST">
                    <div class="panel-body wrapper-lg">
                    <div class="form-group">
                    <div class="form-group">
                        <label class="control-label">First Name</label>
                        <input name="first_name" type="text" placeholder="First Name" class="form-control input-lg" value="<?php echo isset($firstName) ? $firstName : ''; ?>" oninput="validateFirstNameInput(this)" required>
                        </div>
                    <div class="form-group">
                        <label class="control-label">Middle Name (Optional):</label>
                        <input name="middle_name" type="text" placeholder="Middle Name" class="form-control input-lg" value="<?php echo isset($middleName) ? $middleName : ''; ?>" oninput="validateMiddleNameInput(this)">
                        </div>
                    <div class="form-group">
                        <label class="control-label">Last Name</label>
                        <input name="last_name" type="text" placeholder="Last Name" class="form-control input-lg" value="<?php echo isset($lastName) ? $lastName : ''; ?>" oninput="validateLastNameInput(this)" required>
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
                    <div class="form-group password-toggle" id="confirm-password-toggle">
                        <label class="control-label">Confirm Password</label>
                        <input name="confirm_password" type="password" id="confirmPassword" placeholder="Confirm your password" class="form-control input-lg" required>
                        <i class="fa fa-eye-slash toggle-password" id="toggle-confirm-password"></i>
                    </div>
                    <?php if ($error): ?>
                        <div class="error"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <div class="line line-dashed"></div>
                    <button name="signup" type="submit" class="btn btn-primary btn-block">Sign up</button>
                    <div class="line line-dashed"></div>
                    <a href="index.php" class="btn btn-default btn-block">Already have an account?</a>
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
        input.setCustomValidity("First name can only contain letters.");
    } else {
        input.setCustomValidity("");
    }
}

function validateMiddleNameInput(input) {
    // Trim leading and trailing spaces
    input.value = input.value.trim();
    
    // Check if the input contains only letters
    if (/[^A-Za-z\s]+/.test(input.value)) {
        input.setCustomValidity("Middle name can only contain letters.");
    } else {
        input.setCustomValidity("");
    }
}

function validateLastNameInput(input) {
    // Trim leading and trailing spaces
    input.value = input.value.trim();
    
    // Check if the input contains only letters
    if (/[^A-Za-z\s]+/.test(input.value)) {
        input.setCustomValidity("Last name can only contain letters.");
    } else {
        input.setCustomValidity("");
    }
}

// Toggle password visibility
document.addEventListener('DOMContentLoaded', (event) => {
    const passwordField = document.getElementById('inputPassword');
    const confirmPasswordField = document.getElementById('confirmPassword');
    const togglePassword = document.getElementById('toggle-password');
    const toggleConfirmPassword = document.getElementById('toggle-confirm-password');
    const passwordToggle = document.getElementById('password-toggle');
    const confirmPasswordToggle = document.getElementById('confirm-password-toggle');

    passwordField.addEventListener('focus', function() {
        passwordToggle.classList.add('focus');
    });

    passwordField.addEventListener('blur', function() {
        if (!passwordField.value) {
            passwordToggle.classList.remove('focus');
        }
    });

    confirmPasswordField.addEventListener('focus', function() {
        confirmPasswordToggle.classList.add('focus');
    });

    confirmPasswordField.addEventListener('blur', function() {
        if (!confirmPasswordField.value) {
            confirmPasswordToggle.classList.remove('focus');
        }
    });

    togglePassword.addEventListener('click', function() {
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });

    toggleConfirmPassword.addEventListener('click', function() {
        const type = confirmPasswordField.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPasswordField.setAttribute('type', type);
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
});
</script>

</body>
</html>
