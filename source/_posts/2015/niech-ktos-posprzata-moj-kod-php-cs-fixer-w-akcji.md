---
comments: true
date: 2015-01-28 22:52:38+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2015/12766763504_917e60db0a_b-300x169.jpg
slug: niech-ktos-posprzata-moj-kod-php-cs-fixer-w-akcji
title: Niech ktoś posprząta mój kod - PHP-CS-Fixer w akcji
wordpress_id: 890
categories:
- Standardy kodowania
- Automatyzacja
- PHP
tags:
- automatyzacja
- php
- php psr
- php-cs-fixer
- psr-1
- psr-2
---

Chcesz aby Twój kod był zgodny z obowiązującymi standardami ? Sprawdźmy w akcji, jak działa narzędzie, które próbuje automatycznie dopasować do nich Twój kod.<!-- more -->

W PHP (na tę chwilę) mamy 5 standardów kodowania: od PSR-0 do PSR-4, choć PSR-0 został teoretycznie zastąpiony PSR-4 (kwestia autoloadingu). Cała lista wszystkich oficjalnych standardów (jak również kilka kolejnych w przygotowaniu) znajduje się na stronie [http://www.php-fig.org/psr/](http://www.php-fig.org/psr/). Zachęcam wszystkich do zapoznania się z nimi (jeżeli jeszcze ich nie znacie).

**[PHP Coding Standards Fixer](http://cs.sensiolabs.org/)** to narzędzie autorstwa samego Fabien Potencier, twórcy Symfony. Próbuje ono **automatycznie** posprzątać w twoim kodzie pod kątem standardów PSR-1 oraz PSR-2. W praktyce sprawdza się doskonale, ale zacznijmy od początku.


## Instalacja


Istniejąc trzy sposoby instalacji: ręczny, poprzez Composer lub za pomocą homebrew. Dwie ostatnie należą do najłatwiejszych. Jeżeli jeszcze nie wiesz co to Composer to przeczytaj mój wcześniejszy wpis: [Composer czyli jak zarządzać zależnościami w PHP](http://itcraftsman.pl/composer-czyli-jak-zarzadzac-zaleznosciami-w-php/)

**Composer**

```
composer global require fabpot/php-cs-fixer
```

**homebrew**

```
brew install homebrew/php/php-cs-fixer
```

Po zainstalowaniu wpisujemy w konsoli php-cs-fixer, jeżeli wszystko przebiegło prawidłowo to efekt powinien wyglądać następująco:

[![php-cs-fixer](/assets/img/posts/2015/php-cs-fixer.png)](/assets/img/posts/2015/php-cs-fixer.png) PHP-CS-Fixer zaraz po instalacji

## Uruchamianie

Jak widać z listy dostępnych poleceń (po wpisaniu php-cs-fixer) polecenie **_fix_** czyni całą magię - stara się naprawić jak najwięcej problemów z standardami w wskazanym pliku lub katalogu. Najprościej jest więc "zawędrować" do wybranego katalogu i wywołać polecenie:

```
php-cs-fixer fix .
```

**Przydatne parametry**

**--dry-run** - pozwala na sprawdzenie błędów bez modyfikacji plików. Na końcu zostanie wyświetlona lista plików, które bez tego parametru, zostałby by naprawione.

**--level** - możemy zdecydować na jakim poziomie PHP-CS-Fixer sprawdzi nasz kod. Do dyspozycji są cztery poziomy: _psr0, psr1, psr2, symfony_.

**--verbose** - obok nazwy pliku wyświetli się lista błędów, które zostały naprawione (wymienione kolejno po przecinku)

**--fixers** - pozwala określić listę błędów, które mają zostać naprawione (lista dostępnych błędów w [dokumentacji](https://github.com/fabpot/PHP-CS-Fixer#usage)). W ten sposób możemy sami zdecydować co konkretnie ma zostać naprawione.

Ok, na próbę sprawdźmy jakiś ostatni większy projekt. Nie korzystam z Symfony, więc poziom niech będzie psr2. Dodatkowo chcę zobaczyć tylko listę plików (dry-run):

```
php-cs-fixer fix . --level=psr2 --dry-run
```

Przy większych projektach (większej ilości plików) może to trochę potrwać, ale w rezultacie wynik będzie następujący:

```
  1) controllers\Backend\DashboardController.php
  2) controllers\Backend\FilesController.php
 ...
167) views\layouts\login.blade.php

Fixed all files in 146.946 seconds, 25.500 MB memory used
```

Nieźle, 167 plików w trochę ponad dwie minuty. Zobaczmy co jeszcze można wykrzesać z fixera.


## Konfiguracja


Jak w każdym dobrym narzędziu, tak i tutaj możemy utworzyć plik konfiguracyjny. Będziemy mogli zapisać w nim nasze parametry na stałe (zamiast za każdym razem wpisywać je w linię komend). W tym celu, należy utworzyć plik _**.php_cs**_ w głównym katalogu naszego projektu. Plik powinien zwrócić instancję typu _SymfonyCSConfigInterface_. Brzmi groźnie, ale to zaledwie parę linijek, które do tego dokumentują się same._ _Dzięki temu możemy określić, które katalogi zostaną przeskanowane (a które wykluczone), jaki poziom zostanie wybrany oraz jakie błędy zostaną sprawdzone:

```
<?php

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->exclude('somedir')
    ->in(__DIR__)
;

return Symfony\CS\Config\Config::create()
    ->level(Symfony\CS\FixerInterface::PSR2_LEVEL)
    ->fixers(array('strict_param', 'short_array_syntax'))
    ->finder($finder)
;
```

Jak widać, znowu fluent interface sprawia, że kod można wręcz czytać jak zwykły tekst. W celu przyspieszenie można również skorzystać z mechanizmu cache:

```
<?php

return Symfony\CS\Config\Config::create()
    ->setUsingCache(true)
;
```

## Porównanie kodu

Dla ciekawskich zamieszczam przykład typu "przed i po". Na początek nasz plik z "bałaganem":

```
<?php
namespace ITCraftsman;
use Auth, Blog, Post;

class BlogController extends Controller {
    const blogName = 'abc';
    final static public function showPost( $id = null ){}

public function list_tags() {
    if( $a==$b ) {
return false;
    }
}

    private function _private() {
    if(true) echo 1; else echo 2;
    $x = ( 2 / 1 );
    }

    static protected function otherfunction($param = '', $param_2=array()) {
        switch($param) {
            case '1':
                echo 'b';
                break;}
    }

}

echo 'test';
```

Teraz wywołamy php-cs-fixer na poziomie psr-2:

```
<?php

namespace ITCraftsman;

class BlogController extends Controller
{

    const blogName = 'abc';
    final public static function showPost($id = null)
    {
    }

    public function list_tags()
    {
        if ($a == $b) {
            return false;
        }
    }

    private function _private()
    {
        if (true) {
            echo 1;
        } else {
            echo 2;
        }
        $x = (2 / 1);
    }

    protected static function otherfunction($param = '', $param_2=array())
    {
        switch ($param) {
            case '1':
                echo 'b';
                break;}
    }
}

echo 'test';

```

Jak widać poprawione zostały tylko i wyłącznie standardy kodowania. Cała logika kodu została nietknięta :)


## Zakończenie


Na ten moment to wszystko. Mam nadzieję, że PHP-CS-Fixer pozwoli **zaoszczędzić Wam wiele czasu** oraz wprowadzi oficjalne standardy w wasz kod. Najważniejszy jest fakt, że kod sprzątany jest za każdym razem tak samo dobrze i do tego automatycznie.

Na końcu warto jeszcze wspomnieć, że istnieje możliwość zintegrowania PHP-CS-Fixer z [PhpStorm](https://gist.github.com/mpalourdio/46f792347cf9d46b121c).

P.S.
Jestem właśnie po przeprowadzce, dlatego ostatnio trochę mniej wpisów, ale wszystko wróci do normy. W sobotę (31.01.2015) mój pierwszy ultramaraton (zamiec.pl) więc trzymać kciuki :D - z góry dzięki.

*Zdjęcie z wpisu: [Flickr](https://www.flickr.com/photos/stavos52093/12766763504).*
