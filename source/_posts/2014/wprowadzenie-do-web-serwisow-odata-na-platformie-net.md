---
author: Adam Kawik
comments: true
date: 2014-11-05 22:24:35+00:00
extends: _layouts.post
link: https://itcraftsman.pl/wprowadzenie-do-web-serwisow-odata-na-platformie-net/
slug: wprowadzenie-do-web-serwisow-odata-na-platformie-net
title: Wprowadzenie do web serwisów ODATA na platformie .NET
wordpress_id: 738
categories:
- ASP .NET
- C#
- Web services
tags:
- .NET
- ASP
- C#
- Code first
- Entity Framework
- json
- OData
- QueryString
- URL
- WebServices
- WebSerwisy
- XML
---

Witajcie! Dzisiaj po dłuższej przerwie zabrałem się do utworzenia nowego wpisu. Zainspirowany nowymi arkanami wiedzy chciałbym przedstawić Wam web serwisy ODATA.
<!-- more -->

**Czym jest serwis ODBC?**

Web serwisy ODATA czyli Open Data Protocol służą do  wykonywania operacji na tabelach i pisanie zapytań po stronie serwera. Są pewną alternatywą dla serwisów SOAP. Wykorzystują technologię Http i JSON.

W pracy z serwisami ODATA wykorzystamy sobie Entity Framework ORM i podejście Code First co bardzo uprości nam sprawę i z zadeklarowanych przez nas modeli wygeneruje bazę danych.

**Tworzenie serwisu ODATA?**

Tak na prawdę praca z web serwisami ODATA jest bardzo przyjemna i tworzenie tego typu serwisu jest bardzo proste i odbywa się w 3 krokach:

  * Tworzenie modelu tabeli
  * Tworzenie Data Contextu dla Code First i Entity Framework
  * Utworzenie Controllera obsługującego żądania

Nie będę Wam dzisiaj rozpisywał się jak to wygląda w teorii. Lepiej zrozumiecie to wszystko w procesie kodowania. Pamiętajmy, że Visual Studio IDE 2013 pozwoli Nam wygenerować sporo kodu automatycznie co znowu skróci naszą pracę.

**Jak to się robi?**

Stworzymy sobie teraz 2 projekty w Visual Studio:

- Pustą aplikację ASP .NET w której będzie znajdował się nasz web serwis ODATA

- Konsolową aplikację kliencką w której będziemy korzystać z naszego web serwisu.

[![1](/assets/img/posts/2014/odata1.png)](/assets/img/posts/2014/odata1.png)

**Web serwis ODATA**

Na samym początku musimy ustalić sobie działanie naszego serwisu. Powiedzmy, że będzie on serwisem zajmującym się sprzedażą samochodów.

Dlatego w naszej pustej aplikacji ASP. NET tworzymy katalog Models i deklarujemy model naszej tabeli Samochod.cs

[![2](/assets/img/posts/2014/odata2.png)](/assets/img/posts/2014/odata2.png)

Nasza klasa reprezentować bedzie obiekt samochod i jego wlaściwości.

```cs
namespace ODATAWebService.Models
{
   public class Samochod
   {
        public int Id { get; set; }
        public string Marka { get; set; }
        public string Model { get; set; }
        public string Kolor { get; set; }
        public decimal Cena { get; set; }
   }
}
```

Nasz model danych będzie służył do wygenerowania tabeli w bazie danych w podejściu Code First. Wszystkie właściwości zawarte w tym modelu stanowią pola naszej tabeli.

Przebudujmy sobie naszą aplikacje klikając Build.

Teraz wygenerujemy sobie nasz web serwis ODATA wraz z Contextem Entity Framework przy użyciu Scaffoldingu. Klikamy ppm na projekt naszej aplikacji web serwisu ODATA i wybieramy zakładkę Add -> New scaffolded item

[![3](/assets/img/posts/2014/odata3.png)](/assets/img/posts/2014/odata3.png)

Zostanie wyświetlone nam okno w którym musimy dokonać wyboru itemu, który chcemy wygenerować przy użyciu Scaffoldingu. Po prawej stronie wybieramy zakładkę Web API a następnie Web API 2 OData Controller with actions using Entity Framework.

[![4](/assets/img/posts/2014/odata4.png)](/assets/img/posts/2014/odata4.png)


