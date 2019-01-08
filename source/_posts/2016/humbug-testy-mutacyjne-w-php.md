---
comments: true
date: 2016-05-31 19:11:05+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2016/microscope-275984_1920-300x199.jpg
slug: humbug-testy-mutacyjne-w-php
title: Humbug - testy mutacyjne w PHP
wordpress_id: 1386
categories:
- PHP
- TDD
tags:
- dajsiepoznac
- dajsiepoznac2016
- humbug
- php
- tdd
- testy mutacyjne
---

Testy mutacyjne to narzędzie służące do analizy jakości testów jednostkowych i kodu źródłowego. Polegają one na wprowadzaniu małych zmian (mutacji) w kodzie źródłowym, a następnie sprawdzaniu, czy wpłynęły one na wyników testów (czy przestały przechodzić). Mutacje, które przetrwały (nie zostały wykryte) są potencjalnymi błędami, które nie zostałyby wykryte przez testy.<!-- more -->

## Humbug

[Humbug](https://github.com/padraic/humbug) jest frameworkiem przeznaczonym do testowania mutacyjnego w PHP. Jest bardzo prosty w instalacji i obsłudze oraz potrafi wygenerować bardzo szczegółowy raport.

**Instalacja**

Możliwe są trzy sposoby instalacji: używając Git, pobierając paczkę PHAR lub z pomocą Composera.

GIT:

```
git clone https://github.com/padraic/humbug.git
    cd humbug
    /path/to/composer.phar install
```

PHAR:

```
wget https://padraic.github.io/humbug/downloads/humbug.phar
wget https://padraic.github.io/humbug/downloads/humbug.phar.pubkey
# If you wish to make humbug.phar directly executable
chmod +x humbug.phar
```

Composer:

```
composer global require 'humbug/humbug=~1.0@dev'
```


**Konfiguracja**

Aby skonfigurować projekty wystarczy uruchomić polecenie:

```
humbug configure
```

Przykładowa konfiguracja utworzona w pliku _humbug.json.dist_

```json
{
    "source": {
        "directories": [
            "src"
        ]
    },
    "timeout": 10,
    "logs": {
        "text": "humbuglog.txt"
    }
}
```

**Raport**

W celu wygenerowania raportu wpisujemy:
    
```php
humbug
```

Przykłady fragment raportu:

    
```
 _  _            _
| || |_  _ _ __ | |__ _  _ __ _
| __ | || | '  \| '_ \ || / _` |
|_||_|\_,_|_|_|_|_.__/\_,_\__, |
                          |___/ 
Humbug version 1.0-dev

Humbug running test suite to generate logs and code coverage data...

   96 [==========================================================] 2 secs

Humbug has completed the initial test run successfully.
Tests: 95 Line Coverage: 95.15%
Humbug is analysing source files...
Mutation Testing is commencing on 55 files...
(.: killed, M: escaped, S: uncovered, E: fatal error, T: timed out)
MM.....M.M.MMMM.M.MT.M.MTM.MM.M.MM.M.MSM.M....S......MM...MM |   60 ( 7/55)
MM..M.M.MMT...M...TMMMM.....TMMM.MMM.M..M..M............TM.. |  120 ( 9/55)
............M......S......S...........M.M..M...M.SSS....M.SS |  180 (22/55)
.....................................................M...... |  240 (35/55)
...................................M.....M.........M....MMMM |  300 (40/55)
M.................................M.................M....... |  360 (40/55)
...M.........M....M...............M........M............MM.. |  420 (46/55)
.M....MM...M.MM..
437 mutations were generated:
     345 mutants were killed
       9 mutants were not covered by tests
      77 covered mutants were not detected
       0 fatal errors were encountered
       6 time outs were encountered

Metrics:
    Mutation Score Indicator (MSI): 80%
    Mutation Code Coverage: 98%
    Covered Code MSI: 82%

Remember that some mutants will inevitably be harmless (i.e. false positives).
Time: 2.87 minutes Memory: 8.00MB
Humbug results are being logged as TEXT to: humbuglog.txt

------
Uncovered
------


1) Mutator \Humbug\Mutator\ReturnValue\FunctionCall on \Phpml\Clustering\KMeans\Cluster::count() in /var/www/php-ml/src/Phpml/Clustering/KMeans/Cluster.php on line 135
2) Mutator \Humbug\Mutator\Boolean\FalseValue on \Phpml\Clustering\KMeans\Space::getBoundaries() in /var/www/php-ml/src/Phpml/Clustering/KMeans/Space.php on line 94
3) Mutator \Humbug\Mutator\ReturnValue\NewObject on \Phpml\Exception\DatasetException::cantOpenFile() in /var/www/php-ml/src/Phpml/Exception/DatasetException.php on line 19
4) Mutator \Humbug\Mutator\ReturnValue\NewObject on \Phpml\Exception\InvalidArgumentException::invalidClustersNumber() in /var/www/php-ml/src/Phpml/Exception/InvalidArgumentException.php on line 66
5) Mutator \Humbug\Mutator\Number\IntegerValue on \Phpml\Preprocessing\Normalizer::normalizeL1() in /var/www/php-ml/src/Phpml/Preprocessing/Normalizer.php on line 56
6) Mutator \Humbug\Mutator\Number\FloatValue on \Phpml\Preprocessing\Normalizer::normalizeL1() in /var/www/php-ml/src/Phpml/Preprocessing/Normalizer.php on line 56
7) Mutator \Humbug\Mutator\Arithmetic\Division on \Phpml\Preprocessing\Normalizer::normalizeL1() in /var/www/php-ml/src/Phpml/Preprocessing/Normalizer.php on line 56
8) Mutator \Humbug\Mutator\Number\IntegerValue on \Phpml\Preprocessing\Normalizer::normalizeL2() in /var/www/php-ml/src/Phpml/Preprocessing/Normalizer.php on line 76

------
Escapes
------


1) \Humbug\Mutator\Number\FloatValue
Diff on \Phpml\Regression\SVR::__construct() in /var/www/php-ml/src/Phpml/Regression/SVR.php:
--- Original
+++ New
@@ @@
     ) {
-        parent::__construct(Type::EPSILON_SVR, $kernel, $cost, 0.5, $degree, $gamma, $coef0, $epsilon, $tolerance, $cacheSize, $shrinking, false);
+        parent::__construct(Type::EPSILON_SVR, $kernel, $cost, 1.50, $degree, $gamma, $coef0, $epsilon, $tolerance, $cacheSize, $shrinking, false);
     }
 }
     
    ...
```
