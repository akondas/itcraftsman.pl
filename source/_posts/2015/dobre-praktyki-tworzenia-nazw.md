---
comments: true
date: 2015-09-05 10:03:52+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2015/4734829999_8086319b4e_b-300x169.jpg
slug: dobre-praktyki-tworzenia-nazw
title: Dobre praktyki tworzenia nazw
wordpress_id: 1063
categories:
- Programowanie
- Wzorce
tags:
- klasy
- kod źródłowy
- metody
- nazwy
- programowanie
- zmienne
---

> W programowaniu istnieją dwa bardzo trudne problemy: unieważnianie cache oraz nazywanie rzeczy. 

To słynny [cytat Phila Karltona](https://martinfowler.com/bliki/TwoHardThings.html). W tym wpisie chciałbym skupić nad problemem tworzenia nazw używanych w kodzie i przedstawić zbiór najlepszych praktyk. Dodatkowo na końcu zaproponuję kilka pomysłów na polepszanie swoich zdolności językowych<!-- more -->

Przykłady użyte w poniższym wpisie napisane są w języku **PHP**, ale opisane techniki można z powodzeniem stosować w każdym dostępnym języku, który to umożliwia.
Na wstępie warto jeszcze wspomnieć, że wpis jest dość długi, dlatego zalecam przygotowanie kawy lub innego ulubionego napoju. Wygodne krzesło lub komfortowa pozycja też będzie mile widziana.

Zapraszam do czytania.


## Używaj nazw przedstawiających intencje


Nazwa (zmiennej, metody, klasy, atrybutu itp.) powinna w sensowny sposób objaśniać swoje znaczenie. Powinna odpowiadać na pytanie, w jakim celu istnieje lub po co jest używana. Nazwy metod i funkcji powinny tłumaczyć (słownie) co konkretnego robią. Ważnie jest aby wybrane słowa przekazywały czytelnikowi swój sens. Poniżej zamieszczam przykłady wybranych nazw zmiennych, które można znaleźć w niejednym kodzie, oraz ich lepsze propozycje:

```
$d; // np. czas trwania w dniach
$elapsedTimeInDays;

$list; // np. lista kategorii
$categories;

$t; // np. czas modyfikacji (timestamp)
$modificationTimestamp;
```

W ten sam sposób możemy odnieść się do funkcji. Czy wiesz do czego służy ta funkcja ?

```
function filterOrders()
{
    $orders = [];
    foreach($this->getAll() as $order) {
        if($order->status == 4)
            $orders[] = $order;
    }
    return $orders;
}
```

Wstępnie widać, że jest to jakiś filtr, ale po szybkim przeczytaniu trudno stwierdzić co tak naprawdę zwraca. Po małej refaktoryzacji, kod staje się bardziej czytelny i przedstawia w sposób bezpośredni to co robi (sam się opisuje):

```
function getPaidOrders()
{
    $paidOrders = [];
    foreach($this->getAll() as $order) {
        if($order->isPaid())
            $paidOrders[] = $order;
    }

    return $paidOrders;
}
```

W tym momencie, po szybkim przeczytaniu wszystko jest jasne. Nie musimy wchodzi w kod głębiej i sprawdzać czym np jest status o wartości 4.


## Unikaj niepotrzebnego nadmiaru informacji


Staraj się przedstawiać nazwy w sposób jak najbardziej prosty. Jeżeli możesz zastąpić dwa słowa jednym - zrób to. Pamiętaj jednak, że istnieją wyjątki.

```
class ProductList 
{
    public function numberOfProducts(){}
}

class CategoryDataObject 
{
    public function returnFilteredChildrenListIfChildrenExist(){}
}
```

Wstępnie wszystko jest jasne i czytelne, ale ilość tekstu do przeczytania jest zbyt duża. Lekka modyfikacja znacznie poprawi jakość kodu i jego czytelność:

```
class ProductList 
{
    public function size(){}
}

class Category
{
    public function getChildren(){}
}
```



## Promuj jasność nad zwięzłością


Nie zawsze najkrótsza możliwa nazwa będzie odpowiednim wyborem. Raz napisany kod będziesz czytać wielokrotnie, dlatego w szczególnych przypadkach warto wydłużyć nazwę, aby kod stał się jaśniejszy. W tym przypadku, należy pamiętać, że wszystko zależy od kontekstu. Oczywiste jest, że zmienną w instrukcji _for_ możesz bezpiecznie nazywać _$i_. Przeczytaj poniższy fragment kodu:

```
class ImportCommand 
{
    public function execute() 
    {
        $this->initialize();
        $this->truncate();
        $this->import();        
    }
}
```

Na wstępnie wydaje się, że użyte nazwy są proste i zrozumiałe. Popatrzmy jednak co można zrobić, aby nadać klasie większą czytelność:

```
class ImportProductsCommand 
{
    public function execute() 
    {
        $this->initializeEntityManagers();
        $this->truncateProductsTable();
        $this->importProductsFromLegacyDatabase();        
    }
}
```

Dodatkowo zamieszczam kilka innych przykładów, gdzie dłuższa nazwa nie zawsze była najlepszą (najbardziej czytelną):

```
$appointmentList
$calendar

$companyPerson
$employee

$textCorrectionByEditor
$edit
```



## Nie używaj negatywnej logiki


Choć może wydawać się to oczywiste, wielu programistów jednak o tym zapomina. Metody czy funkcje zwracające wartości logiczne (bool) nie powinny używać zaprzeczeń. Zobaczmy poniższy fragment kodu:

```
class Product 
{
    public function isNotEnabled();
}

class User 
{
    public function isNotAdmin();
}
```

Zamiast tego możesz użyć:

```
class Product 
{
    public function isEnabled();
}

class User 
{
    public function isAdmin();
}
```

Jeżeli potrzebujesz sprawdzić warunek odwrotny, użyj zwyczajnie znaku zaprzeczenia "_!_". Brak stosowania tej zasady, może doprowadzić do dziwnych zapisów w kodzie źródłowym:

```
if(!$user->isNotAdmin()) {}

if(!$product->isNotEnabled()) {}
```



## Twórz określenia które można wymówić


Nawet jeżeli pracujesz nad kodem sam, nigdy nie masz pewności, czy nie będziesz z kimś o nim rozmawiał. Tym bardziej będąc w zespole. Warto zwrócić uwagę, czy utworzone określenia da się wymawiać.  Inaczej napotkasz trudności w dyskusji i wartość twojego kodu zmaleje. Poniżej prosty przykład. Postaraj się przeczytać na głos przedstawiony kod:

```
class DtaRcd 
{
    private $modDMY;

    public function rcdInt() {}
}
```

Przykład może wydawać się absurdalny, ale zdarzają się takie sytuacje, gdzie programiści idą na skróty i tworzą nazwy niemożliwe do wymówienia. Powyższy przykład mógłby wyglądać tak:

```
class Account 
{
    private $modificationDate;

    public function getInternalId() {}
}
```



## Używaj jedno słowo na jedno pojęcie


Warto zapamiętać sobie ten punkt i stosować się do niego. Chodzi w nim o to, aby na jedną czynność (np. znajdź, zapisz, wylicz) zawsze używać jednego słowa (np. find, save, proccess). W ten sposób napisany kod będzie bardziej spójny. Dodatkowo, będzie ci znacznie łatwiej pracować z takim kodem źródłowy, poprzez znajomość jego metod. Spróbuj zapamiętać metody poniższej klasy _UserRepository_:

```
class UserRepository 
{
    public function fetchAll(){}
    public function retrieveActive(){}
    public function getByOrganization(){}
    public function findOneById(){}
}
```

Każda kolejna metoda inaczej się zaczyna, przez co będzie ci dużo trudniej nawigować po kodzie. Zobaczmy, jak można to uprościć:

```
class UserRepository 
{
    public function findAll(){}
    public function findActive(){}
    public function findByOrganization(){}
    public function findOneById(){}
}
```

Ogólne przykłady, jednego wzoru nazwy dla różnych klas:

```
$repository->find...(){}

$entity->get...(){}

$provider->fetch...(){}

$storage->retrieve...(){}
```



## Uwzględniaj kontekst


W kilku punktach powyżej pojawiły się już wzmianki o kontekście, ale warto zrobić z niego osobny punkt. Rozpatrzmy poniższy przykład kodu:

```
class Order 
{
    private $street;
    private $city;
    private $postCode;
    private $state;
}
```

Na ten moment, nie wiemy czy atrybut _$state_ odnosi się do stanu zamówienia (klasy Order) czy może jest to składowa część adresu zamówienia. W takiej chwili lekka modyfikacja pozwoli uniknąć niepotrzebnej zmyłki:

```
class Order 
{
    private $adrStreet;
    private $adrCity;
    private $adrPostCode;
    private $adrState;
}
```

Jeszcze lepszym ruchem, w tym przypadku, byłoby utworzenie osobnej klasy (typu Value object):

```
class Order 
{
    /**
     * @var Address
     */
    private $address;

    // lub może jeszcze bardziej precyzyjnie

    /**
     * @var DeliveryAddress
     */
    private $deliveryAddress;
}

class Address {}
class DeliveryAddress extends Address {}
```



## Korzystaj z dziedziny problemu


Im bliżej kod jest dziedziny problemu tym bardziej powinien zawierać nazwy z tej dziedziny. W skrócie chodzi o to, aby w przypadku warstw kodu, które modelują rzeczywisty problem, stosować nazwy powszechnie znane przez ekspertów tej dziedziny. Natomiast im kod jest dalej tej dziedziny, tym bardziej wybrane określenia powinny oddawać to, co jest aktualnie wykonywane. Postaram się to rozjaśnić prostym przykładem:

```
$order; // mamy zamówienie

// w warstwie domenowej przyjęcie zamówienia może wyglądać tak:
$shop->placeOrder($order)

// w warstwie infrastruktury, jego zapis może być taki:
$em->persist($order);
$em->flush();
```

Ten temat jest dość złożony i napisano na ten temat niejedną książkę. Polecam zaznajomić się z techniką DDD.


## Przykłady kiepskich nazw



```
$foo
// nie przedstawia intencji

$data
// zbyt ogólna

$a
// za krótka 

$productsEditedBySuperAdminUsers
// za długa

$mod
// niejednoznaczna, skrót od modulo czy może jakiś moduł ?

class InvoiceManager {}
// nieokreślona, co ten manager konkretnie robi ?

$state
// w złym kontekście

$products_list
// inna konwencja (snake_case zamiast camelCase)
```



## Porady od zawodowych pisarzy


Dlaczego warto czytać i stosować porady od zawodowych pisarzy, skoro z pozoru, nie mają nic wspólnego z programowaniem ?

	
  * Są przydatne i nie dotyczą wyłącznie tworzenia nazw	
  * Pisarze istnieją od wieków, programiści tylko od dekad
  * Ich porady są lepiej napisane i bardziej zabawne


Wybrałem kilka cytatów, ale pod [tym linkiem](https://www.goodreads.com/quotes/tag/writing) możecie znaleźć ich całą masę.

**Stephen King **na temat programowania w zespole:


>Write with the door closed, rewrite with the door open


**Anne Rice** na temat hardware developera:


>I find the bigger the monitor, the better the concentration


**Neil Gaiman** na temat code review:


>When people tell you something’s wrong or doesn’t work for them, they are almost always right.

>When they tell you exactly what they think is wrong and how to fix it, they are almost always wrong.


## Komentarze


Na temat komentarzy istnieje stała i sprawdzona zasada: dobry kod nie wymaga komentarzy. Najlepiej zilustruje to przykład:

```
// sprawdzenie czy pracownik jest w wieku emerytalnym
if(
    ($employee->gender=='F' && $employee->age > 60) 
    || 
    ($employee->gender=='M' && $employee->age > 65)
)
```

Warunek if i komentarz można by zastąpić następującym kodem:

```
if($employee->isInRetirementAge())
```

Nie oznacza to jednak, że wszystkie komentarze są złe. Dobre komentarze w kodzie to:
	
  * Komentarze prawne
  * Docblock
  * Ostrzeżenie o konsekwencjach
  * Wyjaśnienie (np. skomplikowany regexp)
  * Komentarze TODO

Złe komentarze w kodzie, których należy unikać to:

  * Komentarze HTML
  * Znaczniki pozycji (np. linie które oddzielają od siebie fragmenty kodu)
  * W klamrach zamykających (np. _} // end if_)
  * Duplikowanie informacji
  * Automatycznie generowane komentarze (IDE i inne narzędzia)

## Jak ulepszać swoje zdolności językowe

Na zakończenie kilka rad, co możesz zrobić, aby uzyskać lepszy zasób słownictwa i dzięki temu tworzyć lepszy kod ?

  * czytać książki, również beletrystykę (a może zwłaszcza :D) - ja osobiście bardzo lubię kryminały i thrillery
  * grać (np. gry słowne takie jak scrabble) - nawet nie muszę pisać, że dostępna jest cała masa gier on-line (gdzie możesz grać z drugą osobą)
  * wykorzystywać słowniki - słownik wyrazów bliskoznacznych - synonimy (ang. thesaurus)

## Podsumowanie

Trochę tego wszystkiego się nazbierało, dlatego na koniec warto podsumować zdobytą widzę. Chciałbym, abyś po przeczytaniu, zapamiętał kilka poniższych punktów:

  1. Tworzenie nazw jest trudne !
  2. Czytaj dobry kod (GitHub)
  3. Rozwiń umiejętności językowe: czytaj, opowiadaj, graj, używaj słowników
  4. Spróbuj coś napisać
    1. programuj !!!
    2. komentarze na blogach/grupach
    3. własny blog
    4. książka

To tyle w temacie tworzenia nazw. Jeżeli macie swoje sprawdzone sposoby, lub inne techniki, podzielcie się nimi w komentarzach. Tymczasem miłego poranka/dnia/wieczoru. Dobrze jest znowu pisać dla Was po dłuższej przerwie :).

Zdjęcie z wpisu: [Flickr](https://www.flickr.com/photos/juhansonin/4734829999).
