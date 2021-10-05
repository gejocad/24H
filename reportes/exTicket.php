<?php 
//activamos almacenamiento en el buffer
ob_start();
if (strlen(session_id())<1) 
  session_start();

if (!isset($_SESSION['nombre'])) {
  echo "debe ingresar al sistema correctamente para vosualizar el reporte";
}else{

if ($_SESSION['ventas']==1) {

?>

<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet">
</head>
<body onload="window.print();">
	<?php 
// incluimos la clase venta
require_once "../modelos/Venta.php";


//incluimos el archivo factura


//establecemos los datos de la empresa
$logo="logo.png";
$ext_logo="png";
$empresa = "PIMIENTA ROSA";
$documento = "NIT 102.237.7406-6";
$direccion = "Cll. 17 Nro. 23-56, Santa teresita. Arauca-Arauca";
$telefono = "+57 (315) 217 04 68";
$telefono1 = "+57 (320) 807 62 83";
$email = "pimientarosagourmet@gmail.com";

$venta = new Venta();

//en el objeto $rspta obtenemos los valores devueltos del metodo ventacabecera del modelo
$rspta = $venta->ventacabecera($_GET["id"]);

$reg=$rspta->fetch_object();



	 ?>
<FONT FACE="Arial">
<div class="zona_impresion">
	<!--codigo imprimir-->
	<br>
	<table border="0" align="center" width="240px">
		<tr>
			<td align="center">
				<!--mostramos los datos de la empresa en el doc HTML-->
				<img src="logo.png" width="220" height="200"/><p>
				.::<strong> <?php echo $empresa; ?></strong>::.<br>
				<?php echo $documento; ?><br>
				<?php echo $direccion; ?><br>
				<?php echo $telefono; ?><br>
				<?php echo $telefono1; ?><br>
				<?php echo $email; ?><br>
			</td>
		</tr>
		<tr>
			<td align="center">Fecha: <?php echo $reg->fecha; ?></td>
		</tr>
		<tr> 
			<td align="center"></td>
		</tr>
		<tr> 
			<td align="center">COMPROBANTE</td>
		</tr>
		<tr> 
			<td align="center"></td>
		</tr>
		<tr>
			<!--mostramos los datos del cliente -->
			<td>Cliente: <?php echo $reg->cliente; ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $reg->tipo_documento.": ".number_format($reg->num_documento); ?>
			</td>
		</tr>
		<tr>
			<td>
				N° de Comprobante: P-0<?php echo $reg->idventa; ?>
			</td>
		</tr>
		
	</table>
	<br>
	<br>

	<!--mostramos lod detalles de la venta -->

	<table border="0" align="center" width="210px">
		<tr>
			<td>CANT.</td>
			<td>DESCRIPCION</td>
			<td align="right">IMPORTE</td>
			<td>D/A</td>
		</tr>
		<tr>
			<td colspan="3">===========================</td>
		</tr>
		<?php
		$rsptad = $venta->ventadetalles($_GET["id"]);
		$cantidad=0;
		while ($regd = $rsptad->fetch_object()) {
		 	echo "<tr>";
		 	echo "<td>".$regd->cantidad."</td>";
		 	echo "<td>".$regd->articulo."</td>";
		 	echo "<td align='right'>$ ".number_format($regd->subtotal, 0, ',', ' ')."</td>";
		 	echo "<td>+".number_format($regd->derecho, 0, ',', ' ')."%</td>";
		 	echo "</tr>";
		 	$cantidad+=$regd->cantidad;
		 } 

		 ?>
		 <!--mostramos los totales de la venta-->
		<tr>
			<td>&nbsp;</td>
			<td align="right"><b>TOTAL:</b></td>
			<td align="right"><b>$ <?php echo number_format($reg->total_venta, 0, ',', ' '); ?></b></td>
		</tr>

		<tr>
			<td colspan="3">N° de articulos: <?php echo $cantidad; ?> </td>
		</tr>
		<tr>
			<td colspan="3">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="3" align="center">¡Gracias por su compra!</td>
		</tr>
		<tr>
			<td colspan="3" align="center">Para cualquier cambio o garantia es indispensable presentar las factura.</td>
		</tr>
	</table>
	<br>
</div>
</FONT>
<p>&nbsp;</p>
</body>
</html>



<?php

	}else{
echo "No tiene permiso para visualizar el reporte";
}

}


ob_end_flush();
  ?>