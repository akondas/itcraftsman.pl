---
author: Adam Kawik
comments: true
date: 2014-10-08 21:51:41+00:00
extends: _layouts.post
link: http://itcraftsman.pl/c-wprowadzenie-do-web-serwisow-asmx/
slug: c-wprowadzenie-do-web-serwisow-asmx
title: 'C#: Wprowadzenie do web serwisów ASMX'
wordpress_id: 620
categories:
- ASP .NET
- C#
- Web services
tags:
- ASMX
- ASP .NET
- Autoryzacja
- C#
- SOAP
- Web services
---

W dzisiejszym wpisie postaram się na chłopski rozum w sposób "nie naukowy" wyjaśnić w jaki sposób działają web serwisy i do czego tak na prawdę mogą Nam się przydać.

<!-- more -->

**Czym tak na prawdę jest Web Serwis?**

Jest to specyficzny rodzaj usługi sieciowej egzystujący niezależnie na serwerze zewnętrznym, z którego korzysta oddzielna aplikacja kliencka bądź grupa takich aplikacji.Aplikacja komunikuje sie z web serwisem, korzysta z jego metod, web serwis przetwarza dane otrzymane od aplikacji klienta i zwraca odpowiedź.

**Web serwis a zwykła biblioteka .dll?**

Mimo, że web serwis jest bardzo podobny do biblioteki .dll, gdyż zawiera on i udostępnia klasy i metody tak samo jak zewnętrzna biblioteka. Natomiast różnica jest kluczowa - bibliotek .dll działa lokalnie a web serwis dostępny jest zdalnie dla każdej aplikacji.

**Jaka jest idea web serwisów?**

Pierwotną ideą web serwisów było zastosowanie ich w systemach rozproszonych. Miały one być tworzone w dowolnej technologii i dostępne bez względu na środowisko.

Podczas tworzenia web serwisów skupiono się na architekturze RPC, która umożliwiała udostępnianie zdalnego wywoływanie procedur wcześniej zaprojektowanego web serwisu. Implementują one pewny mechanizm komunikacji, polegający na przesyłaniu pewnego komunikatu.

**Jaka jest architektura web serwisu?**

Oczywiście trudno omówić to szczegółowo w krótkim artykule. Postaram się wyjaśnić kilka najważniejszych cech budowy web serwisu, które mogą przydać nam się później.

Składa się on z:
	
  1. **Dostawcy** ( providera ) i **klienta** ( consumera )
  2. Oprócz tego bardzo często zawiera **service brokera**, który umożliwia wyszukanie i zindeksowanie web serwisu. (  UDDI )
  3. **UDDI** zawiera informacje o dostawcy i ewentualnych kosztach danego web serwisu.

**Sposoby komunikacji z web serwisem?**

Zwykle mamy do wyboru kilka metod komunikacji:
	
  1. Przy użyciu protokołu SOAP
  2. UDDI tylko przy użyciu SOAP
  3. Poprzez żądania GET i POST dla normalnego serwisu webowego

**Web serwis a XML?**

Język XML jest istotnym składnikiem podczas pracy z web serwisami. Jest on istotny i wymagana do kodowania przesyłanych obiektów pomiędzy web serwisem a aplikacją kliencką.

**Czym jest XSD?**

XSD z angielskiego XML Schema Definition, jest dokumentem tekstowym służącym do definiowania obiektów stworzonych przy użyciu języka XML w innym dokumencie.

Pomaga opisywać struktury poszczególnych dokumentów. Pomaga dokonywać walidacji elementów zawartych w dokumencie. Mając dostęp do pliku XSD jesteśmy w stanie wygenerować sobie klasę w C#.

**Serializacja i metody serializacji XMLa?**

Serializacja to mechanizm umieszczania obiektów do strumienia. W technologii .NET posiadamy kilka metod serializacjii elementów XML:

  1. XmlRootAtribute
  2. XmlElementAttribute
  3. XmlAttributeAttribute
  4. XmlArrayAttribute
  5. XmlArrayItemAttribute

Metody te mogą zostać w łatwy sposób wykorzystane w naszych projektach i pomogą nam przerobić nasze obiekty stworzone przy użyciu języka C# na XMLa.

Pamiętajmy, że nie serializuje się wszystkiego. Serializujemy tylko pola i właściwości publiczne i tylko do odczytu bądź zapisu, ze względu na idee enkapsulacji.

Podczas serializacji zapisywane są do strumienia całe obiekty wraz z ich ewentualnymi powiązaniami.

