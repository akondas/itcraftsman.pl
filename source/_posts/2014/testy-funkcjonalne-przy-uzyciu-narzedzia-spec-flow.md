---
author: Adam Kawik
comments: true
date: 2014-08-11 20:22:39+00:00
extends: _layouts.post
link: http://itcraftsman.pl/testy-funkcjonalne-przy-uzyciu-narzedzia-spec-flow/
slug: testy-funkcjonalne-przy-uzyciu-narzedzia-spec-flow
title: Testy funkcjonalne przy użyciu narzędzia Spec Flow
wordpress_id: 223
categories:
- Testy funkcjonalne
tags:
- C#
- Functional tests
- SpecFlow
- Tests
---

Witamy ponownie w dalszej przygodzie dotyczącej testowania aplikacji różnego typu :) Dzisiaj nie będziemy mówić już o testach automatycznych, zajmiemy się testami funkcjonalnymi przy użyciu narzędzia Spec Flow :)

**Czym są testy funkcjonalne ?**

**Test funkcjonalny** jest to specyficzny rodzaj testu, który nie musi być wykonywany przez osobę, znającą strukturę i budowę testowanego produktu, bardzo często przeprowadzane są przez osoby nie znające się kompletnie na programowaniu. Są również znane pod nazwą testów czarnej skrzynki ( black box testing ). Nasze testy nie są w żaden sposób związane z budową naszego programu, a wszelkie założenia opierane są na rzekomych funkcjonalnościach jakie powinien posiadać testowany przez nas program.

Pisanie tego rodzaju testów pozwala w bardzo skuteczny sposób dokonać weryfikacji czy dana funkcjonalność została spełniona i czy działa dobrze, natomiast test ten nie dostarcza nam w żaden sposób żadnych informacji dotyczących przyczyn tych błędów.

**Jak działa Spec Flow?**

Spec flow jest kultowym narzędziem przystosowanym do pisania testów funkcjonalnych dla BDD ( Behavioral Driven Development ) czyli tworzenie testów kierowane zachowaniem ( trudno to jakoś fajnie spolszczyć ).

Opiera się on właściwie na dwóch plikach:
	
 1. Plik z rozszerzeniem .feature
 2. Plik z rozszerzeniem .cs

Pierwszy z nich - **plik tekstowy zawierający cechy**, które krok po kroku muszą zostać spisane i przetestowane. Zbudowany jest z poszczególnych linii w języku Gherklina. Może zawierać parametry, które umieszczamy w pojedynczych cudzysłowach ' '.  Plik feature może zawierać wiele scenariusz, de facto tyle samo ile testów chcemy przeprowadzić. Przed każdą linią znajdują się odpowiednie słowa kluczowe charakterystyczne dla języka Gherklina.

Przykładowy plik feature scenario:

[![1](/assets/img/posts/2014/spec110.png)](/assets/img/posts/2014/spec110.png)

Drugi plik zawiera poszczególne kroki testu, zgodne ze stworzonym wcześniej scenariuszem. Zawiera on metody testowe z odpowiednim prefiksem GIVEN, WHEN, THEN, parametrami i assercją. W Visualu 2013 możemy w fajny sposób wygenerować sobie automatycznie taki test na podstawie napisanego przez nas scenariusza przy użyciu dwóch kliknięć myszy. Ale za chwile wytłumaczymy sobie to krok po kroku ;)

Przykładowa klasa zawierająca test:

[![2](/assets/img/posts/2014/spec24.png)](/assets/img/posts/2014/spec24.png)

Po wygenerowaniu metod testowych na podstawie stworzonego przez Nas scenariusza uruchamiamy nasze testy w ten sposób co zwykle wciskając kombinację klawiszy CTRL + R,A.

Spec flow posiada bardzo skuteczne i przejrzyste komunikaty błędów. Jeśli o czymś zapomnieliśmy, bądź coś napisaliśmy w zły sposób, bardzo szybko Nas upomni, wskaże metodę zawierającą błąd i pozwoli szybko ją poprawić.

**A więc od czego zacząć?**

