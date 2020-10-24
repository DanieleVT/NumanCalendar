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
     * Calendar offset
     * 
     * Offset del calendario
     */
    const JD0 = 1462158;
    
    /*
     * Roman date offset: is assumed to be the JD
     * of the beginning of the year of 
     * founding of Rome (April 21 753 BC), then
     * March, 1st, 753 BC
     * 
     * Offset fondazione di Roma: 1 Marzo 753 AC
     */
    const JDUC = 1446450;
    
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
    protected $days_in_months = array(31,29,31,29,31,29,29,31,29,29,29,28,27);
 
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
    
    /**
     * Nundinal letter
     * @var string
     */
    protected $nundinal;

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
    
    public function getNundinal() {
        return $this->nundinal;
    }

    /**
     * Return year from founding 
     * of Rome (April 21 753 BC)
     * 
     * @param int $year
     * @return int
     */
    public function getAUCYear(int $year = NULL) {
        if ($year === NULL) $year = $this->year;
        
        // Add A.U.C offset
        $y_offset = explode('/',jdtojulian(self::JD0))[2] - explode('/',jdtojulian(self::JDUC))[2];
        $year += $y_offset;
        
        return $year;
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
        $i = $i % $this->yearLengthInMonths();
        
        return $this->months[$i];
    }

    /**
     * Return info about year
     * @param int $year
     * @return mixed[]
     */    
    public function getYearInfo(int $year=NULL){
        $yearInCicle = ($year===NULL) 
            ? $this->year_in_cicle 
            : $this->yearInCicle($year);
        
        return array(
            'yearInCicle' => $yearInCicle, 
            'leap' => $this->isLeapYear($yearInCicle),
            'length' => $this->yearLengthInDays($yearInCicle)
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
        return sprintf("%02d/%02d/%04d", $d, $m, $y);
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
        $nun = $this->nundinal;
        return $this->romanDate($y,$m,$d,$nun);
    }
    
    /******************************/
    
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
        
        return $this;
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
        
        return $this;
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
        
        return $this;
    }
    
    /**
     * set th given numan year, month and day
     * 
     * @param int $year    numan year
     * @param int $month   numan month
     * @param int $day     day number
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setYMD(int $year, int $month, int $day){
        
        if ($year < 1)
            throw new InvalidArgumentException(sprintf("Invalid year %s provided", $year));
        elseif($month < 1 || $month > count($this->months))
            throw new InvalidArgumentException(sprintf("Invalid month %s provided", $month));
        elseif($day < 1 || $day > 31)
            throw new InvalidArgumentException(sprintf("Invalid day %s provided", $day));
        
        $this->YMDToNuman($year, $month, $day);
        
        return $this;
    }
    
    /******************************/
    
    /**
     * Return fixed, if day is fixed, false otherwise
     * 
     * @param int $d day
     * @param int $m month
     * @return string|boolean
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
        $jd = $this->JD - self::JD0;

        $cicle = (int)($jd / 8766);
        $days_in_cicle = $jd % 8766;
        $subcicle = (int)($days_in_cicle / 2930);

        $cicle+=1; $days_in_cicle+=1; $subcicle+=1;
        
        $this->cicle = $cicle;
        $this->subcicle = $subcicle;

        list($year, $month, $day, $nundinal) = $this->numanYMD($days_in_cicle);
        
        //Anno 
        $year += (($cicle-1)*24);
                
        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
        $this->nundinal = $nundinal;
        
        $this->year_in_cicle = $this->yearInCicle($year);     
    }
    
    /**
     * 
     * @param int $year
     * @param int $month
     * @param int $day
     */
    protected function YMDToNuman(int $year, int $month, int $day){
        
        $this->year_in_cicle = $this->yearInCicle($year);
        
        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
        
        $this->cicle = (int)(($year-1) / 24) + 1;
        $this->subcicle = (int)(($this->year_in_cicle-1) / 8) + 1;

        $this->JD = $this->numantojd($month, $day, $year);
        
        $this->nundinal = $this->nundinalFromYMD($year, $month, $day);
    }
    
    /**
     * Year Length in months
     * 
     * @param int $yearInCicle
     * @return int
     */
    protected function yearLengthInMonths(int $yearInCicle=NULL){
        if ($yearInCicle===NULL) $yearInCicle = $this->year_in_cicle;
        
        return ($this->isLeapYear($yearInCicle)) ? 13 : 12; 
    }
    
    /**
     * Year Length in days
     * 
     * @param int $yearInCicle
     * @return int
     */
    protected function yearLengthInDays(int $yearInCicle=NULL){
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
     * Return the month length
     * 
     * @param int $month
     * @param int $yearInCicle
     * @return int month length
     */
    protected function monthLength(int $month=NULL, int $yearInCicle=NULL){
        if ($month === NULL) $month = $this->month;
        if ($yearInCicle===NULL) $yearInCicle = $this->year_in_cicle;
                
        $i = $month -1;
        $i = $i % $this->yearLengthInMonths($yearInCicle);
        
        $length = $this->days_in_months[$i];
        
        // Leap year: for the intercalation we use the  Michels hypotesis:
        // Mercedonius length is fixed 27-day, and started either on the day 
        // after the Terminalia (23rd day of Februarius) for a 22 day intercalation, 
        // or on the following day, for a 23-day one
        // (A. K. Michels, The Calendar of the Roman Republic 160ff)
        if($month == 12 && $this->isLeapYear($yearInCicle)){
            $length-=(($yearInCicle % 4 == 0 && $yearInCicle != 24) ? 4 : 5);
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
                
        return FALSE;
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
     * year, month, day and nundinal letter 
     * of the current cycle.
     * 
     * Dato il numero di giorni trascorsi 
     * dall'inizio del ciclo, stima
     * anno, mese, giorno e lettera nundinale
     * del ciclo corrente.
     * 
     * @param int $daysInCicle
     * @return int[]
     */
    protected function numanYMD(int $daysInCicle){
        $daysInCicle = ($daysInCicle - 1) % 8766 + 1;

        $year = 1;
        $i = 0;
        for($y=1;$y<=24;$y++){
            $yl = $this->yearLengthInDays($y);
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
        for ($m=1;$m<=$this->yearLengthInMonths($year);$m++){
            $ml = $this->monthLength($m, $this->yearInCicle($year));
            $i += $ml;
            if ($i >= $yr){
                $i -= $ml;
                $month = $m;
                break;
            }
        }
        $mr = $yr - $i;
        
        $day = $mr;
        
        if ($month == 13){
            /* The nundinal cycle is reset to A on Kal. Merc.
             * to join with the Regifugium day (letter G)
             */
            $nundinal = chr(65 + (($mr+7) % 8));
        } else {
            $nundinal = chr(65 + (($yr-1) % 8));
        }
 
        return array($year, $month, $day, $nundinal);
    }
    
    /**
     * Evaluate nundinal letter from y, m and d
     * @param int $year
     * @param int $month
     * @param int $day
     * @return string
     */
    protected function nundinalFromYMD(int $year, int $month, int $day){
        $year = $this->yearInCicle($year);
        
        $d = 0;
        for ($m=1;$m<$month;$m++){
            $d+=$this->monthLength($m, $year);
        }
        
        $d+=$day;
        
        if ($month == 13){
            /* The nundinal cycle is reset to A on Kal. Merc.
             * to join with the Regifugium day (letter G)
             */
            $nundinal = chr(65 + (($day+7) % 8));
        } else {
            $nundinal = chr(65 + (($d-1) % 8));
        }
        
        return $nundinal;
    }
    
    /**
    * Converts a Numan date to Julian Day Count
    * @param int $month The month as a number from 1 (for January) to 13 (for Intercalar)
    * @param int $day   The day as a number from 1 to 31
    * @param int $year  The year as a number between -4714 and 9999
    *
    * @return int The julian day for the given numan date as an integer.
    */
    protected function numantojd(int $month, int $day, int $year){
        
        // full cycles
        $d = 8766*(int)(($year-1)/24);

        // full years of current cicle
        $yr = (int)(($year-1) % 24);
        for ($y=1;$y<=$yr;$y++) {
            $d+=$this->yearLengthInDays($y);
        }
        
        // full months of current year
        for($m=1;$m<$month;$m++){
            $d+=$this->monthLength($m, $this->yearInCicle($year));
        }
        
        // days of current month
        $d+=$day;
        
        return $this::JD0 + $d -1;
    }
    
    /**
     * Format number to Roman representation
     * 
     * @param int $number
     * @return string
     */
    public static function numberToRomanRepresentation(int $number) {
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
     * @param string $nun  nundinal letter
     * @return string
     */
    protected function romanDate(int $y, int $m, int $d, string $nun = NULL){
        // Month length
        $ml = $this->monthLength($m, $this->yearInCicle($y));
        
        // Add A.U.C offset
        $y = $this->getAUCYear($y);
        
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
        
        if ($n) $n = $this::numberToRomanRepresentation($n);
        $year = $this::numberToRomanRepresentation($y);
        $month = $this->getMonthName($m);
        
        return implode(' ', [$nun, $pref, $n, $day, $month, $year, 'A.U.C.']);
    }

}
