<?php
include_once("index_top.php");
?>
<html>
<head>
    <title>Simu</title>
    <script type='text/javascript' src='jquery-1.7.2.min.js'></script>
    <script type="application/x-javascript">
    $(document).ready(function () {
    reload_anfa('1');
    reload_fpc('1');
    });
    
    function simu(){
        var anciennete = eval($("#anciennete").val());
        var prime_anfa = eval($("#anfa_prime").val());
        var prime_fpc = eval($("#fpc_prime").val());
        var ech_anfa = eval($("#echanfa").prop("selectedIndex"));
        var ech_fpc = eval($("#echfpc").prop("selectedIndex"));
        var cat_anfa = eval($("#catanfa").val());
        var cat_fpc = eval($("#catfpc").val());
        $.get( "loadsimu.php", {
            anciennete:anciennete,prime_anfa:prime_anfa,prime_fpc:prime_fpc,ech_anfa:ech_anfa,ech_fpc:ech_fpc,cat_anfa:cat_anfa,cat_fpc:cat_fpc
        } ,function(response) {
            //alert(response);
            $('#div_simu').empty();
            $('#div_simu').html(response);
        });
    }
    
    function reload_anfa(id){
        $.get( "loadanfa.php", {
            id:id
        } ,function(response) {
            //alert(response);
            $('#echanfa').empty();
            $('#echanfa').append(response);
        });
        //return false;
    }
    
    function reload_fpc(id){
        $.get( "loadfpc.php", {
            id:id
        } ,function(response) {
            //alert(response);
            $('#echfpc').empty();
            $('#echfpc').append(response);
        });
        //return false;
    }
    
    function calc_anfa(){
        var base = eval($("#echanfa").val());
        var anciennete = eval($("#anciennete").val());
        var prime1 = eval($("#anfa_prime1").val());
        var prime2 = eval($("#anfa_prime2").val());
        var prime3 = eval($("#anfa_prime3").val());
        var prime4 = eval($("#anfa_prime4").val());
        var prime5 = eval($("#anfa_prime5").val());
        var pourcent = (0.025*anciennete)+1;
        var total;
        var primes;
        
        if(anciennete>0){
            total = roundNumber(eval(base*pourcent),0)+prime1+prime2+prime3+prime4+prime5;
        }else{
            total = base+prime1+prime2+prime3+prime4+prime5;
        }
        $("#salaire_anfa").html("Salaire Actuel : "+total+" F");
        
        primes = prime1+prime2+prime3+prime4+prime5;
        $("#anfa_prime").val(primes);
    }
    
    function roundNumber(num, dec) {
	var result = Math.round(num*Math.pow(10,dec))/Math.pow(10,dec);
	return result;
    }
      function calc_fpc(){
        var base = eval($("#echfpc").val());
        var prime1 = eval($("#fpc_prime1").val());
        var prime2 = eval($("#fpc_prime2").val());
        var prime3 = eval($("#fpc_prime3").val());
        var prime4 = eval($("#fpc_prime4").val());
        var prime5 = eval($("#fpc_prime5").val());
        var valeur = 1408;
        var total;
        var primes;
        
        total = base*valeur+prime1+prime2+prime3+prime4+prime5;
        $("#salaire_fpc").html("Salaire Actuel : "+total+" F");
        
        primes = prime1+prime2+prime3+prime4+prime5;
        $("#fpc_prime").val(primes);
    }  
    </script>
    
</head>
<body>
    <h1>Simulation</h1>
    Categorie ANFA
    <select id="catanfa" onchange="javascript:reload_anfa(this.value);">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select>
    
    Echelon
    <select id="echanfa">
    </select>
    <br/>
    Ancienneté (cat 5 uniquement)<input type="text" id="anciennete" value="0" /><br/>
    Prime1 <input type="text" id="anfa_prime1" value="0" /><br/>
    Prime2 <input type="text" id="anfa_prime2" value="0" /><br/>
    Prime3 <input type="text" id="anfa_prime3" value="0" /><br/>
    Prime4 <input type="text" id="anfa_prime4" value="0" /><br/>
    Prime5 <input type="text" id="anfa_prime5" value="0" /><br/>
    <input type="hidden" id="anfa_prime"/>
    <button onclick="javascript:calc_anfa();">Calculer</button>
    <div id="salaire_anfa"></div> 
    <hr/>
    
        GRADE FPC
    <select id="catfpc" onchange="javascript:reload_fpc(this.value);">
        <option value="1">Conseiller Principal</option>
        <option value="2">Conseiller Qualifié</option>
        <option value="3">Conseiller</option>
        <option value="4">Technicien Principal</option>
        <option value="5">Technicien</option>
        <option value="6">Adjoint Principal</option>
        <option value="7">Ajoint</option>
        <option value="8">Agent Principal</option>
        <option value="9">Agent Qualifié</option>
        <option value="10">Agent</option>
    </select>
    
    Echelon/Groupe
    <select id="echfpc">
    </select>
      <br/>
    Prime1 <input type="text" id="fpc_prime1" value="0" /><br/>
    Prime2 <input type="text" id="fpc_prime2" value="0" /><br/>
    Prime3 <input type="text" id="fpc_prime3" value="0" /><br/>
    Prime4 <input type="text" id="fpc_prime4" value="0" /><br/>
    Prime5 <input type="text" id="fpc_prime5" value="0" /><br/>
    <input type="hidden" id="fpc_prime"/>
    <button onclick="javascript:calc_fpc();">Calculer</button>
    <div id="salaire_fpc"></div> 
    <hr/>
    <button onclick="javascript:simu();">Simuler</button>
    <div id="div_simu"></div> 
</body>
</html>