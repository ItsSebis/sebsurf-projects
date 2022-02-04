<?php
# PHPlot Example: Simple line graph
require_once '../.config/dbh.php';
require_once '../extensions/functions.php';
require_once '../extensions/phplot.php';
require_once '../extensions/rgb.php';

$done = array();
$awin = array();
$bwin = array();

foreach (throws() as $doneData) {
    $done[] = $doneData["done"]/1000000000;
    $awin[] = $doneData["awin"]/1000000000;
    $bwin[] = $doneData["bwin"]/1000000000;
}
//$doneArray = throwsDone();
//echo($doneArray);

$data = array();

for ($i = count($done); $i > 0; $i--) {
    $data[] = array('', $done[$i], $awin[$i], $bwin[$i]);
}

$plot = new PHPlot(1920, 1000, "out/out.png");
$plot->SetImageBorderType('plain');

$plot->SetTextColor("white");
$plot->SetTitleColor("white");
$plot->SetPlotType('lines');
$plot->SetDataType('data-data');
$plot->SetBackgroundColor("black");
$plot->SetImageBorderType("none");
$plot->SetDataColors(array("green", "red"));
$plot->SetDataValues($data);
$plot->SetDrawLegendBorder(true);
$plot->SetLegend(array("A", "B"));

# Main plot title:
$plot->SetTitle('Angaben in Milliarden');

# Make sure Y axis starts at 0:
$plot->SetPlotAreaWorld(NULL, 0, NULL, NULL);

$plot->DrawGraph();

