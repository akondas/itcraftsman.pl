---
author: Adam Kawik
comments: true
date: 2014-08-09 12:33:29+00:00
extends: _layouts.post
link: https://itcraftsman.pl/pierwsze-kroki-z-selenium-web-driver/
slug: pierwsze-kroki-z-selenium-web-driver
title: Pierwsze kroki z Selenium Web Driver
wordpress_id: 167
categories:
- Testy automatyczne
tags:
- Automative
- C#
- Selenium
- Tests
---

Witam w kolejnej edycji kursu dotyczącego testów automatycznych interfejsu użytkownika przy użyciu narzędzia Selenium. Dzisiaj nie będziemy niczego wyklikiwać, tylko zajmiemy się podejściem typowo programistycznym korzystając z .NETowej biblioteki Selenium Web Driver i standardowych Unit Testów dla języka C#. Oczywiście jeśli ktoś woli, może skorzystać z innej biblioteki do testowania takiej jak NUnit lub nawet innego języka, gdyż Selenium wspiera kilka z nich takich jak: Java, PHP, Ruby, Python i JavaScript.

**Przygotowanie środowiska.**

Na samym początku musimy odpowiednie skonfigurować swoje środowisko pracy. W tym tutorialu będziemy korzystać z Visual Studio 2013 i standardowego projektu do Unit Testów wbudowanego w szablony Visuala.

[![1](/assets/img/posts/2014/selenium13.png)](/assets/img/posts/2014/selenium13.png)

Po tej operacji otrzymamy prosty projekt do tworzenia testów jednostkowych z wygenerowaną klasą i metodą przygotowanymi do uruchamiania testów. Dodatkowo przygotujemy sobie prostą strukturę katalogów aby nasz kod był w fajny sposób uporządkowany i przejrzysty. Musimy pamiętać, że liczba testów jest tak na prawdę nieskończona i możemy tworzyć ich dowolnie wiele, tak dużo na ile sięga nasza wyobraźnia i kreatywność. W tych katalogach znajdują się klasy statyczne, które będą zawierać parametry, które będziemy przekazywać do naszych metod oraz metody do konfiguracji Seleniuma czy jakieś dodatkowe metody rozszerzające, które możemy stworzyć sobie na własne potrzeby.

[![2](/assets/img/posts/2014/selenium22.png)](/assets/img/posts/2014/selenium22.png)

