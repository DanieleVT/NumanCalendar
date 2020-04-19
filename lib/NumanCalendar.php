<?php

/**
 * This class provides methods for calculate the date
 * following the traditional Roman Calendar attributed to
 * Numa Pompilius.
 * This work is based on Leonardo Magini's reconstructive hypothesis.
 * 
 * Questa classe implementa metodi per il calcolo della
 * data secondo il calendario numano, attribuito tradizionalmente
 * a Numa Pompilio.
 * Questo lavoro si basa sull'ipotesi ricostruttiva di Leonardo
 * Magini.
 * 
 * @author Daniele Vitantoni
 * @license MIT
 * 
 * @link http://www.leonardomagini.it/PDF/34%20-%20I%20Fondamenti%20astronomici.pdf
 */
class NumanCalendar {
    /*
     * Calendar offset: is assumed to be the JD
     * of the beginning of the year of 
     * founding of Rome (April 21 753 BC), then
     * March, 1st, 753 BC
     * 
     * Offset del calendario: 1 Marzo 753 AC
     */
    const JD0 = 1446450;
    
    /**
     * Month names following Macrobius and Plutarch
     * @var string[] 
     */
    protected $months = array(
        'Martius',
        'Aprilis',
        'Maius', 
        'Iunius', 
        'Quintilis',
        'Sextilis',
        'September',
        'October',
        'November',
        'December', 
        'Ianuarius',
        'Februarius',
        'Mercedonius'
    );

    /*
     * Month lengths in days
     * @var int[] 
     */
    protected $days_in_months = array(31,29,31,29,31,29,29,31,29,29,29,28,22);
 
    /**
     * Julian Day
     * @var int
     */
    protected $JD;
    
    /**
     * Cicle number from the beginning of the calendar
     * @var int 
     */
    protected $cicle;
    
    /*
     * Subcicle (1, 2 or 3)
     * @var int
     */
    protected $subcicle;
    
    /**
     * Year number in the cicle
     * @var int
     */
    protected $year_in_cicle;
    
    /**
     * Numan year
     * @var int
     */
    protected $year;
    
    /**
     * Numan month
     * @var int
     */
    protected $month;
    
    /**
     * Numan day
     * @var int
     */
    protected $day;

    /******************************/
    
    public function getJD() {
        return $this->JD;
    }
    
    public function getCicle() {
        return $this->cicle;
    }

    public function getSubcicle() {
        return $this->subcicle;
    }

    public function getYear() {
        return $this->year;
    }
    
    public function getMonth() {
        return $this->month;
    }
       
    public function getDay() {
        return $this->day;
    }

    /**
     * Return the month proper name
     * 
     * @param int $month
     * @return string
     */
    public function getMonthName(int $month=NULL){
        if ($month === NULL) $month = $this->month;
        if ($month < 1)
            throw new InvalidArgumentException("The month cannot be smaller than 1, $month given");
        
        $i = $month -1;
        $i = $i % $this->yearLenghtInMonths();
        
        return $this->months[$i];
    }

    /**
     * Set the Julian Day
     * 
     * @param int $JD
     * @throws InvalidArgumentException
     */
    public function setJD(int $JD) {
        if ($JD < self::JD0)
            throw new InvalidArgumentException(sprintf("Julian day value must be greater than or equal to %s", self::JD0));
        
        $this->JD = $JD;
        
        $this->JDToNuman();
    }

    /**
     * Set the Julian Day from the gregorian date
     * 
     * @param int $year
     * @param int $month
     * @param int $day
     * @throws InvalidArgumentException
     */
    public function setGregorianDate(int $year, int $month, int $day){
        $JD = gregoriantojd($month, $day, $year);

        if ($JD < self::JD0)
            throw new InvalidArgumentException(sprintf("Gregorian date cannot be prior to %s", 
                jdtogregorian(self::JD0)));
        
        $this->JD = $JD;
        $this->JDToNuman();
    }
    
    /**
     * Set the Julian Day from the julian date
     * 
     * @param int $year
     * @param int $month
     * @param int $day
     */
    public function setJulianDate(int $year, int $month, int $day){
        $JD = juliantojd($month, $day, $year);
        
        if ($JD < self::JD0)
            throw new InvalidArgumentException(sprintf("Julian date cannot be prior to %s", 
                jdtojulian(self::JD0)));
         
        $this->JD = $JD;
        $this->JDToNuman();
    }
        
