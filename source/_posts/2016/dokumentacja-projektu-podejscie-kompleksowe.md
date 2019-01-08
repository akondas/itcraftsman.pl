---
comments: true
date: 2016-05-03 14:44:14+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2016/storage-1209059_1280-300x163.jpg
slug: dokumentacja-projektu-podejscie-kompleksowe
title: Dokumentacja projektu - podejście kompleksowe
wordpress_id: 1350
categories:
- Dokumentacja
tags:
- dajsiepoznac
- dajsiepoznac2016
- dokumentacja
- markdown
- open source
- read the docs
- readme.md
- yml
---

Wpis zamykający krótką serię dotyczącą dokumentacji projektu. W poście tym omówię co powinna zawierać dobra dokumentacja. Dodatkowo przedstawię generowanie i hostowanie dokumentacji z wykorzystaniem bezpłatnej usługi Read the Docs. Zapraszam.<!-- more -->

W poprzednich wpisach skupiłem się na formacie [Markdown](https://itcraftsman.pl/markdown-tworzenie-dokumentacji-projektu/) oraz pliku [README.md](https://itcraftsman.pl/dokumentacja-projektu-pragmatyczne-readme-md/). Czas zająć się szczegółową dokumentację projektu, która dla użytkowników Twojej biblioteki może być niezbędna. Zanim przejdę do omówienia Read the Docs kilka porad na temat samej dokumentacji.


## Zawartość dokumentacji


Odbiorcami dokumentacji mogą być osoby o różnych umiejętnościach i odrębnych doświadczeniach. Z tego powodu trzeba skupić się na różnych formach dokumentacji. Przedstawię trzy z nich. Polecam zacząć przynajmniej od jednej, a z czasem rozwinąć zakres dokumentacji dodając kolejne części.

**Poradniki krok po kroku**

Jednym z najczęściej szukanych i wykorzystywanych stron dokumentacji są właśnie tutoriale step-by-step. Dla nowych użytkowników Twojej biblioteki będą idealną porcją wiedzy, wystarczającej do pierwszego uruchomienia Twojego kodu. Pamiętaj, aby tworzone samouczki dały się wykonać w maksymalnie **30 minut**. Jest to sporo czasu na coś bardziej prostszego niż "Hello World", a zarazem nie za dużo, aby nie zniechęcić początkującego. Możesz przedstawić kilka takich przewodników dotyczących różnych części Twojego projektu.

Przykład: [https://docs.djangoproject.com/en/1.9/intro/tutorial01/](https://docs.djangoproject.com/en/1.9/intro/tutorial01/)

**Przewodnik po wybranych koncepcyjnych obszarach**

Powinien to być kompleksowy opis poszczególnych tematów Twojego projektu. Problemów jakie rozwiązuje. Najlepiej często otoczony licznymi przykładami kodu źródłowego. Będzie stanowił on mięso Twojej dokumentacji.

Do przewodników takich przejdą użytkownicy, którzy są już zaznajomieni z samouczkami i chcieliby zgłębić wiedzę na temat Twojej biblioteki. Pamiętaj, że nie musisz zamieszczać w num wszystkich funkcji, metod czy parametrów. Ta części dokumentacji powinno być jak najbardziej wszechstronna.

Przykład: [https://symfony.com/doc/current/book/index.html](https://symfony.com/doc/current/book/index.html)

**Szczegółowa referencja**

Najbardziej czasochłonna część i zarazem najrzadziej spotykana (w opisanej formie). Tutaj możesz skupić się na bardzo low-levelowej funkcjonalności projektu. Opisać używane struktury danych, parametry metod czy detale implementacyjne. Bardzo często można spotkać projekty, które referencję generują automatycznie na podstawie kodu. Moim zdaniem nie jest to najlepsze rozwiązanie. Aktualnie posiadamy bardzo inteligentne IDE, które podpowie nam wszystko w czasie rzeczywistym, bez potrzeby zerkania w referencję, więc wygenerowana automatycznie staje się bezużyteczna.

Lepszym rozwiązaniem (tylko kto ma na to czas) jest szczegółowy opis niskopoziomowych rozwiązań i skrajnych przypadków użycia. Zobaczcie poniżej na przykład z Pythona, to zrozumiecie sami co mam na myśli.

Przykład: [https://docs.python.org/3/library/index.html](https://docs.python.org/3/library/index.html)


## Read the Docs

Read the Docs to darmowa usługa, która generuje i hostuje dokumentację dla projektów open source. Jeżeli spodoba Ci się, możesz postawić sobie własną instancję do firmowych lub prywatnych projektów. Potrafi obsłużyć zarówno Markdown jak i reStructuredText. Samą dokumentację można z kolei dostarczać z kilku różnych źródeł: Git, SVN, Mercurial i Bazaar. W tym wpisie skupimy się na formacie Mkdocs (Markdown) i publicznym repozytorium GitHub.

Dodatkową zaletą serwisu Read the Docs jest to, że generuje on dokumentację, bazując na systemie kontroli wersji. Oznacza to, że Twoja dokumentacja będzie również wersjonowana, a w przyszłości, gdy Twój projekt osiągnie kolejną wersję, użytkownicy będą mogli swobodnie przełączać się pomiędzy poszczególnymi wydaniami. Wszystko opiera się na gałęziach Twojego repozytorium (dodatkowo jest konfigurowalne).

**Konfiguracja - plik mkdocs.yml**

Sercem dokumentacji jest plik konfiguracyjny. Dla Mkdocs jest to _mkdocs.yml_. W celu stworzenia menu Twojej dokumentacji dodaj w głównym katalogu plik mkdocs.yml z bardzo prostą zawartością. Dla przykładu posłużę się plikiem z biblioteki [PHP-ML](https://github.com/php-ai/php-ml):

```yaml
site_name: PHP-ML - Machine Learning library for PHP
pages:
  - Home: index.md
  - Machine Learning:
    - Classification:
      - KNearestNeighbors: machine-learning/classification/k-nearest-neighbors.md
      - NaiveBayes: machine-learning/classification/naive-bayes.md
    - Regression:
      - LeastSquares: machine-learning/regression/least-squares.md
    - Clustering:
      - KMeans: machine-learning/clustering/k-means.md
      - DBSCAN: machine-learning/clustering/dbscan.md
    - Cross Validation:
      - RandomSplit: machine-learning/cross-validation/random-split.md
    - Datasets:
      - Array Dataset: machine-learning/datasets/array-dataset.md
      - CSV Dataset: machine-learning/datasets/csv-dataset.md
      - Ready to use datasets:
        - Iris: machine-learning/datasets/demo/iris.md
    - Metric:
      - Accuracy: machine-learning/metric/accuracy.md
  - Math:
    - Distance: math/distance.md
    - Matrix: math/matrix.md
theme: readthedocs
```

Pełny opis wszystkich dostępnych opcji znajduje się pod adresem: [https://www.mkdocs.org/user-guide/configuration/](https://www.mkdocs.org/user-guide/configuration/)

Krótki opis  użytych przeze mnie kluczy:

  * site_name: nazwa dokumentacji, będzie wyświetlana również w `<title>`
  * pages: menu dokumentacji z tytułami i linkami
  * theme: szablon strony

**Zawartość dokumentacji - katalog docs**

Zauważyłeś na pewno, że menu linkuje do różnych plików. Aby wszystko sprawnie działało muszęąone się znaleźć w katalogu _docs _w głównym folderze twojego projektu. Są to pliki w formacie Markdown o dowolnej zawartości. Poniżej przykładowa struktura:

![docs-files](/assets/img/posts/2016/docs-files.png)

**Automatyczne generowanie dokumentacji**

W ten sposób utworzona dokumentacja jest przygotowane do importu w Read the Docs. Skonfigurujemy teraz jej automatycznie pobieranie i generowanie za pomocą repozytorium znajdującego się na GitHubie.

Proces trzeba zacząć od założenia sobie konta (mam nadzieję, że tego nie trzeba opisywać i dasz sobie z tym radę). Następnie, po zalogowaniu, wybieramy opcję "Import a Project". Możemy albo skorzystać z automatycznego kreatora (autoryzując się kontem na GitHubie) lub ręcznie dodać nowy projekt podając URL gita.

Read the Docs powinien automatycznie wykryć rodzaj dokumentacji (Mkdocs). Jeżeli nie, to w ustawieniach projektu można ręcznie zmienić jej typ. Polecam przeklikać się po panelu administracyjnym i dostosować wybrane opcje pod siebie (na przykład która gałąź jest domyślna itp.)

![screenshot-readthedocs.org 2016-05-03 13-23-45](/assets/img/posts/2016/screenshot-readthedocs.org-2016-05-03-13-23-45.png)


Na koniec link do dokumentacji projektu PHP-ML wygenerowanej przy użyciu Read the Docs: [https://php-ml.readthedocs.io/](https://php-ml.readthedocs.io/)
