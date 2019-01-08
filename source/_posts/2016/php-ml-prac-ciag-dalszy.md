---
comments: true
date: 2016-04-24 20:07:36+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2016/11953774924_1d3f2e50be_b-300x169.jpg
slug: php-ml-prac-ciag-dalszy
title: PHP-ML - prac ciąg dalszy
wordpress_id: 1316
categories:
- Programowanie
tags:
- dajsiepoznac
- dajsiepoznac2016
- github
- machine learning
- php-ml
- productivity
---

Kolejne dwa tygodnie konkursu "[Daj się poznać](https://itcraftsman.pl/daj-sie-poznac-2016-zaczynamy/)" za nami. Sprawdźmy co udało się dokonać w kwestii rozwoju biblioteki PHP-ML.<!-- more -->

Jak pisałem wcześniej ([Postępy w pracy nad PHP-ML](https://itcraftsman.pl/postepy-w-pracy-nad-php-ml/)) miałem drobne problemy z motywacją i rozpoczęciem prac na biblioteką do ML. Aby rozwiązać ten problem, wspomogłem się dość prostą aplikacją o nazwie [Forest](https://play.google.com/store/apps/details?id=cc.forestapp&hl=pl). Odliczała ona określoną ilość czasu i jeżeli przez ten okres nie korzystamy z telefonu (czyli teoretycznie robimy coś tam sobie założonego i pożytecznego) to punktował sukces.

Muszę stwierdzić, że był to idealny strzał. Codziennie staram się poświęcić około 30 minut i jak do tej pory to działa. Czasami nawet nie potrzebuję uruchamiać do tego Foresta. Oczywiście, są dni kiedy w 30 minut nie uda mi się stworzyć logicznego i działającego fragmentu kodu, to jednak widać ewidentny postęp prac i przyrost comitów (zielono !!!):

![screenshot-github.com 2016-04-24 21-20-28](/assets/img/posts/2016/screenshot-github.com-2016-04-24-21-20-28.png)

## PHP-ML

Na dzień dzisiejszy udało mi się zaimplementować dwa (bardzo uproszczone) algorytmy klasyfikacji: K Nearest Neighbors oraz Naive Bayes. Sposób użycia wygląda następująco:

    use Phpml\Classifier\KNearestNeighbors;
    
    $samples = [[1, 3], [1, 4], [2, 4], [3, 1], [4, 1], [4, 2]];
    $labels = ['a', 'a', 'a', 'b', 'b', 'b'];
    
    $classifier = new KNearestNeighbors();
    $classifier->train($samples, $labels);
    
    $classifier->predict([3, 2]); 
    // return 'b'


Deklarujmy próbki wejściowe _$samples_ i ich etykiety _$labels_, a następnie poprzez metodę _predict()_ przewidujemy etykietę dla próbki, która nie występowała w zbiorze uczącym.

Zaimplementowałem również parę narzędzi: do pomiaru sprawności algorytmów klasyfikujących
    
    use Phpml\Metric\Accuracy;
    
    Accuracy::score($actualLabels, $predictedLabels);

Oraz do tzw. walidacji krzyżowej (o której będzie osobny wpis):
  
    
    use Phpml\CrossValidation\RandomSplit;
    use Phpml\Dataset\ArrayDataset;
    
    $dataset = new ArrayDataset(
        $samples = [[1], [2], [3], [4]],
        $labels = ['a', 'a', 'b', 'b']
    );
    
    $randomSplit = new RandomSplit($dataset, $testSize = 0.5);
    
    $randomSplit->getTestSamples();
    $randomSplit->getTrainSamples();
    
    $randomSplit2->getTestLabels();
    $randomSplit1->getTrainLabels();


Dodatkowo bibliotek posiada kila przykładowych [zbiorów danych](https://itcraftsman.pl/ogolnodostepne-zbiory-danych-do-machine-learningu/), które można w łatwy i szybki sposób użyć do przetestowania algorytmów:
   
    
    use Phpml\Dataset\Demo\Iris;
    
    $irisDataset = new Iris();
    
    $irisDataset->getSamples();
    $irisDataset->getLabels();
    
Na ten moment natrafiłem na problem z implementacją SVM (Support Vector Machine). Jest to trudniejsze niż myślałem i wymaga głębszego poznania algorytmu a więc i więcej czasu, ale na pewno to rozgryzę.

## Blogowanie

W między czasie udało mi się też utworzyć parę wpisów (powinny być 4, więc muszę zacząć nadrabiać)

[Publikacja własnej biblioteki PHP z użyciem GitHub i Composer](https://itcraftsman.pl/publikacja-wlasnej-biblioteki-php-z-uzyciem-github-i-composer/)

[Red Green Refactor – testy jednostkowe](https://itcraftsman.pl/red-green-refactor-testy-jednostkowe/)

[Ciągła integracja i Travis CI](https://itcraftsman.pl/ciagla-integracja-i-travis-ci/)


Całość (blogowanie i kodowanie) pochłania sporo czasu, ale jestem pewien, że zdobyte w ten sposób doświadczenie, wróci się z nawiązką. Jeżeli macie jakieś pytania lub uwagi to zapraszam do komentowania.

*Zdjęcie z wpisu: [Flickr](https://www.flickr.com/photos/stavos52093/11953774924/).*
