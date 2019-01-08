---
comments: true
date: 2016-05-08 10:44:25+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2016/test-986935_1280-300x225.jpg
slug: code-coverage-w-testach-jednostkowych
title: Code Coverage w testach jednostkowych
wordpress_id: 1361
categories:
- TDD
tags:
- code coverage
- dajsiepoznac
- dajsiepoznac2016
- phpunit
- tdd
---

Parę informacji na temat Code Coverage w testach jednostkowych. Co oznaczają poszczególne metryki i jak je interpretować. Całość głównie pod kątem PHPUnit.<!-- more -->


## Co to jest Code Coverage ?


Code Coverage (czasem spotykany również pod nazwą Test Coverage) to miara używana do opisania stopnia, do którego kod źródłowy programu jest testowany przez konkretny zestaw testowy (test suit). Program o wysokim poziome pokryciu kodu został gruntownie przetestowany i ma mniejszą szansę zawierać błędy niż program z niskim pokryciem kodu.

To w teorii. W praktyce trzeba pamiętać, że Code Coverage to **nie jest wskaźnik jakości** kodu czy testów jednostkowych. Bardziej powinien służyć do odnajdywania słabych, nieprzetestowanych fragmentów kodu. Wskaźnik pokrycia powinien służyć programistą, a nie być celem samym w sobie.

Pokrycie na poziomie 100% może być podejrzane. Istnieje obawa, że testy były pisane tylko w taki sposób aby osiągnąć te 100% i będą słabej jakości. Przy dobrych testach i dobrym pokryciu kodu zajdą dwa zauważalne zjawiska:

  * błędów w środowisku produkcyjnym będzie bardzo mało
  * nie będziesz bał się wprowadzić zmian w kodzie obawiają się, że spowoduje to błędy na produkcji

Przykładowy raport Code Coverage wygenerowany przy użyciu PHPUnit:

![code-coverage](/assets/img/posts/2016/code-coverage.png)

Po lewej stronie mamy nazwy katalogów z kodem źródłowym, po prawej poszczególne metryki. Na raporcie można przeglądać również poszczególne klasy, metody i linie kodu.


## Metryki Code Coverage


Istnieją różne metryki do pomiaru pokrycia kodu źródłowego:

**Line Coverage**

Wskaźnik pokrycia linii. Zliczamy ilość linii kodu, który został uruchomiony na skutek testów, a następnie dzielmy przez ilość wszystkich linii. Oczywiście liczone są tylko linie, które są wykonywalne (otwarcia klamr "{" lub komentarze są automatycznie wycinane).

**Function and Method Coverage**

Wskaźnik pokrycia funkcji i metod klas. Analogicznie jak w przypadku linii. Funkcja lub metoda uznawana jest za pokrytą tylko wtedy, gdy wszystkie jej linie wykonywalne zostały pokryte.

**Class and Trait Coverage**

Wskaźnik pokrycia klas i traitów (więcej o [Traits w PHP](http://itcraftsman.pl/jak-korzystac-z-traits-w-php/)). Tak samo jak w powyższych przypadkach. Klasa lub trait uznawany jest za pokryty tylko wtedy, gdy wszystkie jej/jego metody zostały pokryte.

**Change Risk Anti-Patterns (CRAP) Index**

Indeks ryzyka zmian w kodzie. Liczony na podstawie [złożoności cyklometrycznej](https://pl.wikipedia.org/wiki/Z%C5%82o%C5%BCono%C5%9B%C4%87_cyklomatyczna) i stopnia pokrycia kodu danej jednostki (metody lub klasy). Kod, który nie jest zbyt skomplikowany i ma odpowiednie pokrycie będzie miał niski indeks CRAP. Indeks CRAP można obniżyć poprzez pisanie testów i refaktoryzację kodu w celu obniżenia jego złożoność.


Dla bardziej ciekawskich polecam szersze opracowanie tego tematu w artykule: [How to Misuse Code Coverage](http://www.exampler.com/testing-com/writings/coverage.pdf). W następnym wpisie przygotuję krótki przewodnik krok po kroku ja generować raporty Code Coverage przy użyciu PHPUnita.
