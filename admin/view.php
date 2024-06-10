<?php include('../admininc/session.php')?>
<?php include('../admininc/config.php')?>

<?php
if (isset($_GET['stat'])) { 
    $userstat = $_GET['stat'];
  }

if (isset($_GET['delete'])) {
  $delete = $_GET['delete'];
  $sql = "DELETE FROM notes where note_id = ".$delete;
  $result = mysqli_query($conn, $sql);
  if ($result) {
    echo "<script>alert('Note removed Successfully');</script>";
      echo "<script type='text/javascript'> document.location = 'notebook.php'; </script>";
    
  }
}

 if(isset($_POST['submit'])){
        
        $title=mysqli_real_escape_string($conn,$_POST['title']);
        $note=mysqli_real_escape_string($conn,$_POST['note']);
        $username=mysqli_real_escape_string($conn,$_POST['username']);
        $dateposted=mysqli_real_escape_string($conn,$_POST['dateposted']);

        date_default_timezone_set("Asia/Manila"); // Set the time zone to Philippines
        $time_now = date("h:i:sa"); // Get the current time in Philippines timezone
    

        // make sql query
        $query = "INSERT INTO notes(user_id,name,title,note,time_in,date_posted) VALUES('$session_id','$username','$title','$note','$time_now','$dateposted')";

        if(mysqli_query($conn, $query)){
          echo "<script>alert('Note Added Successfully');</script>";

        }else{
            //failure
            echo 'query error: '. mysqli_error($conn);
        }

    }

    //********************Selection********************
     $query = "SELECT note_id,title,note,time_in,date_posted FROM notes WHERE user_id = \"$session_id\" ";

    if(mysqli_query($conn, $query)){

        // get the query result
        $result = mysqli_query($conn, $query);

        // fetch result in array format
        $notesArray= mysqli_fetch_all($result , MYSQLI_ASSOC);

        // print_r($notesArray);

    }else{
        //failure
        echo 'query error: '. mysqli_error($conn);
    }
?>

<!DOCTYPE html>
<html lang="en" class="app">
<head>
  <meta charset="utf-8" />
  <title>Daily Tracker | Admin Panel</title>
  <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
  <link rel="stylesheet" href="../css/bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="../css/animate.css" type="text/css" />
  <link rel="stylesheet" href="../css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="../css/font.css" type="text/css" />
  
  <link rel="stylesheet" href="../css/app.css" type="text/css" />
  <!--[if lt IE 9]>
    <script src="js/ie/html5shiv.js"></script>
    <script src="js/ie/respond.min.js"></script>
    <script src="js/ie/excanvas.js"></script>
  <![endif]-->
</head>
<body>
  <section class="vbox">
    <header class="bg-dark dk header navbar navbar-fixed-top-xs">
      <div class="navbar-header aside-md">
        <a href="../admin/notebook.php" class="navbar-brand" data-toggle="fullscreen" style="float:left;">Admin Panel</a>
        <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".nav-user">
          <i class="fa fa-cog"></i>
        </a>
      </div>
      <ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user">
        <li class="dropdown">
          <?php $query= mysqli_query($conn,"select * from admin where user_ID = '$session_id'")or die(mysqli_error());
                $row = mysqli_fetch_array($query);
            ?>

