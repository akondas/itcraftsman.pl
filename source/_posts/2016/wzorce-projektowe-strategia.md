---
comments: true
date: 2016-12-14 18:31:04+00:00
extends: _layouts.post
featured: true
slug: wzorce-projektowe-strategia
title: 'Wzorce projektowe: Strategia'
wordpress_id: 1501
cover_image: /assets/img/posts/2016/chess-1403622_1280.jpg
categories:
- Wzorce projektowe
tags:
- interfejs
- open/closed principle
- strategia
- wzorce projektowe
---

Jednym z głównych założeń dobrego programowania projektowego jest zasada "**Open/closed principle**" (zasada otwarte-zamknięte), która mówi, że klasy powinny być zamknięte na modyfikację, ale otwarte na rozszerzanie. Wzorzec strategii pozwala w prosty sposób na podtrzymywanie tego standardu w kodzie.

<!-- more -->


## Problem


Od lat w społeczności programistów istnieje tendencja do "**maximize cohesion and minimize coupling**" (co można by przetłumaczyć: zwiększania spójności i zmniejszania powiązań). Strategia bardzo dobrze rozwiązuje problem zmniejszania powiązań. Wzorzec ten pozwala to osiągnąć poprzez zdefiniowanie interfejsów i używanie ich w klasach bazowych (nazwijmy takie klasy **klientami**). Następnie szczegóły implementacyjne ukrywane są w klasach pochodnych implementujących zdefiniowany interfejs. Dzięki temu klienci mogą swobodnie powiązać się z abstrakcją.

Inaczej mówiąc, rozwiązujemy ten problem poprzez **programowanie do interfejsu zamiast do implementacji** ("Program to an interface, not an implementation"). Ponieważ klienci przywiązani są do abstrakcji (abstract coupling), a nie konkretnej implementacji, pozostają swobodnie otwarci na rozszerzanie (poprzez dodanie nowej klasy implementującej zdefiniowany interfejs).


## Cele wzorca

  * Zdefiniowanie rodziny algorytmów, hermetyzacji każdego z nich, i uczynienie ich zamiennych. Strategia pozwala na zmianę algorytmu niezależnie od klientów, którzy go używają.
 	
  * Uchwycenie abstrakcji w interfejsie, zakopanie szczegółów implementacji w klasach pochodnych.

## Struktura


W strategii definiujemy wspólny interfejs, dla obsługiwanych algorytmów, posiadający dozwolone metody. W kolejnym kroku implementujemy poszczególne strategie w poszczególnych klasach. Następnie budujemy klasę klienta, która będzie pozwalała na określenie strategii (na przykład poprzez jej wstrzyknięcie) oraz będzie posiadała referencję do aktualnie wybranej strategii. Klient współpracuje z wybraną strategią w celu wykonania określonego zadania.

[![](/assets/img/posts/2016/strategy-pattern.png)](/assets/img/posts/2016/strategy-pattern.png) Struktura wzorca strategii (kliknij aby powiększyć)




## Przykładowa implementacja


Abstrakcyjny problem: transport gości na lotnisko. Transportu możemy dokonać na kilka sposobów: autobusem, samochodem lub taksówką. Przykładowa implementacji w PHP:

    
```php
/* klasy pomocnicze */
class User {}
class TransportResult {}

interface TransportStrategy
{
    public function transport(User $user): TransportResult;
}

class CityBusTransport implements TransportStrategy
{
    public function transport(User $user): TransportResult
    {
        // TODO: Implement transport() method.
        return new TransportResult();
    }
}

class PersonalCarTransport implements TransportStrategy
{
    public function transport(User $user): TransportResult
    {
        // TODO: Implement transport() method.
        return new TransportResult();
    }
}

class TaxiTransport implements TransportStrategy
{
    public function transport(User $user): TransportResult
    {
        // TODO: Implement transport() method.
        return new TransportResult();
    }
}

class TransportationToAirport
{
    /**
     * @var TransportStrategy
     */
    private $strategy;

    /**
     * @param TransportStrategy $strategy
     */
    public function __construct(TransportStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function run(User $user)
    {
        $this->strategy->transport($user);
    }

}

$user = new User();
$transportation = new TransportationToAirport(new CityBusTransport());
$transportation->run($user);
```


