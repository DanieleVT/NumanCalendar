<?php

include_once('lib/NumanCalendar.php');

$NC = new NumanCalendar;

echo "<pre>";
echo "\nCALENDARIO NUMANO: TESTS";

$JD0 = $NC::JD0;

// Date precedenti offset
for ($i=0;$i<=10;$i++){
    try {
        $jd = rand(1, $JD0);
        echo sprintf("\nJD: %s, data: %s", $jd, implode("/",dateFromJD($jd)));
        $NC->setJD($i);
    } catch (Exception $ex) {
        echo PHP_EOL."ERROR ".$ex->getMessage();
    }
   
}

// Date successive
echo PHP_EOL.' =========================================== ';
for ($i=0;$i<=1000;$i++){
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
        echo PHP_EOL."ERROR ".$ex->getMessage();
    }
}

// Random date
echo PHP_EOL.' =========================================== ';
for ($i=0;$i<=1000;$i++){ 
    try {
        $day = rand(1,31);
        $month = rand(1,12);
        $year = rand(-4713, 2020);
        echo sprintf(PHP_EOL."Data %s ", implode('/', [$day, $month, $year]));
        
        if (gregoriantojd($month, $day, $year) >= 2299161) 
            $NC ->setGregorianDate($year, $month, $day);
        else
            $NC ->setJulianDate($year, $month, $day);
        
        $params = getParamsFromNC($NC);
        echo sprintf("data numana: %s", implode('/', [$day, $month, $year]), $params['date']);
    } catch (Exception $ex) {
        echo PHP_EOL."ERROR ".$ex->getMessage();
    }
}

// build Numan from year, month, day
echo PHP_EOL.' =========================================== ';
for ($i=$NC::JD0; $i<=$NC::JD0+8766; $i+=1) {
    try {
        echo sprintf(PHP_EOL."JD: %s data: %s ", $i, implode("/",dateFromJD($i)));
        $NC->setJD($i);
        $params = getParamsFromNC($NC);
        list($year, $month, $day) = array($NC->getYear(),$NC->getMonth(), $NC->getDay());
        $NC2= new NumanCalendar;
        $NC2->setYMD($year, $month, $day);
        $check = compare($NC, $NC2);
        echo sprintf("data numana: %s check: %s", $params['date'], ($check ? 'OK' : 'KO'));
        if (!$check){
            throw new UnexpectedValueException (
                sprintf("Julian Day %d == %d, cicle %d == %d, subcicle %d == %d, nundinal %s == %s", 
                $i, $NC2->getJD(), $NC->getCicle(), $NC2->getCicle(), 
                $NC->getSubcicle(), $NC2->getSubcicle(),
                $NC->getNundinal(), $NC2->getNundinal()));
        }
    } catch (Exception $ex) {
        echo PHP_EOL."ERROR ".$ex->getMessage();
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

function compare(NumanCalendar &$NC1, NumanCalendar &$NC2){
    $check = ($NC1->getJD() == $NC2->getJD()) 
            && ($NC1->getCicle() == $NC2->getCicle()) 
            && ($NC1->getSubcicle() == $NC2->getSubcicle())
            && ($NC1->getNundinal() == $NC2->getNundinal());
    
    return $check;
}

echo "</pre>";