<?php
include_once('lib/NumanCalendar.php');

/* 
 * Examples
 */

$NC = new NumanCalendar;

echo "\nCALENDARIO NUMANO";

?>
<table>
  <tr>
    <th>JD</th>
    <th>Data</th>
    <th>Data numana</th>
    <th>Giorno fisso</th>
    <th>Data numana formato romano</th>
    <th>Anno</th>
    <th>Ciclo</th>
    <th>Sottociclo</th>
  </tr>
<?php
for ($i=$NC::JD0; $i<=2458953; $i+=8766) {
    // Data da JD
    $date = ($i >= 2299161) ? jdtogregorian($i) : jdtojulian($i);
    list($month, $day, $year) = explode('/', $date);
    if ($year < 0) $year = ($year * -1) . " a.C.";
    $dmy = "$day/$month/$year";
    //     
    $NC->setJD($i);
    $y = $NC->getYear();
    $c = $NC->getCicle();
    $sc = $NC->getSubcicle();
    $fixed = $NC->isFixedDay();
    ?>
  <tr>
    <td><?php echo $i?></td>
    <td><?php echo $dmy ?></td>
    <td><?php echo $NC->getDMY() ?></td>
    <td><?php echo $fixed ? $fixed : '--' ?></td>
    <td><?php echo $NC->getRomanDate() ?></td>
    <td><?php echo $y ?></td>
    <td><?php echo $c ?></td>
    <td><?php echo $sc ?></td>
  </tr>
<?php } ?>
</table>

