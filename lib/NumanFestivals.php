<?php

/**
 *
 */
class NumanFestivals extends NumanCalendar 
{
    /**
     * Fasti
     */
    const FASTUS = 'F';
    
    const FASTVS_PVBLICVS = 'FP';
    
    const COMITIALIS = 'C';
    
    const NEFASTVS = 'N';
    
    const NEFASTVS_PVBLICVS = 'NP';
    
    const ENDOTERCISVS = 'EN';
    
    const QVANDO_REX_COMITIAVIT_FAS = 'QRCF';
    
    const QVANDO_STERCVM_DELATVM_FAS = 'QSDF'; 
    
    /*
     * Festivals
     */
    protected $festivals = array(
        //March
        1 => array(
            1 => ['Feriae Marti'],
            7 => ['Matronalia'],
            14 => ['Equirria','Mamuralia'],
            15 => ['Anna perenna','Bacchanalia'],
            16 => ['Bacchanalia'],
            17 => ['Liberalia','Agonalia (Mars)'],
            19 => ['Quinquatria'],
            20 => ['Quinquatria'],
            21 => ['Quinquatria'],
            22 => ['Quinquatria'],
            23 => ['Quinquatria','Tubilustrium'],
            24 => ['Tubilustrium'],
            30 => ['Salus'],
            31 => ['Luna'],
        ),
        //April
        2 => array(
            1 => ['Veneralia'],
            12 => ['Cerealia'],
            13 => ['Cerealia'],
            14 => ['Cerealia'],
            15 => ['Cerealia','Fordicidia'],
            16 => ['Cerealia'],
            17 => ['Cerealia'],
            18 => ['Cerealia'],
            19 => ['Cerealia'],
            21 => ['Parilia','Dies Natalis'],
            23 => ['Vinalia Priora'],
            25 => ['Robigalia'],
            28 => ['Floralia'],
            29 => ['Floralia'],            
        ),
        //May
        3 => array(
            1 => ['Floralia'],
            9 => ['Lemuria'],
            11 => ['Lemuria'],
            13 => ['Lemuria'],
            15 => ['Mercuralia','Juppiter Victor'],
            16 => ['Argeorum'],
            21 => ['Agonalia (Vediovis)'],
            23 => ['Tubilustrium'],
            29 => ['Honoralia'],
            30 => ['Ambarvalia'],
        ),
        //June
        4 => array(
            3 => ['Bellona'],
            7 => ['Vestalia'],
            8 => ['Vestalia'],
            9 => ['Vestalia'],
            10 => ['Vestalia'],
            11 => ['Vestalia','Matralia'],
            12 => ['Vestalia'],
            13 => ['Vestalia'],
            14 => ['Vestalia'],
            15 => ['Vestalia','Iuppiter Invictor'],
            20 => ['Summānus'],
            24 => ['Fors Fortuna'],
        ),
        //Quintilis
        5 => array(
            5 => ['Poplifugia'],
            6 => ['Ludi Apollinares'],
            7 => ['Nonae Caprotinae','Ludi Apollinares'],
            8 => ['Ludi Apollinares'],
            9 => ['Caprotinia','Ludi Apollinares'],
            10 => ['Ludi Apollinares'],
            11 => ['Ludi Apollinares'],
            12 => ['Ludi Apollinares'],
            13 => ['Ludi Apollinares'],
            19 => ['Lucaria'],
            20 => ['Lucaria'],
            21 => ['Lucaria'],
            23 => ['Neptunalia'],
            25 => ['Furrinalia'],
        ),
        //Sextilis
        6 => array(
            1 => ['Spes'],
            13 => ['Vertumnalia','Nemoralia'],
            17 => ['Portunalia','Tiberinalia'],
            19 => ['Vinalia rustica'],
            21 => ['Consualia'],
            23 => ['Volcanalia'],
            25 => ['Opalia'],
            27 => ['Volturnalia'],
        ),
        //September
        7 => array(
            4 => ['Ludi Magni'],
            5 => ['Ludi Magni'],
            6 => ['Ludi Magni'],
            7 => ['Ludi Magni'],
            8 => ['Ludi Magni'],
            9 => ['Ludi Magni'],
            10 => ['Ludi Magni'],
            11 => ['Ludi Magni'],
            12 => ['Ludi Magni'],
            13 => ['Ludi Magni','Epulum Iovis'],
            14 => ['Ludi Magni','Equorum Probatio'],
            15 => ['Ludi Magni'],
            16 => ['Ludi Magni'],
            17 => ['Ludi Magni'],
            18 => ['Ludi Magni'],
            19 => ['Ludi Magni'],
        ),
        //October
        8 => array(
            1 => ['Tigillum Sororium'],
            4 => ['Ieiunium Cereris'],
            5 => ['Mundus Cereris'],
            11 => ['Meditrinalia'],
            13 => ['Fontinalia'],
            15 => ['October Equus'],
            19 => ['Armilustrium'],
        ),
        //November
        9 => array(
            8 => ['Mundus Cereris'],
            13 => ['Epulum Iovis'],
            15 => ['Feronia'],
            24 => ['Brumalia']
        ),
        //December
        10 => array(
            4 => ['Bona Dea'],
            5 => ['Faunalia'],
            11 => ['Agonalia (Sol Indiges)'],
            15 => ['Consualia'],
            17 => ['Saturnalia'],
            18 => ['Eponalia'],
            19 => ['Opalia'],
            21 => ['Divalia'],
            23 => ['Larentalia'],
            24 => ['Saturnalia'],
            31 => ['Saturnalia'],
        ),
        //January
        11 => array(
            3 => ['Compitalia'],
            5 => ['Compitalia','Vica Pota'],
            9 => ['Agonalia (Janus)'],
            11 => ['Carmentalia','Septimontium'],
            15 => ['Carmentalia'],
            24 => ['Sementivae'],
            25 => ['Sementivae'],
            26 => ['Sementivae'],
        ),
        //February
        12 => array(
            7 => ['Fornacalia'],
            8 => ['Fornacalia'],
            9 => ['Fornacalia'],
            10 => ['Fornacalia'],
            11 => ['Fornacalia'],
            12 => ['Fornacalia'],
            13 => ['Fornacalia','Parentalia','Lupercalia'],
            14 => ['Fornacalia','Parentalia','Lupercalia'],
            15 => ['Fornacalia','Parentalia','Lupercalia'],
            16 => ['Fornacalia','Parentalia'],
            17 => ['Fornacalia','Parentalia','Quirinalia'],
            18 => ['Parentalia'],
            19 => ['Parentalia'],
            20 => ['Parentalia'],
            21 => ['Parentalia','Feralia'],
            22 => ['Caristia'],
            23 => ['Terminalia'],
            24 => ['Regifugium'],
            27 => ['Equirria'],
        ),
        //Mercedinus
        13 => array(
            23 => ['Regifugium'],
            26 => ['Equirria'],
        ),
    );