W kolejnym oknie po prostu wybieramy poszczególne elementy:

Okienko pierwsze - nasz model - Samochod.cs

Okienko drugie - data context - klikamy plus a on sam nam go wygeneruje

Okienko trzecie - nazwa naszego Controller - SamochodController.cs

[![5](/assets/img/posts/2014/odata5.png)](/assets/img/posts/2014/odata5.png)

Klikając dalej przycisk Add, Visual Studio wygeneruje nam Data Context, zapoewni połączenie z bazą danych przy użyciu Entity Framework ORM oraz wygeneruje nam odpowiednie Controller zawierający metody do obsługi naszego web serwisu.

W aplikacji naszego web serwisu dodane zostały odpowiednie katalogi oraz klasy:

[![6](/assets/img/posts/2014/odata61.png)](/assets/img/posts/2014/odata61.png)


Musimy teraz dokonać odpowiedniej konfiguracji naszego Web serwisu OData. Wejdzmy teraz do naszego Controllera i zobaczmy, że sporo kodu zostało dla Nas wygenerowane. Zwróćmy uwagę na komentarz na samej górze:

[![7](/assets/img/posts/2014/odata7.png)](/assets/img/posts/2014/odata7.png)

Musimy skopiować 3 ostatnie linijki tego komentarza i wkleić je na samym dole metody Register() do folderu AppStart/WebApiConfig.Cs

```cs
namespace ODATAWebService
{
       public static class WebApiConfig
       {
                public static void Register(HttpConfiguration config)
                {
                          config.MapHttpAttributeRoutes();

                          config.Routes.MapHttpRoute(name: "DefaultApi",routeTemplate: "api/{controller}/{id}",
                          defaults: new { id = RouteParameter.Optional }
                );

                 // tutaj wklejamy kod z Controllera
                 // pozwala on zarejestrowac nasz model
                 var builder = new ODataConventionModelBuilder();
                 builder.EntitySet<Samochod>("Samochods");
                 config.Routes.MapODataRoute("odata", "odata", builder.GetEdmModel());
        }
}
```

Następnie po zarejestrowaniu naszego modelu w naszym web serwisie będziemy chcieli utworzyć przykładowe dane do testów naszego web serwisu. Do tego będzie nam potrzebna klasa ContextInitializer oraz metoda Seed().

Utwórzmy sobie teraz klasę dla initializera naszej bazy danych. Tworzymy go w katalogu Models obok naszego Modelu i klasy DbContext

[![8](/assets/img/posts/2014/odata8.png)](/assets/img/posts/2014/odata8.png)

Następnie musimy wyrzeźbić tę klasę. Klasa initilizera naszej bazy danych zwykle musi dziedziczyć po 2 klasach

  * DropCreateDatabaseAlways<NazwaContextu>
  * DropCreateDatabaseIfModelChanges<NazwaContextu>

Pierwszy z nich zmusza naszą aplikacje do kasowania bazy danych za każdym uruchomieniem aplikacji. Natomiast drugi z nich każe kasować naszą bazę tylko w przypadku gdy zmieni się model. My na potrzeby edukacyjne wykorzystamy to pierwsze podejście :)

```cs
 public class SamochodContextInitializer : DropCreateDatabaseIfModelChanges<SamochodDbContext>
 {

 }
```

Następnie w naszym Initializerze utworzymy sobie metodę Seed() odpowiedzialną za wypełnienie naszej tabeli w bazie danych obiektami i wartościami tych obiektów.

```cs
 public class SamochodContextInitializer : DropCreateDatabaseAlways<SamochodDbContext>
 {
         protected override void Seed(SamochodDbContext context)
        {

         };
 }
```

Następnie musimy utworzyć kilka samochodów i zapisać je do naszej tabeli w bazie danych.

```cs
 public class SamochodContextInitializer : DropCreateDatabaseAlways<SamochodDbContext>
 {
       protected override void Seed(SamochodDbContext context)
       {
        var samochody = new List<Samochod>
        {
             new Samochod()
             {
                  Marka = "Mercedes", Model = "S3", Kolor = "Srebrny", Cena = 154.000m
             },
             new Samochod()
             {
                  Marka = "BMW", Model = "X4", Kolor = "Czarny", Cena = 124.000m
             },
             new Samochod()
             {
                 Marka = "Volksvagen", Model = "Golf 4", Kolor = "Niebieski", Cena = 24.000m
             }
      };

      foreach (var sam in samochody)
      {
          context.Samochods.Add(sam);
      }

       base.Seed(context);
      }
 }
```

