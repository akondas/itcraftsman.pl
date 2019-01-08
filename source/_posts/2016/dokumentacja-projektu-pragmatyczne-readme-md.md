---
comments: true
date: 2016-05-02 21:55:37+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2016/2414864070_b9fec20328_o-300x183.jpg
slug: dokumentacja-projektu-pragmatyczne-readme-md
title: Dokumentacja projektu - pragmatyczne README.md
wordpress_id: 1310
categories:
- Dokumentacja
tags:
- dajsiepoznac
- dajsiepoznac2016
- dokumentacja
- markdown
- open source
- readme
- readme.md
---

Zaczynasz tworzyć lub rozwijać własną bibliotekę ? Uczestniczysz w projekcie open source ? Przeczytaj jak sprawnie i dobrze stworzyć pierwszy opisowy plik README.md, który będzie zalążkiem Twojej przyszłej dokumentacji.<!-- more -->

Tym razem troszkę dłuższy wpis, więc może przydać się kawa :)


## Dlaczego potrzebujesz dokumentację ?

Na okazję tego wpisu miałem gdzieś przygotowanego Twita, ale niestety gdzieś "umknął". Dlatego zacytuję go z pamięci:

>Projekt open source jest warty tyle ile jego dokumentacja

*(autor: nieznany)*

Tym sposobem przejdźmy do omówienia najważniejszych punktów.

**Chcesz aby ludzie używali twojego kodu.**

Upubliczniłeś kod i wydaje ci się, że ludzie będą go używać. Myślisz tak, ponieważ sam go wykorzystujesz. Pytanie jednak brzmi: czy ludzie będą wiedzieć do czego służy Twój kod ? Jakie problemy stara się rozwiązać ? Jak można go "zainstalować" i zacząć z niego korzystać ? Bez odpowiedzi na te pytania ci ludzie się nie znajdą (no chyba, że stworzysz coś ewidentnie fajnego jak na przykład GITa). Jeżeli naprawdę chcesz, aby inni używali Twojego kodu, musisz im wytłumaczyć jak z niego korzystać oraz do czego on służy. Najlepszym miejscem do tego będzie właśnie dokumentacja projektu.

**Chcesz aby Twój kod był lepszy.**

Spisanie tego jak działa Twoja biblioteka, pomoże Ci usystematyzować całość wiedzy i zdobytego doświadczenia. W ten sposób lepiej "ogarniesz" kod i być może przyjdą Ci do głowy pomysł na nowe usprawnienia i/lub funkcjonalności. Zobaczysz też, czy całość jest spójna i tworzy dobry oraz dopracowany komponent.

**Chcesz aby ludzie ci pomagali.**

Jak w każdym produkcie open source, chcesz aby inny mogli uczestniczyć w rozwoju twojego projektu. Bez odpowiedniej dokumentacji nie znajdziesz ochotników. Musisz pokazać programistą jak mogą rozwijać Twój kod, jak uruchomić zestaw testów które sprawdzą czy czegoś nie zepsuli. Możesz również wskazać im zestaw dobrych praktyk (_coding guide_), który Ty stosujesz w tym projekcie (jak na przykład rodzaj wcięć czy klamer).

Jest też inny aspekt tego punktu. Proponowanie zmian czy ulepszeń w dokumentacji jest dla początkujących dużo łatwiejsze niż wprowadzanie zmian w czystym produkcyjnym kodzie. Nie tworząc dokumentacji zamykasz w ten sposób drzwi dla dużej grupy kontrybutorów.

**Chcesz potrafić przypomnieć sobie co potrafi Twój kod.**

W chwili pisania kodu, ciężko jest uwierzyć, że można nie wiedzieć co tu miałem na myśli. Z rozwojem projektu ilość kodu będzie na tyle duża, że nie zdołasz zapamiętać wszystkiego. Możliwe również, że rozpoczniesz pracę na innym projektem o zupełnie innej charakterystyce. Dobrze jest mieć wtedy taką krótką referencję możliwości stworzonej biblioteki. Dodatkowo nie wszystko można wprost wyczytać z kodu źródłowego. Dokumentacja będzie więc świetnym miejscem aby odświeżyć sobie pamięć o poszczególnych częściach projektu i zastosowanych w nim rozwiązaniach czy algorytmach.

**Chcesz podnieść umiejętności pisania.**

Na koniec być może najmniejsza zachęta (lub przypuszczalnie odwrotnie ?). Pisanie technicznej dokumentacji niezaprzeczalnie podniesie Twoje umiejętności pisarskie. Z własnego doświadczenia wiem, że początki są trudne, ale dlatego właśnie prosty plik README to świetne miejsce aby zacząć. Zobaczysz, że z pisaniem dokumentacji jest jak z pisaniem kodu: im będziesz robił to częściej, tym łatwiej będzie Ci to przychodzić. Dodatkowo sprawność pisania technicznych dokumentacji na pewno się przyda w zawodowej karierze.


