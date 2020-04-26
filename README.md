# PHP Numan Calendar
This class provides methods for calculate the date following the traditional Roman Calendar attributed to Numa Pompilius.
This work is based on [Leonardo Magini's](http://www.leonardomagini.it/PDF/34%20-%20I%20Fondamenti%20astronomici.pdf) reconstructive hypothesis.

## Description
The Numan is a lunar calendar based on a main cicle of 24 lunar years. The year starts on March the 1st. 
Each year is composed by 12 months, and biyearly a leap month (named *Mercedonius* or *Mercedinus*) is added:

| Month | Length in days  | 
| ---------- | ----:|
| Martius | 31 |
| Aprilis | 29 |
| Maius | 31 |
| Iunius | 29 | 
| Quintilis | 31 |
| Sextilis | 29 | 
| September | 29 |
| October | 31 |
| November | 29 |
| December | 29 | 
| Ianuarius | 29 |
| Februarius | 28 |
| Mercedonius | 22 or 23 |

The fixed days are:
* **Kalendae**: the first day of each month (*new moon*)
* **Nonae**: the 7th day for long months, the 5th for the short ones (*waxing quarter moon*)
* **Idus**: the 15th day for long months, the 13th for the short ones (*full moon*)

The length in days of the 13th month depends on the position of the year in the cicle and subcicle.
The calendar is supposed to start the *1 March of 753 BC* (the year of Rome founding).

| Subcicle | Year  | Days in Year | Leap days | Total days |
| :----: | ----:| -----:|----:| -----:|
|1|1|355||355|
|1|2|377|22|732|
|1|3|355||1087|
|1|4|378|23|1465|
|1|5|355||1820|
|1|6|377|22|2197|
|1|7|355||2552|
|1|8|378|23|2930|
|2|9|355||3285|
|2|10|377|22|3662|
|2|11|355||4017|
|2|12|378|23|4395|
|2|13|355||4750|
|2|14|377|22|5127|
|2|15|355||5482|
|2|16|378|23|5860|
|3|17|355||6215|
|3|18|355||6570|
|3|19|377|22|6947|
|3|20|355||7302|
|3|21|355||7657|
|3|22|377|22|8034|
|3|23|355||8389|
|3|24|377|22|8766|


## Usage

```php
$NC = new NumanCalendar;

// set the Julian Day (must be bigger than 1446450)
$NC->setJD($jd);

// Get the year of Numan Calendar
$y = $NC->getYear();

// Get the cicle
$c = $NC->getCicle();

// Get the subcicle
$sc = $NC->getSubcicle();

/* 
 * Check if the current day is a fixed one
 * (Kalendae, Nonae or Idus)
 */
$fixed = $NC->isFixedDay();

// Get the Numan date in D/M/Y format
$date = $NC->getDMY();

/*
 * Get the Numan date in Roman traditional format.
 * For example, Kal. Martius IX A.U.C.
 */
$rdate = $NC->getRomanDate();
```

The *NumanFestivals* class gives informations about traditional Roman festivals and holidays.
It can be used as following:

```php
$NF = new NumanFestivals;

$today = date('d/m/Y');
list($d, $m, $y) = explode('/', $today);
$NF->setGregorianDate((int)$y, (int)$m, (int)$d);

// Array ( [0] => Veneralia ) 
$festival = $NF->isFestival();

// Array ( [fixed] => Kalendae [festival] => Array ( [0] => Veneralia ) [date] => Kal. Aprilis MMDCCLXXIII A.U.C. ) 
$di = $NF->getDayInfo();
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License
[MIT](https://choosealicense.com/licenses/mit/)