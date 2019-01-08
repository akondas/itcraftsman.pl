---

comments: true
date: 2014-11-13 09:00:13+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2014/4908347336_bd8d176f84_b-300x168.jpg
slug: powiedz-nie-pytaj-czyli-prawo-demeter
title: Powiedz, nie pytaj czyli Prawo Demeter
wordpress_id: 799
categories:
- PHP
- Programowanie obiektowe
tags:
- oop
- php
- prawodemeter
- telldontask
---

Programując obiektowo, możesz z czasem zauważyć, że bardzo często odpytujesz obiekt i na podstawie tej odpowiedzi podejmujesz jakieś działania. Okazuje się, że nie jest to do końca zgodne z teorią "czystego kodu".<!-- more -->

_**Alec Sharp**_ w swojej książce (_Smalltalk by Example)_ pisze (pozwoliłem sobie przetłumaczyć):

> Kod proceduralny dostaje informacje, a następnie podejmuje decyzje. Kod obiektowy mówi obiektom co mają robić.

Parafrazując: powinno się dążyć  do tego, aby mówić obiektom co **my** chcemy, aby **one** zrobiły zamiast: najpierw je odpytywać o stan, potem sprawdzać warunek i na tej podstawie kazać im coś zrobić. Dość prosta zasada. Najlepszym sposobem na wyjaśnienie, będzie zaprezentowanie kilku praktycznych przykładów:


## Przykład 1:

**Nie za dobrze:**

```php
if ($user->isAdmin()) {
    $message = $user->admin_text;
} else {
    $message = $user->user_text;
}
```

**Lepiej:**

```php
$message = $user->getMessage();
```

## Przykład 2:

**Nie za dobrze:**

```php
$limit = $downloadLimiter->getMaxLimit();
if ($limit > $currentVolume) {
    throw new Exception("Limit exceeded!");
}
```

**Lepiej:**

```php
$downloadLimiter->checkMaxLimit();
```

## Przykład 3:

**Nie za dobrze:**

```php
class Post {

    public function send($user, $content)
    {
        if ($user instanceof FacebookUser) {
            $user->sendMessage($content);
        } else if ($user instanceof EmailUser) {
            $user->sendEmail($content);
        }
    }

}
```

**Lepiej:**

```php
class Post {

    public function send($user, $content)
    {
        $user->send($content);
    }

}

class FacebookUser {

    public function send($content)
    {
        $this->sendMessage($content);
    }

}

class EmailUser {

    public function send($content)
    {
        $this->sendEmail($content);
    }

}
```

## Prawo Demeter


