<?php
include_once('lib/NumanCalendar.php');
include_once('lib/NumanFestivals.php');

/* 
 * Fasti
 */

$fixed = array('Kalendae' => 'K', 'Nonae' => 'NON', 'Idus' => 'EIDVS');

$colours = array(
    'F'=>'lime',
    'FP'=>'cadetblue',
    'C'=>'yellow',
    'N'=>'red',
    'NP'=>'orange',
    'EN'=>'deepskyblue',
    'QRCF'=>'darkgray',
    'QSDF'=>'darkgray');

$NF = new NumanFestivals;
?>
<h1>Fasti</h1>
<h2>Anno normale</h2>
<?php $y=1 ?>
<table>
<?php
for($d=0;$d<=32;$d++){
    echo '<tr>';
    for($m=1;$m<=12;$m++){
        try {
                if ($d == 0) {
                    // Header dei mesi
                    $NF->setYMD($y, $m, 1);
                    echo '<td colspan="2">' . $NF->getMonthName() . '</td>';
                } elseif ($d == 32) {
                    $NF->setYMD($y, $m, 1);
                    echo '<td colspan="2">' . $NF->numberToRomanRepresentation($NF->getMonthLength()) . '</td>';
                } else {
                    $NF->setYMD($y, $m, $d);
                    $di = $NF->getDayInfo();

                    $content = '';
                    if ($di['fixed'])
                        $content = $fixed[$di['fixed']];
                    if ($di['festival'])
                        $content .= ' '.implode(' ', $di['festival']);
                    $content .=' '.$di['fastus'];

                    echo '<td>' . $di['nundinal'] . '</td>';
                    echo '<td style="background-color:'.$colours[$di['fastus']].'">' . $content . '</td>';
                }
            } catch (Exception $exc) {
                echo '<td colspan="2">&nbsp;</td>';
            }
        }
    echo '</tr>';
}
?>
</table>