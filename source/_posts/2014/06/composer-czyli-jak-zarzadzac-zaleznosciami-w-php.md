---
extends: _layouts.post
section: content
title: Composer czyli jak zarządzać zależnościami w PHP
description: To jest mój pierwszy wpis w którym opiszę co to jest Composer oraz jak się nim posługiwać.
date: 2014-06-24
categories: [feature]
---

To jest mój pierwszy wpis w którym opiszę co to jest Composer oraz jak się nim posługiwać. Postaram się opisać wszystko od podstaw. Zapraszam do lektury :) 

**[Composer](http://getcomposer.org)** to narzędzie pozwalające na bardzo łatwe zarządzanie zależnościami w projekcie. Pozwala on deklarować różne zależności których potrzebuje twój projekt oraz instalować lub aktualizować je automatycznie za ciebie. Zależności te zostały nazwane paczkami (z ang. package). Paczką może być biblioteka, osobny komponent czy nawet cały framework. Analogia do paczki jest bardzo dobra.  Aby taka paczka mogła być przetwarzana przez Composer'a wymagany jest jej opis (etykieta). Opis ten tworzony jest formacie JSON w pliku composer.json. 

## Plik konfiguracyjny composer.json

Zobaczmy teraz jak może wyglądać taki opis. Poniżej znajduje się przykładowy plik composer.json z popularnego framework'a Laravel (w sumie jego fragmenty): 
```json
{
   "name":"laravel/laravel",
   "description":"The Laravel Framework.",
   "keywords":[
      "framework",
      "laravel"
   ],
   "license":"MIT",
   "require":{
      "laravel/framework":"4.2.*"
   },
   "autoload":{
      "classmap":[
         "app/commands",
         "app/controllers",
         "app/models"
      ]
   },
   "scripts":{
      "post-update-cmd":[
         "php artisan clear-compiled",
         "php artisan optimize"
      ]
   }
}
```  

Plik JSON to zbiór danych typu klucz => wartość. Poniżej opisałem znaczenie poszczególnych kluczy: 

**name** \-  nazwa paczki w formacie autor/nazwa. W większości przypadków parametr ten będzie się pokrywał z formatem nazewnictwa repozytoriów na [Github](http://github.com). 

**description** \- krótki opis paczki. Zaleca się aby opis był maksymalnie zwięzły i ograniczał się do jednego zdania. 

**keywords** \- słowa kluczowe, przydają się do wyszukiwarek lub filtrów. 

**license** \- informacja o rodzaju licencji, może być pojedynczy string lub array. 

**require** - lista paczek wymaganych do utworzenia tej paczki, podajemy je w formacie "autor/nazwa" : "wersja", przy czym dla wersji możliwe są wildcardy np. 4.* lub inne warianty o których można przeczytać [tutaj](https://getcomposer.org/doc/01-basic-usage.md#package-versions). Kolejne paczki do prawidłowego działania mogą wymagać innych paczek. Klucz ten pozwala na budowę drzewa zależności projektu i to głównie on będzie zazwyczaj zmieniany/edytowany. 

**autoload** \- sposób w jaki mają zostać utworzone autoloadery - zostanie to omówieni bardziej szczegółowo poniżej 

**scripts** \- jedna z ciekawszych opcji, pozwala ona wpiąć callback do różnych momentów (event) instalacji paczki. Callback'iem może być metoda statyczna naszego skryptu (np. MyClass::postUpdate) lub komenda shell'owa (np. phpunit -c /app). Spis wszystkich eventów do których możemy się wpiąć znajduje się [tutaj](https://getcomposer.org/doc/articles/scripts.md#event-types). 

Pełen spis wszystkich możliwy kluczy oraz ich znaczeń znajduje się pod tym [linkiem](http://composer.json.jolicode.com/). 

## Wymagania i instalacja

Do poprawnego działania Composer potrzebuje PHP w wersji co najmniej 5.3.2 oraz rozszerzenie mcrypt. Instalacja możliwa jest dla systemów typu Linux oraz Windows. Sam proces instalacji jest bajecznie prosty. Na Linuxach wpisujemy w konsoli odpowiednio: [code] curl -sS https://getcomposer.org/installer | php mv composer.phar /usr/local/bin/composer [/code] Pierwsza linia pobiera skrypt Composer'a. Druga pozwoli nam wywoływać Composera w dowolnym miejscu. Instalacja pod Windowsa organiczna się do pobrania zwykłego instalatora. Osobiście instalowałem go pod Ubuntu 14 oraz Windows 8. Jeżeli posiadasz świeżą instalację Ubuntu 14 to możesz napotkać problem z instalacją mcrypt dla PHP. Polecam tą [stronę](http://stackoverflow.com/a/23692816/196491) która pomogła mi rozwiązać ten problem. Po prawidłowej instalacji i wpisaniu composer w konsoli (lub wierszu poleceń) otrzymamy następujący efekt: ![Zrzut ekranu z 2014-06-25 23:34:51](/wp-content/uploads/2014/06/Zrzut-ekranu-z-2014-06-25-233451-e1403774817760.png)

## Obsługa - wybrane polecenia

_**composer install**_ Zakładając że w danym katalogu roboczym znajduje się poprawny plik _composer.json_, wydanie polecenie install spowoduje pobranie przez Composera wszystkich wymaganych paczek z klucza require oraz ich instalację. Za pierwszym razem Composer pobiera daną paczkę z adresu zdalnego. Dla kolejnej instalacji zostanie wczytana jej wersja z cache (jeżeli wersje będą zgodne). Pobrane paczki zostaną skopiowane do katalogu vendor. Po instalacji zostanie utworzony plik _composer.lock_ w którym znajdą się informacje o aktualnie zainstalowanych paczkach i ich wersjach (tego pliku nie polecam edytować).   

_**composer update**_ Aktualizuje wszystkie zależności do najnowszych wersji oraz aktualizuje plik _composer.lock. _Przydaje się gdy ręcznie edytowaliśmy plik _composer.json_. _**composer create-project auto/nazwa katalog/**_ Tworzy nowy projekt (np. laravel/laravel) w podanym katalogu. Pozwala na szybką instalację wybranej paczki. Projekt zostaje pobrany z publicznie dostępnych repozytoriów (najczęściej będzie to Github). ![Zrzut ekranu z 2014-06-25 23:38:59](/wp-content/uploads/2014/06/Zrzut-ekranu-z-2014-06-25-233859-e1403774964148.png) _**composer require autor/nazwa**_ Dodaje odpowiedni wpis do pliku _composer.json_ oraz instaluje lub aktualizuje projekt. _**composer dump-autoload**_ Pozwala na odświeżanie pliku _autoload.php_ i wygenerowanie nowych autoloaderów. Pomocne w przypadku dodania nowej klasy lub nowego namespace'a (patrz niżej). _**composer self-update**_ Automatyczna aktualizacja Composera. 

## Auto Loading

Samo pobieranie i instalacja paczek to tylko połowa zadania. Aby można było korzystać z ich dobrodziejstw potrzebne jest ich prawidłowe podpięcie do projektu. Każda paczka posiada swoje specyficzne klasy lub całe namespace'y. Nikt z nas na pewno nie ma ochoty na pisanie tysiąca poleceń require czy include. Oczywiście niektóre biblioteki posiadają swoje wbudowane autoloader'y co dodatkowo komplikuje sprawę. Na szczęście w procesie instalacji lub aktualizacji Composer automatycznie generuje plik _autoload.php_ w katalogu _vendor_. Plik ten należy dołączyć do naszego kodu aby móc korzystać z pobranych paczek: [code] require vendor/autoload.php'; [/code] W ten sposób nie musimy martwić się sposobem ładowania czy dołączania kolejnych bibliotek lub komponentów. Dodatkowo określając klucz autoload w naszym pliku composer.json możemy sprawić że również nasze własnoręcznie napisane klasy będą odpowiednio "zasysane" do projektu. Istnieje parę różnych mechanizmów które możemy wykorzystać do automatycznego ładowania naszych klas.   

#### Files 

Najprostszym z nich jest  mechanizm _files_:
```json
"autoload": {
    "files": [
        "sciezka/do/pierwszego/pliku.php",
        "sceizka/do/drugiego/pliku.php"
    ]
}
```
