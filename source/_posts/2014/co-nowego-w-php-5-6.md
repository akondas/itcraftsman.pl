---
comments: true
date: 2014-07-18 19:41:14+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2014/9187378656_c3c5aec621_c.jpg
slug: co-nowego-w-php-5-6
title: Co nowego w PHP 5.6
wordpress_id: 93
categories:
- PHP
tags:
- php
- php 5.6
---

PHP w wersji 5.6 jest tuż za rogiem. Sprawdźmy jakie nowości czekają nas w nadchodzącej wersji.

<!-- more -->


## Variadic functions


Funkcje o zmiennej liczbie argumentów (variadic functions) możemy teraz definiować używając operatora "..." (splat operator). Najlepiej pokazać to na przykładzie. Do tej pory, aby móc zdefiniować funkcję o zmiennej liczbie parametrów, trzeba było zrobić coś w stylu:

```
function checkObjectWithAttributes() {
	$args = func_get_args();
	$object = array_shift($args);

	var_dump($object, $args);
}

checkObjectWithAttributes('object', 'one', 'two', 'three');
```

W wyniku wywołania otrzymamy:

```
string(6) "object"
array(3) {
  [0]=>
  string(3) "one"
  [1]=>
  string(3) "two"
  [2]=>
  string(5) "three"
}
```

Od wersji 5.6 ten sam efekt będzie można uzyskać używając splat operatora:

```
function checkObjectWithAttributes($object, ...$attributes) {
	var_dump($object, $attributes);
}

checkObjectWithAttributes('object', 'one', 'two', 'three');
```

Wynik wywołania będzie identyczny. Zmienna wpisana za operatorem "..." będzie teraz wyłapywać wszystkie pozostałe argumenty funkcji. Od teraz _func_get_args_ odchodzi do lamusa :)




## Wypakowywanie argumentów


Poznany przed chwilą splat operator może posłużyć także do rozpakowywania argumentów funkcji. Załóżmy że nasza funkcja przyjmuje 3 parametry. Poniżej przykład w jaki sposób użycie operatora "..." pozwala wypakować tablicę na listę trzech kolejnych parametrów funkcji:

```
function doMagic($one, $two, $three) {
	return $three . $one . $two;
}

$params = ['ala', 'ma', 'kota'];
echo doMagic(...$params);

// można również łączyć sposoby
$params = ['ma', 'kota'];
echo doMagic('ala', ...$params);
```




## Wyrażenia w stałych


Constant scalar expressions - czyli możliwość używania wyrażeń przy definiowaniu stałych. Wyrażenia te możemy teraz stosować zarówno przy definiowaniu stałych jaki i stałych klas oraz wartości domyślnych parametrów. Poniższy przykład nigdy nie zadziała poniżej wersji 5.6:

```
const A = 1;

const B = A + 1;

class MyShop {

	const TAX = 0.21;

	const FEE = B * 0.1;

	const FACTOR = self::TAX + self::FEE;

	public function getPrice($factor = self::TAX + 0.3) {
		return 10 * $factor;
	}

}

echo MyShop:FACTOR;
echo (new MyShop)->getPrice()."\n";
```




## use const oraz use function


Od teraz operator _use_ będzie wspierał dwie nowe konstrukcje: _const_ oraz _function_. Pozwolą one zaimportować odpowiednią stałą lub funkcję z innej przestrzeni nazw.

```
namespace Blog\Post {
    const ID = 21;
    function comments() { echo __FUNCTION__."\n"; }
}

namespace {
    use const Blog\Post\ID;
    use function Blog\Post\comments;

    echo FOO."\n";
    comments();
}
```

W wyniku uruchomienia nz wersji 5.5 otrzymamy parse error ale w wersji 5.6 otrzymamy

```
21
Blog\Post\comments
```




## Inne nowości


Jak zawsze ulepszono również szybkość oraz zmniejszono zapotrzebowanie na pamięć. Dodatkowo wprowadzono:



	
  * nowy operator arytmetyczny **oraz =**

	
  * phpdbg - nowy interaktywny debuger

	
  * obsługę plików większych niż 2GB

	
  * dodano nową funkcję  kryptograficzną oraz nowy algorytm szyfrowania


Po szczegółową listę zmian odsyłam pod adres [http://php.net/manual/en/migration56.new-features.php](http://php.net/manual/en/migration56.new-features.php)



Dzisiaj krótko ale treściwie :). Jak zawsze zapraszam do komentowania.



Zdjęcie z wpisu: [Flickr](https://flic.kr/p/eZRHAh) na licencji Creative Commons
