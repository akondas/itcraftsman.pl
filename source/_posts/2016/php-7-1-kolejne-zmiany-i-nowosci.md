---
comments: true
date: 2016-11-27 11:15:10+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2016/php71-300x169.png
slug: php-7-1-kolejne-zmiany-i-nowosci
title: PHP 7.1 kolejne zmiany i nowości
wordpress_id: 1487
categories:
- PHP
tags:
- nullable types
- php
- php 7
- php 7.1
- void functions
---

Rok temu wydana została oczekiwana przez wszystkich wersja **PHP 7** (czytaj [PHP 7 – nadchodzą nowości !](https://itcraftsman.pl/php-7-nadchodza-nowosci/)). Prawie równocześnie z jej premierą została zapowiedziana lista zmiana na którą musieliśmy czekać prawie rok. Pierwszego grudnia nastąpi oficjalna premiera **PHP 7.1**. Poniżej krótki spis nowości i zmian jakie wchodzą w skład nowej wersji 7.1. <!-- more -->


## Nowe funkcjonalności


### Nullable types


Deklaracja parametrów i zwracanych wartości mogą dopuszczać teraz wartość _null_. Wystarczy w deklaracji zwracanego typu lub argumentu funkcji użyć znaku zapytania:


    <?php
    
    function getId(): ?int 
    {
        return 1; // lub null
    }
    
    function parseLine(?string $text) 
    {
        
    }
    
    parseLine('Lorem lipsum');
    parseLine(null);
    
Nie zwrócenie żadnej wartości, lub nie przekazanie parametru wywoła odpowiednie błędy.

    Fatal error: Uncaught TypeError: Return value of getId() must be of the type integer or null, none returned in index.php
    
    Fatal error: Uncaught ArgumentCountError: Too few arguments to function parseLine(), 0 passed in index.php on line 14 and exactly 1 expected in index.php:10


Warto tutaj zaznaczyć, że jest to zmiana niekompatybilna wstecz. To znaczy, że wcześniej w przypadku podania za małej liczby parametrów emitowany był tylko i wyłącznie _warning _(teraz fatal error).


### Void functions

Jeżeli dana funkcja lub metoda nie zwraca żadnej wartości, możemy użyć słowa kluczowego _void_:
      
    function merge(&$a, $b): void
    {
        $a = array_merge($a, $b);
    }


Należy pamiętać, że zwrócenie wartości _null,_ to nie to samo co nie zwrócenie żadnej wartości (lub wpisanie samego _return;_).

### Symmetric array destructuring

Pojawiła się nowa alternatywa dla wyrażenia _list()_. Do destrukturyzacji tablic i przechwytywania wartości można użyć bezpośrednio nowej notacji tablicowej []. To samo tyczy się deklaracji w pętli foreach:   
    
    $products = [
        1 => 'Laptop',
        2 => 'Smartphone'
    ];
    
    [$id, $name] = $products[0]; // wcześniej list($id, $name)
    
    foreach($products as [$id, $name]) {
    
    }
    
### Class constant visibility

Definicje stałych w klasach mogą teraz zawierać poziom widoczności:
  
    
    class Parser
    {
        public const REGEXP_A = '/[0-9]/';
        protected const REGEXP_B = '/[0-9]/';
        private const REGEXP_C = '/[0-9]/';
    }


### iterable pseudo-type

Nowy pseudo typ: _iterable_, który może zostać wykorzystany przy definicji argumentów i zwracanych wartości. Typ _iterable_ akceptuje typ _array_ lub obiekt który implementuje wbudowany interfejs _Traversable_.
   
    
    function sum(iterable $iterator)
    {
        return array_sum($iterator);
    }


W tym miejscu warto również dodać, że słowa _iterable_ jak i _void_ stały się kluczowymi i nie można ich użyć jako nazwy klasy, interfejsu lub traita.


### Multi catch exception handling

Wyłapywanie kilku wyjątków jednocześnie w jednej instrukcji _catch()_ za pomocą znaku "|":
   
    try {
    
    } catch (ConnectionErrorException | TransferException) {
    
    }

### Support for keys in _list()_

Wsparcie dla kluczy w wyrażeniach _list()_ i nowej notacji niszczącej _[]_. Od teraz możliwe jest rozbijanie tablic asocjacyjnych:

    
    $data = [
        ["id" => 1, "name" => 'Tom'],
        ["id" => 2, "name" => 'Fred'],
    ];
    
    list("id" => $id1, "name" => $name1) = $data[0];
    ["id" => $id1, "name" => $name1] = $data[0];
    
    foreach ($data as list("id" => $id, "name" => $name)) {
       
    }
    
    foreach ($data as ["id" => $id, "name" => $name]) {
    
    }


Spis wszystkich zmiana i nowych ficzerów znajdziecie pod adresem:  [https://php.net/manual/en/migration71.php](https://php.net/manual/en/migration71.php)


## Wydajność 5.6 vs 7.0 vs 7.1


Na koniec postanowiłem przetestować jeszcze dwa proste benchmarki od Zenda: [bench.php](https://github.com/php/php-src/blob/master/Zend/bench.php) oraz [micro_bench.php](https://github.com/php/php-src/blob/master/Zend/micro_bench.php) (na osi pionowej czas w sekundach):

![](/assets/img/posts/2016/php-7.1-performance-1.png)

Przy okazji, jeżeli dalej korzystacie z wersji 5.6 (lub mniejszej) to zalecam upgrade. Jak widać na powyższym wykresie, wzrost wydajności jest dwukrotny.


## PHP 7.2

W sieci pojawiają się już od jakiegoś czasu zapowiedzi zmian w wersji 7.2, oto kilka z nich:
 	
  * Pipe operator - [https://wiki.php.net/rfc/pipe-operator](https://wiki.php.net/rfc/pipe-operator)
  * Null Coalesce Equal Operator - [https://wiki.php.net/rfc/null_coalesce_equal_operator](https://wiki.php.net/rfc/null_coalesce_equal_operator)
  * Argon2 Password Hash - [https://wiki.php.net/rfc/argon2_password_hash](https://wiki.php.net/rfc/argon2_password_hash)
  * Convert numeric keys in object/array casts - [https://wiki.php.net/rfc/convert_numeric_keys_in_object_array_casts](https://wiki.php.net/rfc/convert_numeric_keys_in_object_array_casts)

## PHP 8.0

Pojawiają się również pierwsze przebłyski na temat nowości w wersji 8, ale jak na razie informacje dotyczą głównie usuwania starych rozszerzeń (_mdcrypt_) lub pozbywanie się niebezpiecznych funkcjonalności (modyfikator _/e_ w funkcji _mb_ereg_replace()_). Trwają również prace nad implementacją JIT ([Just-in-time compilation](https://en.wikipedia.org/wiki/Just-in-time_compilation)) w wersji 8: [https://externals.io/thread/268](https://externals.io/thread/268)

Źródła informacji:

 * [https://php.net/manual/en/migration71.php](https://php.net/manual/en/migration71.php)
 * [https://wiki.php.net/rfc](https://wiki.php.net/rfc)
 * [https://blog.pascal-martin.fr/post/php71-en-road-towards-72-and-80.html](https://blog.pascal-martin.fr/post/php71-en-road-towards-72-and-80.html)
 * [https://wiki.php.net/rfc/php8](https://wiki.php.net/rfc/php8)
