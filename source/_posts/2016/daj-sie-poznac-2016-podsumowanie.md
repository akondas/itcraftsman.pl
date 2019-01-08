---
comments: true
date: 2016-05-31 19:18:35+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2016/DSP2016-03-va-dziel-sie-300x300.png
slug: daj-sie-poznac-2016-podsumowanie
title: Daj się poznać 2016 - podsumowanie
wordpress_id: 1408
categories:
- PHP
- Programowanie
tags:
- dajsiepoznac
- dajsiepoznac2016
- machine learning
- php-ml
- podsumowanie
---

Konkurs "Daj się poznać" z dniem dzisiejszym dobiega końca. Oto krótkie podsumowanie co udało się mi się w tym czasie zrobić.
<!-- more -->

## Biblioteka PHP-ML

[https://github.com/php-ai/php-ml](https://github.com/php-ai/php-ml)

Machine Learning w PHP. Przykładowe użycie algorytmu k najbliższych sąsiadów (k nearest neighbours):

    
```php
use Phpml\Classification\KNearestNeighbors;

$samples = [[1, 3], [1, 4], [2, 4], [3, 1], [4, 1], [4, 2]];
$labels = ['a', 'a', 'a', 'b', 'b', 'b'];

$classifier = new KNearestNeighbors();
$classifier->train($samples, $labels);

$classifier->predict([3, 2]); 
// return 'b'
```

To tylko prosty przykład wykorzystania. Najlepszym sposobem na pokazanie ilości prac będzie spis treści dokumentacji. W środku są liczne przykłady kodu i wyjaśnienia:

  * Classification
    * [SVC](https://php-ml.readthedocs.io/en/latest/machine-learning/classification/svc/)
    * [k-Nearest Neighbors](https://php-ml.readthedocs.io/en/latest/machine-learning/classification/k-nearest-neighbors/)
    * [Naive Bayes](https://php-ml.readthedocs.io/en/latest/machine-learning/classification/naive-bayes/)
  * Regression
    * [Least Squares](https://php-ml.readthedocs.io/en/latest/machine-learning/regression/least-squares/)
    * [SVR](https://php-ml.readthedocs.io/en/latest/machine-learning/regression/svr/)
  * Clustering
    * [k-Means](https://php-ml.readthedocs.io/en/latest/machine-learning/clustering/k-means/)
    * [DBSCAN](https://php-ml.readthedocs.io/en/latest/machine-learning/clustering/dbscan/)
  * Metric
    * [Accuracy](https://php-ml.readthedocs.io/en/latest/machine-learning/metric/accuracy/)
  * Cross Validation
    * [Random Split](https://php-ml.readthedocs.io/en/latest/machine-learning/cross-validation/random-split/)
  * Preprocessing
    * [Normalization](https://php-ml.readthedocs.io/en/latest/machine-learning/preprocessing/normalization/)
    * [Imputation missing values](https://php-ml.readthedocs.io/en/latest/machine-learning/preprocessing/imputation-missing-values/)
  * Feature Extraction
    * [Token Count Vectorizer](https://php-ml.readthedocs.io/en/latest/machine-learning/feature-extraction/token-count-vectorizer/)
  * Datasets
    * [CSV](https://php-ml.readthedocs.io/en/latest/machine-learning/datasets/csv-dataset/)
    * Ready to use:
      * [Iris](https://php-ml.readthedocs.io/en/latest/machine-learning/datasets/demo/iris/)
      * [Wine](https://php-ml.readthedocs.io/en/latest/machine-learning/datasets/demo/wine/)
      * [Glass](https://php-ml.readthedocs.io/en/latest/machine-learning/datasets/demo/glass/)
  * Math
    * [Distance](https://php-ml.readthedocs.io/en/latest/math/distance/)
    * [Matrix](https://php-ml.readthedocs.io/en/latest/math/matrix/)
    * [Statistic](https://php-ml.readthedocs.io/en/latest/math/statistic/)

## Wpisy na blogu


W czasie trwania konkursu udało mi się wyprodukować 20 wpisów (podsumowanie będzie 21):

  1. [Daj Się Poznać 2016 – zaczynamy](https://itcraftsman.pl/daj-sie-poznac-2016-zaczynamy/)
  2. [Wstęp do machine learning](https://itcraftsman.pl/wstep-do-machine-learning/)
  3. [Algorytm k-śrendnich – uczenie nienadzorowane](https://itcraftsman.pl/algorytm-k-srednich-uczenie-nienadzorowane/)
  4. [Ogólnodostępne zbiory danych do Machine Learningu](https://itcraftsman.pl/ogolnodostepne-zbiory-danych-do-machine-learningu/)
  5. [Wydajność php i machine learning](https://itcraftsman.pl/wydajnosc-php-i-machine-learning/)
  6. [Postępy w pracy nad php-ml](https://itcraftsman.pl/postepy-w-pracy-nad-php-ml/)
  7. [Publikacja własnej biblioteki PHP z użyciem GitHub i Composer](https://itcraftsman.pl/publikacja-wlasnej-biblioteki-php-z-uzyciem-github-i-composer/)
  8. [Red Green Refactor - testy jednostkowe](https://itcraftsman.pl/red-green-refactor-testy-jednostkowe/)
  9. [Ciągła integracja i Travis CI](https://itcraftsman.pl/ciagla-integracja-i-travis-ci/)
  10. [php-ml - prac ciąg dalszy](https://itcraftsman.pl/php-ml-prac-ciag-dalszy/)
  11. [Markdown - tworzenie dokumentacji projektu](https://itcraftsman.pl/markdown-tworzenie-dokumentacji-projektu/)
  12. [Dokumentacja projektu - pragmatyczne README.md](https://itcraftsman.pl/dokumentacja-projektu-pragmatyczne-readme-md/)
  13. [Dokumentacja projektu - podejście kompleksowe](https://itcraftsman.pl/dokumentacja-projektu-podejscie-kompleksowe/)
  14. [Code Coverage w testach jednostkowych](https://itcraftsman.pl/code-coverage-w-testach-jednostkowych/)
  15. [Generowanie raportu Code Coverage z phpunit](https://itcraftsman.pl/generowanie-raportu-code-coverage-z-phpunit/)
  16. [Uzupełnianie brakujących wartości - php-ml](https://itcraftsman.pl/uzupelnianie-brakujacych-wartosci-php-ml/)
  17. [Normalizacja danych - php-ml](https://itcraftsman.pl/normalizacja-danych-php-ml/)
  18. [Walidacja krzyżowa - randomsplit - php-ml](https://itcraftsman.pl/walidacja-krzyzowa-randomsplit-php-ml/)
  19. [Ekstrakcja danych - tokenizacja tekstu - php-ml](https://itcraftsman.pl/ekstrakcja-danych-tokenizacja-tekstu-php-ml/)
  20. [Humbug - testy mutacyjne w PHP](https://itcraftsman.pl/humbug-testy-mutacyjne-w-php/)
  

## Postscriptum


Jestem mega zadowolony z tego co udało mi się zrobić i choć na końcu nie obyło się bez trudności to dotarłem szczęśliwie do końca.

Na przyszłość polecam Wam wszystkim takie inicjatywy i udział w nich bo dają dużą porcję wiedzy, motywacji i inspiracji.

Mogę śmiało powiedzieć, że najprzyjemniejszym momentem było wykorzystanie przez **Mariusz Gila** ([@mariuszgil](https://twitter.com/mariuszgil)) fragmentu biblioteki PHP-ML w czasie jego prezentacji pt. "Holistic approach to machine learning", która odbyła się w Bielsku-Białej na [WeBB MeetUp](https://webbmeetup.com/). Dzięki Mariusz !

**P.S. 2**

Podsumowanie miało być dłuższe, pełne ochów i achów, dogłębnych przemyśleń i innych podobnych rzeczy, ale brakło mi czasu. Musi Wam wystarczyć to co jest :) Jak tylko uda mi się poukładać parę spraw, to postaram się zrekompensować te krótkie wpisy i stworzyć kilka "grubszych" postów.
