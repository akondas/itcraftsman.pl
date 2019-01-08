---
comments: true
date: 2016-05-31 15:11:24+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2016/balance-865089_1920-300x200.jpg
slug: normalizacja-danych-php-ml
title: Normalizacja danych - PHP-ML
wordpress_id: 1398
categories:
- PHP
- Machine Learning
tags:
- dajsiepoznac
- dajsiepoznac2016
- machine learning
- normalizacja
- php-ml
---

Normalizacja to proces skalowania pojedynczych próbek w celu otrzymania małego, specyficznego przedziału. Przykładowo przekształcamy dane wejściowe w taki sposób, aby mieściły się w przedziale [-1, 1] lub [0, 1].

<!-- more -->

Normalizacja to po prostu metoda uzyskania wszystkich danych na tej samej skali: jeżeli wartości różnych danych są szalenie różne, może to mieć negatywny efekt na zdolność uczenia się (w zależności od wybranej metody). Zapewnienie znormalizowanych danych pozwoli dobrze wyważyć wartości i zabezpieczy przed nieoczekiwanymi efektami.

W bibliotece [PHP-ML](https://github.com/php-ai/php-ml) zaimplementowałem dwie metody normalizacji:

## Norma L1

Matematyczne wyjaśnienie: [https://mathworld.wolfram.com/L1-Norm.html](https://mathworld.wolfram.com/L1-Norm.html)

    
```php
use Phpml\Preprocessing\Normalizer;

$samples = [
    [1, -1, 2],
    [2, 0, 0],
    [0, 1, -1],
];

$normalizer = new Normalizer(Normalizer::NORM_L1);
$normalizer->preprocess($samples);
```

Dane po przetworzeniu:
    
```php
$samples = [
   [0.25, -0.25, 0.5],
   [1.0, 0.0, 0.0],
   [0.0, 0.5, -0.5],
];
```

## Norma L2

Matematyczne wyjaśnienie: [https://mathworld.wolfram.com/L2-Norm.html](https://mathworld.wolfram.com/L2-Norm.html)
    
```php
use Phpml\Preprocessing\Normalizer;

$samples = [
    [1, -1, 2],
    [2, 0, 0],
    [0, 1, -1],
];

$normalizer = new Normalizer();
$normalizer->preprocess($samples);
```

Dane po przetworzeniu:
    
```php
$samples = [
  [0.4, -0.4, 0.81],
  [1.0, 0.0, 0.0],
  [0.0, 0.7, -0.7],
];
```

# L1 vs L2

Różnice pomiędzy normą L1 i L2, opisane bardziej dokładnie: [https://www.chioka.in/differences-between-l1-and-l2-as-loss-function-and-regularization/](https://www.chioka.in/differences-between-l1-and-l2-as-loss-function-and-regularization/)
