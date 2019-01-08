---
comments: true
date: 2014-11-06 23:28:48+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2014/phpunit.png
slug: tdd-w-php-testy-jednostkowe-z-phpunit-krok-po-kroku
title: 'TDD w PHP: testy jednostkowe z PHPUnit - krok po kroku'
wordpress_id: 741
categories:
- PHP
- TDD
tags:
- php
- phpunit
- phpunit.xml
- tdd
- testy jednostkowe
- unittest
---

Konkretny wpis na temat wykorzystania bardzo popularnego narzędzia, jakim jest PHPUnit, do tworzenia testów jednostkowych. Od instalacji, przez konfigurację do testowania kodu.<!-- more -->

[PHPUnit](https://phpunit.de/) to framework testów jednostkowych, którego autorem jest Sebastian Bergmann. Jak inne tego typu frameworki używa on do testów tzw. asercji, które sprawdzają jak zachowuje się kod poddany testom (można spotkać się również z skrótem SUT - system under test). O idei samych testów jednostkowych możesz przeczytać w [Wprowadzeniu do TDD w PHP](https://itcraftsman.pl/tdd-w-php-wprowadzenie-do-test-driven-development/). PHPUnit jest w pełni obiektowym narzędziem, które czerpie swoje rozwiązania z frameworków typu xUnit.

Trzeba jeszcze rozjaśnić, czym jest ta cała asercja ? Najpierw pozwolę sobie zacytować Wikipedię:


>W programowaniu **asercja** (ang.*assertion*) to predykat (forma zdaniowa w danym języku, która zwraca prawdę lub fałsz), umieszczony w pewnym miejscu w kodzie. Asercja wskazuje, że programista zakłada, że predykat ów jest w danym miejscu prawdziwy.


Przyznam, że zawile to opisali. Teraz tak bardziej po mojemu: asercja to zwyczajne sprawdzenie czy to co otrzymał dany fragment kodu jest tym czego się spodziewamy. Poniżej krótki fragment (wyjęty z kontekstu, omówię go niżej):

```php
$text = 'Hello World';
$this->assertTrue($text === 'Hello World');
```

W tym przypadku sprawdzamy czy wyrażenie porównania zwraca prawdę. Po napisaniu pierwszego testu sprawa na pewno się rozjaśni :).

<div class="shadow-md p-4 bg-yellow-lighter">
    Cały kod źródłowy z tego wpisu dostępny jest publicznie pod adresem: <a href="https://github.com/itcraftsmanpl/PHPUnitTests">https://github.com/itcraftsmanpl/PHPUnitTests</a>
</div>

Ok, po krótkim wstępie możemy przejść do instalacji.


## Instalacja PHPUnit


