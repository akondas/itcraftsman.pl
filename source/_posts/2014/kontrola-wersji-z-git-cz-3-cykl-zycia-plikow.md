---

comments: true
date: 2014-08-16 19:15:03+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2014/logo@2x1.png
slug: kontrola-wersji-z-git-cz-3-cykl-zycia-plikow
title: Kontrola wersji z Git cz. 3 - cykl życia plików
wordpress_id: 291
categories:
- GIT
tags:
- git
- system kontroli wersji
---

Wiemy już jak stworzyć nowe repozytorium oraz jak zatwierdź pierwsze zmiany. Przyjrzyjmy się teraz w jakich stanach mogą znajdować się pliki poddane kontroli wersji.<!-- more -->

[![Cykl życia plików - GIT](/assets/img/posts/2014/git-lifecycle.png)](/assets/img/posts/2014/git-lifecycle.png)

Każdy plik w katalogu który poddany jest kontroli wersji może być śledzony lub nieśledzony. Pliki śledzone to te które zostały już dodane do repozytorium poprzez wywołanie _git add_ a następnie _git commit_. Dzielimy je na zmodyfikowane, niezmodyfikowane lub oczekujące w poczekalni. Reszta plików w katalogu to pliki nieśledzone - czyli takie, które nie zostały poddane kontroli wersji.

Podczas zmiany pliku który jest już śledzony Git oznacza ten plik jako zmodyfikowany. Zmodyfikowany plik przed zatwierdzeniem należy dodać do poczekalni (lub od razu wywołać _git commit_ z parametrem _-a_ który pomija poczekalnię, więcej [tutaj](https://itcraftsman.pl/kontrola-wersji-z-git-cz-2-instalacja-konfiguracja-i-pierwszy-commit/)). Po zatwierdzeniu zmian i ponownej modyfikacji cały proces powtarza się ponownie.

**Status plików w repozytorium**

W poprzednim wpisie przedstawiłem już tą komendę, ale krótkie przypomnienie: w celu sprawdzenia aktualnego stanu plików w katalog wywołujemy polecenie _git status_:

```bash
$ git status
On branch master
nothing to commit, working directory clean
```

W powyższym przykładzie widzimy że pracujemy na gałęzi master oraz nie ma żadnych oczekujących zmian do zatwierdzenia. Polecam dodanie kilku plików i wykonanie ponownie tego polecanie w celu sprawdzenia co tym razem otrzymamy.

**Dodawanie nowych plików**

Aby dodać nowy plik do kontroli wersji wykonujemy polecenie _git add nazwa_pliku_. Teraz po wykonaniu _git status_ zobaczymy że nasz pliki widnieje pod statusem "_Changes to be committed_":

```bash
$ git status
On branch master
Changes to be committed:
  (use "git reset HEAD <file>..." to unstage)

	new file:   index.php
```

W tym momencie plik index.php został przeniesiony do poczekalni.

[alert-announce]Do poczekalni nie został dodany sam plik, tylko migawka pliku z obecnego momentu.[/alert-announce]

Jeżeli przed zatwierdzeniem zmian ponownie zmodyfikujemy plik _index.php_ to po wywołaniu _git status_ zobaczymy:

```bash
$ git status
On branch master
Changes to be committed:
  (use "git reset HEAD <file>..." to unstage)

	new file:   index.php

Changes not staged for commit:
  (use "git add <file>..." to update what will be committed)
  (use "git checkout -- <file>..." to discard changes in working directory)

	modified:   index.php
```

Oznacza to, że jeżeli chcemy aby nowe zmiany zostały dodanego do poczekalni, musimy ponownie wywołać _git add_. W innym przypadku po zatwierdzeniu zmian do historii trafi wersja z przed edycji.

**Dodawanie zmodyfikowanych plików**

Okazuje się że polecenie _git add_ dodaje również do poczekalni pliki znajdujące się pod kontrolą wersji, które zostały zmodyfikowane. Warto wspomnieć tutaj o możliwości dodanie wszystkich nowych i zmodyfikowanych plików jednym poleceniem:

```bash
$ git add .
```

**Zatwierdzanie zmian**

Zatwierdzanie zmian zostało już opisane w poprzednim wpisie dostępny [tutaj](https://itcraftsman.pl/kontrola-wersji-z-git-cz-2-instalacja-konfiguracja-i-pierwszy-commit/).

**Usuwanie plików**

Do usuwania plików wykorzystujemy polecenie _git rm_.

[alert-announce]Wywołanie _git rm_ spowoduje **trwałe usunięcie pliku z dysku twardego** oraz oznaczenie go jako usuniętego (Changes to be committed).[/alert-announce]

Dopiero zatwierdzenie zmian (_git commit_) spowoduje usunięcie go z kontroli wersji. Istnieje możliwość zachowanie pliku na lokalnym dysku poprzez dodanie parametru_ --cached_

```bash
$ git rm --cached index.php
rm 'index.php'
```

**Przenoszenie plików**

W GIT'cie nie ma możliwości bezpośredniego przeniesienia plików, istnieje jednak mechanizm który ułatwie tego typu operacje. Polecenie _git mv_ posłuży nam do zmiany nazwy pliku lub zmiany jego lokalizacji. Poniżej przykład:

```bash
$ git mv index.php default.php

$ git status
On branch master
Changes to be committed:
  (use "git reset HEAD <file>..." to unstage)

	renamed:    index.php -> default.php

Changes not staged for commit:
  (use "git add <file>..." to update what will be committed)
  (use "git checkout -- <file>..." to discard changes in working directory)

	modified:   default.php
```

W ten sposób zmieniamy plik_ index.php_ na_ default.php_. Teraz wystarczy zatwierdzić zmiany i gotowe.

**Ignorowanie plików**

Na końcu warto wspomnieć jeszcze o mechanizmie ignorowania plików.  Czasami nie chcemy aby pewne pliki były poddane kontroli wersji np. pliki logów lub cache. W tym celu jeszcze przed rozpoczęciem prac nad repozytorium warto utowrzyć plik _.gitignore_, który będzie zawierał definicję plików ignorowanych, które zostaną pominięte przy sprawdzania stanu repozytorium. Przykładowy plik .gitignore:

```
/bootstrap/compiled.php
/vendor
composer.phar
composer.lock
.env.*.php
.env.php
```

Każda definicja/wzorzec powinien znajdować się w osobnym wierszu. Ogólne zasady formatowana pliku ._gitignore_:


  * linia zaczynająca się od znaku # jest komentarzem
  * możemy stosować wyrażenia przetwarzania katalogów zgodnie z tymi z konsoli (np. znak * oznacza dowolny znak)
  * dodanie ostatniego znaku "/" oznacza wskazanie katalogu
  * istnieje możliwość negowania definicji poprzez wstawienie znaku "!" na początku

To wszystko w dzisiejszym artykule. W kolejnym wpisie przerobimy temat zdalnych repozytoriów. Dziękuję za poświęconą uwagę oraz zapraszam do komentowania.
