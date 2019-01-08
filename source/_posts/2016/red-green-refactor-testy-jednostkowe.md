---
comments: true
date: 2016-04-16 21:53:29+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2016/red_green_refactor-300x176.png
slug: red-green-refactor-testy-jednostkowe
title: Red Green Refactor - testy jednostkowe
wordpress_id: 1284
categories:
- TDD
tags:
- dajsiepoznac
- dajsiepoznac2016
- phpunit
- red green refactor
- tdd
- tdd w php
- testy jednostkowe
- unittest
---

Praktyczny przykład pisania testów jednostkowych z wykorzystaniem metody "Red Green Refactor".<!-- more -->

O samych testach jednostkowych (oraz TDD) pisałem już wcześniej: [TDD w PHP: Wprowadzenie](https://itcraftsman.pl/tdd-w-php-wprowadzenie-do-test-driven-development/) i [TDD w PHP: testy jednostkowe z PHPUnit - krok po kroku](https://itcraftsman.pl/tdd-w-php-testy-jednostkowe-z-phpunit-krok-po-kroku/)). Dzisiaj krótki przykład praktycznego zastosowania testów jednostkowych oraz metody "Red Green Refactor". Krótki opis na czym ona polega:
 	
  1. **Red** - piszemy testy, które nie przechodzą
  2. **Green** - piszemy minimalny kod, który przechodzi testy
  3. **Refactor** - ulepszamy jakość i czytelność kodu

Bez zbędnego rozpisywania się przejdźmy od razu do kodziku:

## Red

Dzisiaj moim celem było stworzenie nowej klasy do wyliczania Odległości Minkowskiego ([wiki](https://pl.wikipedia.org/wiki/Odleg%C5%82o%C5%9B%C4%87_Minkowskiego)). Zaczynamy od stworzenia nowego testu i metody _setUp_, która uruchamiana jest przed każdym testem (będzie odpowiedzialna za utworzenie testowanej klasy). 
    
    use Phpml\Metric\Distance\Minkowski;
    
    class MinkowskiTest extends \PHPUnit_Framework_TestCase
    {
        /**
         * @var Minkowski
         */
        private $distanceMetric;
    
        public function setUp()
        {
            $this->distanceMetric = new Minkowski();
        }
    
    }

Dodajmy prostą metodę, która przetestuje wyliczoną odległość dla dwuwymiarowych współrzędnych:

    public function testCalculateDistanceForTwoDimensions()
    {
        $a = [4, 6];
        $b = [2, 5];

        $expectedDistance = 2.080;
        $actualDistance = $this->distanceMetric->distance($a, $b);

        $this->assertEquals($expectedDistance, $actualDistance, '', $delta = 0.001);
    }

Trzeba również zadbać o sprawdzenie podanych argumentów. Dodajmy kolejny test, który sprawdzi, czy wyrzucany jest odpowiedni wyjątek (za pomocą adnotacji **_@expectedException_**):
 
    /**
     * @expectedException \Phpml\Exception\InvalidArgumentException
     */
    public function testThrowExceptionOnInvalidArguments()
    {
        $a = [0, 1, 2];
        $b = [0, 2];

        $this->distanceMetric->distance($a, $b);
    }


W oryginalnym teście dodaję jeszcze kilka metod dla większej ilości wymiarów oraz inne wartości parametru _lambda_, ale dla uproszczenia zostawmy przedstawione powyżej testy. Uruchamiamy PHPUnit:
    
    There were 2 errors:
    
    1) tests\Phpml\Metric\MinkowskiTest::testThrowExceptionOnInvalidArguments
    Error: Class 'Phpml\Metric\Distance\Minkowski' not found
    
    /var/www/php-ml/tests/Phpml/Metric/Distance/MinkowskiTest.php:18
    
    2) tests\Phpml\Metric\MinkowskiTest::testCalculateDistanceForTwoDimensions
    Error: Class 'Phpml\Metric\Distance\Minkowski' not found
    
    /var/www/php-ml/tests/Phpml/Metric/Distance/MinkowskiTest.php:18
    
    FAILURES!
    Tests: 36, Assertions: 64, Errors: 2.  

Czyli mamy "**czerwono**", czas przejść do implementacji.

## Green

Zaczynamy od stworzenia nowej klasy _Minkowski_:
 
    <?php
    
    declare (strict_types = 1);
    
    namespace Phpml\Metric\Distance;
    
    use Phpml\Metric\Distance;
    
    class Minkowski
    {
    
    }

Sprawdźmy stan testów:

    There was 1 error:
    
    1) tests\Phpml\Metric\MinkowskiTest::testCalculateDistanceForTwoDimensions
    Error: Call to undefined method Phpml\Metric\Distance\Minkowski::distance()
    
    /var/www/php-ml/tests/Phpml/Metric/Distance/MinkowskiTest.php:39
    
    --
    
    There was 1 failure:
    
    1) tests\Phpml\Metric\MinkowskiTest::testThrowExceptionOnInvalidArguments
    Failed asserting that exception of type "Error" matches expected exception "\Phpml\Exception\InvalidArgumentException". Message was: "Call to undefined method Phpml\Metric\Distance\Minkowski::distance()" at
    /var/www/php-ml/tests/Phpml/Metric/Distance/MinkowskiTest.php:29
    .
    
    FAILURES!
    Tests: 36, Assertions: 65, Errors: 1, Failures: 1.