    /**
     * Exceptions to the general schema of fasti
     * @var array 
     */
    protected $fasti = array(
        //March
        1 => array(
            1 => self::NEFASTVS_PVBLICVS,
            14 => self::ENDOTERCISVS,
            22 => self::NEFASTVS,
            24 => self::FASTUS,
        ),
        //April
        2 => array(
            5 => self::NEFASTVS,
            6 => self::NEFASTVS,
            12 => self::NEFASTVS,
            14 => self::NEFASTVS,
            15 => self::NEFASTVS,
            16 => self::NEFASTVS,
            17 => self::NEFASTVS,
            18 => self::NEFASTVS,
            23 => self::FASTUS,
            
        ),
        //May
        3 => array(
            7 => self::NEFASTVS,
            9 => self::NEFASTVS,
            11 => self::NEFASTVS,
            13 => self::NEFASTVS,
            16 => self::FASTUS,
            22 => self::NEFASTVS,
            24 => self::FASTUS,
            29 => self::COMITIALIS,
            30 => self::COMITIALIS,
        ),
        //June
        4 => array(
            1 => self::NEFASTVS,
            5 => self::NEFASTVS,
            6 => self::NEFASTVS,
            7 => self::NEFASTVS,
            8 => self::NEFASTVS,
            9 => self::NEFASTVS,
            10 => self::NEFASTVS,
            12 => self::NEFASTVS,
            14 => self::NEFASTVS,
            15 => self::FASTUS,
            20 => self::COMITIALIS,
            24 => self::COMITIALIS,
        ),
        //Quintilis
        5 => array(
            1 => self::NEFASTVS,
            2 => self::NEFASTVS,
            6 => self::NEFASTVS,
            7 => self::NEFASTVS,
            8 => self::NEFASTVS,
            9 => self::NEFASTVS,
            10 => self::COMITIALIS,
            11 => self::COMITIALIS,
            12 => self::COMITIALIS,
            13 => self::COMITIALIS,
            20 => self::COMITIALIS,
            24 => self::NEFASTVS,
        ),
        //Sextilis
        6 => array(
            19 => self::FASTVS_PVBLICVS,
            22 => self::ENDOTERCISVS,
        ),
        //September
        7 => array(
            4 => self::COMITIALIS,
            6 => self::FASTUS,
            7 => self::COMITIALIS,
            8 => self::COMITIALIS,
            9 => self::COMITIALIS,
            10 => self::COMITIALIS,
            11 => self::COMITIALIS,
            12 => self::NEFASTVS,
            14 => self::FASTUS,
            15 => self::NEFASTVS,
            16 => self::COMITIALIS,
            17 => self::COMITIALIS,
            18 => self::COMITIALIS,
            19 => self::COMITIALIS,
        ),
        //October
        8 => array(
            1 => self::NEFASTVS,
            4 => self::COMITIALIS,
            5 => self::COMITIALIS,
            14 => self::ENDOTERCISVS,
            16 => self::ENDOTERCISVS,
        ),
        //November
        9 => array(
            8 => self::COMITIALIS,
            15 => self::COMITIALIS,
            24 => self::COMITIALIS,
        ),
        //December
        10 => array(
            1 => self::NEFASTVS,
            2 => self::NEFASTVS,
            4 => self::COMITIALIS,
            12 => self::ENDOTERCISVS,
            15 => self::ENDOTERCISVS,
            17 => self::ENDOTERCISVS,
            18 => self::COMITIALIS,
            19 => self::NEFASTVS,
            22 => self::COMITIALIS,
            24 => self::COMITIALIS,
        ),
        //January
        11 => array(
            3 => self::COMITIALIS,
            14 => self::ENDOTERCISVS,
            24 => self::COMITIALIS,
            25 => self::COMITIALIS,
            26 => self::COMITIALIS,
        ),
        //February
        12 => array(
            1 => self::NEFASTVS,
            2 => self::NEFASTVS,
            5 => self::NEFASTVS,
            6 => self::NEFASTVS,
            7 => self::NEFASTVS,
            8 => self::NEFASTVS,
            9 => self::NEFASTVS,
            10 => self::NEFASTVS,
            11 => self::NEFASTVS,
            12 => self::NEFASTVS,
            14 => self::NEFASTVS,
            16 => self::ENDOTERCISVS,
            18 => self::COMITIALIS,
            19 => self::COMITIALIS,
            20 => self::COMITIALIS,
            21 => self::FASTUS,
            22 => self::COMITIALIS,
            // Regifugium
            24 => self::NEFASTVS,
            26 => self::ENDOTERCISVS,
        ),
        //Mercedinus
        13 => array(
            // Regifugium
            23 => self::NEFASTVS,
            25 => self::ENDOTERCISVS,
        ),
    );
    