Następnie do swojego projektu musimy załączyć odpowiednie biblioteki potrzebne do prawidłowego działania naszego narzędzie. W Visualu od 2010 w górę możemy skorzystać z Nuget Managera, w którym możemy w łatwy i szybki sposób wyszukać dodatek i go zainstalować. Jeśli natomiast ktoś z Was korzysta ze starszej wersji Visual Studio takiej jak 2008 to nasze biblioteki musimy pobrać sobie ręcznie ze strony producenta narzędzia i dołączyć referencję poprzez Add Reference -> Browse. Paczkę dllek możecie pobrać bezpośrednio z tej strony: [https://selenium-release.storage.googleapis.com/2.42/selenium-dotnet-2.42.0.zip](https://selenium-release.storage.googleapis.com/2.42/selenium-dotnet-2.42.0.zip). My natomiast skorzystamy sobie z Nugeta :) Instalujemy wybrane dodatki tak jak na zdjęciu :)

[![3](/assets/img/posts/2014/selenium33.png)](/assets/img/posts/2014/selenium33.png)

Ok od tego momentu wszystkie klasy i metody Seleniuma są dostępne. Natomiast jeśli będziemy chcieli uruchomić nasz nic nie robiący test przy użyciu skrótu klawiszowego CTRL + R,A otrzymamy błąd, że driver nie został odnaleziony, ponieważ nie pobraliśmy go ze strony producenta i nie wskazaliśmy ścieżki do niego.

Aby to zrobić udajemy się znowu na stronę producenta do działu Download i wybieramy interesujący nas serwer. Na potrzeby naszego tutoriala pobierzemy sobie sterownik dla Internet Explorera w wersji 32 bitowej i umieścimy go na naszym dysku, w moim przypadku będzie to E:\drivers\IEDriver.exe. Pobieramy serwer bezpośrednio z tego linku[ https://selenium-release.storage.googleapis.com/2.42/IEDriverServer_Win32_2.42.0.zip](https://selenium-release.storage.googleapis.com/2.42/IEDriverServer_Win32_2.42.0.zip).

Do naszej klasy **SeleniumParameters** dodamy sobie parametr zawierający ścieżkę do naszego drivera, który później przekażemy do metody konfiguracyjnej.

[![4](/assets/img/posts/2014/selenium41.png)](/assets/img/posts/2014/selenium41.png)

Teraz w klasie** SeleniumMethods** stworzymy sobie metodę, która będzie przygotowywać nasz sterownik do pracy przed każdym uruchomieniem testu:

[![5](/assets/img/posts/2014/selenium53.png)](/assets/img/posts/2014/selenium53.png)

Chcemy aby nasza metoda była uruchamiana za każdym razem przed uruchomieniem jakiegokolwiek testu. Dlatego w naszej klasie zawierającej test SeleniumTests.cs musimy zdefiniować metodę z prefiksem **[TestInitialize()]** w której wywołamy naszą metodę ConfigureDriver().

[![6](/assets/img/posts/2014/selenium61.png)](/assets/img/posts/2014/selenium61.png)

Jak widzimy zdefiniowaliśmy sobie zmienną

```cs
private IWebDriver _driver
```

, którą przekazujemy do naszej metodu ConfigureDriver() wraz z innymi parametrami jak rodzaj przeglądarki i ścieżkę dla drivera dla przeglądarki. W ten sposób zainicjalizowaliśmy zmienną _driver, z której będziemy korzystać lokalnie w naszych testach.

Ale czym jest tak na prawdę klasa IWebDriver?

Obiekt klasy IWebDriver to chyba najważniejszy i najczęściej używany obiekt biblioteki Selenium. Pozwala on na przygotowanie drivera do pracy, wybór drivera, otwieranie przeglądarki, nawigowanie do wybranej strony i wiele innych.

Dobrze. Ale skoro możemy wykonywać coś przed wykonaniem testu to może również przydało by się wykonywać coś po wykonaniu testu? jak najbardziej!

Stworzymy sobie teraz metodę z prefiksem** [TestCleanup()]** w której wywołamy metodę Dispose() drivera, która zabije nam wszystkie procesy przeglądarki po wykonaniu testu. Dodatkowo w przypadku testowania bardziej skomplikowanych produktów wykorzystujących bazę danych możemy na przykład kasować śmieci z bazy, dodane wcześniej przez test.

[![7](/assets/img/posts/2014/selenium72.png)](/assets/img/posts/2014/selenium72.png)



To już wszystko jeśli chodzi o podstawową konfigurację. Jeśli wszystko zrobiliście poprawnie to teraz po wciśnięciu CTRL  + R,A powinna wyświetlić się Wam testowa strona w przeglądarce Internet Explorer z odpowiednim komunikatem:

[![8](/assets/img/posts/2014/selenium83.png)](/assets/img/posts/2014/selenium83.png)

**Testowanie w praktyce.**

Po nużącej konfiguracji przejdziemy w końcu do jakichś konkretów. Przed rozpoczęciem testowania przy użyciu Selenium Web Driver musicie dowiedzieć się jeszcze o kilku ważnych rzeczach.

Oprócz klasy IWebDriver najczęściej będziemy wykorzystywać klasę** IWebElement**, która określa dany element na testowanej stronie identyfikowany przez jakiś szczególny ciąg znaków czyli:

 * ID elementu
 * XPath
 * CSS selector
 * Class
 * LinkText
 * Name

Każdy z tych elementów może zostać pobrany poprzez inspekcję danego elementu przy użyciu narzędzia Firebug lub tego standardowego, wbudowanego w przeglądarkę.

[![9](/assets/img/posts/2014/selenium92.png)](/assets/img/posts/2014/selenium92.png)

Musimy pamiętać, że nasze narzędzie nie jest idealne. Czasami nie będzie w stanie w tak oczywisty sposób poradzić sobie np. z wyskakującymi oknami przy użyciu Java Scripta lub dynamicznie generowanymi kontrolkami Telerikowymi.

Nasz obiekt typu IWebElement tworzony jest w taki sam sposób jak IWebDriver

```cs
private IWebElement _element
```

Po utworzeniu obiektu tego typu, uzyskamy dostęp do wielu użytecznych metod, które pozwolą nam na wyszukiwanie danego elementu strony po ID itp, wypełnianie inputów zadanym tekstem, czyszczenie inputów, klikanie w przyciski i wiele innych.

Dodatkowo pomocna może być klasa **Actions**, nie mylić z Action, która zawiera metody odpowiadające za interakcję z eventami klawiatury i myszy, drag and dropa itp. Pamiętajmy o using OpenQA.Selenium.Interactions;

```cs
private Actions _action
```

**Zaczynamy!**

Na samym początku nauczymy nawigować do wybranych przez nas podstron. Powiedzmy, że chcielibyśmy udać się do popularnego sklepu Agito.pl.

Na samym początku stworzymy sobie nowe zmienne o których mówiliśmy wcześniej, i stworzymy sobie metodę, która po podaniu adresu strony WWW będzie nam do niego nawigować.

[![10](/assets/img/posts/2014/selenium102.png)](/assets/img/posts/2014/selenium102.png)

Następnie w klasie SeleniumParameters.cs dodamy sobie parametr zawierający adres strony WWW do której chcemy przejść:

[![11](/assets/img/posts/2014/selenium112.png)](/assets/img/posts/2014/selenium112.png)

Następnie nasza metoda musi zostać wywołana na samym początku naszego testu i musimy przekazać do niej odpowiednie parametry takie jak _driver i adres URL strony.

[![12](/assets/img/posts/2014/selenium121.png)](/assets/img/posts/2014/selenium121.png)

Teraz możemy uruchomić nasz test przy użyciu CTRL + R,A i przekonać się, że nasza przeglądarka otworzy się i przejdzie do strony Agito.pl.

Powiedzmy, że teraz chcielibyśmy wyszukać inputa na stronie agito i wpisać do niego automatycznie jakiś tekst a następnie wcisnąć enter lub przycisk wyszukaj.

Aby to wykonać będziemy potrzebowali ID dwóch elementów ze strony Agito. Tworzymy sobie dwa nowe IWebElementy:

[![13](/assets/img/posts/2014/selenium131.png)](/assets/img/posts/2014/selenium131.png)

Następnie musimy zbadać wybrane przez nas elementy i utworzyć odpowiednie parametry w klasie z parametrami. Zrobiłem już to za was, ale polecam poeksperymentować samemu:)

[![14](/assets/img/posts/2014/selenium14.png)](/assets/img/posts/2014/selenium14.png)

Nasz input field posiadał jawne ID, natomiast przycisk nie, dlatego skorzystamy ze ścieżki XPath.

Teraz wewnątrz testu skorzystamy z metody FindElement() aby spróbować wyszukać nasze elementy:

[![15](/assets/img/posts/2014/selenium15.png)](/assets/img/posts/2014/selenium15.png)

Wyszukaliśmy nasz element przy użyciu ścieżki XPath, którą przekazaliśmy jako parametr do metody **FindElement()**. Następnie na znalezionym elemencie użyliśmy metodę **Clear()**, która ma nam zapewnić, że żaden niechciany znak nie zostanie wprowadzony oprócz naszych ( po prostu całkowicie czyścimy inputa przed wprowadzaniem tekstu). Następnie korzystamy z metody** SendKeys()** w której bezpośrednio przekazujemy stringa, który wpisuje się automatycznie do inputa.

Jeśli chodzi o metodę **SendKeys() **to jest ona bardzo przydatna i oprócz zwykłego tekstu może przyjmować klawisze z naszej klawiatury takie jak strzałki czy Enter. Może się nam to czasem przydać :)

