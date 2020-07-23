<?php 
    session_start(); 

    // logout
    if(isset($_GET['action']) and $_GET['action'] == 'logout'){
        session_start();
        unset($_SESSION['username']);
        unset($_SESSION['password']);
        unset($_SESSION['logged_in']);
    }
    //log in
    if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {	
       if ($_POST['username'] == 'Tomas' && $_POST['password'] == '1234') {
          $_SESSION['logged_in'] = true;
          $_SESSION['username'] = 'Tomas';
       } else {
          $msg = 'Wrong username or password';
       }
    }
?>
<?php
// file download 
if(isset($_POST['download'])){
    $file='./' . $_GET["path"] . $_POST['download'];
    $fileToDownloadEscaped = str_replace("&nbsp;", " ", htmlentities($file, null, 'utf-8'));

    header('Content-Description: File Transfer');
    header('Content-Type: application/');
    header('Content-Disposition: attachment; filename=' . basename($fileToDownloadEscaped));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($fileToDownloadEscaped));

    flush();
    readfile($fileToDownloadEscaped);
    exit;
}

?>
<?php
    if(isset($_POST['upload'])){
        $file_name = $_FILES['file']['name'];
        $file_size = $_FILES['file']['size'];
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_type = $_FILES['file']['type'];

        $file_store = "C:\Program Files\Ampps\www\Php-Fs-Browser/".$file_name;

        move_uploaded_file($file_tmp,$file_store);
        
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
    
            <div>
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
                print('<input type = "password" name = "password" placeholder = "password = 1234" required><br>');
                print('<button class = "button" type = "submit" name = "login">Login</button>');
                print('</form>');
                die();
            }
            
        ?>
        
        <form action = "" method = "post">
            <h3>Logged In!</h3>
            <h4><?php echo $msg; ?></h4>
            Click here to <a href = "index.php?action=logout"> logout.</a>
        </form>

            
        </div>


        <h2>Files:</h2>
        <?php
        $full_path = ".";
        $path = './' . $_GET["path"];
        $dir = opendir($full_path) or die ("Unable to open directory");

                print "<table>";
                print "<th>Type</th><th>Name</th><th>Download</th><th>Delete</th>";      
            while($file = readdir($dir)){

               if($file == "." ||$file == "..")
               continue;
               print "<tr>";
               print('<td>' . (is_dir($path . $file) ? "<img src='./Images/folder.png' alt='Folder' width='25px'>" 
               : "<img src='./Images/file.png' alt='File' width='25px'>") . '</td>');
              
               print "<td><a href='$file'>$file</a></td>";
                print '<td><form style="display: inline-block" action="" method="post">
                <input type="hidden" name="download" value='.$file.'>
                <input class="middle" type="submit" value="Download">
               </form></td>';
                if($file == ".git" || $file == ".gitattributes" || $file == "create_file.php" || $file == "deleteFile.php"
                || $file == "deleteFolder.php"|| $file == "download.php"|| $file == "index.php"|| $file == "styles.css" || $file == "Images")
               continue;
                print (is_dir($path . $file) ? "<td><a href='deleteFolder.php?dir=$file'>Delete</a><br></td>"
                 : "<td><a href='deleteFile.php?name=$file'>Delete</a></td>");
                print "</tr>";
                
            }
            
            print "</table>";

        ?>
         
        
        <form class="inline" action="create_file.php" method="POST">
        <h3>Create new Folder</h3>
            Folder Name: <input type="text" name="name">
                <input  type="submit" value="Create Folder">
                </form>

        <form class="inline" action="" method="POST" enctype="multipart/form-data">
        <h3>Upload File</h3>
            <input type="file" name="file">
                <input  type="submit" value="upload" name="upload">
           
            </form>
           
        
       
   
        
    </body>
</html>