---
comments: true
date: 2014-09-10 11:59:11+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2014/14577885086_768ad2260c_k-300x168.jpg
slug: tworzenie-i-modyfikacja-bazy-danych-z-poziomu-kodu-php-laravel-schema-builder
title: Tworzenie i modyfikacja bazy danych z poziomu kodu PHP - Laravel Schema Builder
wordpress_id: 412
categories:
- Laravel
- PHP
tags:
- laravel
- mysql
- php
- postgres
- schema builder
- sql server
- sqlite
---

Przedstawiam kompletny kurs korzystania z narzędzia dostarczonego wraz z Laravel Framework o nazwie Schema Builder. Dzięki niemu można w prosty i skuteczny sposób tworzyć i modyfikować strukturę naszej bazy danych wprost w poziomu kodu PHP.<!-- more -->

Na wstępnie można by zadać pytanie: po co zajmować się definiowaniem bazy danych z poziomu kodu PHP ? Może w chwili obecnej nie wydaj się to przydatne ale wraz z następnym wpisem na temat migracji postaram się udowodnić mega użyteczność tego narzędzia oraz zachęcić Was do skorzystania z niego. Dodatkowo zaletą jest również fakt, że tworzony w ten sposób kod zadziała w czterech różnych systemach baz danych: MySQL, Postgres, SQLite oraz SQL Server. Nie potrzebujemy znać do tego szczegółowej składni tych systemów. 

Cały niżej przedstawiony kod pisany i testowany był w Laravel 4.2. Przed przystąpieniem do modyfikacji należ skonfigurować wcześniej połączenie z bazą danych (domyślnie w pliku _app/config/database.php_).

<div class="shadow-md p-4 bg-yellow-lighter">
    Kurs miał być krótki ale w trakcie pisania postanowiłem pochylić się bardziej nad tym tematem i dostarczyć Wam kompletny opis możliwości.
</div>

Dla celów testowych możemy utworzyć sobie osobnego routa który będzie wykonywał nasz kod pod odwiedzeniu konkretnego adresu, przykładowo:

```php
Route::get('schema', function () {
    Schema::create('customers', function ($table) {
        $table->increments('id');
    });
});
```

Sam routing w Laravelu jest na tyle ciekawy, że zasługuje na osobny wpis. Na chwilę obecną wystarczyć odwiedzić adres _/schema_ aby uruchomić nasz Schema Builder.


## Operacje na samych tabelach


Kod buildera jest na tyle intuicyjny i samo opisujący się, że postanowiłem najpierw go przedstawić (fragmenty) a następnie krótko opisać:

```php
Route::get('schema', function () {

    Schema::create('customers', function ($table) {
        $table->increments('id');
    });

    if (Schema::hasTable('customers')) {
        Schema::rename('customers', 'clients');

        Schema::table('clients', function ($table) {
            $table->string('email');
        });
    }

    Schema::drop('clients');

    Schem<code>a::dropIfExists('clients');

});
```

Metoda _Schema::create_ pozwala na utworzenie nowej tabeli. Przyjmuje ona dwa argumenty: pierwszym jest nazwa tabeli a drugim anonimowa funkcja która przyjmuje jako parametr obiekt typu _Blueprint_ którym (jak przedstawię poniżej) posłużymy się do dalszej definicji naszej tworzonej/modyfikowanej tabeli. Gdy dana tabela już istnieje i chcemy tylko zmodyfikować jej właściwości lub kolumny możemy wykorzystać _Schema::table_ - metoda ta przyjmuje takie same argumenty jak _Schema::create_.

Kolejne metody opisują się wręcz same z definicji. Mamy _Schema::rename_ do zmieniania nazwy tabeli, _Schema::drop_ do usuwania istniejącej tabeli oraz jej bardziej bezpieczniejszą odpowiedniczkę (brzmi zabójczo :)) _Schema::dropIfExists_ która najpierw sprawdzi czy dana tabela istnieje i dopiero wtedy trwale ją usunie. Dodatkowo możemy osobno sprawdzić czy dana tabela istnieje przy pomoc _Schema::hasTable_.




## Operacje na kolumnach


Obiekt klasy _Blueprint_ który otrzymujemy w naszej anonimowej funkcji (w metodach _Schema::create_ oraz _Schema::table_) posiada szereg przydatnych metod, które posłużą nam do opisu definicji tabeli.

**Dodawanie kolumn**

Aby dodać nową kolumną wystarczyć posłużyć się odpowiednią metodą klasy _Blueprint_. Całość kodu umieszczamy w funkcji którą przekazujemy jak drugi parametr do _Schema::create_ oraz _Schema::table_. Większość poniższych metod tej klasy jako pierwszy parametr przyjmuje nazwę tworzonej kolumny. Przykład:

```
Schema::create('users', function ($table) {
    $table->string('email');
});
```

W ten sposób utworzona została kolumna dla tabeli users typu VARCHAR o nazwie email. Poniżej lista możliwych metod:


<table >
<tbody >
<tr >
Metoda
Opis
</tr>
<tr >

<td >_$table->bigIncrements('id');_
</td>

