---
comments: true
date: 2015-02-13 11:35:10+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2015/Laravel-5-300x180.png
slug: co-nowego-w-laravel-5
title: Co nowego w Laravel 5
wordpress_id: 920
categories:
- Laravel
tags:
- flysystem
- laravel 5
- laravel 5 news
- middleware
- php
---

Sprawdźmy jakie nowości czekają Nas w najnowszej odsłonie Laravela oznaczoną cyfrą 5. Jest sporo nowych funkcjonalności, które od razu przypadną Wam do gustu. Z drugiej strony spora liczba zmian utrudni płynne przejście z wersji 4 na 5, ale coś za coś. Zapraszam do lektury i polecam kawę, wpis jest jednym z tych dłuższych.

<!-- more -->

Choć hejtu na Laravela nie brakuje (w polskich grupach PHP również :P), jest on ciągle jednym z moich ulubionych **narzędzi**. Podkreślam narzędzi, bo framework właśnie powinien być aż i jednocześnie tylko narzędziem, a nie filozofią życia. Niemniej, nie wykluczam, że tak będzie cały czas i być może za jakiś czas przestawię się na Symfony ? A może powstanie jeszcze coś innego ? Tymczasem wracając do tematu ...

<div class="shadow-md p-4 bg-yellow-lighter">Niektóre, z niżej opisanych nowości, zostaną omówione w osobnych wpisach, dlatego polecam zapisanie się do newslettera, żeby nic Wam nie umknęło.</div>

Najnowsza wersja spotkała się również z dużą dawką krytyki (nawet tej konstruktywnej). Moim zdaniem, framework jest naprawdę przyjemny i ma coś czego nie mają inne tak duże frameworki. Pozwala on na rozwój poziomu programowania w miarę wzrostu doświadczenia z jego korzystania. Z Laravela mogą korzystać osoby na prawie każdym etapie rozwoju (potrzebny poziom wiedzy do rozpoczęcia pracy z nim jest relatywnie niski). Może to być Twój pierwszy framework, od którego zaczniesz naukę, ale może też być kolejny, który pozwoli na zdobycie kolejnej porcji doświadczenia. Dobra, nie jest to tematem tego wpisu, dlatego zacznijmy od wspomnianych nowości:


## Nowa struktura katalogów


Od teraz cały kod tworzonej aplikacji znajduje się w katalogu _app/_ i domyślnie jest objęty namespacem _App_, który bardzo łatwo można zmienić w dowolnym momencie. Używa się do tego polecenia _app:name_ w Artisan CLI (Laravelowy wiesz poleceń). Dzięki tej zmianie kod aplikacji spełnia teraz standard **PSR-4** w kwestii autoloadingu.

Kontrolery zostały przeniesione do katalogu _Http/Controllers_ (wcześniej _controllers/_) wraz z nowymi middlewareami, które zastąpiły poprzednie filtry (wyjaśnienie będzie niżej). Widoki (_views_) i pliki językowe są teraz w całkowicie nowym, osobnym katalogu _resources_ - poza katalogiem _app/_. Poza _app/_ wrzucony został również katalog _database/_ z migracjami i seederami.

[![Nowa struktura katalogów w Laravel 5](/assets/img/posts/2015/laravel-5-dirs.png)](/assets/img/posts/2015/laravel-5-dirs.png) Nowa struktura katalogów w Laravel 5



Przejście na nową wersję dla istniejących już projektów może być uciążliwe, dlatego zaleca się aby zacząć całą procedurę od nowej instalacji Laravel 5. Następnie należy skopiować z poprzedniej wersji: kontrolery, routy, modele, polecenia Artisan, testy oraz inne klasy specyficzne dla naszego projektu. Brak automatyzacji tego procesu na pewno spowolni proces przejścia na nowszą wersję.


## Kontrakty


