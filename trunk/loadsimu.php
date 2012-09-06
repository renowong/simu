<?php
include_once("config.php");

$prime_anfa = $_GET['prime_anfa'];
$prime_fpc = $_GET['prime_fpc'];
$ech_anfa = $_GET['ech_anfa'];
$ech_fpc = $_GET['ech_fpc'];
$cat_anfa = $_GET['cat_anfa'];
$cat_fpc = $_GET['cat_fpc'];


//print $ech_anfa;
load_simu($cat_anfa,$cat_fpc,$ech_anfa,$ech_fpc,$prime_anfa,$prime_fpc);


function load_simu($cat_anfa,$cat_fpc,$ech_anfa,$ech_fpc,$prime_anfa,$prime_fpc){
   if($cat_anfa=='5'){
        print load_secondary_anfa($cat_anfa,$cat_fpc,$ech_anfa,$ech_fpc,$prime_anfa,$prime_fpc); 
   }else{
        print load_primary_anfa($cat_anfa,$cat_fpc,$ech_anfa,$ech_fpc,$prime_anfa,$prime_fpc);    
   }

}

function load_secondary_anfa($cat_anfa,$cat_fpc,$ech_anfa,$ech_fpc,$prime_anfa,$prime_fpc){
    $mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);

    /* check connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
    $query = "SELECT * FROM `anfa2` WHERE `idanfa`='$ech_anfa'";
    
   
    if ($result = $mysqli->query($query)) {
        $row = $result->fetch_assoc();
        $s_anfa = $row['salaire'];
        
        $result->free();
    }
    
    $query = "SELECT * FROM `fpc` WHERE `cat`='$cat_fpc'";
    
    if ($result = $mysqli->query($query)) {
        $row = $result->fetch_assoc();
        $ar_fpc = array($row['ech1'],$row['ech2'],$row['ech3'],$row['ech4'],$row['ech5'],$row['ech6'],$row['ech7'],$row['ech8'],$row['ech9'],$row['ech10'],$row['ech11'],$row['ech12']);
        $result->free();
    }
    
    $mysqli->close();
    
    $compens = ($s_anfa+$prime_anfa)-($ar_fpc[$ech_fpc-1])*1408+$prime_fpc;
    
    $output = "Prime compensatrice lors de l'integration : $compens <br/><table border=1 cellpadding=10>";
    $output .= "<tr>";
    $j=0;
    for($i=0;$i<11;$i++){
        $output .= "<td>";
        $output .= $j;
        $output .= "</td>";
        $j=$j+2;
    }
    $output .= "</tr><tr>";
    
    for($i=0;$i<11;$i++){
        $output .= "<td>";
        $output .= $s_anfa+$prime_anfa." F";
        $output .= "</td>";
    }
    
    $output .= "</tr><tr>";
    
    for($i=$ech_fpc-1;$i<12;$i++){
        $output .= "<td>";
        if(($s_anfa+$prime_anfa)>(($ar_fpc[$i])*1408+$prime_fpc)){
            $output .= $s_anfa+$prime_anfa." F";
        }else{
            $output .= ($ar_fpc[$i])*1408+$prime_fpc." F";
        }
        $output .= "</td>";
    }
    
    $output .= "</tr>";
    $output .= "</table>";
    
    return $output;
}

function load_primary_anfa($cat_anfa,$cat_fpc,$ech_anfa,$ech_fpc,$prime_anfa,$prime_fpc){
    $mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);

    /* check connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
    $query = "SELECT * FROM `anfa` WHERE `cat`='$cat_anfa'";
    
    if ($result = $mysqli->query($query)) {
        $row = $result->fetch_assoc();
        $ar_anfa = array($row['ech1'],$row['ech2'],$row['ech3'],$row['ech4'],$row['ech5'],$row['ech6'],$row['ech7'],$row['ech8'],$row['ech9'],$row['ech10'],$row['ech11']);
        $result->free();
    }
    
    $query = "SELECT * FROM `fpc` WHERE `cat`='$cat_fpc'";
    
    if ($result = $mysqli->query($query)) {
        $row = $result->fetch_assoc();
        $ar_fpc = array($row['ech1'],$row['ech2'],$row['ech3'],$row['ech4'],$row['ech5'],$row['ech6'],$row['ech7'],$row['ech8'],$row['ech9'],$row['ech10'],$row['ech11'],$row['ech12']);
        $result->free();
    }
    
    $mysqli->close();
    
    $compens = ($ar_anfa[$ech_anfa-1]+$prime_anfa)-($ar_fpc[$ech_fpc-1])*1408+$prime_fpc;
    
    $output = "Prime compensatrice lors de l'integration : $compens <br/><table border=1 cellpadding=10>";
    $output .= "<tr>";
    $j=0;
    for($i=$ech_anfa-1;$i<11;$i++){
        $output .= "<td>";
        $output .= $j;
        $output .= "</td>";
        $j=$j+2.5;
    }
    $output .= "</tr><tr>";
    
    for($i=$ech_anfa-1;$i<11;$i++){
        $output .= "<td>";
        $output .= $ar_anfa[$i]+$prime_anfa." F";
        $output .= "</td>";
    }
    
    $output .= "</tr><tr>";
    
    $j=$ech_anfa-1;
    for($i=$ech_fpc-1;$i<12;$i++){
        $output .= "<td>";
        if(($ar_anfa[$j]+$prime_anfa)>(($ar_fpc[$i])*1408+$prime_fpc)){
            $output .= $ar_anfa[$j]+$prime_anfa." F";
        }else{
            $output .= ($ar_fpc[$i])*1408+$prime_fpc." F";
        }
        $output .= "</td>";
    }
    
    $output .= "</tr>";
    $output .= "</table>";
    
    return $output;
}
?>