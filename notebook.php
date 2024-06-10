<?php
// Include necessary PHP files
include('includes/session.php');
include('includes/config.php');

// Define the number of notes per page
$notesPerPage = 4;

// Get the current page number, default to 1 if not set
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the offset for the SQL query
$offset = ($page - 1) * $notesPerPage;

// Define success message variable
$successMessage = "";

// Move note to removed_notes table if delete parameter is set
if (isset($_GET['delete'])) {
    $delete = $_GET['delete'];
    
    // Retrieve the note details before deleting
    $noteDetailsQuery = "SELECT title, note FROM notes WHERE note_id = $delete";
    $noteDetailsResult = mysqli_query($conn, $noteDetailsQuery);
    $noteDetails = mysqli_fetch_assoc($noteDetailsResult);
    
    // Insert the note into removed_notes table
    $insertQuery = "INSERT INTO removed_notes (note_id, title, note) VALUES ($delete, '{$noteDetails['title']}', '{$noteDetails['note']}')";
    $insertResult = mysqli_query($conn, $insertQuery);
    
    // Delete the note from the notes table
    $deleteQuery = "DELETE FROM notes WHERE note_id = $delete";
    $deleteResult = mysqli_query($conn, $deleteQuery);
    
    if ($deleteResult && $insertResult) {
        $successMessage = "Note successfully removed.";
    } else {
        // Handle error
        echo 'Error: ' . mysqli_error($conn);
    }

    // Check if the success message is not empty before displaying it
    if (!empty($successMessage)) {
        echo "<div class='success-message'>" . $successMessage . "</div>";
    }
}

// Add note if submit button is pressed
if (isset($_POST['submit'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $note = mysqli_real_escape_string($conn, $_POST['note']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $dateposted = mysqli_real_escape_string($conn, $_POST['dateposted']);

    date_default_timezone_set("Asia/Manila"); // Set the time zone to Philippines
    $time_now = date("h:i:sa"); // Get the current time in Philippines timezone

    // make sql query
    $query = "INSERT INTO notes(user_id, name, title, note, time_in, date_posted) VALUES('$session_id', '$username', '$title', '$note', '$time_now', '$dateposted')";

    if (mysqli_query($conn, $query)) {
        $successMessage = "Note Added Successfully";
    } else {
        //failure
        echo 'query error: ' . mysqli_error($conn);
    }
}

// Fetch notes from the database
$query = "SELECT note_id, title, note, time_in, date_posted FROM notes WHERE user_id = \"$session_id\" LIMIT $notesPerPage OFFSET $offset";

$result = mysqli_query($conn, $query);

if ($result) {
    // Fetch notes in array format
    $notesArray = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    // Handle query error
    echo 'Query error: ' . mysqli_error($conn);
}

// Count total number of notes
$totalNotesQuery = "SELECT COUNT(*) as total FROM notes WHERE user_id = \"$session_id\"";
$totalNotesResult = mysqli_query($conn, $totalNotesQuery);
$totalNotes = mysqli_fetch_assoc($totalNotesResult)['total'];

// Calculate total number of pages
$totalPages = ceil($totalNotes / $notesPerPage);
?>

<!DOCTYPE html>
<html lang="en" class="app">

<head>
    <meta charset="utf-8" />
    <title>The Notebook - Dashboard</title>
    <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="css/animate.css" type="text/css" />
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css" />
    <link rel="stylesheet" href="css/font.css" type="text/css" />

    <link rel="stylesheet" href="css/app.css" type="text/css" />

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!--[if lt IE 9]>
        <script src="js/ie/html5shiv.js"></script>
        <script src="js/ie/respond.min.js"></script>
        <script src="js/ie/excanvas.js"></script>
    <![endif]-->
</head>

<style>
    .success-message {
    background-color: #f2dede;
    color: #a94442;
    border: 1px solid #ebccd1;
    padding: 10px;
    margin-bottom: 10px;
}
</style>

<body>
    <section>
        <header class="bg-dark dk header navbar navbar-fixed-top-xs">
            <div class="navbar-header aside-md">
                <a href="notebook.php" class="navbar-brand" data-toggle="fullscreen" style="float:left;">The Notebook</a>
                <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".nav-user">
                    <i class="fa fa-cog"></i>
                </a>
            </div>
            <ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user">
                <li class="dropdown">
                    <?php
                    $query = mysqli_query($conn, "select * from register where user_ID = '$session_id'") or die(mysqli_error());
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
                    <div class="panel panel-default">
                        <h3>
                            <div class="panel-heading">Welcome, <i><?php echo $row['firstName'] . ' ' . $row['middleName'] . ' ' . $row['lastName']; ?>!</i></div>
                            <div class="panel-body" style="background-color:#fff;">
                                <b>Get Started</b>
                                <br>
                                <br>

                                <label for="add">Add Notes: </label>
                                <a class="add" href="addnote.php"><img src="images/plus.png"></a>
                                <li class="divider" style="width:100%;margin-top: 10px;background-color: #717173;height: 2px;"></li>
                                <aside class="bg-white">
                                    <section class="vbox">
                                        <header class="header bg-light bg-gradient">
                                            <ul class="nav nav-tabs nav-white">
                                                <li class="active"><a href="#activity" data-toggle="tab"><h4><b>My Notes</b></h4></a></li>
                                            </ul>
                                        </header>
                                        <section>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="activity">
                                                <ul class="list-group no-radius m-b-none m-t-n-xxs list-group-lg no-border">
                                                    <?php foreach($notesArray as $note){ ?>
                                                    <li class="list-group-item">
                                                        <div class="btn-group pull-right">
                                                            <h5><a href="edit_note.php?edit=<?php echo $note['note_id']; ?>"><button type="button" class="btn btn-sm btn-default" title="Show"><i class="fa fa-eye"></i></button></a></h5>
                                                            <h5><a href="notebook.php?delete=<?php echo $note['note_id']; ?>"><button type="button" class="btn btn-sm btn-default" title="Remove"><i class="fa fa-trash-o bg-danger"></i></button></a></h5>
                                                        </div>
                                                        <h4><b><?php echo $note['title']; ?></b></h4>
                                                        <p><?php echo substr($note['note'], 0, 200); ?></p>
                                                        <small class="block text-muted text-info"><i class="fa fa-clock-o text-info"></i> <?php echo $note['date_posted']." / ".$note['time_in']; ?></small>
                                                    </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- Pagination links -->
                                        <nav>
                                            <ul class="pagination">
                                                <?php for($i = 1; $i <= $totalPages; $i++) { ?>
                                                    <li class="page-item <?php if($page == $i) echo 'active'; ?>">
                                                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </nav>
                                    </section>
                                    
                                </section>
                            </aside>
                        </div>
                    </div>
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

    </body>
</html>

