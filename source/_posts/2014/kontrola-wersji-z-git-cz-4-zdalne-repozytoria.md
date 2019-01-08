---
comments: true
date: 2014-09-02 20:24:46+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2014/logo@2x1.png
slug: kontrola-wersji-z-git-cz-4-zdalne-repozytoria
title: Kontrola wersji z Git cz. 4 - zdalne repozytoria
wordpress_id: 366
categories:
- GIT
tags:
- git
- system kontroli wersji
---

Skupimy się teraz na pracy z zdalnymi repozytoriami, które umożliwiają współpracę z innymi osobami. Omówię jak nimi zarządzać oraz jak wypychać własne zmiany na zdalny serwer i pobierać zmiany dokonane przez innych użytkowników.<!-- more -->

Na tym etapie powinieneś już umieć [zatwierdzać zmiany](https://itcraftsman.pl/kontrola-wersji-z-git-cz-2-instalacja-konfiguracja-i-pierwszy-commit/) oraz wiedzieć w [jakim stanie znajdują się pliki](https://itcraftsman.pl/kontrola-wersji-z-git-cz-3-cykl-zycia-plikow/) twojego repozytorium. Jeżeli nie, to polecam moje wcześniejsze wpisy, a jeżeli  zastanawiasz się jeszcze czy warto zabierać się za GIT'a to polecam mój [pierwszy wpis na temat GIT'a](https://itcraftsman.pl/kontrola-wersji-z-git-cz-1-wstep/) w tym cyklu.

Na wstępie chciałbym jeszcze dodać, że jeżeli któraś z niżej opisywanych rzeczy jest dla Ciebie niezrozumiała, to proszę o komentarza pod wpisem, z chęcią pomogę w miarę moich możliwości.


Zdalne repozytoria w gicie służą do współdzielenia pracy. Oczywiście można je również wykorzystać do tworzenia kopii zapasowej własnego lokalnego repozytorium. Każde zdalne repozytorium to tak naprawdę kopia Twojego lokalnego repozytorium ale owinięta z reguły w jakiś mechanizm logowania (autentykacji). Takich repozytoriów przypiętych do naszego lokalnego może być kilka (lub ewentualnie zero) i każde z nich może być tylko do odczytu lub do odczytu i zapisu. Na razie nie opisałem jeszcze gałęzi ani zasad ich działania więc sama praca zdalna powinna wydać się łatwa (i w rzeczywistości taka jest). Zacznijmy od podstawowych poleceń które pozwolą nam zarządzać zdalnymi repozytoriami.




## Dodawanie zdalnych repozytoriów:


W celu dodania zdalnego repozytorium wpisujemy:

```
git remote add [alias] [adres_url]
```

[alias] - to krótka nazwa dodanego repozytorium którą posługujemy się zamiast podawania za każdym razem pełnego adresu
[adres_url] - pełny adres url pod jakim znajduje się zdalne repozytorium

Dodanie zdalnego repozytorium nie powoduje zwrócenia żadnego komunikatu (a szkoda) ale możemy sprawdzić ręcznie czy wpis się dodał, co opisałem w kolejnym punkcie.




## Wyświetlanie listy zdalnych repozytoriów:



```
git remote
```

To polecenie wyświetli nam listę samych dodanych aliasów, co niestety nie za dużo nam mówi. Aby wyświetlić więcej szczegół należy skorzystać z parametru _-v_

```
git remote -v
origin https://github.com/laravel/laravel.git
```

Teraz wygląda to jaśniej. Przy okazji warto wspomnieć, że jako alias naszego głównego tzw. źródłowego repozytorium przyjmuje się nazwę "origin" (z ang. pochodzenie) - taka niepisana zasada, których jest na pewno jeszcze więcej. Nie jest to oczywiście obligatoryjne, równie dobrze można użyć dowolnie innego aliasu. Jeżeli chcemy wyświetlić szczegółowy opis wybranego repozytorium to korzystamy z polecenia _show_:

```
$ git remote show origin
 * remote origin
 Fetch URL: https://itcraftsman@bitbucket.org/test/test.git
 Push URL: https://itcraftsman@bitbucket.org/test/test.git
 HEAD branch: master
 Remote branch:
 master tracked
 Local branch configured for 'git pull':
 master merges with remote master
 Local ref configured for 'git push':
 master pushes to master (up to date)
```

W ten sposób można dowiedzieć się jak przebiegać będzie proces ściągania zmian do nas (co opisałem na samym dole). Dużo zależy tutaj od konfiguracji gałęzi wiec na chwilę obecną nie będę tego szczegółowo opisywał (chcę zrobić osobny wpis na ten temat).




## Edycja i usuwanie


Do edycji i usuwania zdalnych repozytoriów służą kolejno następujące polecenia:

```
git remote rename [alias_z] [alias_na]
```


```
git remote rm [alias_do_usuniecia]
```

Oba polecenia nie zapytają nas czy jesteśmy tego pewni więc radzę używać z rozwagą. Raz wpisane i wywołane polecenie zrobi co ma zrobić.




## Wypychanie zmian do zdalnego repozytorium


Eksport Twoich własnych zmian w kodzie do zdalnego repozytorium nazywamy wypychaniem, co wzięło się zapewne od nazwy komendy "push". W trakcie wypychania naszych zmian musimy określić repozytorium zdalne (jego alias) oraz gałąź na którą zapiszemy nasze zmiany. Na chwilę obecną zakładamy że wszystkie zmiany wypychamy na gałąź główną naszego repozytorium, która zawsze nazywa się "master". Ogólnie polecenie wygląda następująco:

```
git push [alias] [branch]
```

Jeżeli chcemy wypchać zmiany na gałąź główna naszego pierwotnego repozytorium to wpisujemy odpowiednio:

```
git push origin master
```

<div class="shadow-md p-4 bg-yellow-lighter">Wydanie takiego polecenie będzie możliwe tylko w jednym przypadku: musimy posiadać pobrane aktualne wersje plików z tego repozytorium oraz nikt w między czasie nie mógł wgrać swoich własnych zmian.</div>

Jeżeli, w czasie od naszego ostatniego pobrania zmian, ktoś inny dokonał modyfikacji i wrzucił je do naszego zdalnego repozytorium, to próba wypchania lokalnych zmian zakończy się niepowodzeniem. Trzeba będzie najpierw pobrać nowe zmiany, scalić je (czasem automatycznie) a następnie wypchać na serwer.

Najważniejsze zostawiłem na koniec :)




