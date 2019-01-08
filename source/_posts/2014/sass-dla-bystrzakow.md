---

comments: true
date: 2014-07-03 20:07:39+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2014/logo-235e394c.png
slug: sass-dla-bystrzakow
title: Sass dla bystrzaków
wordpress_id: 56
categories:
- CSS
tags:
- css
- sass
- scss
---

Na samym początku ostrzegam wszystkich: SASS uzależnia. Jak spróbujesz to nie będzie odwrotu, dlatego zastanów się czy na pewno chcesz przeorganizować własny sposób pisania arkuszy CSS ?<!-- more -->


## Co to jest SASS ?


SASS (Syntactically Awesome Stylesheets) to rozszerzenie języka CSS które wnosi go na całkowicie nowy poziom. Sam SASS występuje w dwóch wersjach składniowych: starszej (podobnej do [Haml](https://pl.wikipedia.org/wiki/Haml)) oraz nowszej SCSS (czyli Sassy CSS) którą się zajmiemy. Nowsza składnia bardzo przypomina standardowe arkusze CSS ale pozwala jednocześnie korzystać z dobrodziejstwa SASS'a. Każdy arkusz CSS będzie poprawnym arkuszem SCSS ale odwrotnie już nie. Aby móc wykorzystać wszystkie możliwości, które zostaną opisane poniżej, potrzebujemy kompilatora SASS który przetworzy nasz plik .scss w plik .css. Można to zrobić na parę sposób które opiszę pod koniec. Tymczasem przedstawię 6 głównych zalet/możliwości tego skryptowego języka, które na pewno będzie można wykorzystać od zaraz.




## Zmienne


Tak :), w końcu można używać zmiennych w CSS. Pole możliwości jest olbrzymie. Od zapisywania kolorów, przez rozmiary czcionek, wybrane stałe szerokości, punkty złamań w RWD czy cokolwiek innego. Zmienną może być każda wartość atrybutu jaka dostępna jest w standardowej składni CSS. Od tego momentu, zmiana podstawowego koloru (którego używasz w kilkunastu miejscach) dla całej strony będzie pestką. Zmienną należy poprzedzić znakiem _$ _aby stała się zmienną. Poniższy przykład wszystko rozjaśni:

```css
$color-orange: #F66013;
$default-font: 14px;

.content {
  color: $color-orange;
  font-size: $default-font;
}
```

Po przetworzeniu otrzymamy:

```css
.content {
  color: #f66013;
  font-size: 14px;
}
```




## Zagnieżdżanie


Mój faworyt, coś czego w CSS brakowało od zawsze. Dzięki tej funkcji możemy tworzyć strukturę naszego CSS'a zgodną z strukturą HTML'a. SASS pozwala na zagnieżdżanie kolejnych tagów/selektorów w sobie, i to bez limitu :). Możliwe jest również zagnieżdżanie media query, dzięki czemu decydujemy w jednym miejscu jak dany element ma się zachowywać. Nigdy nie będziesz musiał pisać ponownie tego samego selektora. Poniżej przykład:

```css
.article {
	width: 90%;
	margin: 0 auto;
	h2 {
		margin: 0;
		color:#002C71;
	}
	.thumb {
		img {
			width: 100%;
		}
	}
}
```

Na wyjściu otrzymamy:

```css
.article {
  width: 90%;
  margin: 0 auto;
}
.article h2 {
    margin: 0;
    color: #002C71;
}
.article .thumb img {
    width: 100%;
}
```

Jak widać możemy idealne odwzorować strukturę drzewa HTML. W takim podejściu możemy skupić się na danym elemencie, a nie na ścieżce do niego prowadzącej.




## Importowanie


