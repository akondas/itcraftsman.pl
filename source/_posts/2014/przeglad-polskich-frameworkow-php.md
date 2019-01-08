---
comments: true
date: 2014-10-17 07:28:09+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2014/4950684667_5430bd5d6c_b-300x192.jpg
slug: przeglad-polskich-frameworkow-php
title: Przegląd polskich frameworków PHP
wordpress_id: 687
categories:
- PHP
tags:
- framework
- hanariu
- momentphp
- moss
- ouzo
- php
- przegląd
- spawn
- splot
---

Wszyscy znamy wiodące framework'i PHP. Postanowiłem przedstawić Wam dokonania polskich developerów PHP oraz spytać się ich co mają do powiedzenia na temat swoich projektów.<!-- more -->

Pracę nad wpisem rozpocząłem już dawno temu, ale dopiero teraz udało mi się skompletować wszystkie odpowiedzi oraz "usiąść" do wpisu. Wybrałem <del>5</del> 6 polskich projektów:

**Aktualizacja [23.07.2015]: dodałem MomentPHP**.

  * Ouzo Framework
  * MOSS Framework
  * Spawn Framework	
  * Hanariu
  * Splot Framework
  * MomentPHP


Na samym wstępie chciałbym podziękować autorom za poświęcony czas i przesłane odpowiedzi. Kolejność przedstawionych framewor'ów PHP jest całkowicie przypadkowa :) Przyda się też kawa do czytania. Zapraszam:

## Ouzo Framework

*Opis przygotował dla Was Piotr Olaszewski:*

[![screenshot-ouzoframework.org 2014-10-15 21-46-01](/assets/img/posts/2014/screenshot-ouzoframework.org-2014-10-15-21-46-01.jpeg)](/assets/img/posts/2014/screenshot-ouzoframework.org-2014-10-15-21-46-01.jpeg) Ouzo Framework

**Historia**

