<?php include('includes/session.php')?>
<?php include('includes/config.php')?>

<?php
$successMessage = ""; // Initialize a variable to hold the success message

if (isset($_GET['delete'])) {
  $delete = $_GET['delete'];
  $sql = "DELETE FROM notes where note_id = ".$delete;
  $result = mysqli_query($conn, $sql);
  if ($result) {
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
      $successMessage = "New note successfully added."; // Set the success message
    }else{
        // Failure
        echo 'query error: '. mysqli_error($conn);
    }
}

// Selection
$query = "SELECT note_id,title,note,time_in,date_posted FROM notes WHERE user_id = \"$session_id\" ";

if(mysqli_query($conn, $query)){

    // get the query result
    $result = mysqli_query($conn, $query);

    // fetch result in array format
    $notesArray= mysqli_fetch_all($result , MYSQLI_ASSOC);

}else{
    // Failure
    echo 'query error: '. mysqli_error($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Notebook - Add A Note</title>
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="css/animate.css" type="text/css" />
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css" />
    <link rel="stylesheet" href="css/font.css" type="text/css" />
    
    <link rel="stylesheet" href="css/app.css" type="text/css" />
</head>
<body>
<section class="hbox stretch">
    <aside class="aside-lg bg-light lter b-r">
        <div class="wrapper">

              <!-- Show success message here -->
              <?php if (!empty($successMessage)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $successMessage; ?>
            </div>
            <?php endif; ?>
            
            <h2 class="m-t-none"><strong>Add A New Notes</strong></h2>
            <br>
            <a href="notebook.php"><img src="images/close.png" style="float: right;position: relative;bottom: 0px;"></a>
    
            <!-- Form -->
            <form method="POST">
                <div class="form-group">
                <?php $query= mysqli_query($conn,"select * from register where user_ID = '$session_id'")or die(mysqli_error());
                      $row = mysqli_fetch_array($query);
                ?>
                 <h4><label>Name</label></h4>
                 <input name="username" type="text" value="<?php echo $row['firstName'] . ' ' . $row['middleName'] . ' ' . $row['lastName']; ?>" class="input-sm form-control" readonly>
                </div>
                <div class="form-group">
                    <h4><label>Title</label></h4>
                    <input name="title" type="text" placeholder="Title" class="input-sm form-control" required>
                </div>
                <div class="form-group">
                    <h4><label>Note</label></h4>
                    <textarea name="note" class="form-control" rows="8" data-minwords="8" data-required="true" placeholder="Note"  required></textarea>
                </div>
                <div class="form-group">
                    <h4><label>Date Posted</label></h4>
                    <input name="dateposted" id="dateposted" type="date" class="input-sm form-control" readonly>
                </div>
                <h4> <div class="m-t-lg"><button class="btn btn-sm btn-primary" name="submit" type="submit">Add Notes</button></div><h4>
                </form>

                <style>
                    .btn-primary:hover {
    background-color: #286090; /* Your desired hover color */
}
</style>

        </div>
    </aside>
                
    <aside class="col-lg-4 b-l">
        <section class="vbox">
            <section class="scrollable">
                <div class="wrapper">
                    <section class="panel panel-default">
                        <?php
                        $get_note = mysqli_query($conn,"select * from notes WHERE user_id = \"$session_id\" LIMIT 1") or die(mysqli_error());
                        while ($row = mysqli_fetch_array($get_note)) {
                            $id = $row['note_id'];
                        ?>
                        </ul>
                        <?php } ?> 
                    </section>
                    <section class="panel clearfix bg-info lter">
                        <div class="panel-body">
                            <a href="" class="thumb pull-left m-r">
                                <img src="images/prof.jpg" class="img-circle">
                            </a>
                            <div class="clear">  
                                <small class="block text-muted">Developed By:</br></small>
                                <a class="text-info">Michael Angelo Entera</i></a>
                                <br>
                                <a href="https://www.facebook.com/michael.enteraaa" target="_blank" class="btn btn-xs btn-success m-t-xs">Follow</a>
                                </br>
                            </div>
                        </div>
                    </section>
                </div>
            </section>
        </section>              
    </aside>
</section>

<script>
    // set default date automatically
    var today = new Date();
    var date = today.getFullYear()+'-'+(String(today.getMonth()+1)).padStart(2,'0') +'-'+ String(today.getDate()).padStart(2,'0');
    var dateTime = date
    //document.write(dateTime); //for checking
    document.getElementById("dateposted").value = date;
</script>
</body>
</html>
