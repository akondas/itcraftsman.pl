---
comments: true
date: 2016-12-21 05:46:18+00:00
extends: _layouts.post
featured: true
slug: techniki-refaktoryzacji-upraszczanie-wyrazen-warunkowych
title: 'Techniki refaktoryzacji: upraszczanie wyrażeń warunkowych'
wordpress_id: 1534
cover_image: /assets/img/posts/2016/school-1223873_1920-1024x683.jpg
categories:
- Refaktoryzacja
tags:
- clean code
- refaktoryzacja
- wyrażenia warunkowe
---

Wyrażenia warunkowe stają się coraz bardziej skomplikowane w swojej logice w miarę upływu czasu. Na szczęście istnieją techniki, które pomogą Ci walczyć z tym problemem.<!-- more -->

Czym jest sama refaktoryzacja?


> **Refaktoryzacja** (*czasem też refaktoring, ang. refactoring*) – proces wprowadzania zmian w projekcie/programie, w wyniku których zasadniczo nie zmienia się funkcjonalność. Celem refaktoryzacji jest więc nie wytwarzanie nowej funkcjonalności, ale utrzymywanie odpowiedniej, wysokiej jakości organizacji systemu. (źródło: [wikipedia](https://pl.wikipedia.org/wiki/Refaktoryzacja))


Jednym z ważniejszych rezultatów refaktoryzacji jest poprawa czytelności kodu poprzez jaśniejsze wyrażanie jego **intencji **(o czym bardzo wielu programistów zapomina):


<blockquote>_As with any large block of code, you can make your intention clearer by decomposing it and replacing chunks of code with a method call named after the intention of that block of code. **MARTIN FOWLER (**Refactoring - p. 238)_</blockquote>


Zobaczmy teraz jakie techniki refaktoryzacji możemy zastosować w celu upraszczania wyrażeń warunkowych w naszym kodzie.




## Dekompozycja warunku


**Problem
**Skomplikowany kod warunku (i_f_/_else_ lub _switch_)

    
 ```php
if ($date->before(SUMMER_START) || $date->after(SUMMER_END)) {
    $charge = $quantity * $winterRate + $winterServiceCharge;
} else {
    $charge = $quantity * $summerRate;
}
```




**Rozwiązanie
**Dekompozycja poszczególnych składników warunków do osobnych metod; wyciągamy sam warunek, oraz jego bloki

    
```php
if (notSummer($date)) {
    $charge = winterCharge($quantity);
} else {
    $charge = summerCharge($quantity);
}
```




**Dlaczego refaktoryzować?**

Im dłuższy staje się warunek tym trudniej go zrozumieć. Co daje dekompozycja warunku?



 	
  * Wyciągniecie warunku do osobnej metody czyni kod bardziej czytelniejszym, co prowadzi do łatwiejszego utrzymania go. Gdy wrócisz do tego miejsca za dwa lub trzy miesiące nie będziesz musiał ponownie zastanawiać się co oznacza warunek, nazwa metody (np. _notSummer_) wyraźnie zasugeruje o co chodziło

 	
  * Dekompozycja prowadzi również do większej zwięzłości kodu (warunki są dużo krótsze). Warunek z metodą _isWeekDay_ jest dużo ładniejszy niż porównywanie dwóch dat.


**Jeżeli masz trudności z nazywaniem nowych metod, przeczytaj wpis: [Dobre praktyki tworzenia nazw](http://itcraftsman.pl/dobre-praktyki-tworzenia-nazw/).**




## Konsolidacja wyrażeń warunkowych


**Problem
**Kilka warunków, które prowadzą do tego samego rezultatu:

    
```php
public function calculateProjectRate($request, $language, $timeline)
{
    if ($request == 'interpretive dancing') {
        return false;
    }
    if ($language == 'Fortran 1') {
        return false;
    }
    if ($timeline == '1 day') {
        return false;
    }
    // continue rate processing
}
```




**Rozwiązanie**
Konsolidacja wszystkich warunków w jedno wyrażenie:

    
```php
public function calculateProjectRate($request, $language, $timeline)
{
    if($this->isNotOurKindOfWork($request, $language, $timeline)) {
        return false;
    }
    // continue rate processing
}

private function isNotOurKindOfWork($request, $language, $timeline)
{
    return $request == 'interpretive dancing' || $language == 'Fortran 1' || $timeline == '1 day';
}
```




**Dlaczego refaktoryzować?**

Twój kod zawiera wiele ścieżek alternatywnych, które zwracają ten sam rezultat. Warto połączyć je w jeden nazwany warunek, dzięki temu:



 	
  * Eliminujesz duplikację w kodzie. Połączenie kilku warunków w jednej metodzie ma na celu pokazanie przyszłemu programiście, że robisz tylko jedno skomplikowane sprawdzenie prowadzące do jednej akcje.

 	
  * Izolujesz kilka skomplikowanych wyrażeń w jednej reużywalnej metodzie. Twój kod staje się bardziej czytelniejszy i jawnie **wyraża swoje intencje**.





## Konsolidacja zduplikowanego fragmentu warunku


**Problem**
Identyczny fragment kodu w każdym rozgałęzieniu warunku:

    
```php
public function calculateProjectRate()
{
    if ($this->isComplexWork()) {
        $rate = $this->calculateComplexRate();
        $this->verifyRateWithTheBoss($rate);
    } else {
        $rate = $this->calculateBaseRate();
        $this->verifyRateWithTheBoss($rate);
    }
}
```




**Rozwiązanie**
Wyciągnięcie kodu poza warunek:

    
```php
public function calculateProjectRate()
{
    if ($this->isComplexWork()) {
        $rate = $this->calculateComplexRate();
    } else {
        $rate = $this->calculateBaseRate();
    }
    $this->verifyRateWithTheBoss($rate);
}
```




**Dlaczego refaktoryzować?**

Taki stan kodu najczęściej możemy znaleźć w projektach wieloosobowych, gdzie z czasem nikt nie zwrócił uwagi, że dany fragment wykonuje się za każdym razem. Ta technika prowadzi do zmniejszania ilości duplikującego się kodu.




## Usuwanie flagi kontrolnej


**Problem**
Zmienna typu _bool_, która zachowuje się jako flaga kontrolna dla innego wyrażenia:

    
```php
public function findByLength($length)
{
    $found = false;
    $i = 0;
    $length = count($this->users);
    while ($i < $length && !$found) {
        $user = $this->users[$i];
        if (strlen($user) ==$length) {
            $found = true;
            return $user;
        }
        $i++;
    }
}
```




**Rozwiązanie
**Użycie słów kluczowych _break_, _continue_ i _return_ zamiast zmiennej typu _bool_ (przy okazji zamieniany pętla _while_ na _foreach_):

    
```php
public function findByLength($length)
{
    foreach ($this->users as $user) {
        if (strlen($user) == $length) {
            return $user;
        }
    }
}
```




**Dlaczego refaktoryzować?**

Flaga kontrolna to echo przeszłości programowania liniowego, gdzie programiści mieli jeden punkt wejścia do funkcji i jeden punkt wyjścia. W obecnych czasach nasze języki posiadają więcej ciekawszych możliwości sterowania przepływem. Możemy użyć _break_, który stopuje pętle, _continue_, który przechodzi do kolejnego elementu zbioru oraz _return_ który natychmiast zwraca wartość. Kod bez flagi kontrolnej jest o wiele lżejszy i (znowu, jak to bywa przy refaktoryzacji) bardziej czytelniejszy.




## Wymiana zagnieżdżonego warunku na instrukcję wyjścia


Bardzo często ta technik nosi również nazwę "**Avoid Else, Return Early**" (czyli omijamy elsy i zwracamy wynik najszybciej jak to możliwe).

**Problem
**Grupa zagnieżdżonych warunków z której trudno wyczytać prawidłowy przepływ danych:

    
```php
function getPayAmount()
{
    if ($this->isDead) {
        $result = $this->deadAmount();
    } else {
        if ($this->isSeparated) {
            $result = $this->separatedAmount();
        } else {
            if ($this->isRetired) {
                $result = $this->retiredAmount();
            } else {
                $result = $this->normalPayAmount();
            }
        }
    }
    return $result;
}
```




**Rozwiązanie**
Izolacja wszystkich specjalnych wyrażeń do osobnych warunków (może nawet metod) i umieszczenie ich najwyżej jak to możliwe. Czyli najpierw sprawdzamy wszystkie warunki krańcowe, a następnie zwracamy domyślną wartość. Najlepsze rozwiązanie to **płaska list warunków** jeden pod drugim (im mniej tym lepiej):

    
```php
function getPayAmount()
{
    if ($this->isDead) {
        return $this->deadAmount();
    }

    if ($this->isSeparated) {
        return $this->separatedAmount();
    }

    if ($this->isRetired) {
        return $this->retiredAmount();
    }

    return $this->normalPayAmount();
}
```




Esencję tej techniki bardzo dobrze oddaje cytat z książki Refactoring Martina Fowlera:


<blockquote>_If you are using an if-then-else construct you are giving equal weight to the if leg and the else leg. This communicates to the reader that the legs are equally likely and important. Instead, the guard clause says, "This is rare, and if it happens, do something and get out."_
**MARTIN FOWLER **Refactoring - p.251</blockquote>




**Dlaczego refaktoryzować?**

W tym przypadku staramy się uniknąć czegoś co potocznie nazywane jest "conditional hell" i pozostawione gdzieś w kodzie może prowadzi do czegoś w stylu:

    
```php
if () {
    if () {
        do {
            if () {
                if () {
                    if () {
                        ...
                    }
                }
                ...
            }
            ...
        }
        while ();
        ...
    }
    else {
        ...
    }
}
```


W takim przypadku bardzo trudno jest wydedukować jakie dane otrzymamy na wyjściu lub co tak naprawdę zadzieje się po drodze. Celem tej techniki jest uzyskanie płaskiej, możliwie jak najmniejsze listy warunków, która sprawdzą logikę i szybko wychodzą z funkcji w razie potrzeby (np. poprzez pusty _return;_).




## Wprowadzenie asercji


**Problem**
Dla danego fragmentu kodu, aby działał on poprawnie, muszą zaistnieć jakieś określone warunki.

    
```php
function getExpenseLimit() 
{
    return ($this->expenseLimit != NULL_EXPENSE) ?
        $this->expenseLimit :
        $this->primaryProject->getMemberExpenseLimit();
}
```


W powyższym fragmencie zakładamy, że albo istnieje jakaś wartość w atrybucie _expenseLimit_ i jest różna od stałej (_NULL_EXPENSE_) **lub** atrybut _primaryProject_ jest jakimś obiektem na którym można wywołać metodę _getMemberExpenseLimit_. Te dwa warunki są zaprezentowane w sposób mało jawny (dla pierwszego widzimy wyraźny warunek, ale drugi jest bardziej schowany).

**Rozwiązanie**
Jawne wprowadzenie założeń przy pomocy asercji:

    
```php
function getExpenseLimit() 
{
    assert($this->expenseLimit != NULL_EXPENSE || isset($this->primaryProject));

    return ($this->expenseLimit != NULL_EXPENSE) ?
        $this->expenseLimit:
        $this->primaryProject->getMemberExpenseLimit();
}
```




**Uwaga**

W php funkcja _assert_ działa inaczej dla wersji PHP 7. Warto zaznajomić się z dokumentacją: [http://php.net/assert](http://php.net/assert)



**Dlaczego refaktoryzować?**

Wprowadzenie asercji w jawny sposób pokazuje, że w ciele funkcji istnieją jakieś określone założenia, których warunki mogły zostać spełnione w innym miejscu, przez co nie są one jawne. Asercja jawnie przedstawia jakie wymagania musi spełnić aktualny stan, aby program ruszył dalej. W przypadku brak takiej assercji nastąpi egzekucja kodu, która może wywołać niechciane rezultaty (na przykład zapisanie niekompletnych lub niespójnych danych).

Czasami lepszym rozwiązaniem jest wyrzucenie odpowiedniej klasy wyjątku. Można w ten sposób tworzyć bardziej indywidualną obsługę błędów. W PHP 7 funkcja assert przyjmuje jako drugi parametr obiekt wyjątku, który zostanie rzucony w razie niespełnienia asercji.




## Wprowadzenie pustego obiektu (Null Object)


**Problem**
W kodzie znajdują się instrukcje sprawdzające czy dana zmienna jest nullem:

    
```php
if (null == $customer) { // yoda style :)
    $plan = BillingPlan::basic();
} else {
    $plan = $customer->getPlan();
}
```




**Rozwiązanie**
Zamiast zwracać wartość null, zwróć NullObject, które reprezentuje "puste/domyślne" zachowanie:

    
```php
class NullCustomer extends Customer
{
    public function getPlan()
    {
        return new NullPlan();
    }

}

$plan = $customer->getPlan();
```




**Dlaczego refaktoryzować?**

Samo powstanie wartości _null_ jest dość kontrowersyjne (czytaj: [Billion dollar mistake](https://blog.valbonne-consulting.com/2014/11/26/tony-hoare-invention-of-the-null-reference-a-billion-dollar-mistake/)). Jej występowanie w kodzie doprowadza do wielu błędów (słynny _NullPointerException_) oraz w znacznym stopniu wymusza stosowanie dodatkowych instrukcji warunkowych (jak ta z przykładu powyżej). Zastosowanie pustego obiektu prowadzi do redukcji takich warunków. Minusem tego rozwiązania jest potrzeba stworzenia dodatkowej klasy, oraz sprawdzenie w miejscu zwracania rezultatu. Co i tak prowadzi do powstania warunku (jak w przykładzie poniżej), ale taki warunek można sprytnie "ukryć" w innej warstwie, odpowiedzialnej na przykład za konstrukcję. To pozwoli pozbyć się sprawdzeń z innych miejsc kodu.

    
```php
$customer = ($order->customer != null) ?
  $order->customer :
  new NullCustomer();
```


To rozwiązania jest również wzorcem projektowym o nazwie "Null Object", któremu na pewno poświęcę osobny wpis.




## Zastąpienie Instrukcji Warunkowej Polimorfizmem


**Problem**
Instrukcje warunkowe wykonuję różne akcje w zależności od typu lub atrybutów jakiegoś obiektu (lub innej struktury danych).

**Rozwiązanie**
Ta technika zasługuje na osobny wpis, dlatego w dzisiejszym artykule pozostawię ten punkt otwarty (jak tylko uda mi się go napisać to wstawię tutaj link, wpis jest już na ukończeniu).




## Reasumując


Przedstawione techniki dążą do poprawy czytelności kodu, a nie jego wydajności. Pamiętajcie, że kod będziecie czytać ponad 100 razy częściej niż go pisać.

Więcej technik znajdziecie pod adresem: [http://refactoring.com/catalog/](http://refactoring.com/catalog/)
