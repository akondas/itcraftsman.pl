---

comments: true
date: 2014-08-12 21:22:08+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2014/traits.png
slug: jak-korzystac-z-traits-w-php
title: Jak korzystać z traits w PHP
wordpress_id: 246
categories:
- PHP
tags:
- php
- traits
---

Traits'y to sposób, jaki twórcy PHP zaproponowali do rozwiązywania problemu limitu pojedynczego dziedziczenia. Przedstawię czym one są i w jaki sposób ich używać.<!-- more -->

Na wstępie dodam jeszcze że bardzo kusiło mnie (jak zawsze) przetłumaczenie nazwy tego mechanizmu na język polski. Jedyny sensowny zapis jaki udało mi się znaleźć to "cechy". Osobiście uważam jednak, że lepiej będzie korzystać z wersji angielskiej, choć skojarzenie z cechą może być pomocne.


## Czym są traits ?


Traits to mechanizm pozwalający na ponowne użycie kodu w językach (w tym PHP) gdzie dozwolone jest pojedyncze dziedziczenie. Trait pozwala programiście na używanie tych samych metod (oraz atrybutów) przez kilka różnych klas. Rozwiązuje on w ten sposób problem wielokrotnego dziedziczenia oraz zmniejsza złożoność kodu poprzez redukcję powtarzających się metod.

Pojedynczy trait jest więc bardzo podobny do klasy ale zawiera tylko i wyłącznie zestaw metod. Niemożliwe jest używanie trait'a samego w sobie (tak samo jak klasy abstrakcyjnej). Musi być on zawsze wykorzystywany w wskazanej klasie. Trait potrafi również wykorzystywać zdefiniowane w klasie prywatne atrybuty.

Znalazłem jeszcze jedno ciekawe określenie na traits'y: Traits to interfejsy z implementacją.

Traits dostępne są w PHP od wersji 5.4 w górę.

Poniżej przedstawiam prosty przykład:

```
trait SayWords {

	public function sayHello() {
		echo 'Hello World';
	}

}

class Person {

	use SayWords;

}

$p = new Person();
$p->sayHello();
```

Najpierw definiujemy nowy trait (podobnie jak klasę), a następnie w klasie _Person_ wskazujemy używanie naszego trait'a piszą "_use SayWords;_"

W wyniku uruchomienia powyższego skryptu otrzymamy na wyjściu: "_Hello World_" .




## Jak korzystać z traits ?


**Pojedynczy trait**

Klasyczny przykładem wykorzystania pojedynczego trait'a będzie (nielubiany) wzorzec Singleton (czasami nazywany antywzorcem):

```
trait Singleton {
    private static $instance;

    public static function getInstance() {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self;
        }
        return self::$instance;
    }
}

class Logger {
    use Singleton;
}

class Messages {
    use Singleton;
}
```

Jak widać teraz bardzo łatwo i szybko zrobić z każdej klasy singleton.

**Wielokrotny trait**

Bardziej złożonym przypadkiem może być użycie kilku traits'ów jednocześnie. Wystarczy wymienić je kolejno po przecinku:

```
trait Filter {
    function filterString() {
        echo "Filter by string";
    }
}

trait Sort {
    function sortNumber() {
        echo "Sort by number";
    }
}

class PersonList {
    use Filter, Sort;
}

$list = new PersonList();
$list->filterString();
$list->sortNumber();
```

**Łączenie traits**

Idąc dalej możemy również stworzyć nowy trait bazując na poprzednich:

```
trait FilterSort {

	use Filter, Sort;

}

class PersonList {
    use FilterSort;
}

$list = new PersonList();
$list->filterString();
$list->sortNumber();
```

**Konflikty i aliasy**

Rozpatrzymy teraz następujący przykład

```
trait Rectangle {
    function render() {
        echo "Render rectangle";
    }
}

trait FormElement {
    function render() {
        echo "Playing form elemnt";
    }
}

class Button {
    use Rectangle, FormElement;
}

$button = new Button();
$button->render();
```

Uruchomienie powyższego skryptu spowoduje wywołanie fatal error. PHP nie wie której metody _render_ ma użyć dla naszego _Buttona_. Musimy mu w pewien sposób wskazać prawidłowy wybór. Poniżej przedstawiam skorygowany przykład.

```
trait Rectangle {
    function render() {
        echo "Render rectangle";
    }
}

trait FormElement {
    function render() {
        echo "Playing form elemnt";
    }
}

class Button {
    use Rectangle, FormElement {
    	Rectangle::render insteadof FormElement;
    }
}

$button = new Button();
$button->render();
```

Teraz wskazaliśmy aby PHP używał metody _render_ z trait'a _Rectangle_ **zamiast z** _FormElement_. Jeżeli chcemy zachować jednak możliwość wykorzystania obu metod możemy posłużyć się aliasem:

```
trait Rectangle {
    function render() {
        echo "Render rectangle";
    }
}

trait FormElement {
    function render() {
        echo "Playing form elemnt";
    }
}

class Button {
    use Rectangle, FormElement {
    	FormElement::render as renderFormElement;
    	Rectangle::render insteadof FormElement;
    }
}

$button = new Button();
$button->render();
$button->renderFormElement();
```

W ten sposób zachowujemy dostęp do obu identycznie nazwanych metod.



Podsumowując traits'y: są one bardzo pomocnym mechanizmem który rozwiązuje problem dziedziczenia wielokrotnego. Przy czym omijają one tzw "[_diamentowy problem_](http://en.wikipedia.org/wiki/Multiple_inheritance#The_diamond_problem)", który powstaje w przypadku języków używających mechanizmu wielokrotnego dziedziczenia.  Mam nadzieję, że udało mi się w jasny sposób przedstawić sposoby wykorzystania traits. Jak zawsze dziękuję za poświęcony czas oraz zachęcam do komentowania lub konstruktywnej krytyki :)


