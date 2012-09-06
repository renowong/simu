<?php
include_once("config.php");

$id = $_GET['id'];
print load_fpc($id);


function load_fpc($id){
    $mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);

    /* check connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
    $query = "SELECT * FROM `fpc` WHERE `cat`='$id'";
    $output = "<option value='0'>S&eacute;lectionner</option>";
    
    if ($result = $mysqli->query($query)) {
        while($row = $result->fetch_assoc()){
            $output .= "<option value='".$row['ech1']."'>ech1</option>";
            $output .= "<option value='".$row['ech2']."'>ech2</option>";
            $output .= "<option value='".$row['ech3']."'>ech3</option>";
            $output .= "<option value='".$row['ech4']."'>ech4</option>";
            $output .= "<option value='".$row['ech5']."'>ech5</option>";
            $output .= "<option value='".$row['ech6']."'>ech6</option>";
            $output .= "<option value='".$row['ech7']."'>ech7</option>";
            $output .= "<option value='".$row['ech8']."'>ech8</option>";
            $output .= "<option value='".$row['ech9']."'>ech9</option>";
            $output .= "<option value='".$row['ech10']."'>ech10</option>";
            $output .= "<option value='".$row['ech11']."'>ech11</option>";
            $output .= "<option value='".$row['ech12']."'>ech12</option>";
        }
        $result->free();
    }
    $mysqli->close();
    return $output;
}
?>