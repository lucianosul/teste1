




<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawSeriesChart);

    function drawSeriesChart() {

      var data = google.visualization.arrayToDataTable([


        ['Ip', 'X aleatorio', 'Y Aleatorio', 'Tabel de cor',     'Numero de Ataques:'],
<?php 
session_start();
$_SESSION['intervalo'] = 3;
try { 
  $conn = new PDO('mysql:host=hidden.cpd.ufsm.br;dbname=prelude', 'admin2prelude', 'guarana8181'); 
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

  if (isset($_POST['varIntervalo']))     {$tempo=$_POST['varIntervalo'];} else {$tempo=1;}
  if (isset($_POST['varGranularidade'])) {$granularidade=$_POST['varGranularidade'];} else {$granularidade=1;}
    
  //$consulta="SELECT count(ad.address), ad.address  FROM prelude.Prelude_CreateTime AS t, prelude.Prelude_Address AS ad WHERE (ad._message_ident = t._message_ident) AND (t.time > date_sub(now(), interval 3 minute)) AND (ad._parent0_index=0) AND (ad._index=0) AND (ad._parent_type="."'"."S"."'".")  GROUP BY ad.address   ORDER BY ad.address;";
  $consulta="SELECT count(ad.address), ad.address  FROM prelude.Prelude_CreateTime AS t, prelude.Prelude_Address AS ad WHERE (ad._message_ident = t._message_ident) AND (t.time > date_sub(now(), interval {$tempo} minute)) AND (ad._parent0_index=0) AND (ad._index=0) AND (ad._parent_type="."'"."S"."'".")  GROUP BY ad.address   ORDER BY ad.address;";
  $data = $conn->query($consulta); 
  
  foreach($data as $row) {
    $y = explode(".",$row[1]);

    //print_r($row); 
    
    if ($row[0] >= $granularidade) {
		echo  "["."'".$row[1]."'".", ".$y[3]." ,    ".$y[2].",      "."'"."Origem: "."'".",  ".$row[0]."],";    
	}
  } 
 //$consulta="SELECT count(ad.address), ad.address  FROM prelude.Prelude_CreateTime AS t, prelude.Prelude_Address AS ad WHERE (ad._message_ident = t._message_ident) AND (t.time > date_sub(now(), interval 1 minute)) AND (ad._parent0_index=0) AND (ad._index=0) AND (ad._parent_type="."'"."T"."'".")  GROUP BY ad.address   ORDER BY ad.address;";
 $consulta="SELECT count(ad.address), ad.address  FROM prelude.Prelude_CreateTime AS t, prelude.Prelude_Address AS ad WHERE (ad._message_ident = t._message_ident) AND (t.time > date_sub(now(), interval {$tempo} minute)) AND (ad._parent0_index=0) AND (ad._index=0) AND (ad._parent_type="."'"."T"."'".")  GROUP BY ad.address   ORDER BY ad.address;";
 $data = $conn->query($consulta);
 
  foreach($data as $row) {
    $y = explode(".",$row[1]);
    $seuhash=($y[1]+(2*$y[2])+(7*$y[3])%100);
    $seuhash=$seuhash % 255;
    if ($row[0] >= $granularidade) {
      echo  "["."'".$row[1]."'".", ".$y[3]." ,    ".$seuhash.",      "."'"."Desntino: "."'".",  ".$row[0]."],";
    }
  } 
  //echo "['IP',100,100,'Outra Classifica',50]";
  //echo "['sdIP',202,202,'".(string)$granularidade."',200]";
  
  



} catch(PDOException $e) { 
  echo 'ERROR: ' . $e->getMessage(); 
}




?>


      ]);

      var options = {
        title: 'Titulo a ser empregado no programa: ' +
               'Linha de baixo da linha de título com ano (2011)',
        hAxis: {title: 'valor aleatório'},
        vAxis: {title: 'outro valor aleatório'},
        bubble: {textStyle: {fontSize: 11}}
      };

      var chart = new google.visualization.BubbleChart(document.getElementById('series_chart_div'));
      chart.draw(data, options);
    }
    </script>
  </head>
  <body>
    <div id="series_chart_div" style="width: 1500px; height: 800px;"></div>
    <h1> Opcoes de Comando </h1>
	<?php
	echo "Intervalo=".$_POST['varIntervalo']."<BR>";
	echo "Granularidade=".$_POST['varGranularidade']."<BR>";
	echo "
	<form action=\"teste2.php\" method=\"post\">
		Intervalo:
	    <select name=\"varIntervalo\">	        			
			<option selected value=\"3\">3 Minutos</option>
			<option value=\"15\">15 Minutos </option>
			<option value=\"60\">60 Minutos </option>
		</select>	
		<br>
		Granularidade:
	    <select name=\"varGranularidade\">	        			
			<option selected value=\"1\">1 Ataque</option>
			<option value=\"3\">3 Ataques</option>
			<option value=\"10\">10 Ataques</option>
		</select>	
    <p><input type=\"submit\" value=\"Me acione\"></p>
    </form>";
	  
	?>
  </body>
</html>
