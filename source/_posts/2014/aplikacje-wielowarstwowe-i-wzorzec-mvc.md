---
author: Adam Kawik
comments: true
date: 2014-09-21 12:46:34+00:00
extends: _layouts.post
link: https://itcraftsman.pl/aplikacje-wielowarstwowe-i-wzorzec-mvc/
slug: aplikacje-wielowarstwowe-i-wzorzec-mvc
title: 'ASP: Aplikacje wielowarstwowe i wzorzec MVC'
wordpress_id: 460
categories:
- ASP .NET
- Wzorce
tags:
- Aplikacje webowe
- ASP .NET
- C#
- MVC
- Warstwowość
- Wzorce
---

Wzorzec MVC czyli Model View Controller to chyba jeden z najbardziej popularnych wzorców stosowanych w projektowaniu aplikacji webowych. Znajduje on nie tylko zastosowanie w Microsoftowych frameworkach takich jak ASP .NET MVC ale również możecie go znaleźć w potężnych frameworkach do PHP takich jak Zend, Symphony, Laravel oraz Pythonowym Django czy Ruby on Rails.

<!-- more -->

**Dlaczego MVC ?**

Wpis ten powstał głównie dla tego, że często stosujemy ten wzorzec w praktyce, natomiast czy jesteśmy świadomi jakie są najważniejsze zalety tego wzorca? Co nowego wnosi do naszych projektów? Dlaczego warto go stosować?

Oczywiście słyszy się również o podobnym wzorcu, którym jest MVVM, natomiast znajduje on szerokie zastosowanie głównie w aplikacjach napisanych w WPFie. Oprócz tego coraz bardziej popularny staje się NANCY, który może w przyszłości zastąpi MVC.

**Główne zalety MVC**

Aby tak na prawdę zrozumieć czym jest MVC musimy uruchomić wyobraźnie. Skrót ten zbudowany jest z trzech wyrazów, które stanowią nazwy poszczególnych warstw.

Pierwszy wniosek nasuwa się w sumie sam - MVC jest wzorcem dzielącym naszą aplikację na trzy podstawowe warstwy:

  1. Model ( model )
  2. View ( widok )
  3. Controller ( kontroler )

Każda z tych warstw jest fajnie widoczna w frameworkach z zaimplementowanym MVC, np. w ASP .NET MVC:

[![1](/assets/img/posts/2014/1.png)](/assets/img/posts/2014/1.png)

Każda warstwa znajduję się w osobnym katalogu, który zawierać będzie odpowiednie pliki w zależności od funkcji pełnionej przez poszczególne warstwy. Tak, właśnie funkcji ze względu na to, że każda z tych warstw odpowiedzialna jest za wykonywanie innych zadań :)

Jak możemy zauważyć każdy z tych katalogów zawiera odmienne pliki:

  1. **Katalog Controllers** zawiera różnorodne kontrolery
  2. **Katalog Models** zawierać będzie modele danych
  3. **Katalog Views** zawiera widoki czyli zwyczajne strony .cshtml

**Funkcje poszczególnych warstw**

Skupmy się teraz na funkcjach poszczególnych warstw we wzorcu MVC. Jak pisałem wcześniej wzorzec MVC pozwala rozdzielić strukturę aplikacji na poszczególne warstwy z czego wyróżniamy 3 najważniejsze a każda z tych warstw odpowiada za odmienne funkcje.

  1. **Warstwa Model** (reprezentuje logikę biznesową,  stanowi sposób reprezentacji danych w naszej aplikacji, zawiera klasy, właściwości, pola. może opisywać strukturę bazy danych bądź zawierać pliki XML )
  2. **Warstwa View** ( stanowi warstwę prezentacji dla użytkownika końcowego czyli ostylowane pliki HTML, które widzi ostateczny użytkownik )
  3. **Warstwa Controller** ( jest warstwą odpowiedzialną za przechwytywanie żądań serwera i odpowiednio na nie reaguje, nie zawiera w sobie żadnej logiki biznesowej a wkładanie do niej logiki biznesowej to poważny błąd )

Wszystkie te warstwy współpracują ze sobą ale nie powinny w żaden sposób się ze sobą łączyć. Powinny być modularne i niezależne.

**Czym tak na prawdę jest logika biznesowa?**