Ok. Następnie chcemy aby wpisany przez nas test został wysłany tak samo jakbyśmy ręcznie szukali czegoś w sklepie. Aby to wykonać musimy zlokalizować przycisk SZUKAJ po XPath i go kliknąć korzystając z metody **Click();**

[![16](/assets/img/posts/2014/selenium161.png)](/assets/img/posts/2014/selenium161.png)

Jeśli wszystko przebiegło dobrze to zostaniemy przekierowani na stronę z wynikami wyszukiwania. Niestety nie wszystko zawsze wygląda tak kolorowo. Czasami będziemy otrzymywali dziwne wyjątki spowodowaną złą konfiguracją naszej przeglądarki lub firewalla.

Mówiliśmy również o combo boxach. Jak sobie z nimi radzić? Również musimy wyszukać ich na podstawie ID lub innego elementu, kliknąć w niego, przy użyciu strzałek wybrać pożądany element i wysłać na końcu ENTER.

[![17](/assets/img/posts/2014/selenium17.png)](/assets/img/posts/2014/selenium17.png)

To jest najprostsza i może najmniej elegancka metoda. Każdy combo box to zwykle lista zawierająca poszczególne poditemy, zawierające jakiś text. My aktualnie przechodzimy od samej góry do trzeciego itemu z combo box, a co gdyby takich itemów było tyle co krajów na świecie czy języków?

