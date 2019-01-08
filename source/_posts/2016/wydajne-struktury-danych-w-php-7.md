---
comments: true
date: 2016-02-15 22:40:00+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2016/5485671820_a6de4d2298_b-150x150.jpg
slug: wydajne-struktury-danych-w-php-7
title: Wydajne struktury danych w PHP 7
wordpress_id: 1139
categories:
- PHP
- Programowanie
tags:
- benchmark
- performance
- php
- php7
- struktury danych
- wektor
---

Najnowsza 7 wersja PHP wniosła bardzo duże usprawnienia pod kątem wydajności. Jedną z przyczyn była nowa [implementacja tablic](https://nikic.github.io/2014/12/22/PHPs-new-hashtable-implementation.html). Pomimo tego, zmiennie w PHP (ze względu na luźne typowanie) dalej nie są zbyt wydajnie i istnieje przestrzeń do poprawy. Tak się składa, że jeden z pasjonatów postanowił coś z tym zrobić. Przedstawiam omówienie najnowszego rozszerzenia dla PHP 7 o nazwie "ds" (data structures) autorstwa: Rudi Theunissen ([@rudi_theunissen](https://twitter.com/rudi_theunissen)).
<!-- more -->

Inspiracją dla tego wpisu był dla mnie sam autor. Patrząc na repo (**php-ds/ds**) i ilość testów jednostkowych, nie da się przejść obojętnie. Całe rozszerzenie zostało naprawdę dobrze zrobione przez prawdziwego pasjonata programowania. Generalnie można zazdrościć :) Przejdźmy do konkretów:

Strona projektu: [https://github.com/php-ds/ds](https://github.com/php-ds/ds)

Namespace rozszerzenia: **Ds\**

Zaczniemy od omówienia nowych interfejsów.

## Collection

Collection jest bazowym interfejsem dla wszystkich nowych struktur. Umożliwia on używanie nowych typów w metodach takich jak: _foreach, echo, count, print_r, var_dump, serialize, json_encode_, i _clone_. Czyli podstawowe zachowanie tablic (interfejsy: Traversable, Iterator, ArrayAccess itp.). Dodatkowo wprowadza parę nowych metod: c_lear, copy, count, isEmpty_ i _toArray_.

## Sequence

_Sequence_ służy do opisania struktury która przechowuje wartości w liniowej przestrzeń. Niektóry języki programowania stosują na to nazwę _List_. Sekwencja jest bardzo podobna do natywnej tablicy z paroma wyjątkami:

  * wartości są zawsze indeksowane za pomocą kolejnych liczb naturalnych (uwzględniając zero): [0, 1, 2, 3 ...]
  * dodanie lub usunięcie wartości spowoduje przeliczenie indeksów
  * dostęp do wartości możliwy jest tylko za pomocą indeksów [0, 1, 2, 3 ...]

## Hashable

_Hashable_ pozwala aby obiekty mogły być używane jako klucze. Autor pisze, że powstało już parę RFC które miały wprowadzić natywną obsługę "haszowania" obiektów, ale żadne z nich nie przeszły. Jest to dość prosty interfejs z dwoma metodami:

  * _hash_ - która powinna zwrócić skalarną wartość (hasz danego obiektu)
  * _equals_ - powinna zwrócić true gdy obiekt jest identyczny (lub zwraca identyczny hash)

Typy które uwzględniają nowy interfejs to _Map_ i _Set_.

Teraz czas na nowe struktury:

## Vector

_Vector_ implementuje interfejs _Sequence_ i jest ciągłą strukturą, która powiększa i pomniejsza się automatycznie. Wektor jest najbardziej efektywną strukturą (pod kątem pamięci) ponieważ mapuje bezpośrednio klucze do wartości bez zbędnych funkcjonalności. **Benchmarki i porównania wydajności struktur zamieszczone są na samym dole wpisu.**
  

    use Ds\Vector;
    $vector = new Vector();
    $vector->push('A');
    $vector->push('B');
    $vector->get(1);
    $vector->set(1, 'C');
    $vector->pop();


Autor utworzył nawet krótkie animacje przedstawiające zasady działania wybranych typów. Poniżej sposób zachowania typu _Vector_:

<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/154438958" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>


**Plusy:**

  * bardzo niskie zużycie pamięci
  * bardzo szybkie iteracje
  * _get, set, push, pop, shift_, i _unshift_ mają złożoność **O(1)**

**Minusy**:
	
  * _insert, remove, shift_, i _unshift_ mają złożoność **O(n)**

>The number one data structure used in Photoshop was Vectors. Sean Parent, [CppCon 2015](https://youtu.be/sWgDk-o-6ZE?t=21m52s)


## Deque

Podobnie jak _Vector_, _Deque_ również implementuje _Sequence_ i tak samo w sposób ciągły przechowuje wartości automatycznie regulując zajmowaną powierzchnię. Posiada on jednak dwa wskaźniki: _head_ i _tail_. Dzięki temu może on niejako zawijać swój koniec co pozwala oszczędzi czynności robienia miejsca nowym wartością. Bardzo dobrze widać to na poniższej animacji:

<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/154438012" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>

Zawijanie wartości ma jednak pewne konsekwencje. Aby otrzymać wartość na konkretnym indeksie trzeba dokonać niezbędnych obliczeń (_(head + position) % capacity_).
    
    use Ds\Deque;
    $deque = new Deque();
    $deque->push('C');
    $deque->push('D');
    $deque->unshift('B');
    $deque->unshift('A');
    $deque->pop(); // return D
    $deque->shift(); // return A

**Plusy:**

  * bardzo małe zużycie pamięci
  * _get, set, push, pop, shift_, i _unshift_ mają złożoność **O(1)**

**Minusy:**
	
  * _insert, remove_ mają złożoność **O(n)**
  * pojemność bufora musi być potęgą liczby 2.

## Stack

_Stack_ to kolejka typu **LIFO** - last in, first out (ostatni na wejściu, pierwszy na wyjściu). Jej elementy można dokładać/usuwać tylko i wyłącznie w ten sposób (czyli nie możemy zwyczajnie iterować po każdym elemencie). Aby sięgnąć po jakąś wartość trzeba ściągać z naszego stosu elementy ostatnio do niego dołożone. _Stack_ wewnętrznie został zaimplementowany na podstawie typu _Vector_.
 
    use Ds\Stack;
    $stack = new Stack();
    $stack->push('A');
    $stack->push('B');
    $stack->push('C');
    $stack->count(); // return 3
    $stack->pop(); // return C
    $stack->pop(); // return B
    $stack->pop(); // return A
    $stack->isEmpty(); // return true

**Plusy:**

  * analogicznie jak _Vector_
  * zabezpiecza kolejność danych
  * uniemożliwia podejrzenie wartości bez jej pobrania

**Minusy:**
	
  * analogicznie jak _Vector_

## Queue

Przeciwieństwo _Stack_. _Queue_ to standardowa kolejka **FIFO** - first in, first out (pierwszy na wejściu, pierwszy na wyjściu). Całość zaimplementowana tak samo _Stack_ - czyli za pomocą _Vector_. W ten sposób plusy i minusy są analogicznie.

    use Ds\Queue;
    $queue = new Queue();
    $queue->push('A');
    $queue->push('B');
    $queue->push('C');
    $queue->count(); // return 3
    $queue->pop(); // return A
    $queue->pop(); // return B
    $queue->pop(); // return C
    $queue->isEmpty(); // return true

## PriorityQueue

Bardziej ciekawsza odmiana _Queue_. Jest to również **FIFO** ale z możliwością nadawania priorytetów (_int_). Wartości z najwyższym priorytetem będą ustawiać się na początek kolejki i schodzić z niej jako pierwsze. Wartości z takim samym priorytetem będą ustawiać się jak w zwykłej kolejce _Queue_.

Autor pokazuje (co będzie widać później w benchmarkach), że jego implementacja _PriorityQueue_ w porównaniu do _SplPriorityQueue_ (bardziej oficjalna implementacja) jest lepsza ponieważ:
	
  * jest dwukrotnie szybsza
  * wykorzystuje dwudziestokrotnie mniej pamięci (tylko 5%)


    use Ds\PriorityQueue;
    $queue = new PriorityQueue();
    $queue->push('A', 1);
    $queue->push('B', 1);
    $queue->push('C', 5);
    $queue->push('D', 5);
    $queue->pop(); // return C
    $queue->pop(); // return D
    $queue->pop(); // return A
    $queue->pop(); // return B
    $queue->isEmpty(); // return true

## Map

_Map_ to prosta kolekcja typu klucz - wartość. Prawie identyczna jak natywny _array,_ ale kluczem może być wszystko, np. obiekt (o ile jest unikalny).
   

    use Ds\Map;
    $map = new Map();
    $map->put('name', 'John');
    $map->get('name'); // return John
    $map->put($object, $value);
    $map->get($object); // return $value
    $map->containsKey($object); // return true

**Plusy:**

  * wydajność i zużycie pamięci analogicznie jak w _array_
  * automatycznie zwalnia dostępną pamięć przy usuwania wartości
  * klucze mogą być obiektami (interfejs _Hashable_)
  * **_put, get, remove_, i _containsKey_ mają złożoność typu** O(1)

**Minusy:**
	
  * brak możliwości konwersji do _array_ gdy klucze są obiektami
  * brak możliwości dostępu po pozycji (indeksie)

## Set

_Set_ jest analogiczny jak _Map,_ ale jego wartości muszą być **unikalne**. Jeżeli dodamy do _Seta_ wartość która już istnieje nie zmieni to jego stanu. Taki sposób przechowywania danych da pewną przewagę w momencie sortowania danych oraz w porównaniu do natywnej funkcji _array_unique_. Do dyspozycji znowu mamy ciekawą wizualizację:
  
<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/154441519" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>

    use Ds\Set;
    $set = new Set();
    $set->add('A');
    $set->add('B');
    $set->add('C');
    $set->count(); // return 3
    $set->add('A');
    $set->add('B');
    $set->count(); // return 3


## Benchmarki

Ok, skoro wiemy już jakie nowe typy danych zostały nam udostępnione, czas przyjrzeć się jak prezentują się one pod kątem wydajnościowym i pamięciowym. Autor udostępnił nam [benchmark](https://github.com/php-ds/benchmarks) który generuje bardzo ładne wykresy. Każdy samodzielnie może uruchomić sobie testy i wygenerować wynik (na własnym sprzęcie).

Pierwsze dwa wykresy dotyczą klasy **_PriorityQueue_**, która wypada zdecydowanie najlepiej. Zarówno czas jak i pobrana pamięć dla operacji **_push_** jest zdecydowanie lepsza od "standardowej" implementacji _SplPriorityQueue_:

[![priority-queue-time](/assets/img/posts/2016/priority-queue-time.png)](/assets/img/posts/2016/priority-queue-time.png)

[![priority-queue-memory](/assets/img/posts/2016/priority-queue-memory.png)](/assets/img/posts/2016/priority-queue-memory.png)

Następnie mamy testy wydajności dla klasy **_Sequence,_** która została zastosowana zarówno w _Vectore_ jak i _Deque_. Czas jak i pamięć jest tutaj zdecydowanie lepsza. Zaczynamy od operacji **_push_**:

[![sequence-push-time](/assets/img/posts/2016/sequence-push-time.png)](/assets/img/posts/2016/sequence-push-time.png) 
[![sequence-push-memory](/assets/img/posts/2016/sequence-push-memory.png)](/assets/img/posts/2016/sequence-push-memory.png)

Kolejno **_unshift_**:

[![sequence-unshift-time](/assets/img/posts/2016/sequence-unshift-time.png)](/assets/img/posts/2016/sequence-unshift-time.png)

I wreszcie **_pop_**:

[![sequence-pop-time](/assets/img/posts/2016/sequence-pop-time.png)](/assets/img/posts/2016/sequence-pop-time.png) 
[![sequence-pop-memory](/assets/img/posts/2016/sequence-pop-memory.png)](/assets/img/posts/2016/sequence-pop-memory.png)

Warto pokazać jeszcze proces zwalniania pamięci dla klasy _**Map**_ - metoda _**remove**_:

[![map-remove-memory](/assets/img/posts/2016/map-remove-memory.png)](/assets/img/posts/2016/map-remove-memory.png)

Na koniec porównanie klasy _**Set**_ kontra natywny **_array_unique_**:

[![set-time](/assets/img/posts/2016/set-time.png)](/assets/img/posts/2016/set-time.png) 
[![set-memory](/assets/img/posts/2016/set-memory.png)](/assets/img/posts/2016/set-memory.png)


## Zestaw testów

W chwili tworzenia tego wpisu, "php-ds" posiadało 2652 testów z 5509 asercjami. Przejście przez nie wszystkie na mojej maszynie trwało średnio **550ms** i pochłaniało **14Mb** pamięci. To naprawdę świetny wynik. Testy są bardzo czytelnie opisane i często zawierają dodatkowe komentarze. Na przykład poniżej wklejam pojedynczy test z wybranych testów klasy Deque:
   

    public function testInsertAtBoundaryWithEqualOnBothSides()
    {
        $instance = $this->getInstance();
        $instance->push(4, 5, 6);
        $instance->unshift(1, 2, 3);

        // [4, 5, 6, _, _, 1, 2, 3]
        //
        // Inserting at index 3 should choose to move either partition.
        $instance->insert(3, 'x');

        $this->assertToArray([1, 2, 3, 'x', 4, 5, 6], $instance);
    }


## Reasumując ...


Mam nadzieję, że zaciekawiłem Was tym wpisem. Ja osobiście byłem pod olbrzymim wrażeniem dokładności i podejścia do tematu autora. Zresztą zmotywowało mnie to nowego wpisu (bo od jakiegoś czasu miałem problem z czasem i motywacją do pisania). Polecam zaznajomienie się z tym repozytorium, jego testami oraz możliwościami.

Trzeba jeszcze na zakończenie powiedzieć jedną rzecz: **optymalizacja nie jest najważniejsza**. PHP nie został stworzony pod kątem super wydajności, choć i tak nie jest źle. Pamiętajcie, że utrzymanie kodu i dbanie o jego **jakość** stoi na pierwszym miejscu (ale oczywiście **to zależy**).

P.S.
Ja osobiście zamierzam wykorzystać to rozszerzenie do mojego najnowszego projektu o którym już wkrótce będę intensywnie pisał.

Zdjęcie z wpisu: [Flickr](https://www.flickr.com/photos/focx/5485671820).