Sama klasa nie wystarczy do zaspokojenia testów. Przejdźmy teraz do samej implementacji metody _distance, _która zwróci wyliczoną odległość:

    public function distance(array $a, array $b): float
    {

        $distance = 0;
        $count = count($a);
        $lambda = 3;

        for ($i = 0; $i < $count; ++$i) {
            $distance += pow(abs($a[$i] - $b[$i]), $lambda);
        }

        return pow($distance, 1 / $lambda);
    }

I w takim przypadku, PHPUnit wykrzyczy:
    
    There was 1 error:
    
    1) tests\Phpml\Metric\MinkowskiTest::testThrowExceptionOnInvalidArguments
    Undefined offset: 2
    
    /var/www/php-ml/src/Phpml/Metric/Distance/Minkowski.php:40
    /var/www/php-ml/tests/Phpml/Metric/Distance/MinkowskiTest.php:29
    
    FAILURES!
    Tests: 36, Assertions: 65, Errors: 1.
    
Niestety dalej "**czerwono**". Musimy dodać sprawdzenie argumentów i wyrzucić odpowiedni wyjątek, który został zadeklarowany w teście:
    
    if (count($a) !== count($b)) {
        throw InvalidArgumentException::sizeNotMatch();
    }

Ok, jak teraz wygląda sytuacja
    
    Time: 93 ms, Memory: 4.00Mb
    
    OK (36 tests, 66 assertions)
    
Wszystko działa jak należy. Możemy przejść do ostatniego kroku.

## Refactor

W ostatnim kroku będziemy "refaktoryzować" napisany kod. Pod tym pojęciem kryje się definicja na kolejny wpis (lub nawet całą serię), dlatego na ten moment możemy krótko powiedzieć, że refaktoryzacja kodu to polepszenie jego "czytelności" i "jakości", która nie spowoduje zmian w logice jego działania (np. wyodrębnienie parametrów czy metod, zmiana nazw zmiennych itp.). W przypadku naszej klasy, moglibyśmy dodać konstruktor aby odpowiednio przekazać parametr _lambda_ zamiast zostawiać go zakodowanym w środku metody _distance_:
 
    /**
     * @var float
     */
    private $lambda;

    /**
     * @param float $lambda
     */
    public function __construct(float $lambda = 3)
    {
        $this->lambda = $lambda;
    }

Aktualizujemy metodę _distance_ i odpalamy ponownie testy:
    
    Time: 84 ms, Memory: 4.00Mb
    
    OK (36 tests, 66 assertions)
    
Testy przechodzą, czyli nasze zmiany nie spowodowały "uszkodzenia" kodu. Trzeba sobie teraz zadać trudne pytanie: czy to już koniec ulepszania ? Odpowiedź z reguły dyktowana jest przez biznes, a krócej: przez deadline :). Dla naszego przypadku będzie to na razie wszystko.

W ten prosty sposób możemy przejść sprawnie przez trzy etapy: Red -> Green -> Refactor. Ostatni z nich nie będzie występował za każdym razem (lub może wystąpić w późniejszym terminie). Macie pytania ? Piszcie w komentarzach.
