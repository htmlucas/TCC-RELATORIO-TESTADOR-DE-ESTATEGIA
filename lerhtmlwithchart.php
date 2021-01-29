

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
$def = json_encode($df);

$x_axis = [];

$lucro_acumulado = 0;
$data = array();
for ($i=0; $i < count($df); $i++) { 
	$trade_no = $i;	
	$lucro = $df[$i][10];
    
    $lucro_acumulado = $lucro_acumulado+$lucro;

	$row = array('', $trade_no, $lucro_acumulado);

	array_push($data, $row);
	
	array_push($x_axis, $lucro_acumulado);
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
     <script src="package/dist/Chart.js"></script>
</head>
<body>

    <canvas id="myChart" width="400" height="400"></canvas>
    
    <script>
        var df = [<?php echo implode(', ', $x_axis);?>];
        
        var data = [];
        var numtrades = [];
        var lucroacumulado = 0;
            
        for (var i=0; i < df.length; i++) {
             
            numtrades[i] = i;

            var lucro = parseInt(df[i][10]);  

            lucroacumulado += lucro;
            
            var row = ['',numtrades[i],lucroacumulado];
            
            console.log(row);
            data.push(row);

        }
        
        console.log(data);
        var ctx = document.getElementById('myChart');
        var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels:numtrades,
            datasets:[
                {
                    label:"Lucro Acumulado",
                    fill:false,
                    lineTension:0.1,
                    backgroundColor:"rgba(75,192,192,0.4)",
                    borderColor:"rgba(75,192,192,1)",
                    borderCapStyle:'butt',
                    borderDash:[],
                    borderDashOffset:0.0,
                    borderJoinStyle:'miter',
                    pointBorderColor:"rgba(75,192,192,1)",
                    pointBackgroundColor:"#fff",
                    pointBorderWidth:1,
                    pointHoverRadius:5,
                    pointHoverBackgroundColor:"rgba(75,192,192,1)",
                    pointHoverBorderColor:"rgba(220,220,220,1)",
                    pointHoverBorderWidth:2,
                    pointRadius:1,
                    pointHitRadius:10,
                    data:df,
                }
            ]
        }
        
        });
        
    </script>
</body>
</html>

