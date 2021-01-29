

<?php
header('Content-Type: text/html; charset=utf-8');
require 'phplot-6.2.0/phplot.php';

$DOM = new DOMDocument();
$DOM->loadHTMLFile('101 BB abertura.html');

$df = array();

$find_deals = false; # ao encontrar o rótulo das transações alterna para armazenar as linhas

$rows = $DOM->getElementsByTagName('tr');
foreach($rows as $row)
{
	$headers = $row->getElementsByTagName('th'); 
	foreach ($headers as $header) {
		$divs = $header->getElementsByTagName('div'); 
		foreach ($divs as $div) {
			$bold = $div->getElementsByTagName('b'); 
			if(trim($bold[0]->textContent) == 'Transações')
			{
				$find_deals = true;
			}
		}
	}
	if($find_deals)
	{		
		$linha = array();
		$cells = $row->getElementsByTagName('td'); 
		foreach ($cells as $cell) {
			array_push($linha, $cell->textContent);
		}
		array_push($df, $linha);
	}	
}

array_shift($df); #deletar linha vazia
array_shift($df); #deletar linha do cabeçalho
array_shift($df); #deletar linha do depósito inicial
array_pop($df);
array_pop($df);
$lucro_acumulado = 0;
$data = array();
for ($i=0; $i < count($df); $i++) { 
	$trade_no = $i;	
	$lucro = $df[$i][10];
    
    $lucro_acumulado = $lucro_acumulado+$lucro;

	$row = array('', $trade_no, $lucro_acumulado);

	array_push($data, $row);
	
}
/*
$plot = new PHPlot(1200, 800);
$plot->SetImageBorderType('plain');

$plot->SetPlotType('lines');
$plot->SetDataType('data-data');
$plot->SetDataValues($data);

# Main plot title:
$plot->SetTitle('Portfolio de Robos Investidores');

# Make sure Y axis starts at 0:
$plot->SetPlotAreaWorld(NULL, NULL, NULL, NULL);

$plot->DrawGraph();
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
     <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
</head>
<body>

    <div id="tester" style="width:1200px;height:500px;"></div>
    
       <script>
	TESTER = document.getElementById('tester');
    var lucroacumulado = "<?php echo $lucro_acumulado;?>";
          
    var numtrade = "<?php echo $trade_no;?>";
           
	Plotly.newPlot( TESTER, [{
	x: [lucroacumulado],
	y: [numtrade],
    mode:'lines'}], {
	margin: { t: 0 } } );
</script>
</body>
</html>