Ktoś może stwierdzić, że owszem, w zwykłym CSS też mamy import, ale ten działa inaczej. Zawartość importowanego pliku jest przetwarzana ("kompilowana") a następnie wrzucana bezpośrednio do pliku który go importuje. Oznacza to że w wyniku wykonania importu zwróci on zawsze jeden plik. Dzięki temu możemy podzielić nasze style na mniejsze części i lepiej skupić się na nich lub podzielić pracę na parę osób. Pozwala to również zaoszczędzić kolejnych zapytań HTTP które miałyby miejsce w przypadku "standardowego" importu. Przykład:

```css
/* plik normalize.scss */
html {
  font-family: sans-serif; /* 1 */
  -ms-text-size-adjust: 100%; /* 2 */
  -webkit-text-size-adjust: 100%; /* 2 */
}
```


```css
/* plik colors.scss */
$color-orange: #F66013;
$color-blue: #002C71;
$color-grey: #C4C4C4;
```


```css
/* plik style.scss */
@import 'normalize';
@import 'colors';

body {
	color:$color-orange;
}
```

Po przetworzeniu otrzymamy jeden plik z zawartością:

```css
html {
  font-family: sans-serif;
  /* 1 */
  -ms-text-size-adjust: 100%;
  /* 2 */
  -webkit-text-size-adjust: 100%;
  /* 2 */ }

body {
  color: #f66013; }
```




## Wstawki (ang. mixins)