Standardowo utworzymy sobie Unit test project przy użyciu Visual Studio 2013. Pamiętajmy, że w starszych wersjach wizualna takich jak 2008 nie mamy możliwości dogrywania dodatków z nugeta a wszelkie zewnętrzne biblioteki będziemy musieli dodać ręcznie.

[![3](/assets/img/posts/2014/spec34.png)](/assets/img/posts/2014/spec34.png)

Teraz zamknijmy nasz projekt i przejdźmy do strony [http://visualstudiogallery.msdn.microsoft.com/90ac3587-7466-4155-b591-2cd4cc4401bc](http://visualstudiogallery.msdn.microsoft.com/90ac3587-7466-4155-b591-2cd4cc4401bc) aby pobrać dodatek dla naszego Visuala, gdyż zapewne jeśli pierwszy raz spotkaliście się z tego rodzaju technologią, wasze IDE nie będzie domyślnie wyposażone w wymagane przez Spec Flow pliki. Pobieramy i instalujemy.

Następnie do swojego projektu musimy dograć sobie odpowednie dodatki, korzystając z nuget managera. Pobieramy te, przy których znajduje się zielona fajka na zdjęciu :)

[![4](/assets/img/posts/2014/spec42.png)](/assets/img/posts/2014/spec42.png)

Ok. Jeśli wszystko zainstalowaliśmy to pora przygotować sobie strukturę katalogów. W naszym projekcie dodamy sobie **katalog Tests** do którego dodamy sobie nowy feature file. Możemy zrobić to na kilka sposobów natomiast najłatwiej kliknąć prawym przyciskiem myszy na ten katalog, kliknąć add -> new item a następnie odnaleźć **Spec Flow Feature File**.

[![5](/assets/img/posts/2014/spec54.png)](/assets/img/posts/2014/spec54.png)

Dobra. Do naszego katalogu Tests dodał się plik feature file z szablonowo wygenerowaną zawartością. Możemy sobie ją śmiało modyfikować, kopiować i na jej podstawie generować testy funkcjonalne.

Powiedzmy, że tym razem dla przykładu napiszemy scenariusz testu sprawdzający powodzenie lub nie powodzenia zakupów w sklepie internetowym. Poprzedni scenariusz zawierał tylko sam tekst, który nic nie wnosił do naszego testu, tym razem wprowadzimy sobie parametry testowe i numeryczne :)

[![6](/assets/img/posts/2014/spec62.png)](/assets/img/posts/2014/spec62.png)

Jak można zauważyć, każdy parametr w pliku scenariusza znajduje się pomiędzy znakami ' '. Dodatkowo mamy w sumie 3 bloki GIVEN ( bo AND pełni funkcję givena bo znajduje się za givenem ). Nasze parametry będą przekazywane do metody testowej tak samo jak do każdej zwykłej funkcji.

Zauważmy, że nasz plik feature zawiera dodatkowo w sobie plik .cs, który zawiera automatycznie wygenerowany kod C#. ( Ale nie jest to jeszcze kod samego testu ). Nie musimy tam zaglądać.

[![7](/assets/img/posts/2014/spec73.png)](/assets/img/posts/2014/spec73.png)

Ok. Jeśli utworzyliśmy sobie już scenariusz to teraz pora aby wygenerować sobie odpowiednie metody testowe przy użyciu magicznych dwóch kliknięć myszy :) Aby to zrobić, klikamy na wyraz Scenario ppm a następnie **Generate Step Definitions**.

[![8](/assets/img/posts/2014/spec84.png)](/assets/img/posts/2014/spec84.png)

Po kliknięciu tego przycisku, otrzymamy okno **Step Definition Skeletor Spec Flow**, w którym widnieją poszczególne kroki scenariusza, niczego nie musimy zmieniać, klikamy GENERATE i zapisujemy naszą klasę gdzieś w projekcie.

[![9](/assets/img/posts/2014/spec93.png)](/assets/img/posts/2014/spec93.png)

Po zapisaniu naszej klasy testowej, wszystkie linie w plik scenariusza zmienią swój wygląd, a parametry zostaną wyróżnione.

