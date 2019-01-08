---
comments: true
date: 2016-03-26 21:00:27+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2016/kmeans2-300x178.png
slug: algorytm-k-srednich-uczenie-nienadzorowane
title: Algorytm k-średnich - uczenie nienadzorowane
wordpress_id: 1199
categories:
- Algorytmy
- Machine Learning
tags:
- algorytmy
- analiza skupień
- centroid
- dajsiepoznac
- dajsiepoznac2016
- k-means
- k-średnich
- klasteryzacja
- machine learning
- systemy uczące się
---

Algorytm k-średnich (_z ang. k-means_) inaczej zwany również algorytmem centroidów, służy do podziału danych wejściowych na **z góry założoną** liczbę klas. Jest to jeden z algorytmów stosowany w klasteryzacji (grupowaniu) i jest częścią uczenia nienadzorowanego w [Machine Learning](http://itcraftsman.pl/wstep-do-machine-learning/).<!-- more -->

Aby dobrze zrozumieć zasady działania tego algorytmu musimy wprowadzić jedno nowe pojęcie: "**centroid**". Centroid jest to reprezentant danego skupienia lub inaczej środek danej grupy.

## Podstawowa zasada działania

Dla dobrej wizualizacji działania algorytmu k-średnich proponuję zbiór punktów ułożonych na płaszczyźnie w 3 różnych skupiskach. Na początku zakładamy, że przynależność poszczególnych punktów do klas (etykiet) nie jest nam znana.

[![kmeans-step-0](/assets/img/posts/2016/kmeans-step-0.png)](/assets/img/posts/2016/kmeans-step-0.png)  
*Zbiór danych bez etykiet*


**Krok pierwszy**

Wybór ilości centroidów i początkowe ułożenie ich w przestrzeni. Tak jak napisałem na wstępie, dla tego algorytmu musimy z góry określić na ile grup chcemy podzielić nasz zbiór. Następnie umieszczamy w przestrzeni zadaną ilość punktów. Sposób rozmieszczenia ma ogromne znaczenie i zależy od niego ostateczny wynik działania algorytmu. Stosuje się tutaj różne techniki, aby zoptymalizować jego pracę. Ja umieszczę trzy punkty w losowych miejscach:

[![kmeans-step-1](/assets/img/posts/2016/kmeans-step-1.png)](/assets/img/posts/2016/kmeans-step-1.png)  
Losowe umieszczenie centroidów.


**Krok drugi**

Teraz ustalamy przynależność punktów do naniesionych centroidów. Jak widać na poprzednim obrazie wszystkie punkty były białe. W tym kroku wyliczamy średnie odległości poszczególnych punktów i przypisujemy najbliższym im centroid (w naszym przypadku będzie to przypisanie koloru):

[![kmeans-step-2](/assets/img/posts/2016/kmeans-step-2.png)](/assets/img/posts/2016/kmeans-step-2.png)  
Przypisanie danych do centroidów.


**Krok trzeci**

Aktualizujemy położenie naszych centroidów. Nowe współrzędne centroidów to średnia arytmetyczna współrzędnych wszystkich punktów mających jego grupę (są też inne techniki). Zobaczmy jak przemieszczą się punkty w naszym przykładzie (zauważcie, że przynależność samych punktów nie zmieniła się, na tym etapie przesuwamy same środki):

[![kmeans-step-3](/assets/img/posts/2016/kmeans-step-3.png)](/assets/img/posts/2016/kmeans-step-3.png)  
Przesunięcie centroidów na podstawie średniej arytmetycznej odległości.

**Zakończenie algorytmu**

Krok drugi i trzeci powtarzamy aż do osiągnięcia kryterium zbieżności, którym najczęściej jest stan w którym nie zmieniła się przynależność punktów do klas. Dla naszego przykładu osiągniemy ostateczny krok już po drugiej iteracji:

[![kmeans-step-final](/assets/img/posts/2016/kmeans-step-final.png)](/assets/img/posts/2016/kmeans-step-final.png)  
Zakończenie działania algorytmu.

## Problem z inicjalizacją centroidów

W powyższym przykładzie zbiór danych został pogrupowany zgodnie z naszą "intuicją" na trzy grupy, ale wszystko zależy od początkowego ułożenia punktów startowych centroidów. Zobaczcie do czego może doprowadzić takie początkowe ułożenie:

[![kmeans-step-wrong](/assets/img/posts/2016/kmeans-step-wrong.png)](/assets/img/posts/2016/kmeans-step-wrong.png)  
Pechowe rozmieszczenie początkowe centroidów.


W skutek 3 iteracji otrzymamy następujący wynik:

[![kmeans-step-wrong2](/assets/img/posts/2016/kmeans-step-wrong2.png)](/assets/img/posts/2016/kmeans-step-wrong2.png)  
Rezultat działania algorytmu k-średnich przy złym rozłożeniu.


Jedną ze strategii obrony jest wybór punktów początkowych, które będą od siebie "maksymalnie" oddalone. Niestety nie zawsze daje to dobre rezultaty. Poniższy przykład pokazuje, że pogrupowane dane nie zawsze odzwierciedlają naszą intuicję. Być może chcielibyśmy podzielić ten zbiór w trochę inny sposób:

[![kmeans-step-wrong3](/assets/img/posts/2016/kmeans-step-wrong3.png)](/assets/img/posts/2016/kmeans-step-wrong3.png)  
Podział zbioru na 4 mało intuicyjne grupy.


## Podsumowanie

**Algorytm k-średnich:**

  * wstępnie ustalamy parametr k czyli liczbę grup na które chcemy podzielić nasze dane wejściowe
  * działamy do momentu stabilizacji czyli gdy nie dochodzi już do żadnych zmian w uzyskanych grupach.
  * wykorzystujemy miarę odległości między punktami (zwykle euklidesową)

**Możliwe ulepszenia lub modyfikacje:**

  * różne sposoby znajdowania odległości
  * zmiana liczby grup w trakcie pracy algorytmu (zapobieganie nadmiernej unifikacji i przesadnemu rozdrobnieniu)
  * wykorzystanie warzonej miary odległości uwzględniającej znaczenie atrybutów

**Zalety algorytmu k-średnich:**

  * niska złożoność, a co za tym idzie wysoka wydajność działania
  * przy dużych zbiorach i niskich ilościach grupa algorytm ten będzie zdecydowanie szybszy niż pozostałe algorytmy tej klasy	
  * pogrupowane zbiory są z reguły bardziej ciaśniejsze i zbite

**Wady:**

  * nie pomaga w określeniu ilości grup (K)	
  * różne wartości początkowe prowadzą do różnych wyników
  * działa dobrze tylko dla "sferycznych" skupisk o jednorodnej gęstości


Do wizualizacji wszystkich przykładów wykorzystałem narzędzie autorstwa Naftali Harris ([@naftaliharris](https://twitter.com/naftaliharris)) dostępny na stronie: [http://www.naftaliharris.com/blog/visualizing-k-means-clustering/](http://www.naftaliharris.com/blog/visualizing-k-means-clustering/)
