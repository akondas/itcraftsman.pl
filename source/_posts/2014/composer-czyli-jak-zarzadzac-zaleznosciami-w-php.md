---
comments: true
date: 2014-06-24 07:29:37+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2014/logo-composer1.jpg
slug: composer-czyli-jak-zarzadzac-zaleznosciami-w-php
title: Composer czyli jak zarządzać zależnościami w PHP
wordpress_id: 1
categories:
- PHP
tags:
- autoloading
- composer
- php
---

To jest mój pierwszy wpis w którym opiszę co to jest Composer oraz jak się nim posługiwać. Postaram się opisać wszystko od podstaw. Zapraszam do lektury :)<!-- more -->

[**Composer** ](https://getcomposer.org) to narzędzie pozwalające na bardzo łatwe zarządzanie zależnościami w projekcie. Pozwala on deklarować różne zależności których potrzebuje twój projekt oraz instalować lub aktualizować je automatycznie za ciebie. Zależności te zostały nazwane paczkami (z ang. package). Paczką może być biblioteka, osobny komponent czy nawet cały framework. Analogia do paczki jest bardzo dobra.  Aby taka paczka mogła być przetwarzana przez Composer'a wymagany jest jej opis (etykieta). Opis ten tworzony jest formacie JSON w pliku composer.json.


## Plik konfiguracyjny composer.json


Zobaczmy teraz jak może wyglądać taki opis. Poniżej znajduje się przykładowy plik composer.json z popularnego framework'a Laravel (w sumie jego fragmenty):

```javascript
{
    "name": "laravel/laravel",
    "description": "The Laravel Framework.",
    "keywords": ["framework", "laravel"],
    "license": "MIT",
    "require": {
        "laravel/framework": "4.2.*"
    },
    "autoload": {
        "classmap": [
            "app/commands",
            "app/controllers",
            "app/models"
        ]
    },
    "scripts": {
        "post-update-cmd": [
            "php artisan clear-compiled",
            "php artisan optimize"
        ]
    }
}
```

Plik JSON to zbiór danych typu klucz => wartość. Poniżej opisałem znaczenie poszczególnych kluczy:

**name** -  nazwa paczki w formacie autor/nazwa. W większości przypadków parametr ten będzie się pokrywał z formatem nazewnictwa repozytoriów na [Github](https://github.com).

**description** - krótki opis paczki. Zaleca się aby opis był maksymalnie zwięzły i ograniczał się do jednego zdania.

**keywords** - słowa kluczowe, przydają się do wyszukiwarek lub filtrów.

**license** - informacja o rodzaju licencji, może być pojedynczy string lub array.

**require** - lista paczek wymaganych do utworzenia tej paczki, podajemy je w formacie "autor/nazwa" : "wersja", przy czym dla wersji możliwe są wildcardy np. 4.* lub inne warianty o których można przeczytać [tutaj](https://getcomposer.org/doc/01-basic-usage.md#package-versions). Kolejne paczki do prawidłowego działania mogą wymagać innych paczek. Klucz ten pozwala na budowę drzewa zależności projektu i to głównie on będzie zazwyczaj zmieniany/edytowany.

**autoload** - sposób w jaki mają zostać utworzone autoloadery - zostanie to omówieni bardziej szczegółowo poniżej

**scripts** - jedna z ciekawszych opcji, pozwala ona wpiąć callback do różnych momentów (event) instalacji paczki. Callback'iem może być metoda statyczna naszego skryptu (np. MyClass::postUpdate) lub komenda shell'owa (np. phpunit -c /app). Spis wszystkich eventów do których możemy się wpiąć znajduje się [tutaj](https://getcomposer.org/doc/articles/scripts.md#event-types).

Pełen spis wszystkich możliwy kluczy oraz ich znaczeń znajduje się pod tym [linkiem](https://composer.json.jolicode.com/).


## Wymagania i instalacja


Do poprawnego działania Composer potrzebuje PHP w wersji co najmniej 5.3.2 oraz rozszerzenie mcrypt. Instalacja możliwa jest dla systemów typu Linux oraz Windows. Sam proces instalacji jest bajecznie prosty. Na Linuxach wpisujemy w konsoli odpowiednio:

```
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
```

Pierwsza linia pobiera skrypt Composer'a. Druga pozwoli nam wywoływać Composera w dowolnym miejscu. Instalacja pod Windowsa organiczna się do pobrania zwykłego instalatora. Osobiście instalowałem go pod Ubuntu 14 oraz Windows 8. Jeżeli posiadasz świeżą instalację Ubuntu 14 to możesz napotkać problem z instalacją mcrypt dla PHP. Polecam tą [stronę](https://stackoverflow.com/a/23692816/196491) która pomogła mi rozwiązać ten problem.

Po prawidłowej instalacji i wpisaniu composer w konsoli (lub wierszu poleceń) otrzymamy następujący efekt:

[![Zrzut ekranu z 2014-06-25 23:34:51](/assets/img/posts/2014/composer.jpg)](/assets/img/posts/2014/composer.jpg)


## Obsługa - wybrane polecenia


_**composer install**_

Zakładając że w danym katalogu roboczym znajduje się poprawny plik _composer.json_, wydanie polecenie install spowoduje pobranie przez Composera wszystkich wymaganych paczek z klucza require oraz ich instalację. Za pierwszym razem Composer pobiera daną paczkę z adresu zdalnego. Dla kolejnej instalacji zostanie wczytana jej wersja z cache (jeżeli wersje będą zgodne). Pobrane paczki zostaną skopiowane do katalogu vendor. Po instalacji zostanie utworzony plik _composer.lock_ w którym znajdą się informacje o aktualnie zainstalowanych paczkach i ich wersjach (tego pliku nie polecam edytować).



_**composer update**_

Aktualizuje wszystkie zależności do najnowszych wersji oraz aktualizuje plik _composer.lock. _Przydaje się gdy ręcznie edytowaliśmy plik _composer.json_.

_**composer create-project auto/nazwa katalog/**_

Tworzy nowy projekt (np. laravel/laravel) w podanym katalogu. Pozwala na szybką instalację wybranej paczki. Projekt zostaje pobrany z publicznie dostępnych repozytoriów (najczęściej będzie to Github).

[![Zrzut ekranu z 2014-06-25 23:38:59](/assets/img/posts/2014/Zrzut-ekranu-z-2014-06-25-233859-e1403774964148.png)](/assets/img/posts/2014/Zrzut-ekranu-z-2014-06-25-233859-e1403774964148.png)

_**composer require autor/nazwa**_

Dodaje odpowiedni wpis do pliku _composer.json_ oraz instaluje lub aktualizuje projekt.

_**composer dump-autoload**_

Pozwala na odświeżanie pliku _autoload.php_ i wygenerowanie nowych autoloaderów. Pomocne w przypadku dodania nowej klasy lub nowego namespace'a (patrz niżej).

_**composer self-update**_

Automatyczna aktualizacja Composera.


## Auto Loading


Samo pobieranie i instalacja paczek to tylko połowa zadania. Aby można było korzystać z ich dobrodziejstw potrzebne jest ich prawidłowe podpięcie do projektu. Każda paczka posiada swoje specyficzne klasy lub całe namespace'y. Nikt z nas na pewno nie ma ochoty na pisanie tysiąca poleceń require czy include. Oczywiście niektóre biblioteki posiadają swoje wbudowane autoloader'y co dodatkowo komplikuje sprawę. Na szczęście w procesie instalacji lub aktualizacji Composer automatycznie generuje plik _autoload.php_ w katalogu _vendor_. Plik ten należy dołączyć do naszego kodu aby móc korzystać z pobranych paczek:

```
require vendor/autoload.php';
```

W ten sposób nie musimy martwić się sposobem ładowania czy dołączania kolejnych bibliotek lub komponentów. Dodatkowo określając klucz autoload w naszym pliku composer.json możemy sprawić że również nasze własnoręcznie napisane klasy będą odpowiednio "zasysane" do projektu. Istnieje parę różnych mechanizmów które możemy wykorzystać do automatycznego ładowania naszych klas.



**Files**

Najprostszym z nich jest  mechanizm _files_:

```javascript
"autoload": {
    "files": [
        "sciezka/do/pierwszego/pliku.php",
        "sceizka/do/drugiego/pliku.php"
    ]
}
```

Mechanizm _files_ pozwala na podanie tablicy plików które zostaną zwyczajnie zaciągnięte w momencie podpięcia autoloadera. Metoda ta jest bardzo wydajna ale niestety mało wygodna. Wymaga od nas podania wszystkich nazw plików jakie mają zostać dołączone (ścieżka powinna być relatywna do głównego katalogu). Jednocześnie należy pamiętać że pliki te zostaną dołączone przy każdym wywołaniu.

**Classmap**

Nikt nie chce za każdym razem dodawać kolejnych wpisów do pliku konfiguracyjnego dlatego następnym, ciekawszym mechanizm jest classmap:

```javascript
"autoload": {
    "classmap": [
        "app/commands",
        "app/controllers",
        "app/models"
    ]
}
```

_Classmap_ wymaga podania tablicy katalogów w których Composer będzie przeszukiwała pliki PHP zawierające klasy. W ten sposób zostanie wygenerowana tablica z wartościami klasa => sciezka. Gdy wywołamy nazwę klasy która nie istnieje nasz autoloader będzie próbować załadować ją zgodnie z wygenerowaną "mapą". Ta metoda jest również bardzo wydajna ale za każdym razem, gdy dodamy nową klasę, potrzebne będzie wywołanie polecenia composer dump-autoload. Osobiście najczęściej korzystam właśnie z tej opcji. Kwestia wywołania jednego polecenia z konsoli staje się po czasie naprawdę bezbolesna a w zamian dostajemy wzrost wydajności.

**Standard PSR-0 i PSR-4**

Najbardziej zaawansowany mechanizm to PSR-4 oraz PSR-0 które wczytują pliku zgodnie z odpowiadającymi im standardami.

```javascript
"autoload": {
    "psr-4": {
        "Monolog\\": "src/",
        "Vendor\\Namespace\\": ""
    },
    "psr-0": {
        "Monolog": "src/",
        "Vendor\\Namespace": ["src/", "lib/"],
        "Pear_Style": "src/",
        "": "src/"
    },
}
```

W obu przypadkach nie ma potrzeby ponownego generowania autoloader'a. Pod kluczem PSR-4 definiujemy mapę typu namspace => sciezka. Kiedy autloader będzie chciał wczytać klasę Foo\Bar\Baz w przestrzeni nazw Foo która wskazuje na katalog src/ poszuka pliku o nazwie src/Bar/Baz.php oraz dołączy go jeżeli istniej. Zachęcam do przeczytania więcej o samych standardach po linkami: [PSR-0](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md), [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md). Należy pamiętać że ścieżki muszą być relatywne do folderu głównego.


---


Uff ... :) jeżeli czytałeś aż do teraz to bardzo Ci dziękuję. Jeśli dowiedziałeś się czegoś nowego lub czujesz że nie wyczerpałem tematu to proszę daj mi znać.  Jest to mój pierwszy wpis dlatego będę wdzięczny za wszelkie uwagi lub komentarze, nawet te krytyczne.
