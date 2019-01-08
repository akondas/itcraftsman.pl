---
comments: true
date: 2014-12-28 22:52:01+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2014/237296033_3a39f95978_b-1-300x225.jpg
slug: pulapki-programowania-w-php-czesc-1
title: Pułapki programowania w PHP część 1
wordpress_id: 846
categories:
- PHP
tags:
- php
- programowanie w php
- pułapki w php
---

Przedstawiam zbiór różnych, wybranych pułapek programowania w języku PHP. Nie wiem czy sama nazwa "pułapki" jest trafiona. Być może lepszym słowem byłyby trudności, absurdy lub nieścisłości. Zdecydujcie sami.<!-- more -->

Celem tego wpisu jest pokazanie złych praktyk (złego projektu) samego kodu PHP. Na podstawie tego można wyciągnąć pewne wnioski, które będą pomocne przy tworzenia własnego kodu, oraz pozwolą na lepsze wyczucie języka. Uważam, że język powinien być narzędziem programisty a nie ideologią, dlatego warto znać również jego słabe strony. Zapraszam do czytania:

	
  1. Funkcja _json_decode_ zamienia zapisany jako string obiekt JSON na strukturę obsługiwaną przez PHP. Zwraca ona null jeżeli przekazany string jest niepoprawny. Nawet w przypadku gdy przekazany string jest faktycznym (prawidłowym i dozwolonym zapisem JSON) nullem. Czyli, jeżeli zdecydujesz się na jej używanie to po każdym jej wywołaniu należy wywołać _json_last_error_ i sprawdzić czy proces parsowania przebiegł prawidłowo. W innym przypadku nigdy nie będziesz mieć pewności, że proces konwersji przebiegł bez problemu. 	
  2. Operator porównania "==". Jego znaczenie nie jest takie oczywiste, bo_ "string" == TRUE_ i _"string"==0_ ale w drugą stronę uwaga ... _TRUE != 0_. Inne ciekawe przypadki to _123 == "123string"_ ale oczywiście .. _"123" != "123string"_. Ten ostatni przykład w skrajnych przypadkach może spowodować, że twój hash hasła nie zawsze będzie bezpieczny ([przykład](https://phpsadness.com/sad/47)). Kolejne ciekawe przypadki to: _"3" == " 3"_, _"2.7" == "2.70"_, oraz _"123" == "0123"_.  Inaczej już przy  _123 != 0123_, ponieważ 0123 jest zapisem w notacji ósemkowej.
  3. Obsługa błędów (choć to jest temat na osobny wpis). W PHP istnieje niespójne podejście do tego co jest dozwolone a co nie. Przykłady błędów które nie powodują przerwania skryptu (zgłaszają jedynie istnienie problemu):

    1. użycie niezdefiniowanej stałej (notice)	
    2. próba uzyskania dostępu do atrybutu czegoś co nie jest obiektem (notice)	
    3. próba uzyskania dostępu do nie istniejącego atrybutu (warning)	
    4. foreach (7 as $v) (warning)
  Z drugiej strony błędy, które powodują przerwanie skryptu:
  
    1. próba wywołania niezdefiniowanej  funkcji (fatal error)
    2. próba dostępu do nieistniejącej stałej klasy, np. $obj::name (fatal error)
    3. brak średnika w ostatnim wyrażeniu w pliku (lub na końcu bloku) (parse error)	
    4. użycie stałej jako nazwy funkcji, zmiennej lub klasy (parse error)


  4. Niektóre wbudowane funkcje konfliktują z funkcjami zwracającymi referencję. Przykład jest lekko skomplikowany ale zachęcam do przeczytania[ tego wpisu](https://www.phpwtf.org/php-function-calls-returning-references). 

	
  5. Wyjątki wyrzucone w metodzie __autoload lub destruktorze powodują błędy fatal error.  Błąd ten został dla destruktora poprawiony w wersji 5.3.6.  W wersji tej poprawiono również inny ciekawy błąd. Weźmy oto taką konstrukcją:

```php
new SomeClass(someFunction())
```

Jeżeli _someFunction()_ wyrzuci wyjątek to konstruktor klasy _SomeClass _nie zostanie wywołany, natomiast jej destruktor tak !

	
  6. Inkrementacja jest również ciekawa. Inkrementujcą (++) NULL otrzymamy 1. Dekrementując (--) NULL otrzymamy NULL. Co ciekawe, dekrementując zmienną typu _string_ otrzymamy ten sam string, przy inkrementacji już to tak nie działa.

	
  7. Funkcja _create_function_. Jest to nic innego jak wywołanie _eval_ w odpowiednim opakowaniu. Tworzy ona funkcję z zwyczajną nazwą i inicjuje ją globalnie (w ten sposób nie będzie ona nigdy zebrana przez garbage collector - uwaga na pętle!). Mało tego utworzona funkcja nie wie nic o aktualnym zasięgu zmiennych (current scope).  

	
  8. Puste linie przed lub pod <?php ... ?> zawsze traktowane są jak zwykły tekst i wypuszczane prosto do ciała odpowiedzi (response). W ten sposób powodują najczęściej błędy typu "headers already sent". Trudno temu zapobiec. Najlepiej jest nie zamykać pliku tagiem "?>" i pilnować pierwszych linii. Widziałem również kiedyś rozwiązanie z _ob_start_, jednak nie zalecam. 

	
  9. Funkcja _register_tick_function_ akceptuje jako parametr domknięcie (closure) lub dowolny inny callback . Niestety funkcja odwrotna _unregister_tick_function_ akceptuje tylko string. Swoją drogą sama przydatność tych funkcji jest dla mnie zagadką.

	
  10. Argumenty funkcji mogą być określonego typu (type hints). Choć wiele wbudowanych funkcji wymaga zmiennych typu int lub string to sam programista nie może takiego wymagania stworzyć. Rozważmy poniższy przykład:

```php
function test(string $s) {}
test("hello world");
```

Wynikiem uruchomienia takiego kodu będzie (jakkolwiek to brzmi):

```
Catchable fatal error: Argument 1 passed to test() must be
an instance of string, string given, called in ...
```

Niektóry z tych punktów mogą okazać się oczywiste, inne nie. Niemniej pokazują one jednak jakie trudność czekają na programistę PHP. Są to problemy, które powstały na poziomo samego języka PHP i rozwiązanie ich nie zawsze jest możliwe. W następnym wpisie postaram się przedstawić kolejnego tego typu zagadnienie (tak, to jest tylko mała ich część). PHP jest językiem któremu daleko do ideału ... ale pomimo tego radzi sobie na dzisiejszym rynku doskonale.
