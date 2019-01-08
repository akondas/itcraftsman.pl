---
comments: true
date: 2015-06-16 22:52:09+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2015/1430220587Screenshot-2015-04-28-13.29.15-1024x513.png
slug: php-7-nadchodza-nowosci
title: PHP 7 - nadchodzą nowości !
wordpress_id: 1029
categories:
- PHP
tags:
- hhvm
- performance
- php 5.6
- php 7
- scalar type hints
- spaceship operator
- uniform variable syntax
---

Wszystko wskazuje na to, że nową wersją PHP z numerem 7 powitamy już w tym roku (właśnie wyszła wersja ALPHA 1). W zawiązku z tym postanowiłem przyjrzeć się nowościom, przeprowadzić testy wydajności i podzielić się z Wami zdobytą wiedzą. Wpis jest dość obszerny więc zapraszam do czytania z kawą lub innym dowolnym napojem.<!-- more -->


## **Co się stało z PHP 6 ?**


Zapewne wiele z Was zadaje sobie pytanie: dlaczego PHP 7 a nie PHP 6 skoro obecna wersja to PHP 5 ?

Okazuje się, że wersja 6 została utworzona już w 2009 roku ([źródło](https://wiki.php.net/todo/php60)), a prace nad nią rozpoczęto dużo wcześniej (2005). Niestety po pewnym czasie prace nad nową wersją ustały. Podstawowym problemem okazało się być przepisanie silnika z uwzględnieniem UNICODE. Niestety twórcy nie doszli do porozumienia i ostatecznie projekt ugrzązł w miejscu na parę dobrych lat. Gdy aktywność nad projektem została wznowiona, nazwa nowej wersji została [poddana głosowaniu](https://wiki.php.net/rfc/php6). Argumentów za było więcej niż przeciw. W rezultacie (58 głosów za, 24 przeciw) wygrała wersja oznakowana jako **PHP 7**.

W międzyczasie powstała jeszcze wersja **PHNG** (next generation), która refaktoryzowała sam silnik Zend Engine.  Została ona oficjancie złączona z gałęzią master i na jej podstawie zbudowano PHP 7 ([źródło](https://wiki.php.net/phpng)).

To tyle tytułem wstępu, zobaczmy teraz, czego możemy oczekiwać po nowej wersji PHP. Dodatkowo, przy każdym punkcie, starałem się dodać link do RFC, gdzie możecie przeczytać więcej szczegółowo oraz zobaczyć przebieg głosowania (bardzo polecam, można dowiedzieć się wielu ciekawostek).




## **Wydajność - performance !**


Jedną z ważniejszych zmian jest ogromne przyspieszenie. Nowa wersja PHP jest ponad dwukrotnie szybsza od swojego poprzednika oraz zużywa znacząco mniej pamięci. Hostingowcy na pewno się ucieszą, bo ich maszyny udźwigną teraz znacznie większy ruch, bez żadnych dodatkowych kosztów.

Z racji, że wydajność to dość ciekawy temat, postanowiłem przeprowadzić kilka testów osobiście. Skompilowałem najnowszą dostępną wersją (7.0.0 ALPHA 1) i przeprowadziłem kilka eksperymentów. Dodatkowo, w testach uwzględniłem dedykowane rozwiązanie od Facebooka: HHVM - HipHop Virtual Machnie. Stanowi ona teraz główną i bezpośrednią konkurencję dla PHP 7.

Do testów wybrałem dwa wiodące frameworki o różnych (skrajnych) przeznaczeniach: Symfony 2.7 oraz Laravel 5.1 :D

[![PHP 7 framework performance test](/assets/img/posts/2015/screenshot-docs.google.com-2015-06-14-23-41-53.jpg)](/assets/img/posts/2015/screenshot-docs.google.com-2015-06-14-23-41-53.jpg)

Hello world - czyli jedna akcja, jeden kontroler i jeden widok. Odpalenie bez żadnych dodatkowych optymalizacji.

Kolejny test sprawdza operacje na bazie danych - jeden insert z użyciem standardowego narzędzia do obsługi bazy danych dostarczonego z testowanym frameworkiem. Dla Symfony jest to Doctrine (implementacja Object Relational Mapper), w przypadku Laravel mamy Eloqent (implementacja Active Record):

[![PHP 7 performance test](/assets/img/posts/2015/screenshot-docs.google.com-2015-06-16-22-21-19.jpg)](/assets/img/posts/2015/screenshot-docs.google.com-2015-06-16-22-21-19.jpg)



Na koniec postanowiłem przetestować jeszcze dwa proste benchmarki od Zenda: [bench.php ](https://github.com/php/php-src/blob/php-7.0.0alpha1/Zend/bench.php)oraz [micro_bench.php](https://github.com/php/php-src/blob/php-7.0.0alpha1/Zend/micro_bench.php) . Wynik może być zaskakujący, ale okazuje się, że HHVM posiada wbudowany kompilator JIT, który dobrze radzi sobie z powtarzalnymi fragmentami kodu (pętle).

[![PHP 7 HHVM 3.7 PHP 5.6](/assets/img/posts/2015/screenshot-docs.google.com-2015-06-15-23-14-55.jpg)](/assets/img/posts/2015/screenshot-docs.google.com-2015-06-15-23-14-55.jpg)

Pod [tym linkiem](https://docs.google.com/spreadsheets/d/1qW0avj2eRvPVxj_5V4BBNrOP1ULK7AaXTFsxcffFxT8/edit#gid=1334306309) znajdziecie więc testów wydajności PHP 7.




## **Scalar Type Hints & Return Types ([RFC](https://wiki.php.net/rfc/scalar_type_hints_v5))**


Dość kontrowersyjna i długo wyczekiwana zmiana czyli wskazywanie typów skalarnych oraz zwracanych wartości przez funkcję/metodę. W wersji 7 możemy wskazywać jakiego typu argumenty przyjmuje dana funkcja (string, int, float itp.) oraz jakiego typu jest zwracany wynik. Niespełnienie tych warunków spowoduję wystąpienie błędu (_Catchable fatal error_).

Dodatkowo możliwe będzie wykorzystania znacznika **_declare(strict_types=1);_** na początku pliku, który uruchomi bardziej restrykcyjny tryb sprawdzania argumentów i zwracanych typów. Włącznie opcji strict spowoduje błędy jeżeli będziemy próbowali przekazać int w miejsce float lub odwrotnie. Bez tej opcji możliwe jest przekazanie int(1) do funkcji która wymaga float(1). W takim przypadku nastąpi prosta konwersja typów (czasem stratna, np. float -> int).

```php
<?php
function add(int $a, int $b): int {
    return $a + $b;
}
add(1, '2');
```

Poniżej wersja z _strict mode_:

```php
<?php
declare(strict_types=1); // musi być w 1 linii
function add(int $a, int $b): int {
    return $a + $b;
}
add(1, '2');
// Catchable fatal error: Argument 2 passed to add() must be of the type integer, string given
```




## **Combined Comparison Operator ([RFC](https://wiki.php.net/rfc/combined-comparison-operator))**


Inna nazwa to spaceship operator (T_SPACESHIP). Nowy operator porównania, który wygląda następująco: **<=>**.

Jak on działa ? Bardzo prosto: zwraca 1 gdy lewa strona jest większa od prawej, 0 gdy są takie same, oraz -1 gdy prawa strona jest większa niż lewa.  Inny słowy, ten sam efekty uzyskamy wpisując: _($a < $b) ? -1 : (($a > $b) ? 1 : 0). _Nowy operator zadziała na wszystkich typach (_string, int, array_ itp).

Przykład zastosowania: funkcja sortująca (np. callback do _uasrot_)

```php
<?php
// przed php 7
uasort($array, function($a, $b){
    return ($a < $b) ? -1 : (($a > $b) ? 1 : 0);
});
// po php 7
uasort($array, function($a, $b){
    return $a <=> $b;
});
```


## **Uniform Variable Syntax ([RFC](https://wiki.php.net/rfc/uniform_variable_syntax))**


Ujednolicona została składnia zmiennych (oraz ich wywoływania). Od teraz będzie można wywoływać funkcję przypisane do atrybutów klasy (przykład poniżej), oraz łączyć kolejne wywołania zmiennych/metod statycznych:

```php
<?php
// call closures assigned to properties
($object->closureProperty)()
// chain static calls
class foo { static $bar = 'baz'; }
class baz { static $bat = 'Hello World'; }
baz::$bat = function () { echo "Hello World"; };
$foo = 'foo';
($foo::$bar::$bat)();
```

Uwaga, wprowadzona została jeszcze jedna zmiana, która może spowodować znaczne różnice w interpretacji. W wersji PHP 7 wywołanie _$a->$property['key']_ odwoła się do atrybutu klasy (zapisanym w zmiennej $property) z podanym kluczem. W wersji wcześniejszej, ten sam kod odwoływał się do atrybutu klasy, którego nazwa była dostępna pod kluczem '_key_' w tablicy _$property_. Najlepiej będzie zobrazować to przykładem:

```php
<?php
// co zwróci podane wyrażenie ?
$obj->$properties['name'];
// w PHP 5.6
$obj->{$properties['name']}
// w PHP 7
{$obj->$properties}['name']
```


## **Group Use Declarations ([RFC](https://wiki.php.net/rfc/group_use_declarations))**


Jeżeli ktoś korzysta z dobrego, **IDE** które automatycznie importuje klasy do pliku (_use_), to ten punkt nie będzie go raczej dotyczył. Dla wszystkich innych w PHP 7 istniała będzie nowa możliwość import klas: import grupowy. Pozwoli to na zachowanie lepszej czytelności, oraz ułatwi wpisywanie. Poniżej konkretny przykład nowej i starej składni _use_:

```php
<?php
// do PHP 5.6
use Framework\Component\ClassA;
use Framework\Component\ClassB as ClassC;
use Framework\Component\OtherComponent\ClassD;
// od PHP 7
use Framework\Component\{
     ClassA,
     ClassB as ClassC,
     OtherComponent\ClassD
};
// można używać też do funkcji i stałych
use Framework\Component\{
     ClassA,
     function OtherComponent\someFunction,
     const OtherComponent\SOME_CONSTANT
};
```


## **Null Coalesce Operator ([RFC](https://wiki.php.net/rfc/isset_ternary))**


Nowy operator: **??**. Użycie go spowoduje: zwrócenie wartości po jego lewej stronie, jeżeli jest inna niż **null**, natomiast w inny przypadku zwrócona zostanie wartość po prawej stronie operatora. Dodatkowo użycie tego operatora na nieistniejącej zmiennej (po lewej stronie) nie spowoduje powstania błędu (a raczej notice: non-existent variable) w przeciwieństwie do operatora **?:**.

Zanim przedstawię przykład warto jeszcze wspomnieć, że podany operator można wykorzystać w ciągu- kolejno po sobie.

```php
<?php
// proste zastosowanie
$username = $user->getName() ?? 'nobody';
// dobre do tablic bo nie trzeba sprawdzać isset
$width = $imageData['width'] ?? 100;
// bardziej złożony przykład
$config = $config ?? $this->config ?? static::$defaultConfig;
```

## **Zmiany niekompatybilne wstecz**


Niestety nie udało się uniknąć kilku zmian, które spowodują niekompatybilność kodu wstecz.  Główną zmianą opisaną wyżej jest Uniform Variable Syntax. Dodatkowo:

  *  usunięto obsługę tagów ASP (<%, <%=, <script language="php”>)
  * usunięto wszystkie funkcje oznaczone jako depracated (po więcej danych odsyłam do [RFC](https://wiki.php.net/rfc/remove_deprecated_functionality_in_php7))
  * usunięto składnie POSIX
  * usunięto rozszerzenie ext/mysql
  * usunięto możliwość definiowania więcej niż jednego warunku _default_ w _switch _

## **Engine Exceptions ([RFC](https://wiki.php.net/rfc/engine_exceptions_for_php7))**


Punkt ten nie do końca można uznać za skończony bo trwają jeszcze prace nad doprecyzowanie nowych typów wyjątków, ale już teraz można spodziewać się kilku zmian.

Genezą powstania **Engine Exceptions** jest bardzo utrudniona obsługa błędów typu fatal error oraz catchable fatal error.

Nowy rodzaj wyjątków będzie dziedziczyły po klasie \EngineException. W ten sposób wszystkie dotychczasowe bloki _try/catch_ będą mogły działać dalej bez problemów i nie będą wyłapywały nowych wyjątków.

Dodatkowo, jeżeli ktoś będzie chciał obsłużyć wszystkie wyjątki (nawet te nowe), może posłużyć się klasą \BaseException. Niestety tego nie wiemy jeszcze na 100% bo prace nadal trwają ([ostatnie zmiany](https://wiki.php.net/rfc/throwable-interface)).

Dodatkowe błędy w funkcji eval będą wyrzucały **\ParseException** oraz **\TypeException**. Poniżej zamieszczam przykład:

```php
<?php
try {
    nonExistentFunction();
} catch (\EngineException $e) {
     var_dump($e);
}
object(EngineException)#1 (7) {
  ["message":protected]=>
  string(32) "Call to undefined function nonExistantFunction()"
  ["string":"BaseException":private]=>
  string(0) ""
  ["code":protected]=>
  int(1)
  ["file":protected]=>
  string(17) "engine-exceptions.php"
  ["line":protected]=>
  int(1)
  ["trace":"BaseException":private]=>
  array(0) {
  }
  ["previous":"BaseException":private]=>
  NULL
}
```


## **The end ...**


Na zakończenie wpisu zachęcam do zabawy z nową wersją, samodzielnej kompilacji i eksperymentów ([przykład](http://www.zimuel.it/install-php-7/) od którego można zacząć). Można w ten sposób dowiedzieć się wiele ciekawych rzeczy o samym silniku PHP, jego możliwościach oraz sposobie działania.

Wpis był dość długi, więc jeżeli udało Wam się dobrnąć do końca to dziękuję za uwagę. Przypominam o komentarzach, które pozostają do waszej dyspozycji. Dajcie znać czy podobają Wam się nowości w PHP 7 oraz czy chcielibyście zapoznać jeszcze z parom innymi zmianami ?

Tymczasem niech kod będzie z Wami :)

*Grafik autorstwa [Vincent Pontier](https://twitter.com/Elroubio/status/583414360350949376)*