W przypadku web serwisów wszystkie kolekcje jednowymiarowe zapisywane są do strumienia wejściowego w tym samym formacie bez względu na rodzaj zwracanego obiektu.

Sprawa nieco komplikuje się, jeśli mamy do czynienia z obiektami klas pochodnych, ponieważ na poziomie komunikacji nie jesteśmy w stanie określić czy dana klasa w danej chwili dziedziczy od innej klasy lub nie.

**Protokół SOAP**

Pomaga zakodować przesyłane obiekty w postaci XMLa. Posiada on informacje jaka metoda ma zostać wywołana na web serwisie, który z parametrów przyjmowanych w tej metodzie jest odpowiednim obiektem, czy przesyłamy nasze obiekty przez wartość czy przez referencje.

Pomaga nam zdefiniować pewien mechanizm rutingu. przez który będzie podążał nasz komunikat do i z web serwisu. Musimy pamiętać, że web serwis to często nie tylko jeden serwer a może przechodzić przez wiele węzłów.

Wspomaga mechanizm kodowania referencji do obiektu, czyli umożliwia nam przesłanie samego adresu do obiektu a nie od razu całego obiektu. Jest to tylko imitacja przesyłania.

Najczęściej korzysta z żądania POST.

**Z czego składa się protokół SOAP?**

Zawiera w sobie kilka elementów:
	
  1. SOAP Envelope ( czyli kopertę )
  2. SOAP Header (nagłówki; najczęściej do autoryzacji )
  3. SOAP Body ( zawartość z informacjami o wywołaniu procedur )
  4. SOAP Fault ( z opisem kodu błędu )

**Mechanizm wywoływania metody na web serwisie**

Na początku musimy przygotować odpowiednie żądanie typu POST. Następnie musimy połączyć się z hostem. Kolejno ustawiamy odpowiednie nagłówki. Na końcu przygotowujemy cały dokument XML kodowany przy użyciu protokołu SOAP.

**Czym jest WSDL?**

Jest standardem opisywania web serwisów. Zawiera w środku plik XSD. Na podstawie WSDL generowana jest klasa Proxy, która umożliwai nam tworzenie lokalnych obiektów web serwisu, idealnie go odzwierciedlających. Na podstawie obiektu klasy PROXY, wywoływana zostaje metoda a następnie składana zostaje do requesta a my otrzymamy wynik w postaci gotowego obiektu. W językach z grupy .NET WSDL generowany jest automatycznie.

**Jak zbudowany jest WSDL?**
	
  1. Sekcja z typami zdefiniowanymi na web serwisie.
    * Zawiera definicje w postacie fragmentów pliku XSD opisujące nasze klasy. Określa również strukturę przesyłanych i odbieranych komunikatów.
  2. Definicja komunikatu
    * Określa jakie komunikaty będą pracowały na web serwisie. Oprócz tego pozwala określić czy dany komunikat jest komunikatem wejściowym czy wyjściowym.
  3. Element interfejsu
    * Definiuje informacje o udostępnianych metodach. Określa, który komunikat w danej chwili znajduje się na wejściu lub na wyjściu.
  4. Element wiążący
    * Określa na którą metodę będziemy aktualnie wchodzić
  5. Element serwisu

**W jaki sposób definiujemy web serwis?**
	
  1. Wewnątrz naszego web serwisu definiujemy publiczną klasę **dziedziczącą po klasie WebService**.
  2. Klasa ta zawiera metody publiczne udostępniane na zewnątrz poprzez web serwis.
  3. Metody te muszą zostać opatrzone parametrem **[WebMethood]**


**Dostępne przełączniku dla atrybutu [WebMethood]**

Posiada on kilka bardzo istotnych przełączników sterujących sposobem udostępniania poszczególnych metod z naszego web serwisu. Najpopularniejsze i najczęściej używane to:
	
  1. (BufferRespone=false)
    * Określa czy odpowiedź ma zostać buforowana i zbierana od klienta czy nie.
  2. (CacheDuration=60)
    * Odpowiada za cachowanie odpowiedzi na konkretne żądanie z konkretnym zestawem parametrów przez okres 60 sekund.
  3. (Description="Some description")
    * Odpowiada za dodatkowy opis metody naszego web serwisu. Zapisywane w dokumencie WSDL. Stanowi pewną dokumentację dla klienta.
  4. (EnableSession=true)
    * Odpowiada za włączenie mechanizmu sesji. Zmusza nas to do przesyłania identyfikatora sesji co nie zawsze jest bezpieczne.
  5. (MessageName="MethoodName")
    * Web serwisu nie posiadają mechanizmu nadpisywania metod, dlatego ten przełącznik stanowi pewien alias do metod, które chcemy ponownie zdefiniować pod inną nazwą, w przypadku gdy została ona źle zdefiniowana.


