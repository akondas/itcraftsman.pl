---

comments: true
date: 2014-10-28 21:41:16+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2014/3945656390_2d78b9c0b1_b-300x200.jpg
slug: tdd-w-php-wprowadzenie-do-test-driven-development
title: 'TDD w PHP: Wprowadzenie do test-driven development'
wordpress_id: 720
categories:
- PHP
- TDD
tags:
- php
- phpunit
- tdd
---

Wpis ten to wprowadzenie do serii na temat TDD w świecie PHP. Postaram się przedstawić techniki, które na chwilę obecną stosuje niewielki procent programistów. Pomogą one wejść Tobie na wyższy poziom programowania.<!-- more -->

Może Cię to zaskoczyć, ale na pewno Ty już testujesz swój kod. Nie zawsze są to testy jednostkowe, z reguły mają inną nazwę. Nie zawsze są to też testy automatyczne. Z tego powodu nie nazywasz tego testami. Jednak na pewno piszesz kod, by po chwili sprawdzić jego działanie w przeglądarce. Czy to właśnie nie jest testowanie ? Co powiesz na to aby ten proces zautomatyzować ? Czy nie lepiej, aby za każdym razem gdy zmienisz coś w kodzie, jakaś automatyczna mała armia krasnali testowała twój kod za Ciebie ?

