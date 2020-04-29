<?php

include_once('lib/NumanCalendar.php');

$NC = new NumanCalendar;

echo "<pre>";
echo "\nCALENDARIO NUMANO: TESTS";

$JD0 = $NC::JD0;

// Date precedenti il 1 Marzo 753 AC
for ($i=0;$i<=10;$i++){
    try {
        $jd = rand(1, $JD0);
        echo sprintf("\nJD: %s, data: %s", $jd, implode("/",dateFromJD($jd)));
        $NC->setJD($i);
    } catch (Exception $ex) {
        echo "\nERROR ".$ex->getMessage();
    }
   
}

// Date successive
for ($i=0;$i<=10000;$i++){
    try {
        $jd = rand($JD0, 2458953);

        echo sprintf("\nJD: %s data: %s ", $jd, implode("/",dateFromJD($jd)));
        list($day, $month, $year) = dateFromJD($jd);
        $NC->setJD($jd);
        $params = getParamsFromNC($NC);
        if ($jd >= 2299161) 
            $NC ->setGregorianDate($year, $month, $day);
        else
            $NC ->setJulianDate($year, $month, $day);
        $params2 = getParamsFromNC($NC);
        $check = ($params == $params2);

        echo sprintf("data numana: %s check: %s", $params['date'], ($check ? 'OK' : 'KO'));
    } catch (Exception $ex) {
        echo "\nERROR ".$ex->getMessage();
    }
}

// Random date
for ($i=0;$i<=10000;$i++){ 
    try {
        $day = rand(1,31);
        $month = rand(1,12);
        $year = rand(-4713, 2020);
        echo sprintf("\nData %s ", implode('/', [$day, $month, $year]));
        
        if (gregoriantojd($month, $day, $year) >= 2299161) 
            $NC ->setGregorianDate($year, $month, $day);
        else
            $NC ->setJulianDate($year, $month, $day);
        
        $params = getParamsFromNC($NC);
        echo sprintf("data numana: %s", implode('/', [$day, $month, $year]), $params['date']);
    } catch (Exception $ex) {
        echo "\nERROR ".$ex->getMessage();
    }
}


function dateFromJD($jd){
    $date = ($jd >= 2299161) ? jdtogregorian($jd) : jdtojulian($jd);
    list($month, $day, $year) = explode('/', $date);    
    return array($day,$month,$year);
}

function getParamsFromNC(&$NC){
    $c = $NC->getCicle();
    $sc = $NC->getSubcicle();
    $y = $NC->getYear();
    $date = $NC->getDMY();
    
    return array('c' => $c, 'sc' => $sc, 'y' => $y, 'date' => $date);
}
echo "</pre>";