---
comments: true
date: 2016-05-14 17:39:34+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2016/code-coverage-300x133.png
slug: generowanie-raportu-code-coverage-z-phpunit
title: Generowanie raportu Code Coverage z PHPUnit
wordpress_id: 1368
categories:
- TDD
tags:
- code coverage
- dajsiepoznac
- dajsiepoznac2016
- phpunit
- tdd
- testy jednostkowe
---

Krótki manual jak wygenerować raport Code Coverage używając PHPUnita. W tekście znajduje się również link do przykładowego raportu wygenerowanego dla biblioteki [PHP-ML](https://github.com/php-ai/php-ml).<!-- more -->

Do czego może posłużyć taki raport można poczytać w poprzednim wpisie: [Code Coverage w testach jednostkowych](http://itcraftsman.pl/code-coverage-w-testach-jednostkowych/). Tym razem konkretnie co i jak, aby otrzymać raport Code Coverage, plus informacje o dodatkowych adnotacjach jakie można wykorzystać.

## Wymagania

**PHPunit i ... testy !**

O samym PHPUnicie pisałem już w wcześniejszych postach ([TDD w PHP: testy jednostkowe z PHPUnit – krok po kroku](http://itcraftsman.pl/tdd-w-php-testy-jednostkowe-z-phpunit-krok-po-kroku/)). Instalacja i użytkowanie jest naprawdę proste.

```
composer require --dev "phpunit/phpunit=5.0.*"
```

**XDebug**

Do generowania raportu pokrycia kodu potrzebne jest dodatkowe narzędzie jakim jest XDebug. Dla części czytelników jest pewnie znany. Instalację trzeba wykonać osobno, gdyż nie jest on standardową częścią PHP. Na szczęście, na stronie samego XDebuga istnieje bardzo fajne narzędzie, które podpowiem, jakie krotki trzeba wykonać, aby zainstalować XDebuga: **[https://xdebug.org/wizard.php](https://xdebug.org/wizard.php)**.

Zaczynamy od wklejenie danych zwracanych przez funkcję _phpinfo()_ (można wkleić html z przeglądarki lub wynik instrukcji _php -i_ z linii poleceń).

```
php -i > phpinfo.txt
```

Następnie otrzymamy zestaw niezbędnych kroków, które zainstalują debugera. Dla przykładu:

```
Instructions

1. Download xdebug-2.4.0.tgz
2. Unpack the downloaded file with tar -xvzf xdebug-2.4.0.tgz
3. Run: cd xdebug-2.4.0
4. Run: phpize (See the FAQ if you don't have phpize.
As part of its output it should show:
Configuring for:
...
Zend Module Api No:      20151012
Zend Extension Api No:   320151012
If it does not, you are using the wrong phpize. Please follow this FAQ entry and skip the next step.

5. Run: ./configure
6. Run: make
7. Run: cp modules/xdebug.so /usr/lib/php/20151012
8. Edit /etc/php/7.0/cli/php.ini and add the line
zend_extension = /usr/lib/php/20151012/xdebug.so
```

Po pomyślnej instlajacji wyniki polecenia php -v powinien wyglądać mniej więcej tak:

```
PHP 7.0.6-6+donate.sury.org~wily+1 (cli) ( NTS )
Copyright (c) 1997-2016 The PHP Group
Zend Engine v3.0.0, Copyright (c) 1998-2016 Zend Technologies
    with Xdebug v2.4.0, Copyright (c) 2002-2016, by Derick Rethans
    with Zend OPcache v7.0.6-dev, Copyright (c) 1999-2016, by Zend Technologies
```

## Generowanie raportu

W celu wygenerowania raportu wystarczy wydać jedno proste polecenie (w głównym katalogu projektu):

```
bin/phpunit --coverage-html coverage-dir
```


W tym przypadku _coverage-dir_ to katalogu docelowy, do którego wygenerowany zostanie raport Code Coverage. Po pomyślnym wygenerowaniu raportu, powinien znajdować się tam plik _index.html_.

Przykłady raport Code Coverage wygenerowany za pomocą PHPUnit: [http://itcraftsman.pl/media/code-coverage/](http://itcraftsman.pl/media/code-coverage/)

Za pomocą raportu CC możemy przeprowadzić analizę i sprawdzić miejsca, które nie są pokryte testami. Dla przykładu na poniższym zrzucie linie oznaczone na czerwono:

![screenshot-localhost 63342 2016-05-14 12-21-47](/assets/img/posts/2016/screenshot-localhost-63342-2016-05-14-12-21-47.png)

Widać tutaj, że w funkcji _normalizeL1_ brak jest testów dla przypadku, gdy wyliczona podstawa normy równa się zero. Wypadałby dopisać odpowiedni test, który mógłbym pokryć ten fragment.


## Adnotacje

Na koniec klika przydatnych adnotacji, które pozwalają wpływać na przebieg generowania raportu CC.

**@codeCoverageIgnore**

W ten sposób możemy wykluczyć z raportu daną klasę, metodę, funkcję lub nawet pojedynczą linię. Przydatne, gdy nie chcemy lub nie możemy przetestować danego fragmentu kodu i jednocześnie nie chcemy aby był on zawarty w raporcie pokrycia.

```php
/**
 * @codeCoverageIgnore
 */
class Normalizer implements Preprocessor
{

}


echo '123'; // @codeCoverageIgnore
```

**@covers**

Przy pomocy _@covers_ możliwe jest wskazanie, który test pokrywa którą metodę. Ta adnotacja może wydawać się niepotrzebna, bo przecież system sam sprawdza jaki kod jest testowany. Istnieją jednak specyficzne przypadki, gdy testowany fragment może wymagać zainicjowania jakieś stanu lub uruchomienia innego fragmentu kodu. Wtedy możemy dokładnie wskazać, że dany test pokrywa tylko i wyłącznie to jedną metodę, a nie pozostałe pomocnicze.

```php
/**
  * @covers Normalizer::normalizeL2
  */
private function testNormalizeSamplesWithL2Norm()
{

}
```

**@coversNothing**

PHPUnit można wykorzystywać również do innego rodzaju testów (np. integracyjnych). W takim przypadku, warto wskazać które testy nie powinny być brane pod uwagę do generowaniu raportu pokrycia. Można do tego użyć adnotacji_ @coversNothing_:
    
```php
/**
 * @coversNothing
 */
public function testCalculateNormalizedScore()
{

}
```
