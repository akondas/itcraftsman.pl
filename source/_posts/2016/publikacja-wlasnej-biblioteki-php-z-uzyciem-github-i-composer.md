---
comments: true
date: 2016-04-10 12:10:11+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2016/composer-packagist-github-300x200.jpg
slug: publikacja-wlasnej-biblioteki-php-z-uzyciem-github-i-composer
title: Publikacja własnej biblioteki PHP z użyciem GitHub i Composer
wordpress_id: 1273
categories:
- PHP
tags:
- composer
- dajsiepoznac
- dajsiepoznac2016
- github
- packagist
- php
---

Jak w szybki i prosty sposób udostępnić światu własny kawałek kodu i stać się kontrybutorem w świecie Open Source. <!-- more -->

Nie da się ukryć, że [Composer](https://getcomposer.org/) zmienił świat zarządzania pakietami w świecie PHP. Inspirowany NPM (menedżerem pakietów dla node.js) stał się powszechnym standardem. Jeżeli jeszcze nie wiesz co to jest ten cały Composer to zachęcam do przeczytania: [Composer czyli jak zarządzać zależnościami w PHP](https://itcraftsman.pl/composer-czyli-jak-zarzadzac-zaleznosciami-w-php/).

Composer umożliwia w bardzo prosty sposób instalację wybranej biblioteki. Dla przykładu, aby zainstalować [PHPUnit](https://itcraftsman.pl/tdd-w-php-testy-jednostkowe-z-phpunit-krok-po-kroku/) (bibliotekę do testów jednostkowych) wystarczy wydać proste polecenie:

    
    composer require "phpunit/phpunit"

Jak widać, Composer rozpoznaje paczki według podanego schematu **vendor/package**, gdzie vendor to nazwa dostawcy paczki (często to powtórzona nazwa paczki, nazwa organizacji lub login konta na githubie), a package to nazwa samej paczki.


## Packagist

Podstawowym źródłem paczek dla Composera (jego repozytorium) jest [Packagist.org](https://packagist.org/). Serwis ten agreguje publiczne paczki PHP i udostępnia je z za pomocą Composera. Aby nasza paczka lub biblioteka stała się publicznie dostępna musi najpierw zostać dodana do serwisu Packagist.

W tym celu dana biblioteka musi zawierać odpowiedni plik _composer.json,_ oraz być dostępna w publicznym repozytorium na GitHubie (są też inne możliwości). Poniżej przykładowy plik konfiguracyjny dla tworzonej przez mnie biblioteki do Machine Learningu o nazwie PHP-ML:

    
    {
        "name": "php-ai/php-ml",
        "type": "library",
        "description": "PHP Machine Learning library",
        "license": "MIT",
        "keywords": ["machine learning","pattern recognition","computational learning theory","artificial intelligence"],
        "homepage": "https://github.com/php-ai/php-ml",
        "authors": [
            {
                "name": "Arkadiusz Kondas",
                "email": "your@email.address"
            }
        ],
        "autoload": {
            "psr-0": {
                "Phpml": "src/"
            }
        },
        "config": {
            "bin-dir": "bin"
        },
        "require": {
            "php": ">=7.0.0"
        },
        "require-dev": {
            "phpunit/phpunit": "^5.2"
        }
    }
    

W dokumentacja samego Packagista można znaleźć minimalny przykład pliku _composer.json_, który wymaga mniejszego nakładu pracy:
    
    {
        "name": "your-vendor-name/package-name",
        "description": "A short description of what your package does",
        "require": {
            "php": ">=5.3.0",
            "another-vendor/package": "1.*"
        }
    }


Z tak przygotowanym repozytorium zakładamy konto na packagist.org (można do tego użyć githubowego konta) i z menu głównego wybieramy zakładkę "**Submit**". Na stronie pokaże się bardzo prosty formularz:

![Packagist submit](/assets/img/posts/2016/screenshot-packagist.org-2016-04-10-12-57-12.png)

Wystarczy podać adres URL repozytorium i kliknąć w "**Check**", po sprawdzeniu paczki potwierdzamy cały proces klikając w "**Submit**" i nasza biblioteka staje się publiczna. Po dodaniu na stronie packagista zostanie utworzona specjalna podstrona z informacjami o dodanej bibliotece:

![Packagist detail](/assets/img/posts/2016/screenshot-packagist.org-2016-04-10-13-01-30.png)

## GitHub

Za każdym razem jak zaktualizujemy naszą bibliotekę musimy zalogować się na konto w serwisie packagist.org, wybrać naszą paczkę i zlecić jej aktualizacje (button Update). W ten sposób Packagist zaciągnie najnowsze zmiany wprost z GitHuba. Na szczęście ten proces da się zautomatyzować. W tym celu należy w ustawienia repozytorium GitHub dodać nowy serwis, który będzie informował Packagista o zmianach.

Będąc zalogowanym na koncie GitHub, otwieramy repozytorium z biblioteką, wchodzimy w zakładkę "_Settings_", następnie z lewego menu wybieramy "_Webhooks & services_". Z rozwijalnej listy "_Add service_" wybieramy "_Packagist_". Do poprawnej konfiguracji należy podać:

  * User - nazwa użytkownika w serwisie Packagist (podana przy rejestracji)
  * Token - token dostępny po zalogowaniu w Packagist (Profile -> Show API token)
  * Domain -wpisujemy https://packagist.org

Po uzupełnieniu danych i ich zapisaniu, możemy przetestować integracje klikając w "_Test service_" (w nagłówku pola "Services / Manage Packagist" po prawej stronie).

![GitHub test packagist integration](/assets/img/posts/2016/screenshot-github.com-2016-04-10-13-13-54.png)

Od teraz każda zmiana będzie automatycznie zaciągania przez Packagista. Pozostaje jeszcze kwestia wersjonowania naszej biblioteki, ale to sprawa na osobny wpis. Na tym etapie korzystając z polecenia:
    
    composer require php-ai/php-ml

zainstalowana zostanie wersja "dev-master" czyli gałąź "master" z repozytorium Gita. Do zainstalowania kodu z gałęzi develop należy użyć:
    
    composer require php-ai/php-ml "dev-develop"
    
## Przed publikacją

Jak widać publikacja pierwszej biblioteki to bardzo prosta sprawa. Zanim jeszcze zdecydujesz się to zrobić pamiętaj o paru dodatkowych kwestiach.

Nie zapomnij dodać pliku "_LICENSE_" zawierającym pełny tekst licencji na jakiej zasadach publikujesz swoje dzieło. Nie staraj się tworzy niczego nowego, wykorzystaj gotowce lub wybierz odpowiednią na stronie: [https://choosealicense.com/](https://choosealicense.com/). Na przykład przy zakładaniu repo na GitHubie można od razu wybrać automatycznie utworzenie pliku licencji z wybranym jej rodzajem.

Dobrą praktyką jest również umieszczenie pliku "_README_" (lub "_README.md_" w formacie markdown) gdzie krótko i zwięźle napiszemy do czego służy dana paczka, jak ją zainstalować, jak z niej korzystać, jak uruchomić testy oraz typ licencji i kto jest jej autorem. Jeżeli instrukcja obsługi jest obszerna, trzeba się zastanowić, czy nie skorzystać z gotowych serwisów typu: [Read the Docs](https://readthedocs.org/) (w kolejnych wpisach na pewno będą o tym pisał). Inną często spotykaną praktyką jest umieszczenie folderu "_examples_" z licznymi przykładki użycia danej paczki.

Teraz pozostaje już tylko cierpliwe czekanie na pierwszy zgłoszony issue lub nawet lepiej, na pierwszy zgłoszony Pull Request ... :)
