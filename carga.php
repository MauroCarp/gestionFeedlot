<html>
<head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script type="text/javascript">
function calcular_total() {
	importe_total = 0
	$(".importe_linea").each(
		function(index, value) {
			importe_total = importe_total + eval($(this).val());
		}
	);
	$("#total").val(importe_total);
}
 
function nueva_linea() {
	$("#lineas").append('<input type="text" class="importe_linea" value="0"/><br/>');
}
</script>
 
</head>
<body>
 
<form method="POST" action="nada.html">
	<div id="lineas">
		<input type="text" class="importe_linea" value="0"/><br/>
	</div>
	<label for="total">Total: <input type="text" id="total" value="0"/><br/>
	<input type="button" value="Nueva l&iacute;nea" onclick="nueva_linea()"/>
	<input type="button" value="Calcular" onclick="calcular_total()"/>
</form>
 
</body>