<td >tak samo jak _increments_ ale używa BIGINT
</td>
</tr>
<tr >

<td >_$table->bigInteger('points');_
</td>

<td >pole typu BIGINT
</td>
</tr>
<tr >

<td >_$table->binary('image');_
</td>

<td >odpowiednik pola typu BLOB
</td>
</tr>
<tr >

<td >_$table->boolean('active');_
</td>

<td >odpowiednik pola typu BOOL
</td>
</tr>
<tr >

<td >_$table->char('firstname', 4);_
</td>

<td >odpowiednik pola typu CHAR o zadanej długości
</td>
</tr>
<tr >

<td >_$table->date('created_at');_
</td>

<td >odpowiednik pola typu DATE
</td>
</tr>
<tr >

<td >_$table->dateTime('created_at');_
</td>

<td >odpowiednik pola typu DATETIME
</td>
</tr>
<tr >

<td >_$table->decimal('column', 5, 2);_
</td>

<td >odpowiednik pola typu DECIMAL z odpowiednimi parametrami
</td>
</tr>
<tr >

<td >_$table->double('column', 15, 8);_
</td>

<td >odpowiednik pola typu DOUBLE z odpowiednimi parametrami
</td>
</tr>
<tr >

<td >_$table->enum('title', array('Mr.', 'Mrs.'));_
</td>

<td >odpowiednik pola typu ENUM
</td>
</tr>
<tr >

<td >_$table->float('amount');_
</td>

<td >odpowiednik pola typu FLOAT
</td>
</tr>
<tr >

<td >_$table->increments('id');_
</td>

<td >odpowiednik pola typu INTEGER wraz z opcją auto inkrementacji oraz kluczem podstawowym
</td>
</tr>
<tr >

<td >_$table->integer('votes');_
</td>

<td >odpowiednik pola typu INTEGER
</td>
</tr>
<tr >

<td >_$table->longText('content');_
</td>

<td >odpowiednik pola typu LONGTEXT
</td>
</tr>
<tr >

<td >_$table->mediumInteger('score');_
</td>

<td >odpowiednik pola typu MEDIUMINT
</td>
</tr>
<tr >

<td >_$table->mediumText('description');_
</td>

<td >odpowiednik pola typu MEDIUMTEXT
</td>
</tr>
<tr >

<td >_$table->morphs('relation');_
</td>

<td >utworzy dwie kolumny: relation_id (INTEGER) oraz relation_type (STRING)
</td>
</tr>
<tr >

<td >_$table->nullableTimestamps();_
</td>

<td >tak samo jak _timestamps_ ale pozwala na NULL'e
</td>
</tr>
<tr >

<td >_$table->smallInteger('points');_
</td>

<td >odpowiednik pola typu SMALLINT
</td>
</tr>
<tr >

<td >_$table->tinyInteger('type');_
</td>

<td >odpowiednik pola typu TINYINT
</td>
</tr>
<tr >

<td >_$table->softDeletes();_
</td>

<td >dodaje kolumnę _deleted_at_ w celu "miękkiego usuwania"
</td>
</tr>
<tr >

<td >_$table->string('email', 100);_
</td>

<td >odpowiednik pola typu VARCHAR o zadanej długości (długość jest opcjonalna)
</td>
</tr>
<tr >

<td >_$table->text('content');_
</td>

<td >odpowiednik pola typu TEXT
</td>
</tr>
<tr >

<td >_$table->time('start');_
</td>

<td >odpowiednik pola typu TIME
</td>
</tr>
<tr >

<td >_$table->timestamp('updated_at');_
</td>

<td >odpowiednik pola typu TIMESTAMP
</td>
</tr>
<tr >

<td >_$table->timestamps();_
</td>

<td >dodaje dwie kolumny typy TIMESTAMP _created_at_ oraz _updated_at_
</td>
</tr>
<tr >

<td >_$table->rememberToken();_
</td>

<td >specjalna metoda dla klasy Auth, dodaje pole _remember_token_ typu VARCHAR
</td>
</tr>
</tbody>
</table>

Dodatkowo każda z tych metod implementuje _fluent interface_ który pozwala na bezpośrednie użycie trzech kolejnych metod:


<table >
<tbody >
<tr >
Metoda
Opis
</tr>
<tr >

<td >_->nullable()_
</td>

<td >kolumna może mieć wartość NULL
</td>
</tr>
<tr >

<td >_->default($value)_
</td>

<td >definicja wartości domyślne dla kolumny
</td>
</tr>
<tr >

<td >_->unsigned()_
</td>

<td >kolumny typu INT są UNSIGNED (nieujemne)
</td>
</tr>
</tbody>
</table>


Przykładowo chcemy utworzyć kolumnę _title_ która domyślnie zawierać będzie string 'Mr.' oraz będzie mogła mieć wartość typu NULL:

```php
Schema::table('clients', function ($table) {
    $table->string('title')->nullable()->default('Mr.');
});
```

**Modyfikacja kolumn**

```php
Schema::table('clients', function ($table) {
    $table->renameColumn('login', 'username');
    $table->dropColumn('username');
    $table->dropColumn(array('firstname', 'lastname'));
});
```