    /**
     * Returns if given day is festival
     * 
     * @param int $d day number
     * @param int $m month number
     * @return string[]|boolean
     * @throws InvalidArgumentException
     */
    public function isFestival(int $d = NULL, int $m = NULL){
        if ($d === NULL) $d = $this->day;
        if ($m === NULL) $m = $this->month;
        
        if ($m < 1 || $m > 13)
            throw new InvalidArgumentException("Invalid month number $m given!");
        
        $ml = $this->monthLength($m, $this->year_in_cicle);
        
        if ($d < 1 || $d > $ml)
            throw new InvalidArgumentException("Invalid day number $d given!");
        
        if ($this->yearLengthInDays() == 378)
            // 24 Feb of leap years is not Regifugium
            unset($this->festivals[12][24]);
        
        if (isset($this->festivals[$m][$d]))
            return $this->festivals[$m][$d];
        
        return FALSE;
    }

    /**
     * Returns info about current day
     * @param int $y year number
     * @param int $m month number
     * @param int $d day number
     * @return mixed[]
     */
    public function getDayInfo(int $y = NULL, int $m = NULL, int $d = NULL){
        if ($y === NULL) $y = $this->year;
        if ($d === NULL) $d = $this->day;
        if ($m === NULL) $m = $this->month;
        
        if ($m < 1 || $m > 13)
            throw new InvalidArgumentException("Invalid month number $m given!");
        
        $ml = $this->monthLength($m, $this->yearInCicle($y));
               
        if ($d < 1 || $d > $ml)
            throw new InvalidArgumentException("Invalid day number $d given!");
        
        $this->setYMD($y, $m, $d);
        
        $fixed = $this->isFixedDay();
        $festival = $this->isFestival();
        $month = $this->getMonthName();
        $nundinal = $this->getNundinal();
        $fastus = $this->getFastus();
        $date = $this->getDMY();
        $romanDate = $this->getRomanDate();
        
        return array(
            'fixed' => $fixed,
            'festival' => $festival,
            'month' => $month,
            'nundinal' => $nundinal,
            'fastus' => $fastus,
            'date' => $date,
            'romanDate' => $romanDate,
        );
    }

