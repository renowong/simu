<?php
include_once("config.php");

$id = $_GET['id'];
load_anfa($id);

function load_anfa($id){
   if($id=='5'){
        print load_secondary_anfa(); 
   }else{
        print load_primary_anfa($id);    
   }

}

function load_secondary_anfa($id){
    $mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
    
    /* check connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
    $query = "SELECT * FROM `anfa2`";
    $output = "<option value='0'>S&eacute;lectionner</option>";
    
    if ($result = $mysqli->query($query)) {
        while($row = $result->fetch_assoc()){
            $output .= "<option value='".$row['salaire']."'>".$row['designation']."</option>";
        }
        $result->free();
    }
    $mysqli->close();
    return $output;
}

function load_primary_anfa($id){
    $mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
    
    /* check connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
    $query = "SELECT * FROM `anfa` WHERE `cat`='$id'";
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
        }
        $result->free();
    }
    $mysqli->close();
    return $output;
}
?>