## README.md na start


Plik README.md to idealne miejscu startu tworzenie dokumentacji (przeczytaj [dlaczego format Markdown](http://itcraftsman.pl/markdown-tworzenie-dokumentacji-projektu/)). Większość systemów hostujących kod źródłowy (np. GitHub czy BitBucket) wyrenderuje plik w formacie Markdown jako stronę główną w HTML. Najczęściej, będzie to również pierwsze miejsce kontaktu innych programistów z Twoim kodem. Wypada więc poświęcić trochę czasu i stworzyć solidne podwaliny. Niektórzy poszli nawet dalej i stworzyli nową technikę zwaną: Readme Driven Development :).

Główni odbiorcy pliku README.md to najczęściej:

  * deweloperzy - będą chcieli wykorzystać Twoją bibliotekę do rozwiązania swojego problemu
  * kontrybutorzy - będą chcieli rozwijać Twoją bibliotekę, najczęściej rozwiązując przy okazji swoje problemy

O czym w takim razie pisać ?

**Tytuł i krótki opis**

Ludzie będą trafiać na stronę projektu z różnych źródeł (np. wyszukiwarek czy samego Githuba). Warto w pierwszych paru zdaniach odpowiedź na pytanie: jaki problem starasz się rozwiązać i dlaczego Twój projekt może pomóc.

Przykład: [https://github.com/Codeception/Codeception](https://github.com/Codeception/Codeception)

**Krótki przykład kodu**

Bardzo fajną praktyką jest, w możliwie krótki sposób, zaprezentowanie działającego fragmentu kodu. Ja osobiście kojarzę właśnie niektóry biblioteki z krótkich przykładów wprost z README.md.

Przykład: [https://github.com/guzzle/guzzle](https://github.com/guzzle/guzzle)

**Informacje dla kontrybutorów**

Napisz krótko co zrobić aby zostać kontrybutorem. Gdzie zgłaszać problemy (issue tracker). Jak uruchamiać zestaw testów. W niektórych projektach można znaleźć całe rozdziały dedykowane dla osób chcących uczestniczyć w rozwoju.

Przykład: [https://github.com/deployphp/deployer](https://github.com/deployphp/deployer)

**Instrukcja instalacji**

Jak w prosty i szybki sposób zainstalować bibliotekę. Najczęściej będzie to jakiś menedżer pakietów (np. w [PHP mamy Composera](http://itcraftsman.pl/composer-czyli-jak-zarzadzac-zaleznosciami-w-php/)). Bardziej złożone sposoby instalacji trzeba umieścić w kompleksowej dokumentacji projektu, ale o tym będzie kolejny wpis.

Przykład: [https://github.com/sebastianbergmann/phpunit](https://github.com/sebastianbergmann/phpunit)

**Najważniejsze elementy**

Jeżeli Twój projekt składa się z większej ilości komponentów, lub rozwiązuje parę problemy, warto umieści krótki spis takich rzeczy. Dodatkowo można od razu je podlinkować do stron z przykładami użycia lub szczegółowej instrukcji.

Przykład: [https://github.com/pattern-lab/patternlab-php](https://github.com/pattern-lab/patternlab-php)

**Licencja i autor**

Nie zapomnij również poinformować innych na jakiej licencji udostępniasz Twój kodu. Nie wymyślaj niczego nowego, zamiast tego skorzystaj z gotowych rozwiązań (a jak nie wiesz jaką licencję wybrać to zerknij na: [http://choosealicense.com/](http://choosealicense.com/)). Na koniec jak się nie wstydzisz możesz wspomnieć kto jest autorem (z czasem może być ich więcej).

Przykład: [https://github.com/Intervention/image](https://github.com/Intervention/image)

## Przykładowy szablon

    # Project title
    
    This project simply solves `this` problem.
    
    Simple code example 
    
    ```php
    use My\Super\Library\Class;
    
    $data = [[1, 3], [1, 4], [2, 4], [3, 1], [4, 1], [4, 2]];
    
    $object = new Class(1, 2, 3)
    $object->makeAwesome($data);
    ```
    
    ## Documentation
    
    To find out how to use this library follow [Documentation](http://link-to-documentation).
    
    ## Installation
    
    You can install it with Composer:
    
    ```
    composer require vendor/project
    ```
    
    ## Features
    
    * Can make this and this
    * Helps with some other problew
    * Is awesome
    
    ## Contribute
    
    * Issue Tracker: github.com/vendor/project/issues
    * Source Code: github.com/vendor/project
    * Tests: phpunit
    
    ## License
    
    This project is released under the MIT Licence. See the bundled LICENSE file for details.
    
    ## Author
    
    John Doe

---

*Zdjęcie z wpisu: [Flickr](https://www.flickr.com/photos/manc/2414864070).*