Jeśli ktoś nie wie o co chodzi tu już wyjaśniam. Na samym początku w metodzie Seed() generujemy sobie 3 obiekty samochodów i wypełniamy ich wartości.

Następnie w pętli foreach dodajemy kolejne obiekty do naszej tabeli Samochods.

Ostatecznie base.Seed(context) powoduje wykonanie naszego initializera. Natomiast to jeszcze nie zadziała, ponieważ my musimy wskazać naszej aplikacji, że stworzyliśmy initializer dla naszej bazy danych i zadeklarować go w konstruktorze naszego DbContextu.

```cs

 public SamochodDbContext() : base("name=SamochodDbContext")
 {
       Database.SetInitializer(new SamochodContextInitializer());
 }
```

Teraz nasza aplikacja będzie wiedzieć, że ma wykorzystać naszego initilizera za każdym uruchomieniem naszej aplikacji i dodać do wygenerowanej tabeli w bazie danych obiekty, które sobie stworzyliśmy.

To już wszystko jeśli chodzi o konfiguracje naszego web serwisu OData. Teraz uruchommy go i zobaczmy co z tego wyszło :)

Po uruchomieniu aplikacji naszego Web Serwisu otrzymamy oczywiście **błąd HTTP 403 Forbidden **

[![9](/assets/img/posts/2014/odata9.png)](/assets/img/posts/2014/odata9.png)

Dzieje się tak, ponieważ my sami musimy wskazać ręcznie ścieżkę do naszego web serwisu OData w adresie URL :)

```
https://localhost:29295/odata
```

Po modyfikacji adresu URL będziemy mogli zobaczyć zawartość naszego serwisu:

[![10](/assets/img/posts/2014/odata10.png)](/assets/img/posts/2014/odata10.png)


Możemy wyświetlić sobie również meta dane naszego web serwisu wpisując $metadata do adresu URL

```
https://localhost:29295/odata/$metadata
```

Otrzymamy coś takiego:

[![11](/assets/img/posts/2014/odata111.png)](/assets/img/posts/2014/odata111.png)

Poprzez adres URL możemy teraz wyświetlać odpowiednie obiekty zadeklarowane w naszej bazie danych oraz filtrować je według naszych upodobań.

Dlatego wpiszmy teraz do naszego adresu nazwę naszej kolekcji obiektów zawartych w bazie:

```
https://localhost:29295/odata/Samochods
```

Otrzymamy bardzo ładnie wylistowaną listę obiektów wraz z wartościami właściwości :)

[![12](/assets/img/posts/2014/odata12.png)](/assets/img/posts/2014/odata12.png)

Jak możemy łatwo zauważyć każdy z naszych samochodów posiada odpowiednie Id tak samo jak każdy rekord w tabeli bazy danych. Id również inkrementuje się automatycznie.

Poprzez adres URL możemy również wyświetlić sobie samochód np. o Id = 2

```
https://localhost:29295/odata/Samochods(2)
```

Wylistowany zostanie tylko ten konkretny samochód o Id = 2

[![13](/assets/img/posts/2014/odata13.png)](/assets/img/posts/2014/odata13.png)

Ale to nie wszystko :) Możemy wyświetlić sobie np. wszystkie tylko same marki naszych samochodów

```
https://localhost:29295/odata/Samochods?$select=Marka
```

Wygląda to tak:

[![14](/assets/img/posts/2014/odata14.png)](/assets/img/posts/2014/odata14.png)

