---
comments: true
date: 2016-04-17 16:36:18+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2016/travis.png
slug: ciagla-integracja-i-travis-ci
title: Ciągła integracja i Travis CI
wordpress_id: 1294
categories:
- Automatyzacja
- Programowanie
tags:
- automatyzacja
- ciągła integracja
- continuous integration
- dajsiepoznac
- dajsiepoznac2016
- testy jednostkowe
- travis
---

W tym wpisie odpowiemy na pytania: co to jest ciągła integracja oraz jak wykonywać ją sprawnie z pomocą usługi Travis CI.<!-- more -->

**Ciągła integracja** (z ang. Continuous Integration) to:


> Praktyka stosowana w trakcie rozwoju oprogramowania, polegająca na częstym, regularnym włączaniu (integracji) bieżących zmian w kodzie do głównego repozytorium. W praktyce, każdy członek zespołu programistycznego powinien przynajmniej raz dziennie umieścić wykonaną przez siebie pracę w repozytorium. Niezbędnym elementem jest także zapewnienie poprawności kompilacji kodu po wykonaniu integracji. (źródło: [wikipedia](https://pl.wikipedia.org/wiki/Ci%C4%85g%C5%82a_integracja))


Sama kompilacja nie jest wystarczająca. Najlepszym sposobem na zapewnienie sobie pewności, co do poprawności kodu, są **testy automatyczne**. Jeżeli Twój kod ich nie posiada to zachęcam do ich napisania.


## Travis CI


**[Travis CI](https://travis-ci.com)** to serwisu typu FOSS (_free and open-source software_), który pozwala na budowanie, testowanie i wdrażanie (_deploy_) projektów hostowanych na GitHubie. Jest całkowicie bezpłatny dla repozytoriów publicznych. Dla prywatnych repo istnieje opcja wykupienia abonamentu.

Funkcjonalność Travisa nie ogranicza się tylko do języków skryptowych. W zasadzie istnieje możliwość konfiguracji projektów w większości popularnych językach programowania.

Funkcjonalność Travisa możemy podzielić na dwa główne przebiegi.

**Branch build flow**
 	
  * nowy kod wypychany jest do repozytorium na GitHubie
  * GitHub inicjuje nowy build
  * Travis buduje i testuje nowy kod
  * testy przechodzą, Travis umieszcza kod na serwerze
  * Travis informuje Twój zespół o pomyślnych testach i wdrożeniu (np. e-mail lub Slack)

**Pull request build flow**

  * powstaje nowy Pull request na GitHubie
  * GitHub inicjuje nowy build (jeżeli PR można złączyć)
  * testy przechodzą, Travis informuje GitHuba i aktualizowany jest status PR
  * powstały PR jest złączany (merge) z gałęzią docelową

Zakładając konto na serwisie travis-ci.com logujemy się poprzez GitHub i autoryzujemy Travisa. W ten sposób możliwe będzie łatwe zaciąganie repozytoriów do Travisa. Jednocześnie Travis sam odpowiednio skonfiguruje repozytoria GitHubowe. Sama rejestracja i integracja to jednak za mało.

## Konfiguracja repozytorium

Jeżeli chcemy zagonić do współpracy Travisa, musimy mu jakoś powiedzieć, jak nasz projekt jest budowany i testowany. W tym celu trzeba utworzyć plik _.travis.yml_ w głównym katalogu repozytorium. Przykładowy plik do projektu opartego na PHP:

```yaml    
language: php
php:
  - '5.5'
  - '5.6'
  - '7.0'
  - hhvm
before_script: composer install
script: bin/phpunit
```

Pierwsza linia to wskazanie języka. Następnie określamy na jakich wersjach PHP mają być przeprowadzone testy. Można wpisać kilka, wtedy Travis przeprowadzi test dla każdej z osobna. Następnie mamy polecenie _before_script_, które uruchomi się bezpośrednio przed testem (w naszym przypadku będzie to instalacja zależności przez Composera). Ostatnia linijka to uruchomienie testów (phpunit).

Jeżeli ciekawi Cię konfiguracja dla innych języków sprawdź dokumentację: [https://docs.travis-ci.com/user/languages](https://docs.travis-ci.com/user/languages)

![Travis CI overview](/assets/img/posts/2016/Selection_003.png)


## Nowy branch lub Pull request


Sprawdźmy teraz jak poprawnie zintegrowany Travis może pomóc w ciągłej integracji kodu. Wprowadźmy celowo błąd w kodzie projektu, który spowoduje błąd w testach:

    
```
FAILURES!
Tests: 39, Assertions: 69, Failures: 3.
```


Następnie komitujemy zmiany i wysyłamy je do repo na nowy branch:

    
```
git commit -a -m "some bug in code"
git checkout -b t-123-distance
git push origin t-123-distance
```


Zobaczmy teraz, jak wyglądają takie gałęzie w repozytorium GitHuba:

![git branches travis error](/assets/img/posts/2016/Selection_002.png)

Widzimy mały czerwony krzyżyk, po najechaniu pojawia się informacja, że dany branch nie przechodzi testów.

Teraz podejście z innej strony czyli nowy Pull request (możemy go stworzyć od razu z nowo powstałej gałęzi_ t-123-distance_). Po utworzeniu nowego PR, Travis przystępuje automatycznie do pracy i sprawdza co się stanie w przypadku złączanie kodu z docelowym branchem:

![pull request build fail ](/assets/img/posts/2016/Selection_001.png)


**Czy to wszystko ?**

Nie, Travis pozwala również na automatyzację procesu wdrażania nowego kodu na serwery (np. produkcyjne). Ciekawych zachęcam do odwiedzenia dokumentacji:[ https://docs.travis-ci.com/user/deployment](https://docs.travis-ci.com/user/deployment). Na dzień dzisiejszy znajdziemy tam 29 różnych integracji oraz dodatkowo możliwość stworzenie niestandardowego skryptu (np. wrzucenie kodu przez FTP).
