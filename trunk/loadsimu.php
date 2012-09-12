<?php
include_once("config.php");

$anciennete = $_GET['anciennete'];
$prime_anfa = $_GET['prime_anfa'];
$prime_fpc = $_GET['prime_fpc'];
$ech_anfa = $_GET['ech_anfa'];
$ech_fpc = $_GET['ech_fpc'];
$cat_anfa = $_GET['cat_anfa'];
$cat_fpc = $_GET['cat_fpc'];


//print $ech_anfa;
load_simu($anciennete,$cat_anfa,$cat_fpc,$ech_anfa,$ech_fpc,$prime_anfa,$prime_fpc);

function load_simu($anciennete,$cat_anfa,$cat_fpc,$ech_anfa,$ech_fpc,$prime_anfa,$prime_fpc){
   if($cat_anfa=='5'){
        print load_secondary_anfa($anciennete,$cat_anfa,$cat_fpc,$ech_anfa,$ech_fpc,$prime_anfa,$prime_fpc); 
   }else{
        print load_primary_anfa($cat_anfa,$cat_fpc,$ech_anfa,$ech_fpc,$prime_anfa,$prime_fpc);    
   }

}

function load_secondary_anfa($anciennete,$cat_anfa,$cat_fpc,$ech_anfa,$ech_fpc,$prime_anfa,$prime_fpc){
    $mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);
    $ar_simu_anfa = array();
    $ar_simu_fpc = array();
    
    /* check connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
    $query = "SELECT * FROM `anfa2` WHERE `idanfa`='$ech_anfa'";
    
   
    if ($result = $mysqli->query($query)) {
        $row = $result->fetch_assoc();
        $s_anfa = $row['salaire'];
        $s_anfa = $s_anfa*(($anciennete/100)+1);
        $s_anfa = round($s_anfa);
        
        
        $result->free();
    }
    
    $query = "SELECT * FROM `fpc` WHERE `cat`='$cat_fpc'";
    
    if ($result = $mysqli->query($query)) {
        $row = $result->fetch_assoc();
        $ar_fpc = array($row['ech1'],$row['ech2'],$row['ech3'],$row['ech4'],$row['ech5'],$row['ech6'],$row['ech7'],$row['ech8'],$row['ech9'],$row['ech10'],$row['ech11'],$row['ech12']);
        $result->free();
    }
    
    $mysqli->close();
    
    $compens = ($ar_anfa[$ech_anfa-1]+$prime_anfa)-((($ar_fpc[$ech_fpc-1])*1408)+$prime_fpc);
    if($compens<0){$compens=0;}
    
    $output = "Prime compensatrice lors de l'integration : $compens F<br/><table border=1 cellpadding=10>";
    $output .= "<tr><td></td>";
    $j=0;
    for($i=0;$i<=13;$i++){
        $output .= "<td>";
        $output .= $j;
        $output .= "</td>";
        $j=$j+2;
    }
    $output .= "</tr><tr><td>ANFA</td>";
    
    for($i=0;$i<=13;$i++){
        $evo = (0.025*$i)+1;
        
        $output .= "<td>";
        array_push($ar_simu_anfa,(round($s_anfa*$evo)+$prime_anfa));
        $output .= trispace(round($s_anfa*$evo)+$prime_anfa)." F";
        $output .= "</td>";
    }
    
    $output .= "</tr><tr><td>FPC</td>";
    
    for($i=$ech_fpc-1;$i<=13;$i++){
        $output .= "<td>";
        if(($s_anfa+$prime_anfa)>(($ar_fpc[$i])*1408+$prime_fpc)&&$i<11){
            array_push($ar_simu_fpc,$s_anfa+$prime_anfa);
            $output .= $s_anfa+$prime_anfa." F";
        }else{
            if($i<=11){$lastfpc=(($ar_fpc[$i])*1408+$prime_fpc);}
            array_push($ar_simu_fpc,$lastfpc);
            $output .= trispace($lastfpc)." F";
        }
        $output .= "</td>";
    }
    
        $output .= "</tr><tr><td>DIFF (FPC-ANFA)</td>";


    for($i=0;$i<count($ar_simu_anfa)-1;$i++){
        $output .= "<td>";
        $output .= trispace($ar_simu_fpc[$i]-$ar_simu_anfa[$i])." F";
        $output .= "</td>";
    }
    
    $output .= "</tr>";
    $output .= "</table>";
    
    return $output;
}

function load_primary_anfa($cat_anfa,$cat_fpc,$ech_anfa,$ech_fpc,$prime_anfa,$prime_fpc){
    $mysqli = new mysqli(DBSERVER, DBUSER, DBPWD, DB);

    $ar_simu_anfa = array();
    $ar_simu_fpc = array();
    
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
    
    $compens = ($ar_anfa[$ech_anfa-1]+$prime_anfa)-((($ar_fpc[$ech_fpc-1])*1408)+$prime_fpc);
    //$compens = (($ar_fpc[$ech_fpc-1])*1408)+$prime_fpc;
    if($compens<0){$compens=0;}
    
    $output = "Prime compensatrice lors de l'integration : $compens F<br/><table border=1 cellpadding=10>";
    $output .= "<tr><td></td>";
    $j=0;
    for($i=$ech_anfa-1;$i<=13;$i++){
        $output .= "<td>";
        $output .= $j;
        $output .= "</td>";
        $j=$j+2.5;
    }
    $output .= "</tr><tr><td>ANFA</td>";
    
    for($i=$ech_anfa-1;$i<=13;$i++){
        $output .= "<td>";
        if($i<=10){$lastanfa=$ar_anfa[$i]+$prime_anfa;}
        array_push($ar_simu_anfa,$lastanfa);
        $output .= trispace($lastanfa)." F";
        $output .= "</td>";
    }
    
    $output .= "</tr><tr><td>FPC</td>";
    
    $j=$ech_anfa-1;
    for($i=$ech_fpc-1;$i<=13;$i++){
        $output .= "<td>";
        if(($ar_anfa[$j]+$prime_anfa)>(($ar_fpc[$i])*1408+$prime_fpc)&&$i<=11){
            array_push($ar_simu_fpc,$ar_anfa[$j]+$prime_anfa);
            $output .= trispace($ar_anfa[$j]+$prime_anfa)." F";
        }else{
            if($i<=11){$lastfpc=(($ar_fpc[$i])*1408+$prime_fpc);}
            array_push($ar_simu_fpc,$lastfpc);
            $output .= trispace($lastfpc)." F";
        }
        $output .= "</td>";
    }
    
    $output .= "</tr><tr><td>DIFF (FPC-ANFA)</td>";


    for($i=0;$i<count($ar_simu_anfa)-1;$i++){
        $output .= "<td>";
        $output .= trispace($ar_simu_fpc[$i]-$ar_simu_anfa[$i])." F";
        $output .= "</td>";
    }
    
    $output .= "</tr>";
    $output .= "</table>";
    
    return $output;
}

function trispace($n){
	return number_format($n, 0, ',', ' ');
}
?>