Ok. Może wystarczy tej bardzo istotnej teorii jako wprowadzenie. Na pewno przyda Nam się ona podczas tworzenia naszego pierwszego web serwisu ASMXowego. Oczywiście pamiętajmy, że mamy do czynienia również z serwisem WCF. Ale o tym porozmawiamy kiedy indziej.

**Praktyczne zastosowanie.**

Stworzymy sobie teraz bardzo prostą aplikację składającą się z aplikacji klienckiej i web serwisu. Aplikacja serwera będzie pustą aplikacją ASP .NET, natomiast aplikacja kliencka będzie zwyczajną aplikacją konsolową.

[![1](/assets/img/posts/2014/asmx.png)](/assets/img/posts/2014/asmx.png)

Następnie ustawimy sobie w configu naszej solucji aby jednocześnie uruchamiały Nam się dwa projekty na raz. Musimy pamiętać, że nasz web serwis uruchamiany jest lokalnie dlatego aby nasza aplikacja kliencka mogła uzyskać do niego dostęp musi on być zawsze aktywny.


[![2](/assets/img/posts/2014/21.png)](/assets/img/posts/2014/21.png)

Wybieramy opcję Multiple startup projects. Przy obu projektach w akcji wybieramy START, a aplikacje klienta przesuwamy na górę. Kolejność ma znaczenie ponieważ aplikacja na samej górze będzie miała większy priorytet.

Przygotowaliśmy sobie środowisko pracy w naszej solucji. Teraz dodamy sobie z klasę naszego Web Serwisu. Klikamy ppm. na projekt ASMX -> Add new item i z dostępnych szablonów wybieramy WebService (ASMX), nadajemy mu nazwę MathService.asmx

[![3](/assets/img/posts/2014/asmx3.png)](/assets/img/posts/2014/asmx3.png)

Visual Studio stworzył dla nas automatycznie klasę dla web serwisu ASMX wraz z wygenerowanym ciałem. Uprzątnijmy niepotrzebne komentarze.

[![4](/assets/img/posts/2014/asmx4.png)](/assets/img/posts/2014/asmx4.png)

Zwróćmy uwagę na namespace naszego web serwisu. Korzysta on z domeny tempuri.org. Po uruchomieniu takiego web serwisu zostaniemy poproszeni o zmianę nazwy przestrzeni nazw czyli tak naprawdę adresu na którym nasze web serwis będzie uruchamiany.

My zmienimy nazwę z tempuri.org na itcraftsman.pl.

[![5](/assets/img/posts/2014/asmx5.png)](/assets/img/posts/2014/asmx5.png)

Teraz możemy śmiało uruchomić sobie nasz web serwis :) Naszym oczom ukarze się bardzo prosta strona, zawierająca w nagłówku nazwę naszego web serwisu oraz dostępne dla niego metody. Oczywiście posiada on na razie tylko metodę HelloWorld().

[![6](/assets/img/posts/2014/asmx6.png)](/assets/img/posts/2014/asmx6.png)

Zobaczmy, co kryje się wewnątrz metody HelloWorld(). Wejdźmy sobie do niej :)

Szybko możemy zauważyć, że zawiera ona dużo ciekawych informacji na temat budowy tej metody webowej. Zawiera podstawowe informacje dotyczące przykładowych żądań poprzez SOAP

[![7](/assets/img/posts/2014/asmx7.png)](/assets/img/posts/2014/asmx7.png)

Jak również poprzez protokół HTTP POST

[![8](/assets/img/posts/2014/asmx8.png)](/assets/img/posts/2014/asmx8.png)



Informacje te są głównie przydatne w przypadku, gdy chcemy wykorzystać web serwis znajdujący się na zewnętrznym serwerze. My jednak nie mamy w tej chwili takiej możliwości i skorzystamy z web serwisu stworzonego lokalnie w naszej solucji.

Aby to zrobić musimy znowu kliknąć ppm. na referencje projektu aplikacji klienckiej i wybrać opcję Add Service Reference.

[![9](/assets/img/posts/2014/asmx91.png)](/assets/img/posts/2014/asmx91.png)



Następnie w oknie, które nam się pojawiło klikamy przycisk Advanced

[![10](/assets/img/posts/2014/asmx10.png)](/assets/img/posts/2014/asmx10.png)

Z kolejnego, trochę większego okna również na samym dole wybieramy przycisk Add Web Reference

