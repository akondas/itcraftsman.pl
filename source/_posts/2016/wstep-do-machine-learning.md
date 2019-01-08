---
comments: true
date: 2016-03-20 19:59:12+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2016/6118141658_3def50a4f2_b-300x169.jpg
slug: wstep-do-machine-learning
title: Wstęp do Machine Learning
wordpress_id: 1181
categories:
- Machine Learning
tags:
- ai
- algorytm
- artificial intelligence
- big data
- dajsiepoznac
- dajsiepoznac2016
- machine learning
- si
- systemy uczące się
- sztuczna inteligencja
---

Krótki wstęp do tematu uczenia się maszyn zwanego popularnie Machine Learning. Jakie problemy stara się rozwiązać oraz przykładowe zastosowania które zostały już wdrożone w codziennym życiu.<!-- more -->

**Machine Learning** (pol. uczenie maszynowe, samouczenie się maszyn lub systemy uczące się) to:

>Dziedzina wchodząca w skład nauk zajmujących się problematyką SI (patrz sztuczna inteligencja). Jest to nauka interdyscyplinarna ze szczególnym uwzględnieniem takich dziedzin jak informatyka, robotyka i statystyka. Głównym celem jest praktyczne zastosowanie dokonań w dziedzinie sztucznej inteligencji do stworzenia automatycznego systemu potrafiącego doskonalić się przy pomocy zgromadzonego doświadczenia (czyli danych) i nabywania na tej podstawie nowej wiedzy. ([źródło](https://pl.wikipedia.org/wiki/Uczenie_maszynowe))

Można powiedzieć, że ML to zbiór technik, których stosowanie pomoże nam stworzyć "inteligentne" systemy. W praktyce to zestaw gotowych algorytmów popartych dowodami matematycznymi. Większość została opracowana już w latach 70-tych, ale dopiero teraz (ze względu na rosnącą moc obliczeniową) znajdują zastosowanie w praktyce. W wielkim uproszczeniu najpierw musimy takie algorytmy wytrenować odpowiednią ilością danych, a następnie mogą nam służyć do predykcji. Istnieją trzy metody uczenia się, krótko opisane poniżej.


## Sposoby uczenia się

**Uczenie nadzorowane (supervised learning)**

System na wstępie otrzymuje dane zarówno wejściowe (np. pomiary) jak i wyjściowe (np. etykiety). Jego zadaniem jest utworzenie odpowiednich reguł (generalizacja), które mapują wejście na wyjście. Po odpowiednim wytrenowaniu system taki powinien móc prawidłowo przypisać wyjście dla obiektu którego dotychczas nie było na wejściu.

**Uczenie nienadzorowane (unsupervised learning)**

W tym przypadku algorytm nie otrzymuje oczekiwanych danych wyjściowych (etykiet). Musi sam znaleźć odpowiednią regułę, która cechuje wejście i w miarę możliwości zgeneralizować ją.

**Uczenie przez wzmacnianie (reinforcement learning)**

Ten sposób zakłada, że system działa w środowisku nieznanym. Brak jest określonych danych wejściowych i wyjściowych. Jedyną informacją jaką otrzymuje "uczeń" jest **sygnał wzmocnienia**, który może być pozytywny (nagroda) w przypadku podejmowania trafnych decyzji lub negatywny w przypadku mylenia się (kara).

Jak zapewne się domyślacie, wybór sposobu uczenia się zależy od klasy problemu jaki będziemy rozwiązywać przy pomocy Machine Learningu.


## Rodzaje problemów

**Klasyfikacja (classification)**

Dane wejściowe (np. pomiar długości i szerokości) dzielimy na dwie lub więcej klas (etykiet), a system musi stworzyć model, który przypisze odpowiednie etykiety do odpowiednich danych. Zwykle stosuje się do tego rozwiązania nadzorowanego uczenia się. Dobrym przykładek jest filtrowanie spamu. Na podstawie danych wejściowych (e-maile) system nadaje odpowiednią etykietę: "spam" lub "nie spam". Innym przykładem może być rozpoznawanie pisma ręcznego.

[![Klasyfikacja kwiatów (irysa) na podstawie pomiaru ich wielkości (źródło: scikit-learn).](/assets/img/posts/2016/plot_classification_001.png)](/assets/img/posts/2016/plot_classification_001.png)  
Klasyfikacja kwiatów (irysa) na podstawie pomiaru ich wielkości (źródło: scikit-learn).

**Regresja (regression)**

W tym przypadku dane wejściowe są podobne jak przy klasyfikacji, ale na wyjściu oczekujemy wartości ciągłych a nie dyskretnych. Klasycznym przykładem regresji (w tym przypadku liniowej) będzie przewidywanie ceny domu na podstawie jego wielkości i położenia (przy założeniu, że potrafimy przedstawić położenie jako wartość liczbową).

[![Różne rodzaje regresji liniowej dla tego samego zbioru danych.](/assets/img/posts/2016/1024px-Thiel-Sen_estimator.svg_.png)](/assets/img/posts/2016/1024px-Thiel-Sen_estimator.svg_.png)  
Różne rodzaje regresji liniowej dla tego samego zbioru danych (źródło: Wikipedia).

**Grupowanie (clustering)**

Zbiór dowolnych danych dzielony jest na grupy. W odróżnieniu od klasyfikacji, grupy na wejściu nie są znane. To właśnie algorytm odpowiedzialny jest za znalezienie reguł, które powodują przynależność konkretnych wartości do grup. Najczęściej nadajemy ręcznie ilość grup, która ma zostać wydzielona ze zbioru. Jest to klasyczny przypadek uczenia nienadzorowanego. Inne nazwy tego zagadnienia to: analiza skupień lub klasteryzacja.

[![Przykład grupowania zbioru danych.](/assets/img/posts/2016/plot_mean_shift_001.png)](/assets/img/posts/2016/plot_mean_shift_001.png)  
Przykład grupowania zbioru danych (źródło: scikit-learn).

W ten sposób możemy podzielić większość algorytmów. Dodatkowo samouczenie się maszyn rodzi kilka kolejnych wyzwań, które trzeba rozwiązać. Są to:

**Redukcja wymiarowości (dimensionality reduction)**

Niektóre analizowane zbiory danych będą posiadać olbrzymią liczbę cech (features). Przykładowo analiza obrazka o wymiarach 50x50 pikseli, daje nam 2500 wymiarów (po jednym kolorze na piksel). Redukcja wymiarowości to zbiór technik, które zmniejszą ilość cech w celu poprawy wydajności algorytmu oraz samej jego skuteczności. Przykłady: usuwanie ze zbioru cech niskiej jakości (nie wpływających na decyzję), eliminacja cech które są skorelowane lub PCA (Principal component analysis).

**Obróbka wstępna (preprocessing)**

Wydobywanie cech ze zbiorów i ich normalizacja. Najczęściej będzie dotyczyć danych tekstowych, które w swojej czystej postaci nie nadają się do dalszej analizy (np. zliczanie częstości wystąpień słów w tekście). Przykłady technik: skalowanie, uśrednianie, uzupełnianie przerwanych ciągów, wektoryzacja tekstów.

**Wybór modelu (model selection)**

Z powodu dużej ilości algorytmów i ich parametrów powstaje problem wyboru odpowiedniego modelu. Z tego powodu powstają narzędzia które walidują dane wejściowe i testowe (np. odpowiednio je mieszając), dobierając różne parametry (np. w zadanym zakresie lub losowo), a na koniec porównują wszystkie wyniki i wskazują najlepszy model. Teraz pozostaje jeszcze pytanie co oznacza "najlepszy model" ? Tutaj również istnieje kilka ciekawych technik, między innymi: dokładność (accuracy), odwołanie (recall), macierz pomyłek (confusion matrix) i sprawdzian krzyżowy (cross-validation).

Jak widać w tekście pojawiło się pełno ciekawych technik a to dopiero wstęp. Część z podanych tu haseł na pewno będę dokładniej opisywał wraz z postępowaniem prac nad projektem ([php-ml](https://github.com/php-ai/php-ml)).


## Praktyczne zastosowania

Teraz kilka praktycznych przykładów wykorzystania uczących się systemów (większość na pewno jest Wam znajoma):

  * rozpoznawanie wzorców (pattern recognition)
  * automatyczna klasyfikacja dokumentów/tekstów (np. według kategorii)
  * rozpoznawanie mowy lub tekstu pisanego (speech and handwriting recognition)
  * rozpoznawanie twarzy (face recognition)
  * rozpoznawanie elementów na zdjęciu (object recognition)
  * przewidywanie trendów finansowych lub ekonomicznych (np. cen mieszkań)
  * kierowanie pojazdami (samochody autonomiczne)
  * nawigacja w nieznanym terenie
  * systemy rekomendacji (np. Spotify lub Filmweb)
  * zabezpieczanie przed oszustwami w transakcjach finansowych (fraud detecion)
  * rozpoznawanie chorób na podstawie objawów
  * marketing (dopasowywanie reklam)
  * i wiele innych ..


## Na zakończenie

W mojej bibliotece chciałbym zaimplementować (na czas trwania konkursu "[Daj Się poznać](http://itcraftsman.pl/daj-sie-poznac-2016-zaczynamy/)") po jednym z algorytmów do: klasyfikacji, regresji i grupowania.

Jeżeli zaciekawił Cię ten temat i chcesz dowiedzieć się więcej to polecam kurs (po angielsku) z Udacity: [Intro to Machine Learning](https://www.udacity.com/course/intro-to-machine-learning--ud120). Tymczasem zabieram się za samą bibliotekę ...

*Zdjęcie z wpisu: [flickr.com](https://www.flickr.com/photos/justinlincoln/6118141658)*