Tego typu operacji jest bardzo wiele. Ale dlaczego tak się dzieje? Wejdźmy teraz do naszego Controllera. Znajdują się tam różnego rodzaju akcje i metody kontrolera wygenerowane na potrzeby naszego serwisu oraz tabeli w bazie danych.
	
  * Metoda **public IQueryable<Samochod> GetSamochods()** pozwalająca na wyświetlenie wszystkich samochodów.
  *  **public SingleResult<Samochod> GetSamochod([FromODataUri] int key)** pozwalajaco na zwrócenie pojedynczego samochodu o wprowadzonym z adresu URL Id
  *  **public IHttpActionResult Put([FromODataUri] int key, Samochod samochod)** pozwalająca na wykonanie aktualizacji stanu naszego obiektu w bazie danych
  *  **public IHttpActionResult Post(Samochod samochod)** pozwala na dodanie nowego samochodu do naszej bazy danych poprzez POSTa
  * **public IHttpActionResult Patch([FromODataUri] int key, Delta<Samochod> patch)** pozwalająca na wyszukanie odpowiedniego samochodu
  * ** public IHttpActionResult Delete([FromODataUri] int key)** która pozwala nam na usuniecie wybranego samochodu z naszej bazy danych
  * **protected override void Dispose(bool disposing)** która czyści nam wszystkie nieużywane obiekty po zakończeniu działania aplikacji
  * **private bool SamochodExists(int key)** to metoda standardowa pozwalająca na sprawdzenie czy samochód o podanym id istnieje

To już wszystko jeśli chodzi o sam web serwis OData. Teraz postarajmy się go jakoś wykorzystać i tak na prawdę zrozumieć jak on działa. Zajmijmy się teraz naszą aplikacją kliencką.

**Kodowanie aplikacji klienckiej.**

Na samym początku musimy dodać referencję do naszego web serwisu w naszej aplikacji klienckiej. Aby to zrobić uruchommy nasz web serwis jako nowa instancja. Zaznacz nasz projekt serwisu i wcisnij CTRL + F5

[![15](/assets/img/posts/2014/odata15.png)](/assets/img/posts/2014/odata15.png)

Następnie skopiujmy adres URL naszego web serwisu ( nie zatrzymujmy uruchomienia!). Ustawmy naszą aplikację kliencką jako aplikacje startową. W naszej aplikacji klienckiej kliknijmy na References -> Add Service Reference

[![16](/assets/img/posts/2014/odata16.png)](/assets/img/posts/2014/odata16.png)

W oknie które się Nam pojawiło wklej adres URL naszego web serwisu i dopisz do niego /odata

```
https://localhost:29295/odata
```

A następnie naciskamy przycisk GO. Jeśli nasz web serwis jest nadal uruchomiony to zostanie on odnaleziony i będziemy mogli dodać go jako referencje do naszej aplikacji klienckiej.

[![18](/assets/img/posts/2014/odata18.png)](/assets/img/posts/2014/odata18.png)

Na samym dole wpisujemy nazwę referencji do naszego web serwisu którą później będziemy wykorzystywać w kodzie naszej aplikacji klienckiej. Potwierdzamy przyciskiem OK.

Jeśli referencja dodała się prawidłowo to pojawi się ona w projekcie naszej aplikacji klienckiej

[![19](/assets/img/posts/2014/odata19.png)](/assets/img/posts/2014/odata19.png)

Teraz w końcu po mozolnej konfiguracji zabierzmy się za kodowanie aplikacji klienckiej a właściwie wykorzystanie metod i danych zawartych w naszym web serwisie.

Na samym początku w metodzie Main() musimy zainicjować kontener naszego web serwisu i przekazać do niego adres URL do naszego web serwisu OData.

```cs
class Program
{
    static void Main(string[] args)
    {
        var container = new Container(new Uri("https://localhost:29295/odata"));
    }
}
```

Następnie będziemy chcieli podglądać nazwy requestów które są wysyłane do naszego web serwisu. Dlatego musimy dodać SendingRequest2()

```cs
class Program
{
     static void Main(string[] args)
     {
          var container = new Container(new Uri("https://localhost:29295/odata"));
          container.SendingRequest2 += (s, e) => Console.WriteLine("{0} {1}", e.RequestMessage.Method, e.RequestMessage.Url);
     }
}
```

Ok. Konfiguracja aplikacji klienckiej jest praktycznie skończona. Mamy już połączenie z naszym web serwisem. Teraz zadeklarujmy kilka metod z których będziemy chcieli skorzystać używając naszego web serwisu OData.

Pierwsza metoda odpowiedzialna będzie za wyświetlanie konkretnego samochodu wraz z wszystkimi wartościami jego properties

```cs
 private static void WyswietlSamochod(Samochod sam)
 {
      Console.WriteLine("{0} {1} {2} {3}", sam.Id, sam.Marka, sam.Model, sam.Cena);
 }
```