    /**
     * Is a day fastus? This method implements a simple schema:
     * - Festivals are genarally NP
     * - Days following fixed days are fasti
     * - Ordinary days are comitalis except for nefasti blocks
     * 
     * @param int $y year number
     * @param int $m month number
     * @param int $d day number
     * @return string kind of fasti
     * @throws InvalidArgumentException
     */
    public function getFastus(int $y = NULL, int $m = NULL, int $d = NULL){
        if ($y === NULL) $y = $this->year;
        if ($d === NULL) $d = $this->day;
        if ($m === NULL) $m = $this->month;
        
        if ($m < 1 || $m > 13)
            throw new InvalidArgumentException("Invalid month number $m given!");
        
        $ml = $this->monthLength($m, $this->yearInCicle($y));
               
        if ($d < 1 || $d > $ml)
            throw new InvalidArgumentException("Invalid day number $d given!");
        
        if ($this->yearLengthInDays() == 378)
            // 24 Feb of leap years is not Regifugium
            unset($this->fasti[12][24]);
        
        if (isset($this->fasti[$m][$d]))
            return $this->fasti[$m][$d];
        
        $this->setYMD($y, $m, $d);
        
        $fixed = $this->isFixedDay();
        $festival = $this->isFestival();
        
        $ml = $this->monthLength($m, $this->yearInCicle($y));
        
        // Is previous day fixed ?
        $previous_fixed = $d >1 ? $this->isFixedDay($d-1, $m) : FALSE;
        
        // Fixed days
        if ($fixed) {
            // Nonae are F
            if ($fixed == 'Kalendae' || $fixed == 'Nonae')
                return $this::FASTUS;
            // Idus are NP
            else
                return $this::NEFASTVS_PVBLICVS;
        }
        // Festivals are genarally NP
        if ($festival)
            return $this::NEFASTVS_PVBLICVS;
        /*********** Ordinary days **************/
        // Following fixed days ...
        if ($previous_fixed) {
            // Days following fixed days are fasti
            return $this::FASTUS;
        }
        // Days between 5 and 22 Apr are N
        if($m == 2 && $d >=5 && $d <= 22)
            return $this::NEFASTVS;
        // Days between 1 and 9 Jul are N
        elseif($m == 5 && $d <= 9)
            return $this::NEFASTVS;
        // 12 and 15 Sep are N (but, why?)
        elseif($m == 7 && ($d == 12 || $d == 15))
            return $this::NEFASTVS;
        // Days between 1 and 3 Dec are N
        elseif($m == 10 && $d <= 3)
            return $this::NEFASTVS;
        // Days between 1 and 14 Feb are N
        elseif($m == 12 && $d <= 14)
            return $this::NEFASTVS;
        // Other days are comitalis
        return $this::COMITIALIS;
    }
}