Może tłumaczenie nie do końca jest trafne ale jakoś po polsku trzeba się porozumiewać :). Mixinem nazywamy grupę deklaracji CSS, którą możemy dowolnie wstawić w wybrane miejsce. Dzięki temu możemy tworzyć nasz plik CSS który będzie zgodny z regułą DRY (Don't Repeat Yourself). Mało tego, taką wstawkę możemy zaopatrzyć w parametr, dzięki czemu zyskamy pewną elastyczność. Definicję wstawki rozpoczynamy od wyrażenia _@mixin_ po nim następuje nazwa i/lub lista parametrów. Jak zawsze odpowiedni przykład wszystko wytłumaczy (przykład bardzo klasyczny):

```css
@mixin border-radius($radius) {
  -webkit-border-radius: $radius;
  -moz-border-radius: $radius;
  -ms-border-radius: $radius;
  border-radius: $radius;
}

.box { @include border-radius(10px); }
```

Wynikiem będzie:

```css
.box {
	-webkit-border-radius: 10px;
	-moz-border-radius: 10px;
	-ms-border-radius: 10px;
	border-radius: 10px;
}
```

Jak widać na przykładzie, oczywistym zastosowaniem jest wykonanie mixin'ów dla stylów wygenerowanych z tzw. vendor prefix. Niektórzy postanowili pójść nawet dalej i stworzyli całe gotowe biblioteki mixin'ów. Wybrane z nich przedstawię w tym artykule. Automatycznie nasuwa się również myśl, że warto wszystkie mixiny trzymać w oddzielnym pliku i tylko je importować używając _@import_.


## Dziedziczenie


Kolejna bardzo mocna cecha. Dzięki dziedziczeniu możemy przekazywać część zastosowanych deklaracji z jednego obiektu na drugi. To z kolei ponownie pozwala nam na podążanie za regułą DRY. Aby dany element odziedziczył cechy swego przodka należy wstawić wyrażenie _@extend_ a następnie selektor z którego mamy dziedziczyć. W przykładzie wykorzystamy klasę _alert_ (która może formatować jakiś komunikat) i dodamy kolejne jej odmiany:

```css
.alert {
	border: 1px solid #ccc;
	padding: 10px;
	color: #FFF;
}

.success {
	@extend .alert;
	background: green;
}

.error {
	@extend .alert;
	background: red;
}

.warning {
	@extend .alert;
	background: yellow;
}
```

Wynikiem przetworzenia takiego pliku _.scss_ będzie:

```css
.alert, .success, .error, .warning {
border: 1px solid #ccc;
padding: 10px;
color: #FFF; }

.success {
background: green; }

.error {
background: red; }

.warning {
background: yellow; }
```



## Matematyka


Z doświadczenia wiem, że możliwość obliczania czegoś w locie jest bardzo przydatna. Mało tego, możliwość obliczania czegoś w locie wraz ze zmiennymi jest jeszcze bardziej przydatna. Do naszej dyspozycji SASS udostępnia operatory typu: +, -, *, /, oraz %. Możliwa jest także konwersja wartości (np z pikseli na procenty).

```css
.container { width: 100%; }

.content {
	float: left;
	width: 600px / 960px * 100%;
}

.sidebar {
	float: right;
	width: 300px / 960px * 100%;
}
```

Po kompilacji uzyskamy:

```css
.container {
	width: 100%; }

.content {
	float: left;
	width: 62.5%; }

.sidebar {
	float: right;
	width: 31.25%; }

```

Po więcej ciekawszych funkcji odsyłam do oficjalnej [dokumentacji](https://sass-lang.com/documentation/file.SASS_REFERENCE.html#sassscript).


## Instalacja


Mam nadzieję że przedstawione wyżej cechy zachęciły już Was do instalacji SASS'a. Jeżeli tak, to do dyspozycji mamy tutaj kilka wariantów:



	
  * Instalacja specjalnego oprogramowania które śledzi i przetwarza pliki na bieżąco. Jest to najprostsze rozwiązanie. Niestety na serwerze docelowym nie zawsze będzie możliwość instalacji osobnej aplikacji. W takim przypadku zawsze pozostaje możliwość kompilacji lokalnie i wrzucanie przetworzonego pliku na zdalny serwer/maszynę. Na [tej stronie](https://sass-lang.com/install) znajduje się lista aplikacji (darmowych lub płatnych) pod różne systemy. Po instalacji i uruchomieniu sprawa zwykle wygląda bardzo podobnie: wskazujemy katalog który ma być "obserwowany", jeżeli nastąpią w nim zmiany plików .scss (ale nie tylko), to aplikacja automatycznie wygeneruje odpowiednie pliki .css.[![koala](/assets/img/posts/2014/koala.png)](/assets/img/posts/2014/koala.png)

	
  * Trudniejszą opcją jest instalacja SASS'a ręcznie. Na chwilę obecną [instalacja](https://sass-lang.com/install) możliwa jest to pod systemami: Linux, Windows oraz Mac. Na każdym systemie wygląda to bardzo podobnie. Najpierw instalujemy Ruby, a następnie za pomocą Gem'a instalujemy SASS'a, poleceniem (zakładając że mamy ruby w konsoli):

```
gem install sass
```

Instalator Ruby dla Windows znajdziesz [tutaj](https://rubyinstaller.org/downloads/). W czasie instalacji zaznaczamy opcję "Add Ruby executables to your PATH". Po instalacji odpalamy wiersz poleceń (cmd.exe) i wpisujemy powyższą linijkę.

Dla systemów Linux polecam skorzystanie z odpowiedniego dla dystrybucji managera (np. apt-get dla Ubuntu).

W Mac'ach Ruby jest preinstalowane.

	
  * Trzecim wariantem jest skorzystanie z rozwiązania napisanego dla wybranego języka programowania. Na Github'ie roi się od implementacji SASS'a pod praktycznie wszystkie popularne języki. Osobiście dla PHP korzystałem z [https://github.com/leafo/scssphp/](https://github.com/leafo/scssphp/). Proponuje poszukać, a na pewno znajdzie się coś odpowiedniego.





## Korzystamy z linii komend


Dla tych którzy zdecydowali się zainstalować "gołego" SASS'a przedstawiam kilka przydatnych komend które można wywoływać bezpośrednio w konsoli (wszystkie systemy):

_**sass style.scss style.css**_

Przetworzy jednorazowo plik style.scss, a wynik zapisze do pliku style.css. Czasem przydaje się przy jednorazowej podmianie, czy poprawce jakiegoś błędu na maszynie zdalnej (o ile jest tam zainstalowany SASS).

_**sass --watch _**style**_.scss:style.css**_

Bardziej praktyczna opcja: SASS będzie teraz na bieżąco obserwował plik style.scss i jeżeli tylko pojawi się jakakolwiek zmiana, to całość zostanie przetworzona i zapisana do pliku style.css. Należy pamiętać, że po zakończeniu edycji proces trzeba zakończyć (np. CTRL + C). Poniżej przykład działania polecenia pod Windowsem:
[![sass](/assets/img/posts/2014/sass.png)](/assets/img/posts/2014/sass.png)

**sass --watch app/sass:public/stylesheets**

Podobna sprawa jak powyżej, z tym, że teraz, SASS będzie obserwował nie pojedynczy plik, a cały katalog.

_**sass --help**_

Spis wszystkich dostępnych komend i ich parametrów znajdziesz w oficjalnej [dokumentacji](https://sass-lang.com/documentation/file.SASS_REFERENCE.html#sassscript). Polecam dla bardziej dociekliwych użytkowników.


## Style kompilowania


Bardzo przydatna informacja. Kompilator SASS posiada opcję o nazwie

```"--style"```

po której podajemy nazwę stylu zwracanego formatu. Poniżej zamieszczam wszystkie cztery możliwości wraz z efektem. Na samym początku mamy oryginalny plik .scss:

```css
.alert, .success, .error, .warning {
	border: 1px solid #ccc;
	padding: 10px;
	color: #FFF;
}

.success {
	background: green;
}

.error {
	background: red;
}

.warning {
	background: yellow;
}
```

Nested (domyślny) _**sass style.scss style.css --style nested:**_

```css
.alert, .success, .error, .warning {
  border: 1px solid #ccc;
  padding: 10px;
  color: #FFF; }

.success {
  background: green; }

.error {
  background: red; }

.warning {
  background: yellow; }
```

Expanded _**sass style.scss style.css --style expanded**_

```css
.alert, .success, .error, .warning {
  border: 1px solid #ccc;
  padding: 10px;
  color: #FFF;
}

.success {
  background: green;
}

.error {
  background: red;
}

.warning {
  background: yellow;
}

```

Compact _**sass style.scss style.css --style compact**_

```css
.alert, .success, .error, .warning { border: 1px solid #ccc; padding: 10px; color: #FFF; }

.success { background: green; }

.error { background: red; }

.warning { background: yellow; }
```

Compressed _**sass style.scss style.css --style compressed**_

```css
.alert,.success,.error,.warning{border:1px solid #ccc;padding:10px;color:#FFF}.success{background:green}.error{background:red}.warning{background:yellow}
```

Jak widać, te bardziej "rozłożyste", będzie można wykorzystać w procesie kodowania, natomiast na serwerach produkcyjnych zaleca się już korzystanie z compressed, co pozwoli zaoszczędzić na transferze oraz wpłynie na szybsze ładowanie strony.


## Przydatne linki


Na koniec zamieszczam linki do bardzo ciekawych gotowych bibliotek oraz innych narzędzi które mogą się przydać. Niektóre z nich można by nazwać wręcz micro-frameworkami. Polecam zapoznanie się z nimi:

  * [**https://bourbon.io/** ](https://bourbon.io/)- razem w parze z Neat tworzą bardzo dobry zestaw (framework) do tworzenia złożonych projektów
  * **[https://compass-style.org/](https://compass-style.org/) - **wsparcie dla CSS3 oraz przyjazność dla designerów to główne cechy Compassa
  * [**https://sassmeister.com/**](https://sassmeister.com/) - pozwala on-line przetwarzać SASS do CSS


Na początek sporo wiedzy do przyswojenia, ale na pewno nie będzie to zmarnowany czas. Umiejętność obchodzenia się z arkuszami scss sprawi, że twoje notowania na pewno wzrosną.

Dotarliśmy do końca dlatego dziękuję za poświęcony czas. Zachęcam do podzielenia się własnymi uwagami/przemyśleniami w komentarzach. Jeżeli czujesz, że nie wyczerpałem tematu, to również powiadom mnie o tym.
