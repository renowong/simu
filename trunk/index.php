<?php
include_once("index_top.php");
?>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
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
        var prime6 = eval($("#anfa_prime6").val());
        var prime7 = eval($("#anfa_prime7").val());
        var prime8 = eval($("#anfa_prime8").val());
        var prime9 = eval($("#anfa_prime9").val());
        var prime10 = eval($("#anfa_prime10").val());
        var prime11 = eval($("#anfa_prime11").val());
        var prime12 = eval($("#anfa_prime12").val());
        
        var pourcent = (anciennete/100)+1;
        var total;
        var primes;
        
        if(anciennete>0){
            total = roundNumber(eval(base*pourcent),0)+prime1+prime2+prime3+prime4+prime5+prime6+prime7+prime8+prime9+prime10+prime11+prime12;
        }else{
            total = base+prime1+prime2+prime3+prime4+prime5+prime6+prime7+prime8+prime9+prime10+prime11+prime12;
        }
        $("#salaire_anfa").html("Salaire Actuel : "+addspace(total)+" F");
        
        primes = prime1+prime2+prime3+prime4+prime5+prime6+prime7+prime8+prime9+prime10+prime11+prime12;
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
        var prime6 = eval($("#fpc_prime6").val());
        var prime7 = eval($("#fpc_prime7").val());
        var prime8 = eval($("#fpc_prime8").val());
        var valeur = 1408;
        var total;
        var primes;
        
        total = base*valeur+prime1+prime2+prime3+prime4+prime5+prime6+prime7+prime8;
        $("#salaire_fpc").html("Salaire Actuel : "+addspace(total)+" F");
        
        primes = prime1+prime2+prime3+prime4+prime5+prime6+prime7+prime8;
        $("#fpc_prime").val(primes);
    }
    function addspace(nStr)
        {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ' ' + '$2');
            }
            return x1 + x2;
        }
    </script>
    
</head>
<body>
    <h1>Simulation <input type="text" size="50"/></h1>
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
    <table><tr><td>
    Ancienneté (cat 5 uniquement)<input type="text" id="anciennete" value="0" /><br/>
    SFT <input type="text" id="anfa_prime1" value="0" /><br/>
    Complement solde <input type="text" id="anfa_prime2" value="0" /><br/>
    Prime à l'emploi <input type="text" id="anfa_prime3" value="0" /><br/>
    Prime d'ancienneté <input type="text" id="anfa_prime4" value="0" /><br/>
    Indemnité de sujétion <input type="text" id="anfa_prime5" value="0" /><br/>
    Indemnité de salisure <input type="text" id="anfa_prime6" value="0" /><br/>
    </td><td>
    Indemnité de nuit <input type="text" id="anfa_prime7" value="0" /><br/>
    Indemnité de panier <input type="text" id="anfa_prime8" value="0" /><br/>
    Indemnité d'astreinte <input type="text" id="anfa_prime9" value="0" /><br/>
    Prime de diplome <input type="text" id="anfa_prime10" value="0" /><br/>
    Indemnité compensatrice <input type="text" id="anfa_prime11" value="0" /><br/>
    Prime de risque <input type="text" id="anfa_prime12" value="0" /><br/>
    </td></tr>
    </table>
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
      <table><tr><td>
    Indemnite de sujétion : salisure <input type="text" id="fpc_prime1" value="0" /><br/>
    IFTS <input type="text" id="fpc_prime2" value="0" /><br/>
    Prime de responsabilité <input type="text" id="fpc_prime3" value="0" /><br/>
    Prime de polyvalence <input type="text" id="fpc_prime4" value="0" /><br/>
    </td><td>
    Indemnité de spécialisation <input type="text" id="fpc_prime5" value="0" /><br/>
    Indemnité de sujétion :caisse <input type="text" id="fpc_prime6" value="0" /><br/>
    Indemnité de sujétion : nuit <input type="text" id="fpc_prime7" value="0" /><br/>
    Prime d'isolement <input type="text" id="fpc_prime8" value="0" /><br/>
    </td></tr>
      </table>
    <input type="hidden" id="fpc_prime"/>
    <button onclick="javascript:calc_fpc();">Calculer</button>
    <div id="salaire_fpc"></div> 
    <hr/>
    <button onclick="javascript:simu();">Simuler</button>
    <div id="div_simu"></div> 
</body>
</html>