Kolejna metoda odpowiedzialna będzie za wyświetlanie wszystkich samochodów znajdujących się w bazie danych naszego web serwisu.

```cs
 private static void WyswietlWszystkieSamochody(SamochodyServiceReference.Container container)
 {
       foreach (var p in container.Samochods)
       {
          WyswietlSamochod(p);
       }
 }
```

Przyjrzyjmy się co tak na prawdę powyższa metoda przyjmuje. A no przyjmuje container naszego web serwisu. I tyle. Nie trzeba kombinować.

Dodajmy jeszcze kolejne metody. Powiedzmy, że chcemy wyświetlić teraz tylko markę i cenę wszystkich samochodów:

```cs
  static void WyswietlMarkeICeneSamochodow(SamochodyServiceReference.Container container)
  {
     foreach (var p in container.Samochods.Select((r => new { r.Marka, r.Cena })))
     {
         Console.WriteLine("{0} {1}", p.Marka, p.Cena);
     }
   }
```

Oprócz tego możemy wyświetlić sobie samochód o zadanym Id

```cs
 static void WyswietlSamochodOPodanymId(SamochodyServiceReference.Container container, int id)
 {
       var q = container.Samochods.Where(n => n.Id == id);

       foreach (var prod in q)
       {
           WyswietlSamochod(prod);
       }
 }
```

Jak widzimy każda z metod zawiera w których chcemy dokonać filtrowania naszych samochodów zawartych w bazie danych naszego web serwisu zawiera LINQowe zapytania, która pozwalają na prostą manipulację obiektami.

Teraz wykorzystajmy sobie te metody i sprawdźmy jak zadziała nasz web serwis. Metody wykorzystujące nasz web serwis oczywiście zostaną zadeklarowane w głównej metodzie Main() na samym dole:

```cs
 static void Main(string[] args)
 {
      var container = new Container(new Uri("https://localhost:29295/odata"));
      container.SendingRequest2 += (s, e) => Console.WriteLine("{0} {1}", e.RequestMessage.Method, e.RequestMessage.Url);

      Console.WriteLine("Wyswietl wszystkie samochody");
      WyswietlWszystkieSamochody(container);
      Console.WriteLine(Environment.NewLine);

      Console.WriteLine("Wyswietl marke i cene samochodow");
      WyswietlMarkeICeneSamochodow(container);
      Console.WriteLine(Environment.NewLine);

      Console.WriteLine("Wyswietl samochod o wybranym Id");
      WyswietlSamochodOPodanymId(container, 2);
      Console.WriteLine(Environment.NewLine);

      Console.ReadKey();
 }
```

Uruchommy teraz naszą aplikację kliencką, która wyśle request do naszego web serwisu i po chwili wyświetli nam wyniki naszych zapytań o obiekty znajdujące się po stronie web serwisu.

[![20](/assets/img/posts/2014/odata20.png)](/assets/img/posts/2014/odata20.png)

Oprócz danych, które zostały dla Nas zwrócone bo o nie prosiliśmy, możemy podglądnąć sobie jakie parametry zostały wpisane do naszego query stringa aby te dane zwrócić. Nie musimy tego robić ręcznie :)

**A co gdybyśmy chcieli dodać jakiś nowy samochód do samochodów istniejących?**

To nic trudnego :)** Znowu musimy udać się na sam dół metody Main() i wywołać metodę naszego kontenera AddNewSamochods(). Nazwa trochę nie fortunna ale taka nam sie wygenerowała :)**

```cs
 container.AddToSamochods(
    new Samochod()
    {
       Marka = "Audi",
       Model = "A6",
       Kolor = "Czerwony",
       Cena = 243.000m
    }
 );
 container.SaveChanges();

 Console.WriteLine("Wyswietl wszystkie samochody");
 WyswietlWszystkieSamochody(container);
 Console.WriteLine(Environment.NewLine);
```

Uruchamiamy nasz serwis ponownie i sprawdzamy czy nowy samochód został dodany do bazy danych naszych samochodów.

[![21](/assets/img/posts/2014/odata21.png)](/assets/img/posts/2014/odata21.png)

Jak widzimy powiodło się :) To już wszystko co chciałem Wam dzisiaj pokazać. Jak zwykle zachęcam do samodzielnego eksperymentowania. Temat jest bardzo ciekawy.
