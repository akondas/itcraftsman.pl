---
comments: true
date: 2015-02-27 10:12:49+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2015/testy-bazy-danych.jpg
slug: tdd-w-php-testowanie-bazy-danych
title: 'TDD w PHP: testowanie bazy danych'
wordpress_id: 966
categories:
- PHP
- TDD
tags:
- database
- php
- phpunit
- phpunit.xml
- tdd
- tdd w php
- testy jednostkowe
- unittest
---

W środowisku programistów panuje przekonanie, że testy jednostkowe nie powinny nigdy wysyłać zapytań do bazy danych. Jeżeli nie potrafisz przetestować kodu, bez pomocy bazy danych, to musisz go zmienić. Jak to jednak w życiu, nie zawsze jest tak kolorowo i czasem Twój test potrzebuje przetestować warstwę bazy danych. Jeżeli już musisz to zrobić, dowiedz się jak zrobić to dobrze.<!-- more -->

<div class="shadow-md p-4 bg-yellow-lighter">

<h4>Cykl wpisów "TDD w PHP"</h4>

Wpis ten publikowany jest w ramach cyklu "TDD w PHP", którego wpisy można czytać niezależnie, ale najlepsze efekty osiągniesz, jeśli zapoznasz się z nimi po kolei. Na ten moment cykl składa się z następujących wpisów:

<ol>
  <li><a href="http://itcraftsman.pl/tdd-w-php-wprowadzenie-do-test-driven-development">Wprowadzenie do test-driven development</a>)</li>	
  <li><a href="http://itcraftsman.pl/tdd-w-php-testy-jednostkowe-z-phpunit-krok-po-kroku">Testy jednostkowe z PHPUnit – krok po kroku</a></li>
  <li><a href="http://itcraftsman.pl/tdd-w-php-jak-testowac-modele">Jak testować modele ?</a></li>	
  <li><strong>Testowanie bazy danych</strong></li>
<ol>
</div>

Są takie przypadki, że nie da się zrezygnować z wysyłania zapytań do bazy. Np. musisz zapewnić działanie z jakimś starym istniejącym już kodem lub po prostu, przetestowanie bazy danych pozwoli spać ci spokojnie. Miej na uwadze jednak, że jeżeli twoje testy, często potrzebują do swojego poprawnego działania bazy danych, to znak, że kod jest źle zaprojektowany.

