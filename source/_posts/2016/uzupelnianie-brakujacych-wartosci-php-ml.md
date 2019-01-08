---
comments: true
date: 2016-05-31 05:46:59+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2016/business-925900_1920.jpg
slug: uzupelnianie-brakujacych-wartosci-php-ml
title: Uzupełnianie brakujących wartości - PHP-ML
wordpress_id: 1393
categories:
- PHP
- Machine Learning
tags:
- dajsiepoznac
- dajsiepoznac2016
- machine learning
- php-ml
---

Z różnych powodów, wiele zestawów danych ze świata rzeczywistego, zawiera brakujących wartości, często oznaczone jako puste pola, nulle lub inne symbole.<!-- more -->

W takich celach ([PHP-ML](https://itcraftsman.pl/daj-sie-poznac-2016-zaczynamy/)) zaimplementowałem klasę **_Imputer_**, która służy do uzupełniania brakujących wartości.

**Parametry konstruktora**

  * _$missingValue_ (mixed) - wartość, która ma zostać zastąpiona (domyślnie null)
  * _$strategy_ (Strategy) - strategia uzupełniania (interfejs, zaimplementowane strategie poniżej)
  * _$axis_ (int) - oś do obliczeń (kolumny lub wiersze: Imputer::AXIS_COLUMN lub Imputer::AXIS_ROW)

**Strategie**

  * _MeanStrategy_ - uzupełnia brakujące wartości wyliczając średnią wartość wzdłuż zadanej osi
  * _MedianStrategy_ -uzupełnia brakujęca wartości wyliczając medianę wzdłuż zadanej osi
  * _MostFrequentStrategy_ -uzupełnia brakujące wartości wyliczając najczęściej powtarzająca się wartość wzdłuż zadanej osi

Przykład użycia

    use Phpml\Preprocessing\Imputer;
    use Phpml\Preprocessing\Imputer\Strategy\MeanStrategy;
    
    $data = [
        [1, null, 3, 4],
        [4, 3, 2, 1],
        [null, 6, 7, 8],
        [8, 7, null, 5],
    ];
    
    $imputer = new Imputer(null, new MeanStrategy(), Imputer::AXIS_COLUMN);
    $imputer->preprocess($data);

W tym przypadku uzupełniać będziemy null wyliczając średnią wartość w danej kolumnie. Po przejściu przez podany kod tablica $data będzie wyglądać następująco:

    $data = [
        [1, 5.33, 3, 4],
        [4, 3, 2, 1],
        [4.33, 6, 7, 8],
        [8, 7, 4, 5],
    ];