Metoda _renameColumn_ zmienia nazwę kolumny (pierwszy parametr to kolumna do zmiany, drugi to nowa nazwa). Tutaj uwaga: **zmiana nazwy nie jest wspierana dla kolumn typu enum**. Z kolei _dropColumn_ pozwala na usunięcie wybranej kolumny lub kolumn (przekazujemy wtedy tablicę). Niestety aby sprawdzić czy dana kolumna istnieje musimy posłużyć się metodą _Schema::hasColumn_, gdzie pierwszy parametr to tabela a drugi kolumna:

```php
Schema::hasColumn('clients', 'username');
```

## Indeksy

**Dodawanie indeksu**

Indeks możemy określić przy pomocy wspomnianego _fluent interface_ lub oddzielnie dla tabeli (wtedy jako parametr podajemy nazwę kolumny). Poniżej przedstawiam oba sposoby:

```php
Schema::table('clients', function ($table) {
    // dla nowej kolumny
    $table->string('email')->unique();
    // dla kolumny już istniejącej
    $table->unique('email');
});
```

Do dyspozycją są następujące indeksy:


<table >
<tbody >
<tr >
Metoda
Opis
</tr>
<tr >

<td >_$table->primary('id');_
</td>

<td >dodanie indeksu primary (podstawowego)
</td>
</tr>
<tr >

<td >_$table->primary(array('first', 'last'));_
</td>

<td >dodanie indeksu primary stworzonego z więcej niż jednej kolumny
</td>
</tr>
<tr >

<td >_$table->unique('email');_
</td>

<td >dodanie indeksu unikalnego
</td>
</tr>
<tr >

<td >_$table->index('state');_
</td>

<td >dodanie indeksu zwykłego
</td>
</tr>
</tbody>
</table>


**Usuwanie indeksu**

Tutaj sprawa jest trochę trudniejsza. Do dyspozycji mam trzy metody: _dropPrimary_, _dropUnique_ oraz _dropIndex_. Każda z tych metod usuwa odpowiadający jej typ indeksu. Jako parametr przyjmuje specjalnie utworzony klucz. Do jego budowy należy użyć nazwę tabeli, nazwę kolumny oraz typ indeksu. Całość łączymy znakiem "_". Dla przykładu usunięcie indeksu primary z kolumny _id_ w tabeli _users_:

```php
Schema::table('users', function ($table) {
    $table->dropPrimary('users_id_primary');
});
```




## Klucze obce


Schema Builder wspiera również definiowanie kluczy obcych w tabeli. **Każdy klucz obcy który jest typu integer musi być unsigned**. Dodatkowo możemy zdefiniować opcję ON DELETE oraz ON UPDATE. Poniżej przykład wraz z metodą która pozwala taki klucz usunąć:

```php
Schema::table('orders', function ($table) {
    $table->foreign('user_id')
    ->references('id')->on('users')
    ->onDelete('cascade');

    $table->dropForeign('orders_user_id_foreign');
});
```

W ten sposób kolumna _user_id_ w tabeli _orders_ stała się **kluczem obcym** i odwołuję się do tabeli _users_ po kolumnie _id_. Dodatkowo w przypadku usunięcia rekordu z tabeli _users_ automatycznie usunięte zostaną jego rekordy zależne w tabeli **orders** (ON DELETE CASCADE).




## Dodatkowe metody i właściwości


Inne wyżej nie wspomniane metody i właściwości klasy _Blueprint_

```php
Schema::create('orders', function ($table) {
    $table->engine = 'InnoDB';
    $table->increments('id');
    $table->timestamps();
    $table->softDeletes();
});

Schema::table('orders', function ($table) {
    $table->dropTimestamps();
    $table->dropSoftDeletes();
});
```

W pierwszej definicji widzimy wykorzystanie atrybutu _$table->engine_ do zmiany silnika przechowywania danych. Dodatkowo utworzone zostają kolumny przy pomocy _timestamps_ oraz _softDeletes_. Następnie skorzystałem z dwóch metod których nie opisałem wcześniej _dropTimestamps_ oraz _dropSoftDeletes_, które usuwają wcześniej utworzone kolumny ich odpowiednikami.

Mam nadzieję, że ten sposób budowania bazy danych przypadnie Wam do gustu. Ja osobiście się w tym zakochałem :) W następnym wpisie skupię się nad migracjami które stanowią mega użyteczne opakowanie do dzisiejszego zbioru metod. Zobaczycie wtedy że ten wpis nabierze większego sensu. Z taką wiedzą tworzenie i przenoszenie bazy danych stanie się przyjemnością nawet w systemach kontroli wersji (np. [GIT](https://itcraftsman.pl/kontrola-wersji-z-git-cz-1-wstep/)). Po drodze mam jeszcze w planach wpis gościnny o którym na pewno będę informował Was na Facebook'owym profilu oraz moim Twitter'że. Dziękuję za poświęcony czas oraz zachęcam do komentowania wpisu.

Zdjęcie z wpisu: [Flickr](https://www.flickr.com/photos/big-dave-diode/14577885086) na licencji Creative Commons
