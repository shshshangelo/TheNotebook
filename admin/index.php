<?php
session_start();
include('../admininc/config.php');

$error = "";

if(isset($_POST['signin'])) {
    $email=$_POST['email'];
    $password=md5($_POST['password']);

    $sql = "SELECT * FROM admin WHERE email ='$email' AND password ='$password'";
    $query= mysqli_query($conn, $sql);
    $count = mysqli_num_rows($query);

    if($count > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            $_SESSION['entera'] = $row['user_ID'];
            echo "<script type='text/javascript'> document.location = '../admin/notebook.php'; </script>";
        }
    } else {
        $error = "Invalid Details.";
    }
}
?>

<!DOCTYPE html>
<html lang="en" class="bg-dark">
<head>
  <meta charset="utf-8" />
  <title>Admin - Login</title>
  <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
  <link rel="stylesheet" href="../css/bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="../css/animate.css" type="text/css" />
  <link rel="stylesheet" href="../css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="../css/font.css" type="text/css" />
    <link rel="stylesheet" href="../css/app.css" type="text/css" />

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

  <!--[if lt IE 9]>
    <script src="js/ie/html5shiv.js"></script>
    <script src="js/ie/respond.min.js"></script>
    <script src="js/ie/excanvas.js"></script>
  <![endif]-->
</head>
<body>
    <section id="content" class="m-t-lg wrapper-md animated fadeInUp">
        <div class="container aside-xxl">
            <br><br><br><br><br>
            <a class="navbar-brand block" href="index.php">The Notebook</a>
            <section class="panel panel-default bg-white m-t-lg">
                <header class="panel-heading text-center">
                    <h3><strong>Admin - Login</strong></h3>
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
  <!-- Bootstrap -->
  <script src="js/bootstrap.js"></script>
  <!-- App -->
  <script src="js/app.js"></script>
  <script src="js/app.plugin.js"></script>
  <script src="js/slimscroll/jquery.slimscroll.min.js"></script>
  
</body>
</html>
