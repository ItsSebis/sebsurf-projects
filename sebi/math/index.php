<?php

if (!isset($_GET["graph"])) {
    header("location: ./?graph=percent");
    exit();
} elseif ($_GET["graph"] == "percent") {
    $graph = "%";
} else {
    $graph = "$";
}

# PHPlot Example: Simple line graph
require_once '../.config/dbh.php';
require_once '../extensions/functions.php';
require_once '../extensions/phplot.php';
require_once '../extensions/rgb.php';

$done = array();
$awin = array();
$bwin = array();

foreach (throws() as $doneData) {
    $doneNumber = $doneData["done"]/1000000000;
    $aWinNumber = $doneData["awin"]/1000000000;
    $bWinNumber = $doneData["bwin"]/1000000000;
    if ($doneNumber !== 0) {
        $aWinPercent = 100/$doneNumber*$aWinNumber;
        $bWinPercent = 100/$doneNumber*$bWinNumber;
    } else {
        $aWinPercent = 0;
        $bWinPercent = 0;
    }
    if ($graph == "%") {
        $done[] = $doneNumber;
        $awin[] = $aWinPercent;
        $bwin[] = $bWinPercent;
    } else {
        $done[] = $doneNumber;
        $awin[] = $aWinNumber;
        $bwin[] = $bWinNumber;
    }
}
//$doneArray = throwsDone();
//echo($doneArray);

$data = array();

for ($i = count($done)-1; $i >= 0; $i--) {
    $data[] = array('', $done[$i], $awin[$i], $bwin[$i]);
}

$plot = new PHPlot(1920, 1000);

$plot->SetLineWidths(1);
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