[![11](/assets/img/posts/2014/asmx11.png)](/assets/img/posts/2014/asmx11.png)

Zwróćmy uwagę na ostatnie okno. Zawiera ono kilka bardzo ważnych opcji. Pozwala ono na dokonanie wyboru z jakiego web serwisu chcemy z danej chwili skorzystać.

[![12](/assets/img/posts/2014/asmx12.png)](/assets/img/posts/2014/asmx12.png)

Jeśli chcielibyśmy podłączyć się do cudzego web serwisu, znajdującego się gdzieś w sieci to wystarczyło by skopiować adres URL i wkleić go do kolumny URL na górze a następnie kliknąć małą strzałkę po prawej stronie aby serwis został załadowany.

My jednak chcemy tym razem korzystać z web serwisu znajdującego się w naszej solucji dlatego wybierzemy sobie opcję:

[![13](/assets/img/posts/2014/asmx13.png)](/assets/img/posts/2014/asmx13.png)

Następnie wszystkie web serwisy z naszej solucji zostaną wczytane. My nie mamy ich zbyt wiele bo aż jeden.

[![14](/assets/img/posts/2014/asmx14.png)](/assets/img/posts/2014/asmx14.png)

Klikamy w nazwę naszego WebSerwisu i dalej kreator załaduje wszystkie dostępne metody z naszego web serwisu.

[![15](/assets/img/posts/2014/asmx15.png)](/assets/img/posts/2014/asmx15.png)

Potwierdzamy przyciskiem Add Reference i kończymy pracę kreatora. Jak widzimy Visual Studio pozwala Nam wszystko wyklikać sobie automatycznie i skonfigurować według naszego uznania.

Jeśli cała konfiguracja przebiegła bez błędu to w aplikacji klienckiej powinny stworzyć się dwa nowe katalogi:

[![16](/assets/img/posts/2014/asmx161.png)](/assets/img/posts/2014/asmx161.png)



Plik localhost stanowi nasze połączenie z naszym web serwisem. Dzięki niemu będziemy mogli aktualizować nasz web serwis po każdej wprowadzonej zmianie ponieważ niestety nie dzieje się to automatycznie.

Konfiguracja naszego Web Serwisa jest już praktycznie gotowa. Teraz zajmijmy się definiowaniem metod w nich zawartych. Załóżmy sobie, że chcemy aby nasze web serwis zawiera metodę matematyczną pozwalającą mnożyć macierz poszarpaną przez liczbę. Natomiast aby było trochę trudniej wprowadzimy sobie tutaj mechanizm autoryzacji poprzez nagłówek SOAP.

[![17](/assets/img/posts/2014/asmx171.png)](/assets/img/posts/2014/asmx171.png)



Jak widzimy operujemy na macierzach nie do końca wielowymiarowych ze względu na to, że nie mogą one zostać tak w prost przesłane. Jeśli spróbujemy przekazać taką macierz do metody web serwisu, zwróci nam błąd.

Dodaliśmy metodę do naszego Web Serwisu. Teraz musimy zaktualizować zmiany w aplikacji klienckiej. Aby to zrobić muismy uruchomić nasz web serwis klikając na projekt ASMX i wciskając CTRL+ F5. Aplikacja uruchomi się. W razie http error należy podać w URL nazwę naszego web serwisa.

Następnie w aplikacji klienckiej klikamy ppm. na localhost i wybieramy opcję Update Web Reference

[![18](/assets/img/posts/2014/asmx18.png)](/assets/img/posts/2014/asmx18.png)

Jeśli wszystko przebiegło bez błędu to zmiany zostaną wprowadzone. Natomiast jeśli nie uruchomilibyśmy naszego web serwisu to otrzymalibyśmy błąd

[![22](/assets/img/posts/2014/asmx22.png)](/assets/img/posts/2014/asmx22.png)

Teraz zajmiemy się oprogramowanie aplikacji klienta. Do metody naszego web serwisu chcemy przekazać macierz double[][] oraz mnożnik. Macierz te zadeklarujemy sobie na sztywno.

```cs
var macierz = new double[][] {new []{2.2, 3.4}, new []{5.4, 6.7}};
int mnożna = 2;
```
Następnie aby skorzystać z metod naszego web serwisu musimy stworzyć w aplikacji klienckiej obiekt typu naszego web serwisu. Do klasy Program.cs dopisujemy:

```cs
var macierz = new double[][] {new []{2.2, 3.4}, new []{5.4, 6.7}};
int mnożna = 2;

var ws = new MathService();
```


