







<?php 

try { 
  $conn = new PDO('mysql:host=hidden.cpd.ufsm.br;dbname=prelude', 'admin2prelude', 'guarana8181'); 
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
  //$data = $conn->query('SELECT * FROM prelude.Prelude_Address limit 50;'); 
  


  $consulta="SELECT count(ad.address), ad.address  FROM prelude.Prelude_CreateTime AS t, prelude.Prelude_Address AS ad WHERE (ad._message_ident = t._message_ident) AND (t.time > date_sub(now(), interval 3 minute)) AND (ad._parent0_index=0) AND (ad._index=0) AND (ad._parent_type="."'"."S"."'".")  GROUP BY ad.address   ORDER BY ad.address;";
  $data = $conn->query($consulta); 
  
  foreach($data as $row) { 
    echo "C1: "; print_r($row[1]); 
    echo "n : "; print_r($row[0]); 
    echo "<BR>";
  } 
} catch(PDOException $e) { 
  echo 'ERROR: ' . $e->getMessage(); 
}