Znajomość tego pojęcia jest rzeczą kluczową do zrozumienia czym jest MVC. Pamiętajmy do końca naszego życia, że logika biznesowa zawiera obiekty wykonujące zadane funkcjonalności. Logika biznesowa jest tym samym co model! Może nazwa "Model" nie jest dokładnie trafną nazwą i może być myląca szczególnie dla programistów JAVA.

Podsumowując! Model to cała logika biznesowa wraz z mapowaniem obiektowo relacyjnym. Logika biznesowa płynąca od klienta jest czymś bardzo cennym w procesie projektowania aplikacji. Jest ona nie zmienna. Oznacza to, że w miarę rozwoju projektu i dopisywania nowych funkcjonalności, tworzenia nowych kontrolerów i widoków nasza aplikacja będzie działać nadal tak samo i zachowa swoje pierwotne założenia.

**A jakie żądania może przechwytywać kontroler?**

Tworząc aplikacje webowe mamy styczność z kilkoma żądaniami serwera. Najbardziej popularne i najczęściej stosowane są cztery ale tak na prawdę jest ich więcej:
	
  1. **GET** ( pozwala na wysyłanie danych przy użyciu adresu URL, gdy potrzebujemy uzyskać dostęp do pewnego zasobu - sposób jawny )
  2. **POST** ( wysyła dane w sposób nie jawny bez użycia adresu URL )
  3. **DELETE** ( kasuje dane w bezpieczny sposób )
  4. **UPDATE** ( pozwala na aktualizację danych w aplikacji )

Oczywiście oprócz standardowych żądań możemy wykorzystać również żądania Ajaxa, które pozwalają nam na komunikację z serwerem bez przeładowywania strony. To podejście jest dużo lepsze i wykorzystywane częściej w dużych aplikacjach.

**A w jaki sposób żądanie działa w ASP .NET MVC?**

Tak na prawdę w dużym skrócie żądanie na podstawie adresu URL odnajduje właściwy kontroler i przypisaną do tego kontrolera akcję, bo metodami kontroler są właśnie akcje. Znaleziona akcja zostaje wywołana w odpowiednim kontrolerze. Następnie następuje przejście do Modelu. W rezultacie otrzymujemy dane częściowe, które możemy wykorzystać ( podmienić, zmodyfikować, pobrać ) . Na końcu zwracamy te dane do odpowiedniego widoku czyli wyświetlamy je na odpowiedniej stronie HTML)

[![2](/assets/img/posts/2014/2.png)](/assets/img/posts/2014/2.png)

W tym przykładzie nasz TestController posiada dwie przykładowe akcje: Index i TestAction1, natomiast akcje te nie posiadają jeszcze wygenerowanych widoków.

**Ale jak to do widoku?**

Tak jak każda akcja należy do konkretnego kontrolera tak każda akcja powinna a nawet musi posiadać swój widok. Dlatego do każdej akcji tworzymy widok lub widok częściowy ( zwany partial view ) i do tego widoku coś przekazujemy.

Dlatego aby nasza akcja w ogóle miała sens powinniśmy wygenerować sobie dla niej widok. Klikamy prawym przyciskiem myszy na nazwę akcji i klikamy Add View:

[![3](/assets/img/posts/2014/3.png)](/assets/img/posts/2014/3.png)

Następnie wybieramy nazwę naszego widoku, możemy wybrać sobie szablon z którego nasz widok może zostać wygenerowany. Tak na prawdę ASP .NET może nam pewne rzeczy wygenerować automatycznie, później możemy wskazać na podstawie jakiego modelu i czy widok normalny czy partial view.

[![4](/assets/img/posts/2014/4.png)](/assets/img/posts/2014/4.png)

Klikamy Add i już nasz widok utworzy się w katalogu Views -> Test -> Index

[![5](/assets/img/posts/2014/5.png)](/assets/img/posts/2014/5.png)


W razie gdyby ktoś jeszcze nie wiedział to powiedzmy sobie czym są te widoki częściowe tzw. partial view. Są one wydzieloną częścią widoku, mogącą zostać użyte w każdym miejscu aplikacji.

**Ok. Ale co z ViewModelami?**

Powiedzieliśmy sobie o modelach i widokach ale tak na prawdę MVC podobnie jak MVVM oferuje nam również jedną bardzo ciekawą funkcjonalność. Jest nią tworzenie ViewModeli.

