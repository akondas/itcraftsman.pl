---
comments: true
date: 2014-09-24 10:38:21+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2014/8156340258_03c7538bf9_h-300x199.jpg
slug: migrowanie-bazy-danych-laravel-migrations
title: Migrowanie bazy danych - Laravel Migrations
wordpress_id: 569
categories:
- Laravel
- MySQL
- PHP
tags:
- baza danych
- laravel
- mysql
- php
---

Czym są migracje bazy danych ? Krótki przewodnik po tym jak skutecznie z nich korzystać.

<!-- more -->

W poprzednim wpisie ([Tworzenie i modyfikacja ](https://itcraftsman.pl/tworzenie-i-modyfikacja-bazy-danych-z-poziomu-kodu-php-laravel-schema-builder/)...) przedstawiłem Wam jak zarządzać strukturą bazy danych z poziomu kodu PHP. Dzisiaj przedstawię praktyczny sposób wykorzystania tego tematu, na bazie frameworka Laravel. Najpierw musimy odpowiedzieć sobie na następujące pytanie:

**Czym są migracje ?**

Migracja to nazwa procesu który pozwala na bezkonfliktowe tworzenie i modyfikacje struktury bazy danych. Cały funkcjonalność polega na odpowiednim (krokowym) zapisie poszczególnych zmian. Może nie brzmi to zbyt jasno, dlatego najlepiej będzie przedstawić to na konkretnym przykładzie.


## Tworzenie nowej migracji


Proces tworzenie migracji został zautomatyzowany i należy używać do tego narzędzia dostarczonego wraz z Laravel'em o nazwie _artisan_. Wywołujemy go normalnie, z linii poleceń, będąc w katalogu głównym naszego projektu. Testowałem zarówno pod Windows'em oraz Linux'em i nie było problemów. Do utworzenie nowej migracja wykorzystujemy polecenie _migrate:make_ po którym podajemy nazwę nowej migracji. Powinna ona krótko opisać czego będzie dotyczyła.

```
php artisan migrate:make create_products_table
```

W konsoli otrzymamy:

```
Created Migration: 2014_09_24_082403_create_products_table
Generating optimized class loader
Compiling common classes
Compiling views
```

W ten sposób w katalogu _app/database/migrations_ utworzona została nowa klasa:

```php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }

}
```

W dalszym kroku należy uzupełnić dwie metody nowo wygenerowanej klasy. Pierwsza z nich to _up()_ - jest wywoływana w momencie zastosowania naszej migracji. Druga to _down()_ - przeciwność metody _up()_, jest wywoływana gdy nasza migracja jest wycofywana (rolling back). Należy zrozumieć to dość prosto: to co robimy w metodzie _up()_ musi zostać zniwelowane w metodzie _down()_.

Jeżeli na przykład, w tej pierwszej tworzymy nową tabelę, to odpowiednio w metodzie _down()_ powinniśmy tą tabele zniszczyć. Innym przykładem może być dodawanie kolumny. W metodzie _up()_ dodajemy nową kolumnę, a w metodzie _down()_ usuwamy ją. Generalnie rzecz ujmując po wywołaniu metody _down()_ stan bazy danych powinien wyglądać jak z przed migracji.

Dla przykładu utwórzmy nową tabelę, z paroma kolumnami:

```php
public function up() {
    Schema::create('products', function ($table) {
        $table->increments('id');
        $table->string('name');
        $table->text('description')->nullable();
        $table->decimal('price', 8, 2);
        $table->timestamps();
        $table->softDeletes();
    });
}
```

Powyższy kod utworzy tabelę _products_ wraz z kilkoma kolumnami. Jeżeli chcesz dowiedzieć się więcej jak tworzyć tabele i kolumny w ten sposób to zapraszam do [poprzedniego wpisu](https://itcraftsman.pl/tworzenie-i-modyfikacja-bazy-danych-z-poziomu-kodu-php-laravel-schema-builder/).

Teraz aby nasza migracja była kompletna musimy uzupełnić metodę _down()_:

```php
public function down() {
    Schema::dropIfExists('products');
}
```

Tutaj krótko: usuwamy tabele _products_ (o ile istnieje). W ten sposób nasza migracja jest kompletna. Resztę dalszych czynności wykonujemy w linii poleceń.




## Uruchamianie migracji


Laravel sam pilnuje aktualny status naszej bazy. Przechowuje on (w osobnej tabeli) informację, które migracje zostały już zastosowane, a które jeszcze nie. Aby uruchomić i zastosować zalegające migracje (czyli naszą nowo utworzoną również) należy skorzystać z polecenia _migrate_

```
php artisan migrate
```

Za pierwszym razem framework utworzy sobie tabelę pomocniczą _migrations_:

```
Migration table created successfully.
Migrated: 2014_09_24_082403_create_products_table
```

Tabela _products_ została utworzona, wszystko przebiegło prawidłowo:

[![Migracje bazy danych](/assets/img/posts/2014/migration1.png)](/assets/img/posts/2014/migration1.png)




## Cofanie migracji


W przypadku gdy chcemy wycofać ostatnio zastosowaną migrację, wystarczy użyć polecenia _migrate:rollback_:

```
php artisan migrate:rollback
```

Wykonany zostanie kod z metody _down()_ i tabela _products_ zostanie usunięta. Jeżeli chcemy cofnąć wszystkie migracje (wyzerować bazę danych) używamy:

```
php artisan migrate:reset
```

Przydatną również rzeczą jest możliwość wycofania wszystkich migracji i zastosowania ich na nowo:

```
php artisan migrate:refresh
```

W ten sposób możemy odtworzyć naszą bazę danych od nowa.




## Przydatne techniki


Tworząc nową migrację możemy skorzystać z parametrów _--table=_ oraz _--create=_ które częściowo uzupełnią kod o użyteczne fragmenty. Pierwsza opcja wygeneruje kod potrzebny do modyfikacji istniejącej już tabeli:

```
php artisan migrate:make add_category_to_products --table=products
```

Wynikiem tego będzie nowa klasa:

```php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoryToProducts extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }

}
```

Moglibyśmy wypełnić ją w następujący sposób:

```php
public function up() {
    Schema::table('products', function (Blueprint $table) {
        $table->integer('category_id');
    });
}

public function down() {
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn('category_id');
    });
}
```

Drugi parametr _--create=_ pozwala wygenerować klasę, która utworzy nową tabele o podanej nazwie:

```
php artisan migrate:make create_orders_table --create=orders
```

W ten sposób otrzymamy kod potrzebny do stworzenia tabeli, parę podstawowych kolumn, oraz instrukcję usuwania tabeli w metodzie _down()_:

```php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('orders');
    }

}
```

Przedstawiony w ten sposób mechanizm pozwala na utrzymanie znakomitego porządku nad modyfikacjami bazy danych. Ten warunek zostaje również spełniany przy pracy zespołowej. Jeden uczestnik zespołu może utworzyć nowe migracje bez naszej wiedzy. My zaciągamy zmiany i uruchamiany polecenie _migrate_, co zastosuje wszystkie wprowadzone przez naszego kolegę modyfikacje.

Osobiście nie wyobrażam już sobie projektu bez wykorzystania migracji. Dodatkowym plusem jest również przejrzystość kodu oraz brak potrzeby przenoszenia aktualnego zrzutu bazy danych. Do kompletu brakuje name jeszcze wypełnianie tak utworzonej bazy, testowymi danymi. Tym tematem zajmę się w kolejnym wpisie. Tymczasem dzięki za przeczytanie. Jeżeli masz jakieś uwagi, pytania lub inne kwestie to proszę skomentuje ten wpis. Jeżeli uważasz że wpis ten stał się dla Ciebie pomocny to również daj mi znać.

Zdjęcie z wpisu: [Flickr](https://www.flickr.com/photos/sergemelki/8156340258/) na licencji Creative Commons