Na potrzeby tego wpisu posłużę się przykładami z frameworka [Laravel 5](http://laravel.com/), ale każdy inny dobry framework posiada analogiczne odpowiedniki opisanych funkcji/technik.

## Środowisko testowe i baza danych

Na początku warto wydzielić sobie osobne miejsce (osobny plik) na zmienne konfiguracyjne, które są specyficznego tylko dla środowiska testowego (podobnie można zrobić z innymi środowiskami: developerskim i produkcyjnym). W Laravel 5 pliki konfiguracyjne zasysają zmienne środowiskowe (trzymane np. w tablicy _$_ENV_), które można wpisywać w pliku _.env_. Przykładowa konfiguracja:

```
	'connections' => [

		'sqlite' => [
			'driver'   => 'sqlite',
			'database' => storage_path().'/database.sqlite',
			'prefix'   => '',
		],

		'mysql' => [
			'driver'    => 'mysql',
			'host'      => env('DB_HOST', 'localhost'),
			'database'  => env('DB_DATABASE', 'forge'),
			'username'  => env('DB_USERNAME', 'forge'),
			'password'  => env('DB_PASSWORD', ''),
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
			'strict'    => false,
		],
```

Plik .env, z którego pobierane są ustawienia, może wyglądać następująco: 

```
...
DB_HOST=localhost
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret

CACHE_DRIVER=file
SESSION_DRIVER=file
```

Jednocześnie [PHPUnit](http://itcraftsman.pl/tdd-w-php-testy-jednostkowe-z-phpunit-krok-po-kroku/) pozwala na utworzenie w głównym pliku konfiguracyjnym (_phpunit.xml_) specjalnej gałęzi, w które możemy takie zmienne wpisać i które nadpiszą domyślne ustawienia:

```
<phpunit>
...
    <php>
        <env name="APP_ENV" value="testing"/>
        <env name="CACHE_DRIVER" value="array"/>
        <env name="SESSION_DRIVER" value="array"/>
    </php>
</phpunit>
```

W ten sposób, możemy ustawić sobie** osobną bazę danych do testów**, która nie będzie kolidować z naszymi aktualnymi pracami i śmiało może być "maltretowana" przez PHPUnita. Wystarczy dopisać 4 parametry:

```
<phpunit>
...
        <env name="DB_HOST" value="localhost"/>
        <env name="DB_DATABASE" value="testing"/>
        <env name="DB_USERNAME" value="username"/>
        <env name="DB_PASSWORD" value="password"/>
    </php>
</phpunit>
```

Przy okazji, można zobaczyć, że L5 domyślnie w czasie testów, przestawia sterownik sesji i cache na typu _array_ - czyli wszystkie operacje będą przechowywane w wewnętrznych tabelach PHP, co dodatkowo przyspieszy wykonywanie testów jednostkowych.

## Migracje

Kolejnym, bardzo przydatny krokiem, będzie wykorzystanie mechanizmu [migracji](http://itcraftsman.pl/migrowanie-bazy-danych-laravel-migrations/). Pozwoli on zapewnić nam w czasie testów taką samą strukturę tabel jak w środowisku developerskim czy produkcyjnym. Warto zainteresować się tym tematem, nie tylko w zakresie testów, ale również tworzenia aplikacji. Jest to bardzo przydatna technika.

Przykładowo korzystając z migracji w Laravel 5, możemy napisać metodę _setUp_ naszego domyślnego _TestCaseu_, która przypilnuje, czy baza posiada odpowiednią strukturę:

```
class AppBaseTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
    }
}
```

W ten sposób, przy każdym uruchomieniu testów (polecenie _phpunit_), skrypt zadba o to aby baza posiadała wszystko czego nam trzeba. 

Dodatkowo, możemy skorzystać z mechanizmu automatycznego wypełniania danymi bazy danych, zwanego [**Database Seeding**](http://laravel.com/docs/5.0/migrations#database-seeding) (może zrobię o tym osobny wpis). Jako, że klasa _TestCase_ jest częścią Laravela, możemy użyć metody:_ $this->seed();_. Teraz nasza metoda _setUp_ wygląda następująco:

```
class AppBaseTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
        $this->seed();
    }
}
```

Dzięki takiemu rozwiązaniu, przed każdym testem, baza danych będzie mieć zawsze aktualną strukturę tabel, oraz będzie wypełniona odpowiednimi danymi (najlepiej testowymi).

## Baza danych w pamięci ... przyspieszamy

Środowisko testowe zostało skonfigurowane. Migracje i wypełnianie danymi testowymi zostało zrobione. Testy przechodzą (lub nie), ale całość działa dość mozolnie ? Jest jeszcze jedna rzecz, którą można zrobić, aby testy z użyciem bazy danych **były szybsze** i przyjemniejsze (na końcu zamieszczam rezultat moich testów tej techniki).

Możemy skorzystać z mechanizmu zapisu bazy danych w pamięci podręcznej (tylko dla SQLite). Funkcjonalność ta, w PHP, dostępna jest od ręki. Wystarczy tylko odpowiednio skonfigurować połączenie z bazą danych. Jako nazwę bazy podajemy string "_**:memory:**_". W ten sposób, PHP utworzy chwilową bazę danych w pamięci podręcznej, która będzie dostępną tak długo, jak długo istnieje do niej aktywne połączenie (czyli tylko na czas trwania testów). Zmniejszamy w ten sposób ilość operacji dyskowych. Do naszych testów jak znalazł.

Poniżej przykład takiej konfiguracji w Laravel 5:

```
return [
	'default' => 'sqlite',

	'connections' => [

		'sqlite' => [
			'driver'   => 'sqlite',
			'database' => ':memory:',
			'prefix'   => '',
		],
    ]
];
```

Technika ta, nie zawsze gwarantuje mega szybkości, ale w niektórych przypadkach może pomóc usprawnić testowanie. Dla potwierdzenie przeprowadziłem małe testy. 

W pierwszej kolumnie mamy ilość wierszy, które wsadzane są do bazy (_insert_) przed każdym testem. W kolejnych kolumnach są czasy dla standardowego mysql oraz :memory: sqlite (czasy podawane w sekundach):

```
  rows | mysql | sqlite (:memory:)
-----------------------
10     | 1.47   | 0.34
100    | 6.01   | 0.35
1000   | 41.62  | 0.42
10000  | 622.11 | 1.23
100000 | > 1h   | 9.19
```

Jak widać, różnica jest znaczna, a przy większej ilości danych testowych wręcz kosmiczna. Dla 1 000 rekordów jest około 100 razy szybciej. Pamiętajmy, że testy jednostkowo powinny być zawsze jak najszybsze, dlatego warto przyjrzeć się tej technice.


## ... The End

Na ten moment to wszystko. Z tej serii mam zaplanowanych jeszcze parę wpisów, między innymi PHPSpec i testowanie kontrolerów. W razie pytań, uwag lub wątpliwości oddaję komentarze w Wasze ręce. Przetestujcie mnie :)

*Zdjęcie z wpisu: [Flickr](https://www.flickr.com/photos/shindotv/3835365695)*.