Koncepcja Ouzo narodziła się gdzieś na początku 2013 roku w firmie Thulium ([thulium.pl](https://thulium.pl)). Od wielu lat firma dostarczała autorskie oprogramowanie call center i przez ten czas, jak to zazwyczaj bywa, dług techniczny projektu powiększał się niczym dziura budżetowa w Polsce. Jednak w przeciwieństwie do naszych polityków, my postanowiliśmy zacząć ten dług spłacać.

Z wielu różnych przyczyn, w które nie warto się tu zagłębiać, podjęliśmy decyzję żeby zmiany w kodzie oprzeć na własnym frameworku (jak to dumnie brzmi!). Stworzyliśmy framework webowy oparty o MVC, własny ORM i masę narzędzi ułatwiających pisanie czystego kodu i testów. Czerpaliśmy z naszych doświadczeń w innych technologiach (Google Guava, Ruby on Rails, Mockito, FEST-Assert itd.).

**Pierwsza wersja**

Po kilku miesiącach pracy stwierdziliśmy, że to co stworzyliśmy jest na tyle fajne, że można się tym podzielić ze społecznością. Pierwszy duży release Ouzo to luty 2014. Od tego czasu wypuszczamy nowe wersje w odstępach 3-miesięcznych. Obecny core team to 5 programistów, którzy pracują nad Ouzo na co dzień. To co jest w projekcie open source, to tylko część tego co mamy do zaoferowania. Planujemy przenosić więcej funkcjonalności z naszego komercyjnego, zamkniętego kodu.

**Plany na przyszłość**

Podział Ouzo na mniejsze komponenty to w tej chwili nasz główny priorytet. Zdajemy sobie sprawę, że migracja na inny framework MVC może być trudna i nieuzasadniona, dlatego chcemy dostarczyć to co w Ouzo najlepsze w postaci oddzielnych bibliotek. Np. podobają Ci się nasze testy - asercje, mocki? Już niedługo każdy projekt będzie w stanie ich w prosty sposób używać.

**Dlaczego Ouzo**

Co nas wyróżnia? Jeśli chcesz czytać swój kod jak książkę, chcesz żeby był prosty do zrozumienia dla innych, do tego łatwo testowalny - Ouzo jest dla Ciebie.

Kilka przykładów:
Asersje w testach - [https://github.com/letsdrink/ouzo/wiki/Tests#array-assertions](https://github.com/letsdrink/ouzo/wiki/Tests#array-assertions)  
Programowanie funkcjonalne z Ouzo - [https://github.com/letsdrink/ouzo/wiki/Functional-programming-with-ouzo](https://github.com/letsdrink/ouzo/wiki/Functional-programming-with-ouzo)  
Mockowanie - [https://github.com/letsdrink/ouzo/wiki/Tests#mocking](https://github.com/letsdrink/ouzo/wiki/Tests#mocking)  
Query builder - [https://github.com/letsdrink/ouzo/wiki/ORM#query-builder](https://github.com/letsdrink/ouzo/wiki/ORM#query-builder)

**O projekcie**

Strona projektu: [https://ouzoframework.org](https://ouzoframework.org)  
Najnowsza stabilna wersja: 1.2  
**Licencja: MIT**  
Github (źródła): [https://github.com/letsdrink/ouzo](https://github.com/letsdrink/ouzo)  
Zgłoszenia: [https://github.com/letsdrink/ouzo/issues](https://github.com/letsdrink/ouzo/issues)  
Grupa mailingowa: [ouzo-framework@googlegroups.com](mailto:ouzo-framework@googlegroups.com)


## MOSS Framework

[![Moss Framework](/assets/img/posts/2014/moss-source.jpg)](/assets/img/posts/2014/moss-source.jpg) Moss Framework

Od autora nie dostałem za dużo informacji ale postanowiłem przetłumaczyć trochę treści z GitHub'a (choć tłumacz ze mnie żaden):

**O frameworku**

Moss to mały (prawie micro) framework dostarczający podstawowe narządzenia, które mogą posłużyć do zbudowania prostej strony lub API. Co odróżnia go od innych tego typu projetków ?

Moss nie jest pomniejszoną lub obciętą wersją jakiegoś rozbudowanego frameworka (jak wiele dostępnych na rynku). Nie jest to również narzędzie stworzone przez miłośników minimalistycznych closure (tutaj trudno jednoznaczne to przetłumaczyć).

Moss stworzony został z myślą o: małych projektach, łatwości rozszerzania, oraz z jak najmniejszą liczbą zależności (aktualnie żadnych).

Równocześnie Moss chce być modny i na czasie, dlatego podąża za obecnymi trendami:  closures, event dispatching, dependency injection, aspect oriented programming (nie będę tłumaczył).

**Możliwości**

  * pełnowartościowy Router
  * obiekty Response i Request (wraz z http auth oraz obsługą nagłówków)
  * łatwy upload plików przez Request::file
  * flash messages
  * dependency injection container
  * event dispatcher z AOP
  * widoki z możliwością podpięcia Twig'a
  * czysty kod oraz loose coupling (zawsze zastanawiam się jak to tłumaczyć ?)

**O projekcie**

Github (źródła): [https://github.com/potfur/moss](https://github.com/potfur/moss)  
**Licencja: MIT**  
Aplikacja demo: [https://github.com/potfur/moss-demo-app](https://github.com/potfur/moss-demo-app)  

Chciałbym jeszcze zacytować Wam zabawne zdanie od samego autora (trzeba przyznać że ma dobry dystans do projektu :)) Michał "potfur" Wachowski:

>"Na obecną chwilę jego popularność powala - ilość użytkowników można by policzyć na jednej ręce ślepego drwala, z odmrożeniami."


## Spawn Framework

[![screenshot-spawnframework.com 2014-10-15 22-28-03](/assets/img/posts/2014/screenshot-spawnframework.com-2014-10-15-22-28-03.jpeg)](/assets/img/posts/2014/screenshot-spawnframework.com-2014-10-15-22-28-03.jpeg) Spawn Framework

*Opis przygotował dla Was Paweł Makowski*

(w sieci można znaleźć jeszcze jeden artykuł na łamach webmastach: [https://webmastah.pl/spawn-framework-czyli-narzedzie-dla-najmniejszych/](https://webmastah.pl/spawn-framework-czyli-narzedzie-dla-najmniejszych/))

**Historia**

Spawn Framework powstał w maju 2010 roku. Spawn jest projektem przeznaczonym dla osób początkujących oraz piszących małe/średnie, proste aplikacje. Czyli jest idealny dla freelancerów oraz małych agencji robiących masowe stronki na tanie hostingi. Pomysł na stworzenie Spawna powstał po pracy na kilku innych fw gdzie żaden nie spełniał moich oczekiwań, a ich dalszy rozwój szedł w złą stronę (np. ko3).

**Plany na przyszłość**

Jeśli chodzi o przyszłość to obecnie próbuję znaleźć czas na rozwój generatorów crud, widgetów zapewniających szybkie generowanie poszczególnych części widoku (menu/datagrid/breadcrumbs itd) oraz lepszą integrację z Bootstrap 3 ([https://getbootstrap.com/](https://getbootstrap.com/)).

**O projekcie:**

Strona projektu: [https://spawnframework.com/](https://spawnframework.com/)  
Najnowsza stabilna wersja: 2.7.4  
**Licencja: New BSD License**  
Github (źródła): [https://github.com/Spawnm/Spawn-Framework](https://github.com/Spawnm/Spawn-Framework)

## Hanariu

[![Hanariu](/assets/img/posts/2014/screenshot-hanariu.pl-2014-10-15-22-37-49.jpeg)](/assets/img/posts/2014/screenshot-hanariu.pl-2014-10-15-22-37-49.jpeg) Hanariu

*Opis przygotował dla Was Radosław "Riu" Muszyński*

**Historia**

Hanariu powstał pod wpływem indolencji twórców frameworka Kohana. Inspiracją dodatkową było środowisko skupione wokół frameworka Phalcon PHP. Sam framework powstawał właściwie w dwóch etapach. Początkowo miał być to fork Kohany, jednak po testach wydajnościowych i wobec ograniczeń jakie niosło ze sobą bycie forkiem, postanowiłem, że będzie to nowa konwencja.

Ciekawostką jest, że wynająłem na dwa miesiące mieszkanie w Białymstoku i zająłem się badaniem wzorców projektowych i następstw praktycznych ich stosowania - nie pracowałem, zająłem się tylko i wyłącznie badaniem co jak działa. W wyniku eksperymentów, po części wbrew przyjętym wzorcom projektowym, powstała pierwsza wersja Hanariu rozumianego jako nowy byt. Wersja ta jeszcze ulegała zmianom ale testy pokazały, że można stworzyć framework, który w świecie prawdziwych aplikacji i benchmarków wychodzących poza regułę "hello word" będzie szybszy niż Phalcon.

Na frameworku powstało kilka testowych aplikacji, kilka stron, po czym prace zostały zawieszone ponieważ związałem się z korporacją jako .... front-endowiec :),

**Plany na przyszłość**

Zawieszenie rozwoju nie oznacza koniec tego projektu. Trwają pracę nad wersja drugą, która ma zostać wydana na początku 2015 roku. Hanariu w pewnym momencie z prostego projektu, pod wpływem wielu rozmów, opinii, przekształciło się w duży komercyjny projekt (jednak nadal open source) i prawdopodobnie na początku 2015 roku powstanie spółka zajmująca się tworzeniem zaawansowanych aplikacji i dużych stron internetowych w oparciu m.in. o Hanariu (obok Node.js i Zephira/Phalcona).

Od strony technicznej - zgodnie z planem publikowanym m.in na Webmastah.pl o Hanariu ma być opartych szereg aplikacji. Aplikacje będą wydane na licencjach open-source, natomiast do każdej będzie można dokupić płatne wtyczki.

Docelowo Hanariu ma być narzędziem mogącym przez swoje możliwości doskonale zastąpić narzędzia takie jak: Wordpress, phpBB forum, czy Redmine.

**O projekcie:**

Strona projektu: [https://hanariu.pl/](https://hanariu.pl/)  
Github (źródła): [https://github.com/Hanariu/hanariu](https://github.com/Hanariu/hanariu)

## Splot Framework

[![Splot Framework](/assets/img/posts/2014/splot-framework.jpg)](/assets/img/posts/2014/splot-framework.jpg) Splot Framework

*Opis przygotował dla Was Michał Dudek ([michaldudek.pl](https://michaldudek.pl))*

**Historia**

Splot Framework powstał przy okazji tworzenia web-aplikacji Focusson ([focusson.pl](https://www.focusson.pl)), do którego chciałem zastosować najnowsze rozwiązania i podejścia w ekosystemie PHP. Wcześniej zauroczyłem się Symfony2, ale po dłuższej zabawie i codziennej z nim walki w pracy stwierdziłem, że przydałoby się jednak coś co nie jest "overengineered", a jednocześnie implementuje i narzuca wszystkie dobre patterny typu m.in. Dependency Injection czy Event Dispatcher.

Splot jest implementacją mojej interpretacji czym powinien zajmować się framework, a co powinien zostawić programiście do implementacji, a także (być może przede wszystkim) zbiorem klocków, które są potrzebne przy budowie współczesnych aplikacji webowych. Nie boi się przy tym korzystać z gotowych rozwiązań, więc od podszewki opiera się też na komponentach Sf2 (m.in. HttpFoundation i Console) częściowo upraszczając ich API.

Główną ideą Splot są bardzo proste interfejsy i proste implementacje, a więc prostota w użyciu, jednocześnie dbając o dobre praktyki.

**Aktualna wersja**

W tej chwili Splot narzuca np. własny routing, który wymusza klasy controllerów, które mogą odpowiadać tylko i wyłącznie na jeden URL - czyli tak jak kiedyś robiło się pliki news.php, thread.php, article.php, itd. tak dzisiaj uważam, że jeden URL = jeden plik. Inaczej koszmarem jest przeglądanie controllerów, które odpowiadają na 10 różnych requestów. Jednakże jeden taki controller może mieć różne metody na metody HTTP (tzn. inna metoda dla HTTP GET a inna dla HTTP POST).

Niedawno zaimplementowałem też stand-alone Dependency Injection Container ([github.com/splot/di](https://github.com/splot/di)) z unikalnym featurem pt. „notify”, gdzie w definicji jakiegoś serwisu możemy powiedzieć, że powinien on dać znać o swoim istnieniu innemu serwisowi (np. extension twigowy, który automatycznie do Twiga się wstrzykuje). Taka alternatywa dla tagów i konieczności tworzenia compiler passów w Sf2.

**Plany na przyszłość **

Splot jest w tej chwili w wersji alpha, choć API ma coraz bardziej stabilniejsze. Raczej nie polecałbym jeszcze nikomu, aby stawiał na nim swoje serwisy, ale jak najbardziej zapraszam do zabawy z nim. Krok po kroku wypuszczam kolejne komponenty (przez wypuszczenie rozumiem pełne pokrycie testami i dokumentacja), aż w końcu przyjdzie czas na release samego frameworka. Niestety, dokumentacji do niego jeszcze nie ma, ale przykładową aplikacją, która na nim działa może być Genry ([michaldudek.pl/genry/](https://www.michaldudek.pl/genry/)) - generator stron statycznych z templatek Twig.

W nowym roku mam nadzieję przysiąść do niego porządnie i wypuścić wersję 1.0.

**O projekcie**

Github (źródła): [https://github.com/splot/Framework](https://github.com/splot/Framework)  
**Licencja: MIT**

## MomentPHP

[![MomentPHP](/assets/img/posts/2014/momentphp.jpg)](/assets/img/posts/2014/momentphp.jpg) MomentPHP

*Opis przygotował dla Was Grzegorz Wójcik*

**Historia**

Stworzenie własnego frameworka to naturalny etap w życiu każdego programisty PHP :) To świetna zabawa i okazja by lepiej poznać sam język oraz koncepcje z innych frameworków. Od zawsze byłem wielkim fanem prostoty i możliwości frameworka Slim. Jednak sam Slim to tylko C w triadzie MVC więc pomyślałem, ze miło by było "ubrać" Slim-a w brakujące elementy - tak zrodził się framework MomentPHP.

Właściwie "framework" to zbyt duże słowo - jest to bardziej rusztowanie i specyficzne połączenie kilku komponentów i idei z innych framework-ów. Mamy więc koncepcję paczek (_bundles_), które działają trochę podobnie do _bundles_ z Symfony, mamy kilka komponentów z Laravel-a (komunikacja z bazami danych, cache, konfiguracja), mamy wreszcie wbudowaną obsługę szablonów Smarty i Twig - wszystko to wokół "jądra" systemu, czyli trzeciej wersji Slim-a. Wersji, która sama w sobie oferuje mnóstwo nowości (kontener DI, nowy router, middleware itp.). Jeżeli szukasz lekkiego i intuicyjnego mini-frameworka PHP opartego o komponenty, które już znasz - MomentPHP może być dla Ciebie idealnym wyborem.

**Plany na przyszłość**

MomentPHP ma pozostać wierny filozofii bycia "mini" - czyli zawierać w sobie absolutne minimum potrzebne do budowy prostych API & aplikacji internetowych. Na tą chwilę framework nie posiada domyślnej implementacji mechanizmu obsługi sesji oraz jakiegoś przykładowego modułu do autentykacji - wydaje mi się, ze te dwa elementy są na liście rzeczy "do wdrożenia" w jego kolejnej iteracji.

**O projekcie**

Strona projektu: [https://momentphp.kminek.pl/](https://momentphp.kminek.pl/)  
Dokumentacja: [https://momentphp.kminek.pl/docs](https://momentphp.kminek.pl/docs)  
Github: [https://github.com/momentphp](https://github.com/momentphp)

Mam nadzieję że przedstawiłem Wam parę ciekawych projektów z naszego rodzimego podwórka. Interesujące są również historie każdego z nich. Jak zawsze dziękuję za poświęcony czas i zapraszam do komentowania wpisu. Jeżeli uznasz go za ciekawy to proszę powiedz mi o tym oraz podziel się linkiem z innymi.

Zdjęcie z wpisu: [Flickr](https://www.flickr.com/photos/arselectronica/4950684667) na licencji Creative Commons