    public function getYearInfo($year=NULL){
        $yearInCicle = ($year===NULL) 
            ? $this->year_in_cicle 
            : $this->yearInCicle($year);
        
        return array(
            'yearInCicle' => $yearInCicle, 
            'leap' => $this->isLeapYear($yearInCicle),
            'length' => $this->yearLenghtInDays($yearInCicle)
        );
    }
    
    /*
     * Get the date in D/M/Y format
     *
     * @return string
     */
    public function getDMY(){
        $d = $this->day;
        $m = $this->month;
        $y = $this->year;
        return sprintf("%s/%s/%s", $d, $m, $y);
    }
    
    /*
     * Get the date in Roman format
     *      
     * @return string
     */
    public function getRomanDate(){
        $y = $this->year;
        $m = $this->month;
        $d = $this->day;
        return $this->romanDate($y,$m,$d);
    }
    
    /**
     * Return fixed, if day is fixed, false otherwise
     * 
     * @param int $d day
     * @param int $m month
     * @return string|bool
     */
    public function isFixedDay(int $d = NULL, int $m = NULL){
        if ($d === NULL) $d = $this->day;
        if ($m === NULL) $m = $this->month;
        
        $ml = $this->days_in_months[$m-1];
        
        $nonae = ($ml == 31) ? 7 : 5;
        $idus = ($ml == 31) ? 15 : 13;
        
        if ($d == 1) return 'Kalendae';
        elseif ($d == $nonae) return 'Nonae';
        elseif ($d == $idus) return 'Idus';
        else return FALSE;
    }
    
    /**
     * Set the Julian Date params for the given Julian Day
     * @param int $JD
     * @return void
     */
    protected function JDToNuman(int $JD = NULL){
        if($JD !== NULL) $this->setJD($JD);
        
        //calcolo il giorno sottraendo l'offset di inizio del calendario
        $jd = $this->JD - self::JD0 + 1;

        $jd-=1;
        $cicle = (int)($jd / 8766);
        $days_in_cicle = $jd % 8766;
        $subcicle = (int)($days_in_cicle / 2930);

        $cicle+=1; $days_in_cicle+=1; $subcicle+=1;
        
        $this->cicle = $cicle;
        $this->subcicle = $subcicle;

        list($year, $month, $day) = $this->getNumanYMD($days_in_cicle);
        
        //Anno 
        $year += (($cicle-1)*24);
        
        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
        
        $this->year_in_cicle = $this->yearInCicle($year);     
    }
    
    /**
     * Year Length in months
     * 
     * @param int $yearInCicle
     * @return int
     */
    protected function yearLenghtInMonths(int $yearInCicle=NULL){
        if ($yearInCicle===NULL) $yearInCicle = $this->year_in_cicle;
        
        return ($this->isLeapYear($yearInCicle)) ? 13 : 12; 
    }
    
    /**
     * Year Length in days
     * 
     * @param int $yearInCicle
     * @return int
     */
    protected function yearLenghtInDays(int $yearInCicle=NULL){
        if ($yearInCicle===NULL) $yearInCicle = $this->year_in_cicle;
        
        $length = 355;
        
        /**
         * Si aggiungono 23 giorni agli anni bisestili
         * multipli di 4 eccetto il 24°, mentre per 
         * gli altri anni bisesitili si aggiungono 
         * 22 giorni.
         */
        if ($this->isLeapYear($yearInCicle)){
                $length += 22;
            if ($yearInCicle % 4 == 0 && $yearInCicle != 24) {
                $length++;
            }
        }
        
        return $length;
    }
    
