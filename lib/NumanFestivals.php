<?php

/**
 *
 */
class NumanFestivals extends NumanCalendar 
{
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
            23 => ['Quinquatria'],
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
        13 => array(),
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
        
        $ml = $this->days_in_months[$m-1];
        if ($m == 13) $ml++;
        
        if ($d < 1 || $d > $ml)
            throw new InvalidArgumentException("Invalid day number $d given!");
        
        if (isset($this->festivals[$m][$d]))
            return $this->festivals[$m][$d];
        
        return FALSE;
    }

    /**
     * Returns info about day
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
        
        $ml = $this->days_in_months[$m-1];
        if ($m == 13) $ml++;
        
        if ($d < 1 || $d > $ml)
            throw new InvalidArgumentException("Invalid day number $d given!");
        
        $fixed = $this->isFixedDay($d, $m);
        $festival = $this->isFestival($d, $m);
        $romanDate = $this->romanDate($y, $m, $d);
        
        return array(
            'fixed' => $fixed,
            'festival' => $festival,
            'date' => $romanDate,
        );
    }
}