Za pomocą interfejsu _TransportStrategy_, możemy rozszerzać domenę o kolejne implementacje. Natomiast samo wydzielenie poszczególnych zachowań do osobnych klas powoduje, że całość możemy łatwo testować:

    
```php
class StrategyTest extends \PHPUnit_Framework_TestCase
{
    public function testCityBusTransportationStrategy()
    {
        $user = new User();
        $transportation = new TransportationToAirport(new CityBusTransport());

        $result = $transportation->run($user);

        $this->assertInstanceOf(TransportResult::class, $result);
    }
}
```


## Kiedy stosować

  * gdy istnieje potrzeba rozwiązania danego problemu na parę różnych sposobów
  * gdy system musi być otwarty na rozszerzanie
  * gdy chcesz zwiększyć czytelność swojego kodu
  * gdy chcesz jasno i jawnie wyrazić intencje w kodzie


## Strategia w kilku krokach
 	
  1. Zidentyfikuj algorytm (lub zachowanie) który klient chciałby obsłużyć w sposób elastyczny (znajdź tzw. "flex point").
  2. Stwórz interfejs z minimalną ilością metod która pokrywa zachowanie tego algorytmu.
  3. Schowaj implementacje (i jej alternatywy) w klasach pochodnych implementując stworzony interfejs.
  4. Powiąż klienta z algorytmem poprzez interfejs.

## Przykład realnego użycia


Na koniec przedstawiam bardziej realny przykład użycia wzorca strategii. Realny problem: generowanie wartości identyfikator encji w bazie. Przykład inspirowany jest biblioteką _Doctrine2_. Załóżmy, że mamy klasę, która zapisuje encje w bazie i potrzebuje dla każdej wygenerować odpowiednie ID.

    
```php
class EntityPersister
{

    /**
     * @var IdGenerator
     */
    private $idGenerator;

    /**
     * @param IdGenerator $idGenerator
     */
    public function __construct(IdGenerator $idGenerator)
    {
        $this->idGenerator = $idGenerator;
    }


    public function executeInserts()
    {
        /* ... */
        $generatedId = $this->idGenerator->generate($this->em, $entity);
        /* ... */
    }

}
```


Takie ID może być generowane na parę różnych sposobów, więc stworzenie interfejsu wydaje się naturalnym rozwiązaniem:

    
```php
interface IdGenerator
{
    /**
     * @param EntityManager $em
     * @param $entity
     * @return mixed
     */
    public function generate(EntityManager $em, $entity);
}
```


Na koncie pozostaje utworzenie konkretnych implementacji. Na przykład strategia tworzenia ID na podstawie globalnego unikalnego identyfikatora ([UUID](https://en.wikipedia.org/wiki/Universally_unique_identifier)).

    
```php
class UuidGenerator implements IdGenerator
{
    public function generate(EntityManager $em, $entity)
    {
        // generate UUID
    }
}
```


Kolejnym sposobem może być generowanie na podstawie specyficznej sekwencji sterowanej warunkami domeny:

    
```php
class SequenceGenerator implements IdGenerator
{
    public function generate(EntityManager $em, $entity)
    {
        // generate next sequence value
    }
}
```


Jeszcze innym razem (jak się okazuje najczęstszym) generujemy ID w samej bazie danych (poprzez mechanizm auto-increment):

    
```php
class IdentityGenerator implements IdGenerator
{
    public function generate(EntityManager $em, $entity)
    {
        // get value from auto-increment column
    }
}
```


Oczywiście w ten sposób możemy rozszerzyć nasz system i w każdym momencie dodać nową implementację. Możemy również stosować różne implementacje w różnych częściach systemu.

Kod źródłowy przykładów możecie znaleźć pod adresem: [https://github.com/itcraftsmanpl/php-design-patterns](https://github.com/itcraftsmanpl/php-design-patterns)