    /**
     * Check if the year is leap following
     * the Magini's hypothesis about intercalar months.
     * 
     * Mi dice se l'anno è bisestile o meno:
     * si basa sull'ipotesi di Magini per la distribuzione
     * dei giorni intercalari
     * 
     * @param int $yearInCicle
     * @return boolean
     * @throws InvalidArgumentException
     * @link http://www.leonardomagini.it/PDF/34%20-%20I%20Fondamenti%20astronomici.pdf
     */
    protected function isLeapYear(int $yearInCicle=NULL){       
        if ($yearInCicle===NULL) $yearInCicle = $this->year_in_cicle;
        
        if ($yearInCicle < 1 || $yearInCicle > 24)
                throw new InvalidArgumentException(sprintf("Invalid required year %s", $yearInCicle));
        
        if ($yearInCicle <= 16){
            // Primi due sottocicli: sono bisestili gli anni pari
            if ($yearInCicle % 2 == 0) return TRUE;
        }
        else {
            // Ultimo sottociclo: sono bisestili il 19°, 22° e 24° anno
            if (in_array($yearInCicle, [19,22,24])) return TRUE;
        }
    }
    
    /**
     * Return the year count in cicle
     * 
     * @param int $year
     * @return int
     */
    protected function yearInCicle(int $year){
        $yearInCicle = (($year - 1) % 24) + 1;

        return $yearInCicle;
    }
    
    /**
     * Given the number of days past from the 
     * beginning of the cycle, provides
     * year, month and day of the current cycle.
     * 
     * Dato il numero di giorni trascorsi 
     * dall'inizio del ciclo, stima
     * anno, mese e giorno del ciclo corrente.
     * 
     * @param int $daysInCicle
     * @return int[]
     */
    protected function getNumanYMD(int $daysInCicle){
        $daysInCicle = ($daysInCicle - 1) % 8766 + 1;

        $year = 1;
        $i = 0;
        for($y=1;$y<=24;$y++){
            $yl = $this->yearLenghtInDays($y);
            $i += $yl;
            if ($i >= $daysInCicle){
                $i -= $yl;
                $year = $y;
                break;
            }
        }
        $yr = $daysInCicle - $i;
        
        $month = 1;
        $i = 0;
        for ($m=1;$m<=$this->yearLenghtInMonths($year);$m++){
            $ml = $this->days_in_months[$m-1];
            // Mercedonio di 23 giorni
            if ($year % 4 == 0 && $year != 24 && $m == 13) $ml++;
            $i += $ml;
            if ($i >= $yr){
                $i -= $ml;
                $month = $m;
                break;
            }
        }
        $mr = $yr - $i;
        
        $day = $mr;
        
        return array($year, $month, $day);
    }
    
    /**
     * Format number to Roman representation
     * 
     * @param int $number
     * @return string
     */
    private function numberToRomanRepresentation(int $number) {
        $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
        $returnValue = '';
        while ($number > 0) {
            foreach ($map as $roman => $int) {
                if($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }
    
    /**
     * Roman format date based on the fixed days
     * (Kalendae, Nonae and Idus)
     * 
     * @param int $y
     * @param int $m
     * @param int $d
     * @return string
     */
    private function romanDate(int $y, int $m, int $d){
        $ml = $this->days_in_months[$m-1];
        
        $nonae = ($ml == 31) ? 7 : 5;
        $idus = ($ml == 31) ? 15 : 13;
        
        $ad = 'a.d.';
        $prid = 'prid.';
        $kal = 'Kal.';
        $non = 'Non.';
        $id = 'Id.';

        $pref = NULL; $n = NULL; $day = NULL;
        $diff = 0;
         
        if ($d == 1){
            $day = $kal;
        }
        else {
            $refs = array(1, $nonae, $idus, $ml+1);
            $names = array_combine($refs, [$kal,$non,$id,$kal]);
            for($i=1;$i<count($refs);$i++){
                if ($d > $refs[$i-1] && $d <= $refs[$i]){
                    $diff = $refs[$i] - $d; 
                    $day = $names[$refs[$i]];
                    if ($i==3) $m++;
                    break;
                }
            }

            if ($diff > 0) {
                $pref = ($diff > 1) ? $ad : $prid;
                if ($diff > 1) $n = $diff + 1;
            } 
        }
        
        if ($n) $n = $this->numberToRomanRepresentation($n);
        $year = $this->numberToRomanRepresentation($y);
        $month = $this->getMonthName($m);
        
        /* 
         * NB: the "A.U.C" suffix implicitly assumes the calendar
         * offset to coincide with the date of the fundation of Rome.
         */
        
        return implode(' ', [$pref, $n, $day, $month, $year, 'A.U.C.']);
    }

}