![10](/assets/img/posts/2014/spec103.png)

Teraz przejdźmy do pliku zawierającej metody testowe. Nosi on taką samą nazwę jak nasz Feature: WplataPieniedzyDoSklepuInternetowegoSteps.cs

```cs
using System;
using Microsoft.VisualStudio.TestTools.UnitTesting;
using TechTalk.SpecFlow;

namespace SpecFlowTutorial
{
     [Binding]
     public class WplataPieniedzyDoSklepuInternetowegoSteps
     {
           private int kwotaDoZaplaty = 0;
           private int kosztWysylki = 0;

           [Given(@"Wybieram '(.*)' do zakupu")]
           public void GivenWybieramDoZakupu(string product)
           {
                  if (product == null)
                      throw new ArgumentNullException("product");

                  product = "Samsung Galaxy S3";
                  Assert.AreSame("Samsung Galaxy S3", product);
           }

           [Given(@"Dokonuję wpłaty na konto kwotę '(.*)' złotych")]
           public void GivenDokonujeWplatyNaKontoKwoteZlotych(int kwota)
           {
                  kwota = 890;
                  kwotaDoZaplaty = kwota;
                  Assert.AreEqual(kwota, kwotaDoZaplaty);
           }

           [Given(@"Oraz pokrywam koszty przesyłki w wysokości '(.*)' złotych")]
           public void GivenOrazPokrywamKosztyPrzesylkiWWysokosciZlotych(int koszt)
           {
                  koszt = 12;
                  kosztWysylki = koszt;
                  Assert.AreEqual(koszt, kosztWysylki);
           }

           [When(@"Gdy wciśnę przycisk zapłać")]
           public void WhenGdyWcisnePrzyciskZaplac()
           {
                  const bool buttonPressed = true;
                  Assert.IsTrue(buttonPressed);
           }

           [Then(@"Sprzedający powinien otrzymać wpłatę w wysokości '(.*)' złotych")]
           public void ThenSprzedajacyPowinienOtrzymacWplateWWysokosciZlotych(int suma)
           {
                  Assert.AreEqual(suma, kosztWysylki+ kwotaDoZaplaty);
           }
     }
}
```

Wygenerowaliśmy sobie automatycznie metody testowe na podstawie naszego scenariusza i dopisaliśmy odpowiednie asercje sprawdzające czy podany parametr wczytany ze scenariusza jest zgodny z wartością oczekiwaną. Jeśli, któraś z asercji zwróci false to otrzymamy błąd i test nie przejdzie. Testy w scenariusz wykonują się krok po kroku. Żaden z bloków nie może zostać ominięty ani przeskoczony. Pamiętajmy o tym!

Taki dziwny znaczek** '(.*)'** znajdujący się nad metodą testową oznacza miejsce, w które wkładamy nasz parametr. Parametryzacja metod jest bardzo użyteczna w przypadku, gdy musimy powtarzać wiele bloków np. GIVEN. Warto o tym pamiętać aby je sparametryzować i nie pisać nadmiarowego kodu.

Mówiąc o parametryzacji mamy na myśli fakt, że gdy w scenariuszu GIVEN: Ide do Pana Mietka, zapłacić mu '30' złotych, to ta liczba 30 zostanie przekazana w miejsce parametru metody testowej: TestPanaMietka(int kwota).

Oprócz tego każdy pojedynczy blok może zostać sparametryzowany oraz może posiadać on dowolną ilość parametrów, właściwie tyle ile ich potrzebujemy, nie ma żadnych ograniczeń.

Ostatnim krokiem, który pozostał nam do wykonania jest finalne uruchomienie testu :) Jak widać u mnie się powiódł. Jestem ciekawe jak Wam pójdzie :)

[![11](/assets/img/posts/2014/spec113.png)](/assets/img/posts/2014/spec113.png)


W taki sam sposób dopisujemy kolejne testy. To narzędzie jest bardzo intuicyjne i nie wymaga dużej znajomości programowania aby coś fajnego sobie potestować :) Miłej zabawy :)