Kolejno korzystając z obiektu ws wywołujemy metodę naszego web serwisu i przekazujemy do niego parametry. Przypisujemy to wszystko do zmiennej var wynik.

```cs
var macierz = new double[][] {new []{2.2, 3.4}, new []{5.4, 6.7}};
int mnożna = 2;

var ws = new MathService();
var wynik = ws.MacierzRazyLiczba(macierz, mnożna);
```

Następnie wyświetlimy sobie wszystko aby sprawdzić czy ta magia na prawdę działa :)

```cs
var macierz = new double[][] {new []{2.2, 3.4}, new []{5.4, 6.7}};
int mnożna = 2;

var ws = new MathService();
var wynik = ws.MacierzRazyLiczba(macierz, mnożna);

wynik.SelectMany(x => x.ToList()).ToList().ForEach(Console.WriteLine);
Console.ReadLine();
```

Na wyjściu otrzymamy wartości macierzy pomnożone przez liczbę. W naszym przypadku przez 2.

[![23](/assets/img/posts/2014/asmx23.png)](/assets/img/posts/2014/asmx23.png)

Następnie pozostało wprowadzić do naszej prostej aplikacji element autoryzacji nagłówka SOAP. Będziemy przekazywać w nim dwa pola: username i password. Następnie będziemy sprawdzać czy podane wartości przez klienta są równe tym w web serwisie. Jeśli tak to metoda się wykona, jeśli nie to zwróci tablicę pustą.

Aby to zrobić, wróćmy do naszego web serwisu. Musimy dodać sobie klasę, zawierającą pola do autoryzacji. Klasa ta musi dziedziczyć po klasie SoapHeader.

```cs
 public class UserAuth : SoapHeader
 {
 public string UserName { get; set; }
 public string Password { get; set; }
 }
```

Następnie w naszym web serwisie musimy stworzyć sobie właściwość typu obiektu naszej klasy z polami do autoryzacji.

```cs
public UserAuth UserAuth { get; set; }
```

Następnie nad metodą, którą chcemy autoryzować, musimy dodać nagłówek [SoapHeader("NazwaObjKlasyAutoryzowanej")]

```cs
 public class MathService : WebService
 {
 public UserAuth UserAuth { get; set; }

 [WebMethod(Description = ("Mnozenie macierzy razy liczba"))]
 [SoapHeader("UserAuth")]
 public double[][] MacierzRazyLiczba(double[][] macierz, int mnoznik)
 {
 for (var i = 0; i < 2; i++)
 {
 for (var j = 0; j < 2; j++)
 {
 macierz[i][j] *= mnoznik;
 }
 }
 return macierz;
 }
 }
```

Pamiętajmy, że nazwa naszego obiektu musi być taka sama jak nazwa nagłówka SOAP. Teraz musimy w jakiś sposób sprawdzić czy podana nazwa użytkownika i hasło została wprowadzona poprawnie. Do tego celu stworzymy sobie dodatkową metodę sprawdzającą. Jeśli dane sa poprawne zwraca true. Jeśli nie zwraca false.

```cs
 private static bool AuthorizeUser(UserAuth usr)
 {
    if (usr.UserName == "Odyn" && usr.Password == "itcraftsman")
    {
       return true;
    }
       return false;
    }
```

Dodatkowo dokonujemy modyfikacji metody z mnożeniem macierzy.

```cs
 [WebMethod(Description = ("Mnozenie macierzy razy liczba"))]
 [SoapHeader("UserAuth")]
 public double[][] MacierzRazyLiczba(double[][] macierz, int mnoznik)
 {
 if (AuthorizeUser(UserAuth) == true)
 {
 for (var i = 0; i < 2; i++)
 {
 for (var j = 0; j < 2; j++)
 {
 macierz[i][j] *= mnoznik;
 }
 }
 return macierz;
 }
 return new[] {new[] {0.00, 0.00}, new[] {0.00, 0.00}};

 }
```

Teraz wróćmy kolejny raz do aplikacji klienckiej. Musimy znowu skorzystać z naszej zmiennej ws i przekazać dane autoryzacji do naszego web serwisu.

```cs
 ws.UserAuthValue = new UserAuth() { UserName = "Odyn", Password = "itcraftsman" };
```

Jeśli nie widzimy tego pola to musimy ponownie uruchomić serwis i go zaktualizować. To już wszystko :) Jeśli dane autoryzacji są poprawne to metoda zostanie wykonana, jeśli nie poprawne to zwracamy macierz z samymi zerami :) Miłego eksperymentowania z własnymi serwisami ;)
