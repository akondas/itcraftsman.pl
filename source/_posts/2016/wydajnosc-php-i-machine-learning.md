---
comments: true
date: 2016-04-03 21:54:05+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2016/iris_scatter-1.png
slug: wydajnosc-php-i-machine-learning
title: Wydajność PHP i Machine Learning
wordpress_id: 1253
categories:
- Machine Learning
- PHP
tags:
- benchmark
- dajsiepoznac
- dajsiepoznac2016
- machine learning
- performance
- php
- php7
- python
- systemy uczące się
- wydajność
---

W tym krótkim wpisie sprawdzimy, czy pod kątem wydajności, PHP nadaje się do Machine Learningu.<!-- more -->

Inspiracją dla tego wpisu był artykuł pt. "[Is PHP Now Suitable For Machine Learning?](https://medium.com/@syntheticmatt/is-php-now-suitable-for-machine-learning-a24e0f3233ac#.bg5tvd6qz)". Z mojej strony przeprowadziłem osobiste testy za pomocą wspomnianego [repozytorium](https://github.com/syntheticminds/php7-ml-comparison), oraz dodałem parę drobnych zmian (dla których stworzyłem [Pull Request](https://github.com/syntheticminds/php7-ml-comparison/pull/1)).


## Benchmark


Do testowania napisana została prosta klasa, która stosuje [algorytmu k-średnich](http://itcraftsman.pl/algorytm-k-srednich-uczenie-nienadzorowane/) na zbiorze Irysów ([co to są zbiory danych ](http://itcraftsman.pl/ogolnodostepne-zbiory-danych-do-machine-learningu/)?). Jedyna różnica polega na tym, że w tym przypadku mamy klasyfikację, a nie klasteryzację. Całość została bardzo uproszczona i sprowadza się do odszukania najbliższego punktu dla szukanej klasy. Uruchomiony test zawsze będzie przeprowadzał te same operacje (w pętli). W ten sposób możemy skupić się tylko i wyłącznie na operacjach CPU. Będziemy zliczać ilość klasyfikacji jaką uda się osiągnąć w ciągu 30 sekund.

Do testów użyłem mojego laptopa o następującej konfiguracji: 8GB RAM i procesor Intel i7 @ 2.40GHz × 8.


## Wyniki


**Interpretatory:**

W pierwszej kolejności testujemy języki interpretowalne. W wspomnianym repozytorium odnajdziemy dwa przykłady napisane w PHP i Pythonie. Dodatkowo możemy porównać wydajność  interpretatorów między wersjami, co wygląda bardzo ciekawie:

![](/assets/img/posts/2016/php-ml-1-1.png)

Ewidentnie widać poprawę wydajność PHP w wersji 7. Intrygujący wydaje się też spadek wydajności w najnowszej wersji Pythona (za pewne eksperci tego języka będą potrafili odpowiedzieć na pytanie skąd ta różnica?).

**Kompilatory Just-In-Time:**

Teraz bardzo podobny test ale z dodatkową mocą JITa. Oryginalnie w repo znajdują się poprzednie przykłady, więc dla dodatkowego porównania dopisałem przykład w JavaScript. Jak widać silnik V8 radzi sobie nie najgorzej.

![](/assets/img/posts/2016/php-ml-2-1.png)

**Szach mat:**

Wszystko mogło by wyglądać bardzo kolorowo, ale nie zapominajmy o sile języków kompilowanych. Dodajmy do porównania benchmark napisany w Javie:

![](/assets/img/posts/2016/php-ml-3-1.png)

Jak widać Java z wynikiem 23 milionów instancji (700 tysięcy na sekundę !) deklasuje rywali.


## Wnioski


Jak pokazuje powyższy eksperyment, PHP ma całkiem dobre zadatki, aby stosować w nim Machine Learning. Niestety na ten moment nie ma żadnego dobrego i stabilnego rozwiązania, które można by używać produkcyjne. Przykładowo Python posiada jeden z lepszych pakietów do ML: [scikit-learn](http://scikit-learn.org/stable/). Być może doczekamy się jakiegoś godnego konkurenta ? (mój projekt na razie na pewno się na to nie nadaje :))
