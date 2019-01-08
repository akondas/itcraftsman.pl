---
comments: true
date: 2014-11-21 09:50:22+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2014/2282696252_c4e47d54a2_b-300x225.jpg
slug: tdd-w-php-jak-testowac-modele
title: 'TDD w PHP: jak testować modele ?'
wordpress_id: 817
categories:
- PHP
- TDD
tags:
- MVC
- php
- phpunit
- tdd
- unittest
---

Zastanawiasz się w jaki sposób testować modele ? Wydaje Ci się, że modele nie nadają się do testowania ? W tym wpisie przedstawiam sposoby testowania modeli (w ogólnym ujęciu, bez używania konkretnego frameworka). **Uwaga: dzisiaj dużo kodu źródłowego. **Przed czytaniem przyda się ciepła kawa.<!-- more -->

Testowanie modeli nie należy do łatwych. Można spotkać się z różnymi podejściami. Każdy ma swoją technikę, dlatego podejdziemy do tego problemu dość ogólnie. Na wstępie zaznaczam, że nie będziemy testować tutaj warstwy bazy danych, zostawiam ten temat na kolejny (niekoniecznie następny) wpis.

Cały kod źródłowy z tego wpisu znajduje się pod adresem (działający i przetestowany :D): [https://github.com/itcraftsmanpl/PHPUnitModelsTests](https://github.com/itcraftsmanpl/PHPUnitModelsTests)

Tyle krótkim wstępem. Zamiast rozpisywania się będzie samo "mięso". Rozpoczynamy od testowania rzeczy najprostszych:


## Metody set i get


Choć generalnie nie każdy zaleca testowanie setterów i getterów, to moim zdaniem warto to robić. Nakład czasu na napisanie takich testów jest niewielki. Zyskujemy za to pewność, że wszystko będzie działało na 100%. Zresztą nie zawsze _set_ lub _get_ wykonuje prosty _return_, zdarza się czasem, że po drodze trzeba coś przeliczyć lub sformatować. Na pewno każdy z Was tworzył klasy podobne to tej:

```php
class Product
{

    protected $tax;

    protected $price;

    public function __construct($price, $tax)
    {
        $this->price = $price;
        $this->tax   = $tax;
    }

    public function getPrice()
    {
        return round($this->price * ($this->tax + 1), 2);
    }

}
```

Dla takiego modelu i jego metody _getPriceGross_ możemy następnie przeprowadzić prosty test:

```php
class ProductTest extends PHPUnit_Framework_TestCase
{

    public function testGetPrice()
    {
        $product = new Product(10, 0.23);

        $this->assertEquals($product->getPrice(), 12.30);
    }

}
```

Ok, jeżeli komuś to nie wystarcza można kombinować dalej i dopisać kolejny test:

```php
    public function testGetPriceWithNullTaxRate()
    {
        $product = new Product(10, null);

        $this->assertEquals($product->getPrice(), 10);
    }
```

Zwróć uwagę na nazewnictwo samych testów. Nazwa metody testu powinna oddawać jego sedno. Trudno też jednoznacznie powiedzieć czy dwa takie testy wystarczą. Trzeba tutaj wyczuć samemu, na ile możesz sobie pozwolić.

**Inny przykład z użyciem mocka.**

Załóżmy teraz, że mamy klasę użytkownika o nazwie _User_. Posiada ona metodę _setPassword_ która tworzy nam hash hasła. Zazwyczaj w takim przypadku będziemy posiłkować się jakimś gotowym rozwiązaniem (biblioteką), które posiada swoje testy jednostkowe. Dlatego najlepszy sposobem będzie utworzenie mocka (więcej o mockowaniu czytaj w wpisie: [Testy jednostkowe z PHPUnit oraz Mockery](https://webmastah.pl/testy-jednostkowe-z-phpunit-oraz-mockery/)). Tym razem zaczniemy od napisania testu (czyli tak jak się to teoretycznie powinno robić):

```php
class UserTest extends PHPUnit_Framework_TestCase
{

    public function tearDown()
    {
        Mockery::close();
    }

    public function testPasswordHashing()
    {
        $hasher = Mockery::mock('Hash');
        $hasher->shouldReceive('generate')
            ->once()
            ->with(Mockery::type('string'))
            ->andReturn('hashed');

        $john = new User($hasher);
        $john->setPassword('secret');

        $this->assertEquals('hashed', $john->getPassword());
    }

}
```

W tym momencie przy uruchomieniu testu otrzymujemy błąd. Czas na utworzenie klasy _User_ i potrzebnych metod:

```php
class User
{

    protected $password;

    protected $hasher;

    public function __construct(Hash $hasher)
    {
        $this->hasher = $hasher;
    }

    public function setPassword($password)
    {
        $this->password = $this->hasher->generate($password);
    }

    public function getPassword()
    {
        return $this->password;
    }

}
```

Teraz uruchamiamy polecenie _phpunit_.  Test zielony, wszystko gra, możemy śmiało być z siebie dumni :D. Nie spoczywając na laurach jedziemy dalej.




## Walidacja danych


Kolejną rzeczą, która warta jest testowania w modelach, to walidacja danych. Z reguły każdy framework rozwiązuje walidację na swój własny indywidualny sposób, ale przedstawię parę ciekawych i uniwersalnych technik które mogą ci się przydać. Zaczniemy od testowania samego procesu walidacji. Klasa testu będzie trochę dłuższa niż poprzednie, ale mam nadzieje, że należy ona do "samoopisującego" się kodu. Zakładam, że użyta w kodzie klasa _Validator_ jest pokryta swoimi własnymi testami. W końcu testujemy walidację modelu a nie sam walidator.

```php
class ModelTest extends PHPUnit_Framework_TestCase
{

    protected $model;

    protected $rules = ['title' => 'required'];

    public function setUp()
    {
        parent::setUp();

        $this->model = $model = new Model;
        $model->setRules($this->rules);
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testReturnsTrueIfIsValid()
    {
        $validator = Mockery::mock('Validator');
        $validator->shouldReceive('make')
            ->once()
            ->with($this->rules)
            ->andReturn(Mockery::mock(['passes' => true]));
        $this->model->setValidator($validator);
        $this->model->title = 'Sample Title';

        $this->assertTrue($this->model->isValid());
    }

    public function testSetErrorsIfIsNotValid()
    {
        $validator = Mockery::mock('Validator');
        $validator->shouldReceive('make')
            ->once()
            ->with($this->rules)
            ->andReturn(Mockery::mock(['passes' => false, 'messages' => 'errors']));
        $this->model->setValidator($validator);
        $result = $this->model->isValid();

        $this->assertFalse($result);
        $this->assertEquals('errors', $this->model->getErrors());
    }
}
```

Zastanawiasz się pewnie teraz, jaką to skomplikowaną klasę trzeba będzie napisać, aby przejść ten test. Wbrew pozorom klasa _Model_ jest dość prosta:

```php
class Model
{

    protected $errors;

    protected $validator;

    protected $rules;

    public function setRules($rules)
    {
        $this->rules = $rules;
    }

    public function setValidator($validator)
    {
        $this->validator = $validator;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function isValid()
    {
        $validation = $this->validator->make($this->rules);
        if ($validation->passes())
            return true;

        $this->errors = $validation->messages();

        return false;
    }

}
```

Całość przechodzi test na zielono. Jeżeli nie wierzysz, pobierz źródła (link na początku artykułu) i sprawdź sam.

**Tworzymy helper używając traits **(nie wiesz co to traits, czytaj: [Jak korzystać z traits w PHP](https://itcraftsman.pl/jak-korzystac-z-traits-w-php/))

Zakładam teraz, że w testowanej aplikacji mamy więcej niż jeden model do przetestowania. Jeżeli tak, to pisanie dla każdego modelu, za każdym razem testu walidacji, może być uciążliwe. Aby ułatwić sobie proces ciągłego testowania stworzymy przydatny helper korzystając z tratis.

```php
trait ModelHelper
{

    public function assertIsValid($model)
    {
        $this->assertTrue(
            $model->isValid(),
            'Validation should succeed but failed'
        );
    }

    public function assertIsNotValid($model)
    {
        $this->assertFalse(
            $model->isValid(),
            'Validation should failed but succeed'
        );
    }

}
```

Umieszczamy go np. w katalogu '_tests/helper_' naszego projektu. Należy pamiętać aby zaktualizować plik _composer.json_:

```json
"autoload": {
    "classmap": [
        "src",
        "tests/helper"
    ]
},
```

Pora sprawdzić _ModelHelper_ w akcji. Tym razem przetestujemy model strony o nazwie _Page_. Zaczynamy od napisana testu. Sprawdzimy dwie rzeczy: czy walidacja zwraca _true_ przy podaniu wymaganego tytułu, oraz czy walidacja zwróci _false_ w przypadku jego braku:

```php
class PageTest extends PHPUnit_Framework_TestCase
{

    use ModelHelper;

    protected $model;

    public function testIsValidWithTitle()
    {
        $page = new Page();
        $page->setValidator(new Validator());
        $page->title = 'Lorem Ipsum';

        $this->assertIsValid($page);
    }

    public function testIsInValidWithoutTitle()
    {
        $page = new Page();
        $page->setValidator(new Validator());

        $this->assertIsNotValid($page);
    }

} 
```

Jak widać, zaczyna się robić bardzo przyjemnie. Kod testu jest bardzo przejrzysty, zarazem pokrywa sporą ilość kodu. W tym podejściu nie będziemy tworzyć mocka klasy walidatora, więc na szybko stworzyłem potrzebną nam klasę (niezbędne minimum):

```php
class Validator
{

    protected $passes = false;

    protected $messages;

    public function make($attributes, $rules)
    {
        foreach ($rules as $field => $rule) {
            $ruleName = 'validate' . ucfirst($rule);
            if (method_exists($this, $ruleName) && isset($attributes[$field])) {
                $this->passes = $this->$ruleName($attributes[$field]);
            }
        }
        return $this;
    }

    public function validateRequired($value)
    {
        if (is_null($value)) {
            return false;
        } elseif (is_array($value) && count($value) == 0) {
            return false;
        } elseif (trim($value) === '') {
            return false;
        }

        return true;
    }

    public function messages()
    {
        return $this->messages;
    }

    public function passes()
    {
        return $this->passes;
    }

}
```



Przechodzimy teraz do napisania klasy testowanego modelu. Tworzymy klasę _Page_. Tutaj skorzystamy z napisanej wcześniej klasy bazowej _Model_ po której będziemy dziedziczyć:

```php
class Page extends Model
{

    protected $rules = [
        'title' => 'required'
    ];

}
```

Jak widać wyszło bardzo schludnie - o to właśnie chodzi. Niestety musimy dokonać drobnych modyfikacja do klasy _Model_ aby całość działała. Najpierw dopiszemy nasz magiczny setter, aby można było wstawiać wartości pisząc wprost _$model->attributeName = $value:_

```php
// w klasie Model
protected $attributes = [];

public function getAttributes()
{
    return $this->attributes;
}

public function __set($name, $value)
{
    $this->attributes[$name] = $value;
}
```

Następnie przerabiamy odrobinę metodę _isValid_. Musimy dodać do wywołania walidatora dodatkowy parametr (atrybuty modelu) _$this->attributes_:

```php
// w klasie Model
public function isValid()
{
    $validation = $this->validator->make($this->attributes, $this->rules);
    if ($validation->passes())
        return true;

    $this->errors = $validation->messages();

    return false;
}
```

Uruchamiamy test (trzeba poprzedzić jeszcze wywołaniem _composer dump-autoload_, żeby zaczytać nowe klasy):

[![phpunit-errors](/assets/img/posts/2014/phpunit-errors.png)](/assets/img/posts/2014/phpunit-errors.png)

Niestety nie udało się. Nie szkodzi. Zobaczmy co możemy z tym zrobić. Jak widać pozostało nam jeszcze naprawienie testu klasy _Model_ w pliku _ModelTest_. Musimy dodać parametry do mocka:

```php
// w metodzie testReturnsTrueIfIsValid()
// zamiast
->with($this->rules)
// wstawiamy
->with(['title' => 'Sample Title'], $this->rules)
```


```php
// w metodzie testSetErrorsIfIsNotValid()
// zamiast
->with($this->rules)
// wstawiamy
->with([], $this->rules)
```

Uff.. Czas na uruchomienie testów ponownie:

[![phpunit-models](/assets/img/posts/2014/phpunit-models.png)](/assets/img/posts/2014/phpunit-models.png)

Jest zielono, jest dobrze. Link do całego kodu jest na samym początku wpisu.




## Inne specyficzne metody


Na koniec warto testować wszystkie inne specyficzne metody modelów.  Podejście podobne jak przy seterach czy geterach. Na przykład mamy klasę _Cart_,_ _która reprezentuje koszyk w sklepie. Chcemy otrzymywać jednolity tekst, który będzie reprezentował koszyk, w prawym górnym rogu ekranu. Zaczniemy ponownie od napisania testu:

```php
class BasketTest extends PHPUnit_Framework_TestCase
{

    public function testBasketToString()
    {
        $basket = new Basket(150, 3);

        $this->assertEquals('Produktów w koszyku: 3; o łącznej wartości 150 zł', $basket);
    }

}
```

Jak widać bardzo prosty kod (bo testowanie jest proste). Z tak przygotowanym testem przechodzimy do pisania klasy Basket:

```php
class Basket
{

    protected $value;

    protected $quantity;

    public function __construct($value, $quantity)
    {
        $this->value    = $value;
        $this->quantity = $quantity;
    }

    public function __toString()
    {
        return sprintf(
            'Produktów w koszyku: %s; o łącznej wartości %s zł',
            $this->quantity,
            $this->value
        );
    }

}
```

Testujemy i ponownie zielono. Testy napisane w ten sposób możesz śmiało rozwijać i urozmaicać. Generalnie (poza paroma wyjątkami) panuje tu zasada im więcej tym lepiej.



Na tym czas na zakończenie wpisu. Jeżeli udało Ci się doczytać do końca to gratulację (było trochę czytania) i zachęcam do komentowania (i krytyki, ale konstruktywnej). Testowanie nie jest łatwe, ale mam nadzieję, że uda mi się Ciebie zachęcić, choć w lekkim stopniu na poznanie tej przydatnej techniki (i jej aktywne używanie). Zielonych testów życzę :).

Zdjęcie z wpisu: [Flickr](https://www.flickr.com/photos/codlibrary/2282696252/).