<a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <!--  <span class="thumb-sm avatar pull-left">
              <img src="../images/profile.png"> -->
            </span>
            <?php echo $row['fullName']; ?> <b class="caret"></b>
          </a>
          <ul class="dropdown-menu animated fadeInRight">
            <span class="arrow top"></span>
            <li class="divider"></li>
            <li>
            <a href="#" onclick="logout()">Logout</a>
            </li>
          </ul>
        </li>
      </ul>      
    </header>
    <section>
      <section class="hbox stretch">
        <!-- .aside -->
        
        <!-- /.aside -->
        <section id="content">
          <section class="hbox stretch">
                <aside class="bg-white">
                  <section class="vbox">
                    <header class="header bg-light bg-gradient">
                      <ul class="nav nav-tabs nav-white">
                        <li class="active"><a href="#activity" data-toggle="tab"><h4 style = "text-transform:uppercase;"><b>Note Details</b></h4></a></li>
                      </ul>
                    </header>
                    <section class="scrollable">
                      <div class="tab-content">
                        <div class="tab-pane active" id="activity">
                        <a href="notebook.php"><img src="../images/close.png" style="float: right;position: relative;bottom: -40px;margin-right: 10px;z-index: 1;"></a>
                          <ul class="list-group no-radius m-b-none m-t-n-xxs list-group-lg no-border">
                            <li></li>
                            <?php 
                                $sql = "SELECT * FROM `notes` WHERE `name` LIKE '$userstat'";
                                $messres = $conn->query($sql); 
                            ?>
                            <?php while ($row = $messres->fetch_object()): ?>
                            <li class="list-group-item">
                                <h3 style = "text-transform:uppercase;"><b><?php echo $row->title ?></b></h3>
                                <p><?php echo substr($row->note, 0, 200)?></p>
                                <small class="block text-muted text-info"><i class="fa fa-clock-o text-info"></i> <?php echo $row->date_posted." / ".$row->time_in; ?></small>
                                <small class="block text-muted text-info"><i class="fa fa-clock-o text-info"> Posted by:</i> <?php echo $row->name; ?></small>
                            <?php endwhile; ?>
                            </li>
                          </ul>
                        </div>
                        <div class="tab-pane" id="events">
                          <div class="text-center wrapper">
                            <i class="fa fa-spinner fa fa-spin fa fa-large"></i>
                          </div>
                        </div>
                        <div class="tab-pane" id="interaction">
                          <div class="text-center wrapper">
                            <i class="fa fa-spinner fa fa-spin fa fa-large"></i>
                          </div>
                        </div>
                      </div>
                    </section>
                  </section>
                </aside>
              <!-- <section class="panel clearfix bg-info lter">
                          <div class="panel-body">
                            <a href="#" class="thumb pull-left m-r">
                              <img src="../images/prof.jpg" class="img-circle">
                            </a>
                            <div class="clear">
                            <small class="block text-muted">Developed By:</br></small>
                            <a class="text-info">Michael Angelo Entera</i></a>
                            <br>
                              <a href="https://www.facebook.com/michael.enteraaa" target="_blank" class="btn btn-xs btn-success m-t-xs">Follow</a>
                             </br>
                            </div>
                          </div>
                  </section> -->
          </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
        </section>
        <aside class="bg-light lter b-l aside-md hide" id="notes">
          <div class="wrapper">Notification</div>
        </aside>
      </section>
    </section>
  </section>
  <script>
      // set default date automatically
      var today = new Date();
      var date = today.getFullYear()+'-'+(String(today.getMonth()+1)).padStart(2,'0') +'-'+ String(today.getDate()).padStart(2,'0');
      var dateTime = date
      //document.write(dateTime); //for checking
      document.getElementById("dateposted").value = date;
  </script>
  <script src="../js/jquery-3.5.1.min.js"></script>
  <script>
    $(document).ready(function(){
      $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
  </script>    
  <script src="../js/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="../js/bootstrap.js"></script>
  <!-- App -->
  <script src="../js/app.js"></script>
  <script src="../js/app.plugin.js"></script>
  <script src="../js/slimscroll/jquery.slimscroll.min.js"></script>
  <script src="../js/libs/underscore-min.js"></script>
<script src="../js/libs/backbone-min.js"></script>
<script src="../js/libs/backbone.localStorage-min.js"></script>  
<script src="../js/libs/moment.min.js"></script>
<!-- Notes -->
<script src="../js/apps/notes.js"></script>

<script>
      // Logout function
      function logout() {
            // Send an AJAX request to the logout script
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Redirect to the desired page after successful logout
                    window.location.href = "logout.php";
                }
            };
            xhttp.open("GET", "logout.php", true);
            xhttp.send();
        }
        </script>

</body>
</html>