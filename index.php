<?php 
    session_start(); 

    // logout logic
    if(isset($_GET['action']) and $_GET['action'] == 'logout'){
        session_start();
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        unset($_SESSION['logged_in']);
    }
    $msg = '';
    if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {	
       if ($_POST['username'] == 'Tomas' && $_POST['password'] == '1234') {
          $_SESSION['logged_in'] = true;
          $_SESSION['username'] = 'Tomas';
       } else {
          $msg = 'Wrong username or password';
       }
    }


 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Failų Naršyklė</title>
    <link rel="stylesheet" href="styles.css">
</head>
    <body>
    <div class="login">
         <?php
            $msg = '';
            if (isset($_POST['login']) 
                && !empty($_POST['username']) 
                && !empty($_POST['password'])
            ) {	
               if ($_POST['username'] == 'Tomas' && 
                  $_POST['password'] == '1234'
                ) {
                  $_SESSION['logged_in'] = true;
                  $_SESSION['timeout'] = time();
                  $_SESSION['username'] = 'Tomas';
               } else {
                  $msg = 'Wrong username or password';
               }
            }
         ?>
      
      <?php 
            if($_SESSION['logged_in'] == false){
                print('<form class="loginas" action = "" method = "post">');
                print('<h4>' . $msg . '</h4>');
                print('<h4>Log In </h4>');
                print('<input type = "text" name = "username" placeholder = "username = Tomas" required autofocus></br>');
                print('<input type = "password" name = "password" placeholder = "password = 1234" required>');
                print('<button class = "button" type = "submit" name = "login">Login</button>');
                print('</form>');
                die();
            }
        ?>
        <form action = "" method = "post">
            <h3>Logged In!</h3>
            <h4><?php echo $msg; ?></h4>
        </form>
            Click here to <a href = "index.php?action=logout"> logout.</a>
      </div> 

        <div>
        <h3>Create new File</h3>
        <form action="create_file.php" method="POST">
            File Name: <input type="text" name="name"><p>
                <input class="button" type="submit" value="Create File">
            </div>
        </div>
       

        <h2>Files:</h2>
            

        <?php
        $full_path = ".";
        $path = './' . $_GET["path"];
        $dir = opendir($full_path) or die ("Unable to open directory");

                print "<table>";
                print "<th>Type</th><th>Name</th><th>Edit</th><th>Delete</th>";
               
                
            while($file = readdir($dir)){

               if($file == "." ||$file == "..")
               continue;
               print "<tr>";
               print('<td>' . (is_dir($path . $file) ? "Folder" : "File") . '</td>');
              
               print "<td><a href='$file'>$file</a></td>";
               if($file == ".git")
               continue;
                print "<td><a href='edit.php'?name=$file>Edit</a></td>";
                print (is_dir($path . $file) ? "<td><a href='delete.php?dir=$file'>Delete</a><br></td>" : "<td></td>");
                print "</tr>";
            }
            
            print "</table>";

            
        ?>
        
    </body>
</html>