ViewModel to kolejna warstwa aplikacji, która pozwala nam wydzielić potrzebną w danej chwili część modelu do innego, wybranego widoku. Taki proces pozwala na odciążenie modelu bazodanowego. A teraz tak na chłopski rozum.

Czy tworząc jakiś model. np. UserModel zawierający wszystkie dane dotyczące użytkownika, zawsze z wszystkich pól musimy i będziemy korzystać? Czy np. podczas tworzenia procesu rejestracji i logowania nie wystarczą nam tylko 2 pola takie jak login i hasło?

Właśnie tak! Między innymi do tego służą ViewModele. Nie musimy za każdym razem używać wszystkich właściwości danego modelu, tylko wyodrębniamy tylko te, które w danej chwili są nam potrzebne i z nich korzystamy.

W strukturze aplikacji wygląda to mniej więcej tak:

[![6](/assets/img/posts/2014/6.png)](/assets/img/posts/2014/6.png)

Czyli tak na prawdę musimy utworzyć w swojej aplikacji kolejny katalog, który zwie się ViewModel, stanowi on kolejną warstwę i zawiera potrzebne nam ViewModele, które również musimy ponownie zadeklarować.

**Ale wróćmy do tego dlaczego warto dzielić aplikacje na warstwy?**

**Dzielenie aplikacji na warstwy ma wiele zalet** z punktu widzenia programisty:
	
  1. Podział na warstwy powoduje, że są one od siebie nie zależne
  2. Pozwalają na oddzielenie logiki biznesowej od modeli i interfejsu użytkownika
  3. Pozwalają na zachowanie modułowości aplikacji
  4. Modułowość aplikacji pozwala na zmianę technologii bez potrzeby przepisywania całej aplikacji bądź jej dużej części
  5. Pozwala przede wszystkim na lepszą czytelność kodu
  6. Pozwala nam zachować porządek w strukturze aplikacji
  7. Modułowość i wielowarstwowość wpływa pozytywnie na łatwość testowania naszego rozwiązania
  8. Oprócz tego pozwala nam na przenoszalność kodu.


Natomiast jeśli chodzi o **najważniejsze zalety samego wzorca MVC** to:

  1. Przede wszystkim pozwala na organizację naszego kodu
  2. Pozwala na całkowite oddzielenie kodu C# od renderowanych widoków ( umieszczanie logiki w widokach jest błędem )

**Jak powinna wyglądać struktura biznesowej aplikacji?**

Każdy bardziej lub mniej zaawansowany programista potrafi wyobrazić sobie rozmiary dużych aplikacji webowych. Struktura organizacyjna takiej aplikacji powinna zostać zorganizowana w taki sposób aby testowanie jej i dalszy rozwój przebiegał w sposób łatwy.

Prawdziwa biznesowa aplikacja powinna być:
	
  1. Modułowa i rozdzielona na poszczególne DLLki
  2. Każda tabela w bazie danych powinna zawierać swoje oddzielne repozytorium
  3. Każdy komponent powinien być odizolowany oddzielną warstwą abstrakcji
  4. Rozdzielone komponenty powinny być od siebie nie zależne ( ze względu na możliwości błędu przy pracy zespołowej )
  5. Modele w oddzielnym projekcie
  6. Logika biznesowa w oddzielnym projekcie w postaci serwisów, które mogą zostać udostępnione na zewnątrz
  7. Logika całej aplikacji zawarta w projekcie MVC
  8. Powinniśmy wydzielić warstwę odpowiedzialną za komunikację z bazą danych i współpracującą z web serwisami ( zwaną grubym klientem )
  9. Cienki klient nie implementuje żadnej logiki biznesowej tylko wywołuje dane z modeli
  10. Interfejs użytkownika wydzielony w innym projekcie

**Podsumowując**

Każda duża aplikacja biznesowa powinna zostać podzielona na odpowiednie warstwy co nie zawsze jest łatwe. Korzystanie z wzorca MVC może wprowadzić wiele wygody i przejrzystości do naszych projektów, niestety nie zawsze opłaca się przepisywać stare projekty do nowych wzorców i praktycznie mało która firma się tego podejmuje. W czasach obecnych wzorzec MVC jest bardzo popularny co nie oznacza, że pozostanie na tej pozycji na zawsze, w przyszłości głównym wzorce może zostać np. NANCY.