Przy opisanej wyżej technice warto wspomnieć o czymś co nazywamy Prawem Demeter (źródło [wikipedia](http://pl.wikipedia.org/wiki/Prawo_Demeter)):

Prawo Demeter mówi, że metoda danego obiektu może odwoływać się jedynie do metod należących do:

  1. tego samego obiektu
  2. dowolnego parametru przekazanego do niej
  3. dowolnego obiektu przez nią stworzonego
  4. dowolnego składnika, klasy do której należy dana metoda

Częstą sytuacją, która może sugerować, że Twój kod łamie powyższe punkty, jest otrzymywanie błędu typu: _Trying to get property of non-object_. Mógłbym nawet pokusić się o nazwaniem tego "zapachem" (jest pomysł na inny wpis, może nawet serię wpisów: "zapachy kodu php" ?).

Najlepiej będzie przedstawić kolejny przykład. Poniższy kod prezentuje 3 klasy: _User_, _Avatar_ oraz _Photo_. Jest to prosta struktura: _User_ ma pod sobą _Avatar'a_ który z kolei ma pod sobą _Photo_. Do tego dochodzi kilka geterów. Następnie (w kodzie) wskrzeszamy odpowiednie obiekty, wydobywamy składniki i wyświetlamy tekst na ekranie. Całość wygląda tak:

```php
class User {

    public function __construct($name, Avatar $avatar = NULL)
    {
        $this->name   = $name;
        $this->avatar = $avatar;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

}

class Avatar {

    public function __construct($title, Photo $photo = NULL)
    {
        $this->title = $title;
        $this->photo = $photo;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

}

class Photo {

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }

}

$user  = new User('Arkadiusz', new Avatar('itcraftsman', new Photo('files/logo.jpg')));
$title = '';
$path  = '';

if ($user->getAvatar())
    $title = $user->getAvatar()->getTitle();

if ($user->getAvatar() && $user->getAvatar()->getPhoto())
    $path = $user->getAvatar()->getPhoto()->getPath();

echo 'Zdjęcie ' . $title . ' jest w ' . $path;
```

W prosty sposób zastosujemy Prawo Demeter na powyższym przykładzie. Jak widać tytuł wydobywany jest w sposób, który łamie pierwszy podpunkt prawa (_$title = $user->getAvatar()->getTitle()_). Dopiszmy teraz nową metodę _getTitle()_ do klasy _User_:

```php
public function getTitle()
    {
        if ($this->avatar) {
            return $this->avatar->getTitle();
        }
    }
```

Następnie pozbędziemy się zagłębionego łańcucha (_$user->getAvatar()->getPhoto()->getPath()_) odpytującego o ścieżkę do pliku. Zaczniemy od dopisania metody _getPhotoPath_() do klasy _Avatar_:

```php
public function getPhotoPath()
    {
        if ($this->photo) {
            return $this->photo->getPath();
        }
    }
```

W ten sposób, nie łamiąc tytułowego prawa, klasa _Avatar_ może wydobyć ścieżkę z obiektu klasy _Photo_. Pozostaje nam jeszcze skonstruowanie analogicznej metody dla klasy _User_, abyśmy mogli wydobyć z niej bezpośrednio całą ścieżkę do pliku. Dlatego dodajemy kolejną metodę _getPhotoPath()_ do klasy _User:_

```php
public function getPhotoPath()
    {
        if ($this->avatar) {
            return $this->avatar->getPhotoPath();
        }
    }
```

Na końcu możemy pozbyć się warunków sprawdzających i wydobyć potrzebne dane bezpośrednio z obiektu _$user_:

```php
$title = $user->getTitle();
$path  = $user->getPhotoPath();
```


W ten sposób udało nam się pozbyć wszystkich niedozwolonych odwołań w klasach i nasz kod stał się czystszy. Poniżej kompletny kod po zmianach:

```php
class User {

    public function __construct($name, Avatar $avatar = NULL)
    {
        $this->name   = $name;
        $this->avatar = $avatar;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function getTitle()
    {
        if ($this->avatar) {
            return $this->avatar->getTitle();
        }
    }

    public function getPhotoPath()
    {
        if ($this->avatar) {
            return $this->avatar->getPhotoPath();
        }
    }

}

class Avatar {

    public function __construct($title, Photo $photo = NULL)
    {
        $this->title = $title;
        $this->photo = $photo;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function getPhotoPath()
    {
        if ($this->photo) {
            return $this->photo->getPath();
        }
    }

}

class Photo {

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }

}

$user  = new User('Arkadiusz', new Avatar('itcraftsman', new Photo('files/logo.jpg')));
$title = $user->getTitle();
$path  = $user->getPhotoPath();

echo 'Zdjęcie ' . $title . ' jest w ' . $path;
```

## Podsumowanie:

Na zakończenie warto wspomnieć, że korzystanie z Prawa Demeter ma też swoje wady. Jak widać w powyższym przykładzie, aby osiągnąć ten sam efekt (na wyjściu) musieliśmy dopisać trzy nowe metody. Wydaje się więc, że kod stanie się bardziej zagmatwany i pełen niepotrzebnych metod.

Z drugiej jednak strony, stosowanie wspomnianego prawa prowadzi do zmniejszenia zależności i pozwala na pisanie bardziej elastycznego kodu. Dzieje się tak dlatego, ponieważ kod wywołujący daną metodę nie potrzebuje wiedzy na temat struktury obiektu. Umożliwia to łatwą zmianę struktury obiektu, bez potrzeby przepisywania kodu korzystającego z jego metod.

W razie pytań lub wątpliwości czekam na Wasze komentarze pod wpisem :) Możecie mnie znaleźć również przez Twittera: [@ArkadiuszKondas](https://twitter.com/ArkadiuszKondas)

*Zdjęcie z wpisu: [Flickr](https://www.flickr.com/photos/robiwan_kenobi/4908347336).*
