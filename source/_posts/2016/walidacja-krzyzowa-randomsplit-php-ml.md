---
comments: true
date: 2016-05-31 16:42:44+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2016/laboratory-1009178_1920-300x219.jpg
slug: walidacja-krzyzowa-randomsplit-php-ml
title: Walidacja krzyżowa - RandomSplit - PHP-ML
wordpress_id: 1403
categories:
- Machine Learning
- PHP
tags:
- dajsiepoznac
- dajsiepoznac2016
- machine learning
- php-ml
- walidacja krzyżowa
---

Sprawdzian krzyżowy (z ang. cross-validation) to technika polegająca na podziale kolekcji danych wejściowych na co najmniej dwa zbiory: uczący i testowy. W ten sposób można zweryfikować czy wyuczony model będzie dobrze działał na wcześniej nie widzianych danych. Walidacja krzyżowa zapobiega również przetrenowaniu (overfitting) modelu.

<!-- more -->

Implementacja w bibliotece [PHP-ML](https://github.com/php-ai/php-ml):

Jedną z najprostszych metod walidacji krzyżowej jest losowy podział danych. Został on zaimplementowany w klasie **_RandomSplit_**. Próbki danych dzielone są na dwie grupy: grupę uczącą i grupę testową. Odpowiednim parametrem (_$testSize)_ można ustawić proporcję podziału obu grup (jej ułamek). Istnieje również możliwość inicjacji algorytmu losującego dowolną liczbą, co pozwala na wygenerowanie takich samych zbiorów.

**Parametry konstruktora klasy RandomSplit:**

  * _$dataset_ - obiekt implementujący interfejs _Dataset_ (zbiór danych)
  * _$testSize_ - wielkość zbioru testowego (float, od 0 do 1, domyślnie: 0.3)	
  * $seed - ziarno do inicjacji generatora losowości (dla tego samego ziarna otrzymamy ten sam wynik)


    use Phpml\CrossValidation\RandomSplit;
    use Phpml\Dataset\Demo\Iris;
    
    $dataset = new Iris();
    
    $randomSplit = new RandomSplit($dataset, 0.2);


**Próbki i etykiety**

Pełny przykład utworzenia zbiorów testowych i uczących oraz ich wydobywania:

    use Phpml\CrossValidation\RandomSplit;
    use Phpml\Dataset\ArrayDataset;
    
    $dataset = new ArrayDataset(
        $samples = [[1], [2], [3], [4]],
        $labels = ['a', 'a', 'b', 'b']
    );
    
    $dataset = new RandomSplit($dataset, 0.5, 1234);
    
    // train group
    $dataset->getTrainSamples();
    $dataset->getTrainLabels();
    
    // test group
    $dataset->getTestSamples();
    $dataset->getTestLabels();

**Przykład zastosowania**

Poniżej przykład zastosowania na realnie próbce (zbór _Iris_):


    use Phpml\Classification\SVC;
    use Phpml\CrossValidation\RandomSplit;
    use Phpml\Dataset\Demo\Iris;
    use Phpml\Metric\Accuracy;
    use Phpml\SupportVectorMachine\Kernel;
    
    $dataset = new RandomSplit(new Iris(), 0.5, 123);
    
    $classifier = new SVC(Kernel::RBF);
    $classifier->train($dataset->getTrainSamples(), $dataset->getTrainLabels());
    
    $predicted = $classifier->predict($dataset->getTestSamples());
    
    $accuracy = Accuracy::score($dataset->getTestLabels(), $predicted);

W tym wariancie dzielimy zbiór na dwie równe części (co jest pewną przesadą). Dla takiej wersji sprawność wynosi **95%**. Wystarczy zwiększyć wielkość zbioru uczącego do 70% (zmniejszając zbiór uczący się do 30%), aby otrzymać sprawność na poziomie **100%**.
