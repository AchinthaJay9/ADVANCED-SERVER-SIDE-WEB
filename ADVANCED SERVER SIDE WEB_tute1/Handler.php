<?php
$marks=array("Samwise Gamgee"=>88,"Frodo Baggins"=>56,"Elrond Half-Elven"=>92,"Gandalf Mithrandir"=>35,"Merry Brandybuck"=>41,"Pippin Took"=>21,"Legolas Greenleaf"=>67);
$mark=$_POST['mark'];
$names=array();
echo'<body>';
foreach($marks as $key=>$value) {  
    if($value>$mark) {
        echo $key;
        echo '<br>';
    }
}
echo '</body>';