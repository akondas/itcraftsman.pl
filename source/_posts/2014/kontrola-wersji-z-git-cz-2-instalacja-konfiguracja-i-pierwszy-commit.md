---
comments: true
date: 2014-07-29 20:09:12+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2014/logo@2x1.png
slug: kontrola-wersji-z-git-cz-2-instalacja-konfiguracja-i-pierwszy-commit
title: Kontrola wersji z Git cz. 2 - instalacja, konfiguracja i pierwszy commit
wordpress_id: 108
categories:
- GIT
tags:
- commit
- git
- system kontroli wersji
---

W tym wpisie zainstalujemy a następnie skonfigurujemy Git do poprawnej pracy. Utworzymy także pierwsze repozytorium i dokonamy pierwszego zatwierdzenia zmian.<!-- more -->


## Instalacja


** Windows**

Pobieramy instalator z [tej strony](http://git-scm.com/download/win). W czasie instalacji, przy kroku "_Adjusting you PATH environment_", wybieramy opcję "_Use Git from the Windows Prompt_". Pozwoli ona używać komend Git'a z normalnego wiersza poleceń (np. cmd.exe). Po instalacji dostępna będzie także powłoka Git'a: Git Bash.

[![git-windows](/assets/img/posts/2014/git-windows.png)](/assets/img/posts/2014/git-windows.png)

W pozostałych krokach zostawiamy domyślne opcje.

**Linux**

W przypadku Linuxowych systemów najlepiej będzie skorzystać z domyślnego dla danej dystrybucji programu do zarządzania pakietami. Dla Ubuntu będzie to przykładowo _apt-get:_

```
apt-get install git
```

** Mac**

Dla komputerów typu Mac możemy skorzystać z graficznego instalatora dostępnego [tutaj](http://sourceforge.net/projects/git-osx-installer/). Inny sposób to instalacja Homebrew (o ile go już nie masz). W tym celu wpisz w terminalu:

```
ruby -e "$(curl -fsSL https://raw.github.com/Homebrew/homebrew/go/install)"
```

Teraz możesz łatwo doinstalowywać dodatkowe pakiety. W celu instalacji Git'a wystarczy wpisać:

```
brew install git
```





Po udanej instalacji, w celu sprawdzenia czy wszystko działa prawidłowo, możemy wpisać w konsoli/wierszu poleceń następujące polecenie:

```
git --version
```

Jeżeli wyświetli się nam odpowiedź w stylu:

```
git version 1.9.4.msysgit.0
```

to wszystko przebiegło prawidłowo i możemy przejść do następnego kroku.




## Konfiguracja


Zaraz po instalacji musimy skonfigurować Git'a aby wszystkie dokonane zmiany były oznaczane naszym imieniem i nazwiskiem (bądź nikiem - jak kto woli) oraz adresem e-mail. W tym celu musimy odpalić dwa polecenia:

```
git config --global user.name "Imię Nazwisko / Nick"
git config --global user.email mojmail@gmail.com
```

Jak łatwo się domyślić pierwszą linią ustawiamy naszą tożsamość a drugą adres e-mail. Dla pewności można wyświetlić zapisane opcje poleceniem:

```
git config --list
```

Czasem może się zdarzyć sytuacja w której pewne zmienne konfiguracyjne będą się powtarzać. Jest to spowodowane faktem że Git odczytuje je najpierw z ścieżek systemowych a następnie z lokalnego repozytorium (jeżeli istnieje). Proponuję wywołać polecenie "git config --list" najpierw w pustym katalogu a następnie w istniejącym repozytorium. Zachęcam do eksperymentowania. W celu wyświetlenia rzeczywistej wartości zmiennej (w przypadku gdy wyświetli nam się więcej niż raz) możemy użyć polecenia "_git config nazwa_zmienne_j":

```
git config user.name
```




## Pierwsze repozytorium


W celu rozpoczęcia śledzenia zmian musimy utworzyć nowe repozytorium lub sklonować istniejące. Na razie zajmiemy się tą pierwszą opcją. Aby utworzyć nowe repozytorium w wybranym folderze musimy uruchomić polecenie:

```
git init
```

Zostaniemy poinformowani o pomyślnym utworzeniu nowego repozytorium. W celu sprawdzenia aktualnego stanu naszego repozytorium używamy polecenia "_git status_". Będzie to jedno z częściej używanych poleceń, więc szybko wejdzie ci w nawyk. Wywołajmy teraz polecenie "_git status_" na nowo utworzonym repozytorium:

```
git status
On branch master

Initial commit

nothing to commit (create/copy files and use "git add" to track)
```

Jak widać świeżo utworzone repozytorium jest puste. Zauważmy że Git od razu proponuje nam dodanie nowych plików :) Dodajmy teraz dowolny plik i ponownie odpalmy polecenie "_git status_":

```
git status
On branch master

Initial commit

Untracked files:
  (use "git add <file>..." to include in what will be committed)

	README.md

nothing added to commit but untracked files present (use "git add" to track)
```

W wyniku wywołania polecenia zostajemy poinformowanie że istnieje nowy plik "README.md", który nie jest śledzony (jego zmiany nie będą wersjonowane). Aby dodać nasz plik do kontroli wersji skorzystamy z polecenia "_git add_", a następnie ponownie sprawdzimy stan przy pomocy "_git status_":

```
git add README.md
git status
```

Tym razem otrzymamy:

```
On branch master

Initial commit

Changes to be committed:
  (use "git rm --cached <file>..." to unstage)

	new file:   README.md
```

Git informuje nas że plik "README.md" jest przygotowany do wykonania operacji zatwierdzenia zmian (commit). Oznacza to że w chwili obecnej znajduje się on w poczekalni i przy najbliższym zatwierdzeniu zostanie dodany do kontroli wersji. Samą poczekalnią zajmiemy się w osobnym wpisie. Na chwilę obecną wystarczy wiedzieć o tym, że plik w poczekalni również jest śledzony (lokalnie) ale nie został jeszcze zatwierdzony.




## Zatwierdzanie zmian


W chwili gdy w poczekalni znajdują się już pliki możemy przejść do zatwierdzenia zmian. Najprościej wykonujemy je przy pomocy polecenia "_git commit_" z parametrem -m, który pozwala od razu podać krótki komentarza:

```
git commit -m "Dodanie pliku pomocy"
```

W odpowiedzi otrzymamy:

```
[master (root-commit) 6020d2e] Dodanie pliku pomocy
 1 file changed, 0 insertions(+), 0 deletions(-)
 create mode 100644 README.md
```

W ten sposób nasze zmiany zostały zatwierdzone a plik dodany do kontroli wersji. Pamiętajmy że zmiany zostały na razie zapisane tylko na lokalnej maszynie w lokalnym repozytorium. Wypychaniem zmian na serwer zajmiemy się w osobnym wpisie.




## Zatwierdzanie bez poczekalni


Istnieje sposób zatwierdzania zmian bez dodawania plików za każdym razem do poczekalni. Wystarczy wywołać polecenie "_git commit_" z parametrem -a. Niestety w ten sposób możemy zatwierdzić zmiany tylko w plikach już śledzonych. Natomiast pliki nowo dodane, które jeszcze nie znajdują się pod kontrolą wersji, musimy dodać przez polecenie "_git add_".

```
git commit -a -m "Opis zmian"
```

W celu dodaniach wszystkich nowych plików (oraz tych zmodyfikowanych) możemy skorzystać jeszcze z polecenia "git add" dodając znak "." na końcu. W ten sposób dodamy wszystkie nowe pliki (oraz te zmodyfikowane) do poczekalni:

```
git add .
```

Po takim poleceniu pozostaje nam już tylko zatwierdzenie zmian z stosownym komentarzem.



Na chwilę obecną to wszystko. Chciałem skupić się w tym wpisie na samej instalacji i konfiguracji, ale w trakcie pisania stwierdziłem, że pokaże jeszcze na szybko jak wykonać pierwszego commit'a. W następnym wpisie skupię się szczegółowo na całym cyklu życia plików poddawanych kontroli wersji.

Na koniec przyszła mi do głowy jeszcze jedna myśl: czy dodatkowo chciałbyś mieć możliwość obejrzenia powyższego wpisu w formie screencastu ? Jeżeli tak, to daj mi znać w komentarzu. Inne uwagi/komentarze również są mile widziane.