Na potrzeby tego wpisu zainstalujemy PHPUnit globalnie, korzystając z [Composera](https://itcraftsman.pl/composer-czyli-jak-zarzadzac-zaleznosciami-w-php/). Cała operacja może wydać się nieco skomplikowana, ale zrobimy ją tylko raz. Potem, do każdego projektu, będziesz mógł używać PHPUnit od ręki.

Uruchamiamy terminal (lub wiersz poleceń) i wpisujemy:

```
composer global require "phpunit/phpunit=4.3.*"
```

Jeżeli wszystko przebiegło prawidłowo, to potrzebujemy dodać odpowiednią ścieżkę do zmiennej systemowej o nazwie PATH. W ten sposób będziemy mogli wywoływać polecenie "_phpunit_" w dowolnym miejscu. W zależności od systemu musimy wykonać:

**Linux/Mac:**

```
export PATH=$PATH:~/.composer/vendor/bin/
```

**Windows **

Tutaj będzie trudniej, musimy zmienną Path uaktualnić o poniższą wartość (podmieniamy username) [upewnij się czy dana ścieżka jest prawidłowa, w zależności od wersji systemu może się różnić, zauważyłem również, że jest ona wyświetlana w czasie wykonywania polecenie _composer global require_]:

```
C:\Users\<username>\AppData\Roaming\Composer\vendor\bin
```
	
  1. Klikamy prawym na "Mój komputer"
  2. Wybieramy "Zaawansowane ustawienia systemu"
  3. Z karty "Zaawansowane" wybieramy "Zmienne środowiskowe"
  4. Z dolnej listy (zmienne systemowe) wybieramy Path i klikamy "Edytuj"
  5. Na końcu dopisujemy średnik (oddziela nową wartość) a następnie wklejamy wyżej przedstawioną ścieżkę


Aby przetestować, czy wszystko jest prawidłowo zainstalowane, restartujemy wiersz poleceń (aby odświeżyła się zmienna Path) i wpisujemy samo _phpunit_. W efekcie powinno wyświetlić się coś w stylu:

[![phpunit](/assets/img/posts/2014/phpunit1.jpg)](/assets/img/posts/2014/phpunit1.jpg) Wywołanie polecenia phpunit w wierszu poleceń.


**Instalacja lokalna**

Warto wspomnieć, że istnieje również możliwość instalacji PHPUnit bezpośrednio do wybranego projektu (lokalnie). Tutaj również korzystamy z Composera, edytując plik _composer.json_:

```javascript
{
    "require-dev": {
        "phpunit/phpunit": "4.3.*"
    }
}
```

lub bezpośrednio w konsoli, w katalogu głównym projektu (tam gdzie znajduje się plik _composer.json_), wywołujemy polecenie:

```
composer require "phpunit/phpunit=4.3.*"
```

W takim przypadku, PHPUnit trzeba będzie wywoływać poprzez wpisanie następującego polecenia:

```
vendor/bin/phpunit
```



**Kolory**

Jeżeli korzystasz z systemu Windows i chcesz aby komunikaty w wierszu poleceń były kolorowe (a na pewno chcesz) to polecam instalację [ANSICON](https://adoxa.altervista.org/ansicon/) (wystarczy pobrać, rozpakować i odpalić exeka).




## Konfiguracja PHPUnit


Przed przystąpienie do pisania pierwszego testu, skonfigurujemy PHPUnit tak, aby był jak najbardziej wygodny w działaniu. W katalogu główny projektu należy utworzyć plik _phpunit.xml_ o następującej zawartości:

```
<?xml version="1.0" encoding="UTF-8"?>
<phpunit
        backupGlobals="false"
        backupStaticAttributes="false"
        bootstrap="vendor/autoload.php"
        colors="true"
        convertErrorsToExceptions="true"
        convertNoticesToExceptions="true"
        convertWarningsToExceptions="true"
        processIsolation="false"
        stopOnFailure="false"
        syntaxCheck="false"
        >
    <testsuites>
        <testsuite name="Application Test Suite">
            <directory>./tests/</directory>
        </testsuite>
    </testsuites>
</phpunit>
```

W ten sposób uruchamiając PHPUnita będzie on zaczytywał domyślną konfigurację. Tym samym do przeprowadzenie testów kodu wystarczy wywołać polecenie _phpunit_. Poniżej krótkie omówienie najważniejszych parametrów:

**boostrap** - tutaj podajemy ścieżką do pliku który zostanie wczytany za każdym razym, gdy uruchomi się proces testowania; najlepszym rowiązaniem jest dodanie autoloadera który dostarcza nam Composer (domyślnie _vendor/autoload.php_)

**colors** - ustawiając na true uzyskamy w konsoli kolorowe komunikaty

**stopOnFailure** - ustawiamy na false - dzięki temu pierwszy błąd nie zatrzyma testowania, a testy będą wykonywane do końca

**directory** - w tym tagu ustawiamy ścieżkę w której mieścić się będą nasze testy, PHPUnit zaciągnie je w ten sposób automatycznie

W razie wątpliwości z resztą opcji, polecam [dokumentację](https://phpunit.de/manual/current/en/appendixes.configuration.html).


## Pierwszy test


Ok, nareszcie możemy przejść do napisania pierwszego testu. W głównym katalogu tworzymy nowy folder "tests" (może być dowolnie inny, pamiętaj tylko żeby zaktualizować odpowiednio tag _directory_ w pliku _phpunit.xml_). Nasz pierwszy test będzie do bólu klasyczny. Tworzymy nowy plik "_ExampleTest.php_" z następującą zawartością:

```php
class ExampleTest extends PHPUnit_Framework_TestCase {

    public function testGreetings()
    {
        $greetings = 'Hello World';
        $this->assertEquals('Hello World', $greetings);
    }

}
```

Objaśnimy teraz jego strukturę. **Nazwa pliku** oraz** nazwa klasy** pokrywa się, jednocześnie nazwa powinna wskazywać testowany obiekt i kończyć się słowem Test (np. UserTest lub RegisterEventTest). Każda testowana klasa powinna dziedziczyć po klasie **_PHPUnit_Framework_TestCase_.**_ Z_apewnia ona dostęp do wszystkich możliwych asercji, oraz paru innych przydatnych metod (m. in. _setUp_ oraz _tearDown_). Każda metoda powinna testować jeden element (funkcjonalność) i być poprzedzona słowem _**test **_(np. _testInstance_ lub _testAddsNumbers_)

Sprawdzimy teraz czy nasz test przechodzi (jest zielony). Wpisz w konsoli _phpunit_ i sprawdź czy masz przed oczami coś podobnego do:

[![Wynik pierwszego testu z PHPUnit](/assets/img/posts/2014/first-test.png)](/assets/img/posts/2014/first-test.png) Zawartość konsoli po przeprowadzeniu pierwszego testu.

Na pewno zielona linia "OK (1 test, 1assertion)" wpada w oko. Oznacza ona, że wszystkie testy przeszły (w ilości 1) oraz łącznie była jedna asercja. Nad linią z czasem i zabraną pamięcią, znajduje się pojedyncza kropka i nie jest przypadkowa. Reprezentuje ona pojedynczy test. Gdy dodamy kolejny, zobaczymy kolejnę kropkę (o ile się powiedzie). W przypadku gdy dany test zawiedzie, zamiast kropki wyświetli się litera F (od _failure_). Przykład poniżej:

[![test_fail](/assets/img/posts/2014/test_fail.png)](/assets/img/posts/2014/test_fail.png) Zawartość konsoli po nieudanym teście.


## Wybrane rodzaje asercji


Przedstawię teraz kilka najpopularniejszych asercji dostępnych w PHPUnit. W momencie w którym tworzyłem ten wpis, całkowita liczba asercji to 93. Na szczęście ich nazwy są na tyle logiczne, że korzystając z dowolnego IDE z funkcją podpowiadania, każdy odnajdzie to czego potrzebuje.

**assertTrue**

```php
$value = 10.99;
$this->assertTrue(is_numeric($value), 'Opcjonalna wiadomość');
```

Najprostszy rodzaj, w tym przypadku zakładamy, że oczekiwana wartość to logiczne _true. _Większość asercji posiada swój odwrotny odpowiednik. Czyli, jeżeli chcemy założyć, że oczekiwana wartość to _false_, to możemy skorzystać z metody **_assertFalse. _**Ostatnim parametrem (w każdej asercji) jest opcjonalna wiadomość, która wyświetli się w przypadku niepowodzenia.

**assertEquals**

```php
$expected = '10';
$this->assertEquals($expected, 5+5);
```

Tym razem podajemy dwa parametry (tak jest w większej części asercji), wartość oczekiwana jako pierwszy, oraz wartość faktyczna (np. zwrócona) jako drugi. W przypadku gdy typy muszę się zgadzać, można wykorzystać _**assertSame**_

**assertContains**

```php
$fruits = ['Apple', 'Orange', 'Grapefruit'];
$this->assertContains('Apple', $fruits);
```

Tutaj sprawdzamy czy pierwszy parametr istnieje jako element tablicy (drugi parametr). Jak widać nazewnictwo w pełni przedstawia to czego dotyczą same test i założenie. Automatycznie jeżeli chcemy poszukać klucza w tablicy to korzystamy z _**assertArrayHasKey**_.

**assertInternalType**

```php
$fruits = ['Apple', 'Orange', 'Grapefruit'];
$this->assertInternalType('array', $fruits);
```

Sprawdzamy czy podany parametr (jako drugi) jest konkretnego typu. Typ musi być wyrażony jako string ([rodzaje typów](https://php.net/manual/en/language.types.php)).

**assertInstanceOf**

```php
$date = new DateTime();
$this->assertInstanceOf('DateTime', $date);
```

Sprawdza czy podana zmienna jest obiektem danej klasy.

**expectedException**

Zdarzają się przypadki, w których będziemy potrzebować upewnić się, że dany test zakończy się wyrzuceniem wyjątku (np. sprawdzamy czy metoda wyrzuca wyjątek w przypadku podania, jako parametru, minusowej wartości). W celu sprawdzenia czy dany test zwrócił wyjątek należy skorzystać z tzw. adnotacji. Adnotacje wstawia się w komentarzu nad metodą:

```php
/**
 * @expectedException Exception
 */
public function testMustThrowException()
{
    throw new Exception("Error", 1);
}
```

Po spacji wpisujemy nazwę spodziewanego wyjątku (np. _Exception_ lub _InvalidNumberException_). Oznaczona w ten sposób metoda musi wyrzucić wyjątek, aby test się powiódł. Do dyspozycji są dodatkowe adnotacje:  _@expectedExceptionCode_, _@expectedExceptionMessage_ oraz _@expectedExceptionMessageRegExp_.



Uff ... wpis zrobił się trochę długi, ale z mnóstwem przykładów. Jeżeli udało ci się dobrnąć do końca, to przyjmij moje gratulacje, jesteś gotowy to przejścia na wyższy poziom. W następnym wpisie z tej serii zajmiemy się praktycznym testowanie całych klas. Jeżeli chciałbyś już teraz poszerzyć swoją wiedzę to zapraszam do mojego gościnnego wpisu: [Testy jednostkowe z PHPUnit oraz Mockery](https://webmastah.pl/testy-jednostkowe-z-phpunit-oraz-mockery/). Jak zawsze zachęcam do komentowania, w miarę możliwości odpowiem na każde, nawet najtrudniejsze pytanie :P