Na początku zacznijmy od definicji, czym jest samo TDD (źródło: [wikipedia](https://pl.wikipedia.org/wiki/Test-driven_development)):


> Programowanie techniką test-driven development wyróżnia się tym, że najpierw programista zaczyna od pisania testów do funkcjonalności, która jeszcze nie została napisana. Na początku testy mogą nawet się nie kompilować, ponieważ może nie być jeszcze elementów kodu (metod, klas) które są w testach użyte.


Tak więc w założeniu: najpierw piszemy test który nie przechodzi/nie zdaje (potocznie mówi się czerwony). Następnie piszemy dowolny kod który taki test przechodzi (zielony). Potem poprawiam lub ulepszamy (refactor). Całość powtarzamy: red-green-refactor. Kiedy przestać ? Tego nikt nie wie, musisz ocenić to sam :)

Fakt: wygląda to strasznie, nudno i czasochłonnie. Moim zdaniem nie zawsze tak musi być. Nie zawsze musimy traktować spisane reguły dosłownie. Czasem warto najpierw napisać kod, a dopiero później test który go sprawdza. Ok, zastanówmy się teraz dlaczego warto poświęcić czas na ten temat (technikę).

<div class="shadow-md p-4 bg-yellow-lighter">
    Pamiętaj: TDD to tylko kolejne narzędzie w Twoim warsztacie, ma służyć tobie a nie ty jemu. Wielu programistów o tym zapomina.
</div>


## Dlaczego warto stosować TDD ?

Trudno wskazać jednoznacznie. Wprawdzie Bob Martin mówi dosadnie:

>It has become infeasible for a software developer to consider himself professional if he does not practice test-driven development.”


Nie należy jednak brać tego dosłownie. Niemniej słowa wujka Boba na pewno o czymś świadczą. Na całość składa się kilka następujących punktów:

**Mniejsza liczba błędów**

Na początku musisz wiedzieć, że stosowanie TDD na pewno nie wyeliminuje 100% błędów. Nie da pokryć się testami wszystkiego (albo może się da, tylko wtedy więcej czasu zajmie testowanie kodu niż pisanie go, a tego chcielibyśmy uniknąć). Jednakże, stosując TDD w praktyce, masz szansę znacząco zmniejszyć ilość błędów.

**Łatwiejsze odtwarzanie sytuacji powodujących błędy**

Skoro Twój kod jest pokryty testami, posiadasz szereg metod/funkcji pomocniczych, które pomogą ci w łatwy i szybki sposób odtworzyć sytuację w której dany błąd powstał. W ten sposób będziesz mógł lepiej analizować swój kod.

**Naprawiaj błędy nie tworząc nowych**

Kto z Was nie miał klasycznego przypadku: naprawiamy błąd, wrzucamy na produkcję i ... powstaje 10 kolejnych błędów. Testując swój kod będziesz w stanie sprawdzić czy Twoja "poprawka" nie wniesie do systemu nieporządanych efektów. Co najważniejsze: będziesz mógł to zrobić za każdym razem i do tego w pełni automatycznie.

**Poprawa architektury**

Nie ma co ukrywać, zaczynając stosować TDD i pisać kod będziesz się zastanawiał: jak mogę go przetestować. Z tego punktu widzenia szybko zaczniesz zwracać na aspekty architektury o których wcześniej nie miałeś pojęcia. Pisząc kod testowalny zapewnisz sobie lepsze uporządkowanie struktur oraz przestaniesz używać metody "kopiuj - wklej". Postaram się ten punkt rozwinąć bardziej w innym wpisie.

**Spokojny sen**

Ten punkt jest trochę na siłę, ale jest bardziej taki osobisty. Ostatnio czytałem gdzieś, że zakupy w sieci dokonywane są często w godzina rannych (pewnie w pracy) oraz późną nocą (z doświadczenia mogę potwierdzić). Twój nowiutki skrypt sprzedaży właśnie został wrzucony na serwer ? Chcesz spokojnie przespać noc ?  Spokojnie, system pokryty testami zapewni Ci bezpieczny sen (teoretycznie) lub zasłużony relaks.

**Fajna zabawa**

Dla tych których lubią grywalizację, testowanie może być swego rodzaju ciekawą zabawą. Piszesz testy, potem kod. Sprawdzasz, czy tym razem uda się przejść po zielonym, a może jednak będzie czerwony. W pewnym sensie można cały ten proces potraktować jak grę, w której graczem jest Twój własny kod.



[![2062037429_3b787ed33a_b](/assets/img/posts/2014/2062037429_3b787ed33a_b.jpg)](/assets/img/posts/2014/2062037429_3b787ed33a_b.jpg)


## Dlaczego nie zawsze warto stosować TDD ?


No dobra, są takie sytuacje w których TDD faktycznie się nie sprawdza, choć na pewno znajdą się na sali puryści którzy temu zaprzeczą.

**Inwestycja w naukę**

Dla małych lub nieskomplikowanych projektów barierą wejścia w TDD może być czas potrzebny na naukę i opanowanie techniki. Choć dla większości wydawać się może, że testy nie są potrzebne, to **w internecie istnieje masa badań udowadniających fakt, że TDD skraca czas tworzenia aplikacji**. Trzeba sobie też przeliczyć co zajmie dłużej: nauka i wdrożenie TDD, czy szybkie wykonanie zlecenia, ale ciągłe poprawianie bugów. Są przypadki gdzie nawet tak druga opcja będzie bardziej opłacalna.

**Dodatkowe złożoność**

Z czasem, gdy projekt się rozrośnie, ilość (także rodzaj) przeprowadzanych testów może bardzo spowolnić lub utrudnić rozwijanie aplikacji. Znane są przypadki gdzie zmiana jednej linii kodu potrafi "zrodzić" potrzebę przepisania 300 pojedynczych testów.

**Przetestowanie**

Co za dużo to nie zdrowo. Ja wszędzie, tak również w testach potrzeba zachować jakiś balans, który w tym przypadku trudno jest jednoznacznie opisać. Każdy musi sam (lub ze swoją drużyną/ekipą) zdecydować czego nie testujemy. Testowanie takich prostych metod jak setXXX czy getXXX na pewno nie ma sensu (no chyba, że robisz tam jakieś skomplikowane obliczenia).




## Terminologia


W środowisku programiści posługuję się pewnym nazewnictwem, które nie zawsze jest zgodne z tym co myślą. Zobaczmy, na tzw. żargon testowy:

**Testy jednostkowe**

Są to najbardziej liczne testy. Test jednostkowy powinien sprawdzać jedną konkretną funkcjonalność w obrębie jednej klasy (jednostki) stąd jego nazwa. Nie zawsze musi dotyczyć jednej metody, ale powinien pozostać w zakresie testowanej klasy. Testowanie jednej klasy ułatwia proces wykrywania błędów - będziesz dokładnie wiedział gdzie go szukać, oraz pozwala na pełną automatyzację. Testy jednostkowe powinny być przeprowadzane w izolacji - jeżeli dana klasa potrzebuje innych do swojego działania należy je emulować (więcej o emulacji możesz przeczytać w wpisie: [Testy jednostkowe z PHPUnit oraz Mockery](https://webmastah.pl/testy-jednostkowe-z-phpunit-oraz-mockery/)).

**Testy integracyjne**

Test integracyjny jest w pewnym sensie czymś odwrotny od testu jednostkowego. Jeżeli test jednostkowy testuje tylko jedną jednostkę to test integracyjny sprawdza całe gotowe elementy systemu. Inaczej mówiąc: jeżeli dla przykładu test jednostkowy testuje zapłon, akumulator i silnik, to test integracyjny sprawdzi czy te elementy zadziałają razem. Z reguły, pisze się je, już po wykonaniu konkretnego fragmentu systemu, który może działać samodzielnie. Testy jednostkowe mogą trwać długo i mogą być powodem kilku awarii jednocześnie (inaczej niż jednostka).

**Testy funkcjonalne**

Testują one całe fragmenty gotowego systemu. Są one sprawdzeniem czy napisany kod robi to czego oczekuje od niego twórca. Od testów integracyjnych różni je to, że z reguły odpalane są z zewnątrz. Typowym przykładem testu funkcjonalnego będzie sprawdzenie czy dany kontroler wykonuje wszystkie swoje akcje poprawnie (np. zapis i odczyt produktów z bazy). Testowany kod powinien być uruchamiany jak normalna aplikacja (a nie tylko wybrany jej fragment czy specjalnie przygotowany bootstrap).

**Testy akceptacyjne**

Ten rodzaj testów nie podlega automatyzacji (przynajmniej ja się nie spotkałem). Test akceptacyjny sprawdza czy wykonane oprogramowanie spełnia wymagania klienta (zamawiającego). Popularna nazwa na takie testy to: testy alpha lub beta.



Na wstępie to tyle teorii. Następny wpis poświęcę już praktyce i konkretnemu narzędziu do testów jednostkowych - PHPUnit. Opiszę od podstaw jak korzystać z jego dobrodziejstw. Jeżeli masz jakieś pytanie do TDD napisz komentarz - postaram się pomóc. Zastanawiam się przy okazji, czy taka długość wpisów Wam odpowiada ? Za krótkie, za długie czy w sam raz ?

Zaciekawił Cię ten temat ? Uważasz ten wpis za przydatny ? Podziel się tym w komentarzu lub udostępnij znajomym.

Zdjęcia z wpisu: [Flickr](https://www.flickr.com/photos/eivindw/2062037429), [Flickr](https://www.flickr.com/photos/dahlstroms/3945656390).
