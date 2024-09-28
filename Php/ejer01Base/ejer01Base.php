<h2>Todo lo escrito fuera de las marcas de php es entregado en la respuesta http sin pasar por el procesador php</h2>

<?php
$mivariable="valor1";

echo "<h2> Todo el texto y/o HTML <span style= 'color: blue'> entregado por el procesador PHP </span> usando la sentencia Echo </h2>";
echo "<h2> Sin usar concatenador <span style= 'color: blue'>\$mivariable</span> : $mivariable" ;
echo "<h2> Usando concatenador <span style= 'color: blue'>\$mivariable</span> : ". $mivariable;
$mivariable=true;
echo "<h2> Variable tipo booleana o logica(Verdadero) <span style= 'color: blue'>\$mivariable</span> : ". $mivariable;
echo "<h2> Variable tipo booleana o logica(falso) <span style= 'color: blue'>\$mivariable</span> : ". $mivariable=false;
define("MiConstante","ValorConstante");
echo "<h2> <span style= 'color: blue'>MiConstante </span> : " . MiConstante;
echo "<h2> <span style= 'color: blue'>MiConstante </span> : " . gettype(MiConstante);
echo "<p> Arreglo : </p>";
$Arreglo = array("Auto","Camion");
echo "<span style='color:blue' >\$Arreglo[0]</span> : $Arreglo[0]";
echo "<h2><span style='color:blue' >\$Arreglo[1]</span> : $Arreglo[1]</h2>";
echo "<h2>Tipo de <span style='color:blue'> \$Arreglo </span> : ". gettype($Arreglo);
array_push($Arreglo,"Avion","Barco");
echo "<h2>Se agregan por programa dos elementos al array</h2>";
echo "<h2>Todos los elementos originales y agregados : </h2>";
foreach($Arreglo as $maquinas) {
    echo"<ul><li>". $maquinas . "</li></ul>";
}


$ArrayPalabrasEspaniol = array("Hola", "Adios", "Casa");
$ArrayPalabrasIngles = array("Hello", "Goodbye", "House");
$ArrayPalabrasItaliano = array("Ciao", "Arrivederci", "Casa");
$ArrayPalabrasFrances = array("Bonjour", "Adieu", "Maison");

$lenguajes = [
    $ArrayPalabrasEspaniol,
     $ArrayPalabrasIngles,
    $ArrayPalabrasItaliano,
    $ArrayPalabrasFrances,
];

echo "<table border='1' ";
echo "<tr>";
echo "<th>Español</th><th>Ingles</th><th>Italiano</th><th>Frances</th>";
echo "</tr>";
for ($i = 0; $i < count($lenguajes)-1; $i++) {
    echo "<tr>";
    foreach ($lenguajes as $lenguaje => $ArraydePalabras) {
        echo "<td>";
        echo $ArraydePalabras[$i];
        echo "</td>";
    }
    echo "</tr>";
}

echo "</table><br>";
echo "<span style='color:red'> Tambien se puede declarar de esta manera \$lenguajes[0][2]: </span>" . $lenguajes[0][2];
echo "<br><br>";

echo "<h1>Variables tipo arreglo asociativo </h1>";
$renglonDeLiquidacion = ["legEmpleado"=>"c0001","periodoLiquidado"=> "Enero de 2023" , "salarioBasico"=>20000, "fechaIngr"=>"02/04/2019"];
echo "<h4>Legajo de empleado ". $renglonDeLiquidacion['legEmpleado'];
echo "<br>";
echo "Tipo de empleado ". gettype($renglonDeLiquidacion['legEmpleado']);
echo "<br>";
echo "Salario basico de empleado ". $renglonDeLiquidacion['salarioBasico'];
echo "<br>";
echo "Tipo de salario  ". gettype($renglonDeLiquidacion['salarioBasico']);
echo "<br> </h4>";


echo "<h2>Expresiones aritmeticas</h2>";
$y=2;
$x=8;
$z= $y + $x;
$m= $x - $y;
$s= $x * $y;
$d= $x / $y;
echo "La variable \$y tiene el siguiente valor : ".$y ;
echo "<br>La variable \$x tiene el siguiente valor : ".$x;
echo "<br> La variable \$y tiene el siguiente tipo :". gettype($y);
echo "<br> La variable \$x tiene el siguiente tipo :". gettype($x);
echo "<br> Una suma entre \$x + \$y :". $z;
echo "<br> Una resta entre \$x - \$y :". $m;
echo "<br> Una Multiplicacion entre \$x * \$y :". $s;
echo "<br> Una division entre \$x / \$y :". $d;
?>