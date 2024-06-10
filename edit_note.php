<?php
// Include necessary files
include('includes/session.php');
include('includes/config.php');

// Set timezone to Philippines
date_default_timezone_set('Asia/Manila');

// Initialize a variable to hold the success message
$updateSuccessMessage = "";

// Get the ID from the URL parameter
$get_id = $_GET['edit'];

// Updation
if(isset($_POST['update'])){
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $note = mysqli_real_escape_string($conn, $_POST['note']);

    // Make SQL query
    $query = "UPDATE notes SET title=\"$title\", note=\"$note\", last_updated_at=CONVERT_TZ(CURRENT_TIMESTAMP, 'UTC', 'Asia/Manila') WHERE note_id = \"$get_id\" ";

    if(mysqli_query($conn, $query)){
        // Set the update success message
        $updateSuccessMessage = "Note successfully updated.";
    } else {
        // Failure
        echo 'Query error: '. mysqli_error($conn);
    }
}

// Selection
$query = "SELECT note_id, title, note, time_in FROM notes WHERE note_id = \"$get_id\" ";

if(mysqli_query($conn, $query)){
    // Get the query result
    $result = mysqli_query($conn, $query);

    // Fetch result in array format
    $notesArray = mysqli_fetch_all($result, MYSQLI_ASSOC);

} else {
    // Failure
    echo 'Query error: '. mysqli_error($conn);
}
?>

<!DOCTYPE html>
<html lang="en" class="app">
<head>
  <meta charset="utf-8" />
  <title>The Notebook - Update Notes</title>
  <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
  <link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="css/animate.css" type="text/css" />
  <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="css/font.css" type="text/css" />
  <link rel="stylesheet" href="css/app.css" type="text/css" />
  <!--[if lt IE 9]>
    <script src="js/ie/html5shiv.js"></script>
    <script src="js/ie/respond.min.js"></script>
    <script src="js/ie/excanvas.js"></script>
  <![endif]-->
</head>
<body>
  <section class="vbox">
    <header class="bg-dark dk header navbar navbar-fixed-top-xs">
      <ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user">
        <li class="dropdown">
          <?php $query= mysqli_query($conn,"select * from register where user_ID = '$session_id'")or die(mysqli_error());
                $row = mysqli_fetch_array($query);
            ?>

          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <!-- <span class="thumb-sm avatar pull-left">
              <img src="images/profile.png"> --> 
            </span>
            <?php echo $row['firstName'] . ' ' . $row['middleName'] . ' ' . $row['lastName']; ?> <b class="caret"></b>
            </a>
          <ul class="dropdown-menu animated fadeInRight">
            <span class="arrow top"></span>
            <li class="divider"></li>
            <li>
              <a href="logout.php" data-toggle="ajaxModal" >Logout</a>
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
                  <aside class="aside-lg bg-light lter b-r">
                    <div class="wrapper">

                     <!-- Display update success message if available -->
                     <?php if (!empty($updateSuccessMessage)): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $updateSuccessMessage; ?>
                        </div>
                      <?php endif; ?>
                      
                      <h4 class="m-t-none">Edit Note</h4>
                      <a href="notebook.php"><img src="images/close.png" style="float: right;position: relative;bottom: 27px;"></a>
                      
                      <form method="POST">
                      	<?php
                          $query = mysqli_query($conn,"select * from notes where note_id = '$get_id' ")or die(mysqli_error());
                          $row = mysqli_fetch_array($query);
                        ?>
                        <div class="form-group">
                          <label>Title</label>
                          <input name="title" type="text" placeholder="Title" class="input-sm form-control" value="<?php echo $row['title']; ?>">
                        </div>
                        <div class="form-group">
                          <label>Note</label>
                          <textarea id="noteContent" name="note" class="form-control" rows="8" data-minwords="8" data-required="true" placeholder="Take a Note ......"><?php echo $row['note']; ?></textarea>
                        </div>
                        <div class="m-t-lg">
    <button class="btn btn-sm btn-primary" name="update" type="submit">Update Note</button>
</div>

<style>
.btn-primary:hover {
    background-color: #286090; /* Your desired hover color */
}
</style>
</form>
                     
                    </div>
                </aside>
                <aside class="bg-white">
                  <section class="vbox">
                    <header class="header bg-light bg-gradient">
                      <ul class="nav nav-tabs nav-white">
                      <li class="active"><a href="#activity" data-toggle="tab"><h4><b>Note Details</b></h4></a></li>
                      </ul>
                    </header>
                    <section class="scrollable">
                      <div class="tab-content">
                        <div class="tab-pane active" id="activity">
                          <ul class="list-group no-radius m-b-none m-t-n-xxs list-group-lg no-border" id="noteDetails">
                            <li></li>
                            <?php foreach($notesArray as $note){ ?>
                            <li class="list-group-item">
                            <h3><b><?php echo $note['title'] ?></b></h3>
                                <p style="font-size:18px;"><?php echo $note['note']; ?> </p>
                                
                                <?php } ?>
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
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
        </section>
        <aside class="bg-light lter b-l aside-md hide" id="notes">
          <div class="wrapper">Notification</div>
        </aside>
      </section>
    </section>
  </section>
  <script src="js/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="js/bootstrap.js"></script>
  <!-- App -->
  <script src="js/app.js"></script>
  <script src="js/app.plugin.js"></script>
  <script src="js/slimscroll/jquery.slimscroll.min.js"></script>
  <script src="js/libs/underscore-min.js"></script>
<script src="js/libs/backbone-min.js"></script>
<script src="js/libs/backbone.localStorage-min.js"></script>  
<script src="js/libs/moment.min.js"></script>
<!-- Notes -->
<script src="js/apps/notes.js"></script>

<!-- JavaScript to update the "Note Details" section dynamically -->
<script>
    // Get references to the title input field and the note textarea
    var titleInput = document.querySelector('input[name="title"]');
    var noteTextarea = document.getElementById('noteContent');

    // Add event listeners to capture input events on both title and note
    titleInput.addEventListener('input', updateNoteDetails);
    noteTextarea.addEventListener('input', updateNoteDetails);

    // Function to update the "Note Details" section
    function updateNoteDetails() {
        // Get the updated title and note content
        var updatedTitle = titleInput.value;
        var updatedNote = noteTextarea.value;

        // Get reference to the "Note Details" section
        var noteDetails = document.getElementById('noteDetails');

        // Update the content of "Note Details" section
        noteDetails.innerHTML = `
            <li class="list-group-item">
            <h3><b>${updatedTitle}</b></h3>
                <p style="font-size:18px;">${updatedNote}</p>
            </li>
        `;
    }
</script>


</body>
</html>