## Zaciąganie zmian z zdalnego repozytorium


Do pełnej obsługi zdalnych repozytoriów potrzebne nam będę dwa polecenie: fetch i pull. Pozwolą one pobrać "wypociny" innych użytkowników.

```
git fetch [alias]
```

W ten sposób pobieramy wszystkie zmiany jakie zostały wykonane (wypchane) na zdalnym repozytorium. Trzeba tutaj zaznaczyć, że zmiany te są tylko pobierane do lokalnego repozytorium (do lokalnych gałęzi). Jeżeli chcemy te zmiany scalić z naszymi to musimy zrobić to ręcznie za pomocą polecenia _merge_. Scalaniem zmian i konfliktami zajmę się w osobnym wpisie.

Ciekawszym rozwiązaniem jest skorzystanie z pull:

```
git pull [alias] [branch]
```

Tym razem potrzebne jest podanie nazwy gałęzi z której pobrane zostaną zmiany. Następnie zaraz po ich pobraniu GIT postara się za nas wykonać całą ciężką pracę i scalić wszystkie zmiany automatycznie. Niestety nie zawsze mu się to udaje i w takim przypadku oznaczy on pliki które spowodowały konflikt. Samym rozwiązywaniem konfliktów, jak wspomniałem powyżej, zajmę się w osobnym wpisie.



W tym momencie znamy już podstawy na tyle aby móc cieszyć się z "rozproszonych" możliwości GIT'a. W kolejnych wpisach zajmę się tematem gałęzi - branches (które są fenomenalnie szybkie), a następnie pochylę się nad sprawą edycji i rozwiązywania konfliktów. Dzięki za poświęcony czas i zapraszam Cię do komentowania (lub też krytykowania).

Zdjęcie z wpisu: [Flickr](https://www.flickr.com/photos/jemimus/66531124) na licencji Creative Commons