Nie ma uniwersalnej metody, która byłaby w stanie temu zaradzić, wszystko zależy od struktury testowanej aplikacji.

Mówiliśmy również o interakcji przy użyciu klasy Actions. Nasza zmienna _action zawiera bardzo ciekawe metody, które możemy wykorzystać w przypadku, gdybyśmy musieli testować drzewka, na których przeciągamy itemy z jednego miejsca na drugie, gdybyśmy musieli coś podnieść i przytrzymać lub po prostu przesunąć o jakąś odległość podawaną w pikselach.

[![18](/assets/img/posts/2014/selenium18.png)](/assets/img/posts/2014/selenium18.png)

Skorzystaliśmy z metody **DragAndDrop()**, która po podaniu ID elementu z którego podnosimy, przenosi ten element na miejsce do którego chcemy go odłożyć.

Podobnie działa metoda, która jako parametry przyjmuje współrzędne na ekranie:

[![19](/assets/img/posts/2014/selenium19.png)](/assets/img/posts/2014/selenium19.png)

Ta metoda może stanowić pewne zagrożenie. Bo co wtedy, gdy położenie naszych elementów zmieni się?

Innymi ciekawymi metodami mogą być metody dotyczące poruszania myszy i przyciskania:

[![20](/assets/img/posts/2014/selenium20.png)](/assets/img/posts/2014/selenium20.png)

Wróćmy jeszcze do IWebDrivera. Zawiera on kilka właściwości, które możemy również wykorzystać w swoich testach. Pierwszą z nich jest pobieranie nazwy aktualnego okna przeglądarki:

[![21](/assets/img/posts/2014/selenium211.png)](/assets/img/posts/2014/selenium211.png)

Inną przydatną właściwością jest sprawdzanie aktualnego adresu URL:

[![22](/assets/img/posts/2014/selenium221.png)](/assets/img/posts/2014/selenium221.png)

Ostatnią bardzo przydatną metodą może być wykonywanie zrzutów ekranu automatycznie, np. w miejscu gdzie test się zfailował lub gdy chcemy udokumentować działanie naszych testów.

[![23](/assets/img/posts/2014/selenium23.png)](/assets/img/posts/2014/selenium23.png)

Myślę, że jak na początek nauki wystarczy :) Polecam Wam wypróbowanie tego narzędzia własnoręcznie.

**Podsumowanie.**

W niniejszym poradniku starałem się wytłumaczyć Wam zasadę działania potężnego narzędzia do automatyzacji testów interfejsu użytkownika. Jednak jak mówiliśmy podstawowe metody mogą nie wystarczyć bądź zastosowanie ich nawet w najprostszych warunkach może sprawiać kłopot. Pamiętajmy, że wykonywanie tego typu testów pozwoli oszczędzić nasz czas w późniejszej pracy, a zaoszczędzony czas będziemy mogli wykorzystać na inne zadania :) Powodzenia :)
