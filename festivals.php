<?php
include_once('lib/NumanCalendar.php');
include_once('lib/NumanFestivals.php');

/* 
 * Examples
 */

$NF = new NumanFestivals;
?>
<h1>Festività</h1>
<h2>Oggi</h2>
<?php
$today = date('d/m/Y');
list($d, $m, $y) = explode('/', $today);
$NF->setGregorianDate((int)$y, (int)$m, (int)$d);
$jd = $NF->getJD();
$yi = $NF->getYearInfo();
$di = $NF->getDayInfo();
$y = $NF->getYear();
$c = $NF->getCicle();
$sc = $NF->getSubcicle();
?>
<p>
    JD: <b><?php echo $jd?></b><br>
    Data: <b><?php echo $today ?></b><br>
    Data numana: <b><?php echo $NF->getDMY() ?></b><br>
    Giorno fisso: <b><?php echo $di['fixed'] ? $di['fixed'] : '--' ?></b><br>
    Festività: <b><?php echo $di['festival'] ? implode(', ',$di['festival']) : '--' ?></b><br>
    Data numana formato romano: <b><?php echo $di['date'] ?></b><br>
    Anno: <b><?php echo sprintf("%s (%s)", $y, $yi['yearInCicle']) ?></b><br>
    Ciclo: <b><?php echo $c ?></b><br>
    Sottociclo: <b><?php echo $sc ?></b><br>
</p>
<h2>Ciclo</h2>
<table>
  <tr>
    <th>JD</th>
    <th>Data</th>
    <th>Data numana</th>
    <th>Giorno fisso</th>
    <th>Festività</th>
    <th>Data numana formato romano</th>
    <th>Anno</th>
    <th>Ciclo</th>
    <th>Sottociclo</th>
  </tr>
<?php
for ($i=1446450; $i<=(1446450+8766); $i+=1) {
    // Data da JD
    $date = ($i >= 2299161) ? jdtogregorian($i) : jdtojulian($i);
    list($month, $day, $year) = explode('/', $date);
    if ($year < 0) $year = ($year * -1) . " a.C.";
    $dmy = "$day/$month/$year";
    //     
    $NF->setJD($i);
    $yi = $NF->getYearInfo();
    $di = $NF->getDayInfo();
    $y = $NF->getYear();
    $c = $NF->getCicle();
    $sc = $NF->getSubcicle();
    ?>
  <tr>
    <td><?php echo $i?></td>
    <td><?php echo $dmy ?></td>
    <td><?php echo $NF->getDMY() ?></td>
    <td><?php echo $di['fixed'] ? $di['fixed'] : '--' ?></td>
    <td><?php echo $di['festival'] ? implode(', ',$di['festival']) : '--' ?></td>
    <td><?php echo $di['date'] ?></td>
    <td><?php echo sprintf("%s (%s)", $y, $yi['yearInCicle']) ?></td>
    <td><?php echo $c ?></td>
    <td><?php echo $sc ?></td>
  </tr>
<?php } ?>
</table>

