---
comments: true
date: 2016-05-31 18:27:16+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2016/pay-1036470_1920-300x212.jpg
slug: ekstrakcja-danych-tokenizacja-tekstu-php-ml
title: Ekstrakcja danych - tokenizacja tekstu - PHP-ML
wordpress_id: 1401
categories:
- Machine Learning
tags:
- dajsiepoznac
- dajsiepoznac2016
- feature-extraction
- machine learning
- php-ml
- tokenization
- vectorizer
---

Analiza tekstu jest jednym z głównych poligonów dla zastosowań algorytmów uczenia maszynowego. Jednak surowe dane tekstowe (czyli sekwencja symboli) nie mogą być poddawane bezpośrednio pod działanie algorytmów jak większość liczbowych wektorów o stałej wielkości.

<!-- more -->

W celu łatwiejszego dokonywania analizy danych tekstowych w bibliotece [PHP-ML](https://github.com/php-ai/php-ml) powstała klasa **_TokenCountVectorizer_**. Jej zadaniem jest zamiana treści na tokeny, a następnie zliczenie ich ilości. W efekcie na wyjściu otrzymamy macierz z ilościami wystąpień tokenów.

**Parametry konstruktora klasy TokenCountVectorizer:**

  * _$tokenizer_ (Tokenizer) - obiekt tokenizatora (implementuje interfejs Tokenizer, opis poniżej)
  * _$minDF_ (float) - ignoruj tokeny których ilość wystąpień w cały zbiorze jest niższa niż zadany próg (tzw. cut-off, domyślnie 0)

```php
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\Tokenization\WhitespaceTokenizer;

$vectorizer = new TokenCountVectorizer(new WhitespaceTokenizer());
```

**Transformacja danych wejściowych**

W celu transformacji danych wejściowych używamy metody _transform()_. Przykład:
    
```php
$samples = [
    'Lorem ipsum dolor sit amet dolor',
    'Mauris placerat ipsum dolor',
    'Mauris diam eros fringilla diam',
];

$vectorizer = new TokenCountVectorizer(new WhitespaceTokenizer());
$samples = $vectorizer->transform($samples);
```


Na wyjściu otrzymamy tablicę z wyliczonymi tokenami:

```php
$samples = [
    [0 => 1, 1 => 1, 2 => 2, 3 => 1, 4 => 1],
    [5 => 1, 6 => 1, 1 => 1, 2 => 1],
    [5 => 1, 7 => 2, 8 => 1, 9 => 1],
];
```

Klucze poszczególnych tablic to indeksy tokenów, a wartości to liczba ich wystąpień w danej próbce.

**Słownik**

Otrzymane dane wyjściowe mogą okazać się kłopotliwe w interpretacji. Tokeny są symbolizowane przez wartości numeryczne. Aby dokonać przekształcenia lub analizy możemy skorzystać z metody _getVocabulary()_:

```php
$vocabulary = $vectorizer->getVocabulary();

// $vocabulary = ['Lorem', 'ipsum', 'dolor', 'sit', 'amet', 'Mauris', 'placerat', 'diam', 'eros', 'fringilla'];
```

**Tokenizatory**

Na chwilę obecną zaimplementowane zostały dwie klasy tokenizatorów:
 	
  * _WhitespaceTokenizer_ - separatorem poszczególnych tokenów są białe znaki
  * _WordTokenizer_ - tokenem staje się słowo mające co najmniej dwa znaki alfanumeryczne (punkcja jest kompletnie ignorowana i traktowana zawsze jako separator)

Przykładowe użycie samego tokenizatora:

```php
use Phpml\Tokenization\WordTokenizer;

$text = 'Lorem ipsum-dolor sit amet, consectetur/adipiscing elit.
                 Cras consectetur, dui et lobortis;auctor. 
                 Nulla vitae ,.,/ congue lorem.';

$tokenizer = new WordTokenizer();
$tokens = $tokenizer->tokenize($text);
```

W ten sposób na wyjściu otrzymamy:
    
```php
$tokens = [
    'Lorem', 'ipsum', 'dolor', 'sit', 'amet', 'consectetur', 'adipiscing', 'elit', 
    'Cras', 'consectetur', 'dui', 'et', 'lobortis', 'auctor',
    'Nulla', 'vitae', 'congue', 'lorem'
];
```