Większość komponentów frameworka implementuje teraz nowe interfejsy (zwane kontraktami), który nie posiadają żadnych zewnętrznych zależności. Wszystkie kontrakty mają swoje osobne repozytorium dostępne na [GitHubie](https://github.com/illuminate/contracts).

Przykładowo kontrakt _**Queue** _definiuje metody do obsługi kolejek, a _**Paginator** _posiada metody do obsługi stronicowania (np. rekordów z bazy danych). Każdy z tych kontraktów posiada szczegółową implementacje dostarczoną wraz z frameworkiem.

Dzięki tej zmianie, bardzo łatwo będzie można podmieniać gotowe implementacje na własne rozwiązania. Tworzony w ten sposób kod jest luźniej powiązany i łatwiejszy do utrzymania.


## Cacheszowanie routingu


Dla dużych aplikacji, gdzie liczba routów przekracza 100, wprowadzono możliwość utworzenia cache. Podobno daje to 100x większe przyspieszenie. Jest tylko jeden warunek: wśród definicji ścieżek nie może być żadnej, która jest obsługiwana przez callback (funkcje anonimową - _closures_) - takiego typu nie da się zserializować - czyli cache nie zostanie utworzony. Cache tworzymy poleceniem:
```
php artisan route:cache
```



## Middleware


Jeżeli do tej pory używałeś filtrów, to teraz zastępują je trochę bardziej złożone Middlewary. Czym więc one są ? Otóż Middlewary to takie wrappery na logikę biznesową aplikacji, której dekorują odpowiednio żądanie (request) oraz odpowiedź (response). Mogą być one uruchamiane tak samo jak filtry: przed lub po akcji kontrolera. Middlewary implementują wzorzec programowania Decorator: na wejście biorą request, coś z nim robią (lub nie) i zwracają request do kolejne warstwy (czyli możliwe, że do kolejnego middlewara). Poniżej mały schemat, który pozwoli na lepsze zrozumienie czym jest middleware:

[![źródło: stackphp.com](/assets/img/posts/2015/onion.png)](/assets/img/posts/2015/onion.png) Jak działa Middleware, źródło: stackphp.com

Temat Middlewarów jest bardziej złożony niż się wydaje, a sam mechanizm jest na tyle ciekawy, że na pewno zostanie opisany w osobnym poście.




## Wstrzykiwanie w metody kontrolera


Dla tych co wolą angielską nomenklaturę, ten punkty nazywał by się Controller Method Injection (niemniej, w miarę możliwości, staram się używać polskich odpowiedników, choć czasem się nie da). Coś, czego brakowało mi już w wersji 4.

W wersji 4 można było wykonać type-hinting parametrów konstruktora i Laravel sam wstrzykiwał odpowiednie obiekty.

```php
public function __construct(Product $product, User $user)
{

}
```

Teraz to samo można zrobić dla każdej metody kontrolera. Do tego framework sam sprawdzi i poprawnie obsłuży inne parametry routa (który kieruje do tego kontrolera).

```php
public function storeUser(Input $input, User $user, $routeParam)
{

}
```


## Gotowe uwierzytelnianie


Mechanizm logowania, rejestracji użytkowników i resetowania hasła jest teraz gotowy od zaraz (out of the box). W pakiecie dostajemy także podstawowe widoki, działające kontrolery, zarejestrowane routy oraz gotowe [migracje bazy danych](http://itcraftsman.pl/migrowanie-bazy-danych-laravel-migrations/). Całość śmiga od zaraz po skonfigurowaniu bazy danych (w pliku_ .env_ lub _app/config/database.php_) i zastosowaniu migracji (polecenie _php artisan migrate_).

[![Laravel 5 - gotowe logowanie](/assets/img/posts/2015/laravel-5-auth.jpeg)](/assets/img/posts/2015/laravel-5-auth.jpeg) Gotowe logowanie w Laravel 5

## Eventy jako obiekty


W wersji 4 definiowanie i obsługa eventów opierała się na używaniu odpowiednich nazw w postaci zwykłego stringa. W Laravel 5 definiujemy eventy jako obiekty. Dla porównania przygotowałem przykłady. Eventy w Laravel 4:

```php
// obsługa eventu przez callback
Event::listen('user.login', function($user)
{
    $user->last_visit = new DateTime;
    $user->save();
});
// obsługa eventu przez klase
Event::listen('user.login', 'UserLoginHandler');

// wywołanie eventu
$response = Event::fire('user.login', array($user));
```

Eventy w Laravel 5:

```php
// obsługa eventu przez callback
Event::listen('App\Events\UserWasLogged', function($event)
{
    // Handle the event...
});

// obsługa eventu przez klasę
class UserLogged {

    public function handle(UserWasLogged $event)
    {
        //
    }

}

// rejestracja obsługi eventu przez klasę
// domyślnie w app/Providers/EventServiceProvider
protected $listen = [
    'App\Events\UserWasLogged' => [
        'App\Handlers\Events\UserLogged@handle',
    ],
];

// wywołanie eventu
Event::fire(new UserWasLogged($user));

// klasa samego eventu
class UserWasLogged {

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

}
```



## Polecenia i Command Bus


Tutaj generalnie chodzi o całą technikę nazwaną "Command Bus", która poniekąd jest wzorcem projektowym. Całość sprowadza się do pisania klas typu Command, które są obsługiwane przez odpowiednie Handlery. O samej obsłudze decyduje właśnie Command Bus, który przydziela odpowiedni Handler do odpowiedniego Commandsa.

Nie jestem jeszcze dokładnie obeznany z tą techniką, ale napotkałem już pewne problemy. Otóż, zgodnie z założeniami, obsługa polecenia (metoda _handle_) nie powinna zwrócić żadnej wartości. W związku z tym bardzo trudno pisze się testy (przynajmniej dla mnie). Muszę ten temat jeszcze rozgryźć. Na pewno będzie osobny wpis na temat całego flow Commandsów w Laravel 5.

Jeszcze jedną zaletą korzystania z Commands, jest możliwość wywoływania ich asynchronicznie, z wykorzystaniem kolejki.


## Nowy sterownik do obsługi kolejek


System kolejkowania (znany z poprzedniej wersji) zyskał teraz sterownik (_driver_) do bazy danych. W ten sposób, bez instalacji dodatkowego oprogramowania, można, za pomocą bazy danych, obsługiwać kolejki. Wcześniej potrzebny był do tego odpowiedni serwer, np. Beanstalkd (choć można było również wykorzystać lokalny system plików, ale wtedy obsługa kolejek była synchroniczna).


## Laravel Scheduler


Jeden z moich ulubionych nowych ficzerów :) Harmonogramowanie zadań. Załatwia całego CRONa i zwalnia z potrzeby zarządzanie nim. Wystarczy dodać do CRON tylko jedną linijkę (na cały skrypt):
```
* * * * * php /path/to/artisan schedule:run 1>> /dev/null 2>&amp;1
```
Następnie w pliku _app/Console/Kernel.php_ w metodzie _schedule_ mamy do dyspozycji szereg możliwości: możemy decydować co ma się uruchamiać (funkcja, komenda czy nawet wywołanie linii poleceń - o ile konfiguracja serwer na to pozwala).  Możemy również decydować (z poziomu kodu) z jaką częstotliwością ma się uruchamiać, oraz pod jakim warunkiem.

Zapodam kilka linijek, które nie powinny wymagać komentarza, ponieważ składnia jest bardzo czytelna:

```php
$schedule->call(function()
{

})->hourly();

$schedule->exec('composer self-update')->daily();

$schedule->command('foo')->everyFiveMinutes();
$schedule->command('foo')->everyTenMinutes();
$schedule->command('foo')->everyThirtyMinutes();

$schedule->command('foo')->daily();
$schedule->command('foo')->dailyAt('15:00');

$schedule->command('foo')->twiceDaily();
```



## Tinker / Psysh


_Tinker_ to narzędzie znane już z wcześniejszych wersji. Umożliwia ono interakcję z naszą aplikacją na zasadzie wiersza poleceń - tak jak gdyby skrypt cały czas działał (a nie tak jak zwyczajnie obsługa requesta i koniec).  Inni nazywają to shellem (php shell). Krótki przykład wykorzystania:
```
> php artisan tinker
> Psy Shell v0.3.3 (PHP 5.5.9 ÔÇö cli) by Justin Hileman
> $user = User::first();
> var_dump($user)
```
W rezultacie otrzymamy szybki var_dump pierwsze znalezionego użytkownika. Taka alternatywa zamiast wrzucania czegoś "brzydkiego" w kod. Oczywiście można znaleźć inne zastosowania.

Dla użytkowników pythona czy node.js to pewnie nic nowego :)


