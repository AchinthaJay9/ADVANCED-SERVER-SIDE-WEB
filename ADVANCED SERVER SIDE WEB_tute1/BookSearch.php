<?php
$dbhost = 'phpmyadmin.ecs.westminster.ac.uk';
$dbuser = 'w1761363';
$dbpass = 'cnbtXkCi0SK7';
$dbname = 'w1761363_0';
//create a DB connection
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
//if the DB connection fails, display an error message and exit
if (!$conn)
{
die('Could not connect: ' . mysqli_error($conn));
}
//select the database
mysqli_select_db($conn, $dbname);
echo '<body>Book Search<form name="search" action="BookSearch.php" method="post">
Criterian <select id="criteria" name="criteria">
<option value="title">title</option>
<option value="author">author</option>
<option value="yop">year</option>
</select>
enter<input type="text" name="search">
<input type="submit" name="submit">
</form>';

if(isset($_POST['submit'])){
    $criterian=$_POST['criteria'];
    $input=$_POST['search'];
    $sql= "SELECT * FROM books WHERE $criterian='$input'";
    // switch ($criterian) {
    //     case 'yop':
    //         $sql.= "yop = '$input'";
    //         break;
    //     case 'author':
    //         $sql.= "author = '$input'";
    //         break;
    //     case 'title':
    //         $sql.= "title = '$input'";
    //         break;
    // }
    $execute= mysqli_query($conn, $sql);

    while($array=mysqli_fetch_array($execute)){
        echo $array['title'].'<br>';
        echo $array['author'].'<br>';
        echo $array['yop'].'<br>';
        echo $array['price'].'<br>';
    }
}

echo'</body>';