## Konfiguracja DotEnv


W kwestiach konfiguracyjnych nastąpiły pewne zmiany. Nie będzie już oddzielnych katalogów zależnych od środowiska (_local_, _staging_, _testing, _itp.). Teraz wszystkie zmienne środowiskowe powinny znaleźć się w pliku .env (w głównym katalogu). Plik ten nie powinien znajdować się w repozytoriach i być pod kontrolą wersji. W dokumentacji jest sugestia, aby każde repozytorium zawierało plik .env.example, który każdy dokonfiguruje sobie samodzielnie.

Za poprawne funkcjonowanie nowego mechanizmu odpowiedzialna jest biblioteka [DotEnv PHP](https://github.com/vlucas/phpdotenv).


## Laravel Elixir


Elixir to narzędzie autorstwa Jeffrey Way, które służy do automatyzacji procesów. Głównie chodzi tutaj o kompilacje i łącznie assetów, ale nie tylko. W praktyce sprowadza się to do kompilacji plików Sass, Less czy CoffeScript. Elixir może również automatycznie odpalać testy jednostkowe i wyświetlać ich wyniki bezpośrednio na ekranie. Samo narzędzie w akcji można zobaczyć pod tym linkiem: [https://laracasts.com/series/whats-new-in-laravel-5/episodes/10](https://laracasts.com/series/whats-new-in-laravel-5/episodes/10)


## Laravel Socialite


Laravel Socialite do nowy dodatkowy pakiet (na osobnym [repozytorium](https://github.com/laravel/socialite)), dedykowany dla Laravel 5. Zawiera on zestaw do autoryzacji użytkowników z wykorzystanie protokołu [OAuth](http://oauth.net/). Aktualnie jest wsparcie dla takich dostawców jak: Facebook, Twitter, Google i GitHub. Aby móc korzystać z mocy tej paczki potrzebny jest dodakowy wpis w composer.json
```
"laravel/socialite": "~2.0"
```
Następnie trzeba dodać odpowiedni provider do config/app.php i dopisać dwa routy które wyglądają następująca (przykład):
```php
public function redirectToProvider()
{
    return Socialize::with('facebook')->redirect();
}

public function handleProviderCallback()
{
    $user = Socialize::with('facebook')->user();
}
```

Tak więc integracja z FB czy logowanie za pomocą Googla powinno zająć maksymalnie do 10 minut :) (ale nikt nie musi tego wiedzieć).


## Integracja z Flysystem


[Flysystem](https://github.com/thephpleague/flysystem) to warstwa abstrakcji do systemu plików, która umożliwia łatwą zamianę lokalnego systemu plików na jeden z dostępnych adapterów. Do dyspozycji jest ładna lista, ale wystarczy wymienić kilka: FTP, SFTP, AWS czy Rackspace. Od teraz całość została włączona do Laravel 5. Dzięki temu zabiegowi, zapisanie czegoś na dowolnym FTP (przykładowo, bo równie dobrze można używać dowolnego innego adaptera) sprowadza się do jednej linii:
```
Storage::put('file.jpg', $contents);
```
Całość jest naprawdę bardzo ciekawa i łatwa w obsłudze. Z pewnością będzie o tym oddzielny wpis.


## Walidacja formularzy


Do dyspozycji mamy nową klasę _FormRequest_, która odpowiada za walidację danych wprowadzanych przez użytkownika. Może zostać ona **automagicznie** wstrzyknięta do dowolnej metody kontrolera, sprawiając, że walidacja będzie lekka i przyjemna. Wymaga to stworzenia osobnej klasy na każdy formularz w naszej aplikacji. Jeżeli to jednak za dużo, to w następnym punkcie jest jeszcze prostsza metoda.

Sprawdźmy na przykładzie jak działa nowa walidacja. Do obsługi mamy prosty formularz kontaktowy z dwoma polami: e-mail i zapytanie (treść). Tworzymy _FormRequest_:
```
<php namespace App\Http\Requests;

class ContactRequest extends FormRequest {

    public function rules()
    {
        return [
            'email' => 'required|email',
            'question' => 'required',
        ];
    }

}
```
Następnie w naszym kontrolerze, który obsługuje formularz kontaktowy, tworzymy odpowiednia metodę z parametrem:
```
public function sendContact(ContactRequest $request)
{
    // Mail::send() i te sprawy
}
```
Po uruchomieniu kodu, klasa _ContactRequest_ zostanie **automatycznie** wstrzyknięta, mało tego, zostanie automatycznie przeprowadzona walidacja. Jeżeli jej wynik będzie negatywny to zostanie wyrzucony wyjątek, który również jest **automatycznie **obsługiwany (patrz punkt niżej). Z tego powodu, zawartość metody _sendContact_, zostanie uruchomiona tylko przy poprawnym wypełnieniu formularza. Pomyśl, jak elegancko będzie wyglądać kod :)

Klasa _FormRequest_ pozwala dodatkowo konfigurować wybrane parametry, które mają wpływ na obsługę walidacji (np. przekierowania czy sposób formatowania błędów).


## Uproszczona walidacja formularzy w kontrolerach


W celu łatwiejszej walidacji danych w kontrolerze, można skorzystać z traita _ValidatesRequests. _Dzięki temu, możliwa jest walidacji bezpośrednio w dowolnej metodzie kontrolera za pomocą metody _$this->validate()_, która przyjmuje jako parametr _request_ i tablicę z wymaganiami:
```
class ProductController extends Controller {

    use ValidatesRequests;

    public function save(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique|max:255',
            'name' => 'required',
        ]);

        //reszta kodu
    }
}
```
Jeżeli walidacja przebiegnie pomyślnie to Twój kod będzie dalej normalnie obsługiwany. W przypadku błędu zostanie wyrzucony wyjątek. Na tym jednak nie koniec. Wyjątek _Illuminate\Contracts\Validation\ValidationException _jest automagicznie obsługiwane przez system, który przekieruje użytkownika do poprzedniego adresu (url). Dodatkowo błędy walidacji zostaną "wepchnięte" do danych sesji (tak samo jak gdyby wywołać metodę _withErrors($validator)_ w przekierowaniu).


## Nowe generatory


Aby przyspieszyć tworzenie kodu, dodane zostały nowe generatory, wywoływane z linii poleceń: _make:command_, _make:console_, _make:controller_, _make:event_, _make:middleware_, _make:migration_, _make:model_, _make:provider_, _make:request_. W ten sposób można szybko utworzyć proste szkielety gotowych klas.

[![laravel-5-generator](http://itcraftsman.pl/wp-content/uploads/2015/02/laravel-5-generator.png)](http://itcraftsman.pl/wp-content/uploads/2015/02/laravel-5-generator.png)


Przykładowo wywołując polecenie: _make:request_ z parametrem _SearchRequest_, otrzymamy gotowy szkielet klasy _Request_:
```
<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class SearchRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return false;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			//
		];
	}

}

```



## Cacheszowanie konfiguracji


Wszystkie pliki konfiguracyjne można spakować teraz w jeden plik, używając polecenia _config:cache_. Niby nic, ale jak robicie jakieś skomplikowanie operacje w plikach konfiguracyjnych (albo jak macie ich całe mnóstwo), to stworzenie cache może pomóc przyspieszyć aplikację.


## VarDumper od Symfony


Funkcja _dd_ (die and dump) korzysta teraz z narzędzia VarDumper od Symfony. W efekcie, przykładowy _array_:
```
dd(Config::get('app'));
```
może, w przeglądarce, wyglądać następująco:

[![laravel-5-var-dumper](/assets/img/posts/2015/laravel-5-var-dumper.jpeg)](/assets/img/posts/2015/laravel-5-var-dumper.jpeg)





## ... koniec.



Na chwilę obecną to wszystko. Trochę się tego nazbierało, więc jak ktoś dotrwał do końca, to dzięki za poświęcony czas. Mam nadzieje, że choć trochę pomogłem coś rozjaśnić lub zachęcić do poznania czegoś nowego. W razie pytań/uwag/wątpliwości: komentarze są Wasze :)
