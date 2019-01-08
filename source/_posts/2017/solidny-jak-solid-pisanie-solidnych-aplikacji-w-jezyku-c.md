---
author: Adam Kawik
comments: true
date: 2017-10-13 21:41:01+00:00
extends: _layouts.post
link: http://itcraftsman.pl/solidny-jak-solid-pisanie-solidnych-aplikacji-w-jezyku-c/
slug: solidny-jak-solid-pisanie-solidnych-aplikacji-w-jezyku-c
title: SOLIDny jak SOLID. Zastosowanie dobrych praktyk podczas tworzenia aplikacji w C#
wordpress_id: 1779
categories:
- C#
- Wzorce
tags:
- .NET
- C#
- programowanie
- SOLID
- wzorce projektowe
---

Wszyscy chcemy aby nasze aplikacje jak i ich architektura była jak najwyższej jakości. Powinniśmy się starać aby kod, który tworzymy nie zamienił się w kod spaghetti, kod kruchy, kod, który będzie sprawiał problemy wtedy gdy będziemy chcieli go zmodyfikować lub po prostu konserwować. Z pomocą przychodzi nam SOLID, o którym warto wiedzieć i go rozumieć.

<!-- more -->

# Czym jest SOLID?

**SOLID** jest zbiorem dobrych praktyk architektonicznych w programowaniu obiektowym, pomagającym sprawić aby nasz kod był bardziej zrozumiały, elastyczny i łatwiejszy w zarządzaniu. Metodologia została wymyślona dawno temu i poparta przez twórców czystego kodu takich jak Robert C. Martin. Po raz pierwszy został zaproponowany przez Michael Feathers. Jest lepszym sposobem myślenia i patrzenia na sposób projektowania aplikacji zorientowanych obiektowo.

# Pięć podstawowych zasad

**SOLID** jest akronimem w którym zawarte zostały najważniejsze i najpotrzebniejsze zasady, którymi każdy dobry programista powinien się kierować. Szczerze mówiąc nie wszystkie zasady zawsze mogą być spełnione w stu procentach, a sam SOLID jest wskazówkami dla programistów, a nie receptą na perfekcyjne życie. Poszczególne litery znaczą kolejno:

**S** jak **SRP (Single Responsibility Principle)**, która oznacza, że nasza klasa czy metoda powinna posiadać tylko jedną odpowiedzialność. Nie powinien istnieć więcej niż jeden powód abyśmy chcieli zmodyfikować naszą klasę.

**O** jak **OCP (Open Close Principle)**, która mówi nam, że nasze klasy powinny być zamknięte na modyfikacje a otwarte na rozszerzenia. Nie powinniśmy dotykać istniejącego kodu, który pracuje w środowisku produkcyjnym co może być przyczyną błędu. Powinniśmy móć dokonać zmian poprzez rozszerzenie kodu a nie jego modyfikację.

**L **jak** LSP (Liskov Substitution Principle)** co oznacza w uproszczeniu, że klasa dziedzicząca powinna rozszerzać klasę bazową bez wpływu na jej aktualne działanie.

**I** jak **ISP (Interface Segregation Principle) **czyli inaczej mówiąc jest to zasada segregacji interfejsów. Oznacza ona, że wiele różnych interfejsów jest lepsze niż jeden duży i zbyt rozbudowany interfejs. Każdy interfejs powinien być tworzony w taki sposób aby zawierał jak najmniejszą ilość metod, czyli metody, które w danej chwili są niezbędne. Nie powinien zawierać metod nadmiarowych a wszystkie inne metody, jeśli nie są związane z konkretnym interfejsem, powinny znaleźć się w odrębnych interfejsach.

**D** jak **DIP (Dependency Inversion Principle)** czyli zasada odwracania zależności. Mówi nam, że moduły wysokiego poziomu nie powinny zależeć od modułów poziomu niskiego a wszystkie powinny być zależne od warstwy abstrakcji. Inaczej mówiąc nie powinniśmy operować bezpośrednio na instancjach naszych klas, zmiennych, obiektów czy metod a na ich interfejsach, które są ich warstwami abstrakcji i pozwalają na rozbudowę i dokonywanie zmian.


# Dlaczego SOLID?

W miarę rozwoju jak i rozbudowy naszej aplikacji, która rozrasta się w wielu kierunkach, powstają również bugi, które gromadzą się w naszym programie. Każda dodatkowa modyfikacja jak i próba naprawy aplikacji staje się coraz bardziej uporczywa i wolna. SOLID jest zbiorem dobrych praktyk, które pomogą nam budować aplikacje w taki sposób aby tych problemów uniknąć.


# **S jak Single Responsibility Principle**

Jest jedną z najprostszych zasad SOLID. Mówi nam, że każda klasa powinna być tworzona w taki sposób aby odpowiadała za jedno zadanie do którego została przeznaczona. Nie możemy tworzyć fabryki, która produkuje samochody i jednocześnie szyje buty. Nie powinniśmy tworzyć klas w których nasza logika jest pokręcona i przeplata się pomiędzy wieloma odpowiedzialnościami.

Konkretna klasa powinna być odpowiedzialna za jedną pracę. Klasa Produkt powinna zawierać tylko i wyłącznie metody związane z tworzeniem i zarządzaniem produktem. Nie powinna zawierać na przykład metod związanych z logowaniem błędów, tworzeniem statystyk itp.

Zwróćmy uwagę na poniższy przykład:

```cs
public class Product
{
    public int ID { get; set; }
    public string Name { get; set; }
    public uint Quantity { get; set; }
    public decimal Price { get; set; }
    public IList<Product> Products { get; set; }
    
    public Product()
    {
        Products = new List<Product>();
    }

    public void AddProduct(Product _prod)
    {
        Products.Add(_prod);
    }

    public void RemoveProduct(Product _prod)
    {
        Products.Remove(_prod);
    }

    public Product FindProductByID(int _prodID)
    {
        return Products.Where(n => n.ID == _prodID).Single();
    }

    public void CreateErrorLog(string path, string exeption)
    {
        File.WriteAllText(path, exeption);
    }
}
```


Nasza klasa `Produkt` implementuje naturalne metody związane z operacjami na produkcie takie jak `AddProduct`, `RemoveProduct` czy `FindProductByID`. Oprócz tego możemy znaleźć w niej metode `CreateErrorLog`, która nie koniecznie jest bezpośrednio związana z samym produktem a jest raczej ogólną metodą, którą możemy zastosować do wszystkiego, do Produktu, naszego Customera, do Kategorii. Możemy logować błędy we wszystkich innych klasach i nie koniecznie musi być ona w klasie Produkt.

Dlatego sama metoda związana z logowaniem błędów powinna znaleźć się w odrębnej klasie, która za to odpowiada aby spełniona była zasada pojedynczej odpowiedzialności.

Powinno to wyglądać tak:

**Klasa Produkt.cs:**

```cs
public class Product
{
    public int ID { get; set; }
    public string Name { get; set; }
    public uint Quantity { get; set; }
    public decimal Price { get; set; }
    public IList<Product> Products { get; set; }
    public Product()
    {
        Products = new List<Product>();
    }

    // Dodaj nowy produkt
    public void AddProduct(Product _prod)
    {
        Products.Add(_prod);
    }

    // Usun produkt
    public void RemoveProduct(Product _prod)
    {
        Products.Remove(_prod);
    }

    // Znajdz produkt po jego ID
    public Product FindProductByID(int _prodID)
    {
        return Products.Where(n => n.ID == _prodID).Single();
    }
}
```


**Klasa ErrorLogger.cs:**

```cs
public class ErrorLogger
{
    public int ID { get; set; }
    public string PathToLogFile { get; set; }
    public string ExceptionMessage { get; set; }

    // Zapisz informacje do error loga
    public void WriteToErrorLog(string path, string exeption)
    {
        File.WriteAllText(path, exeption);
    }
}
```


W tym momencie będziemy mogli w dowolnym miejscu naszego programu odwołać się do klasy `ErrorLog` lub `Product` w sposób niezależny. Każda z klas posiada swoją własną i odrębną odpowiedzialność. Warto o tym pamiętać jak będziemy tworzyć nasze aplikacje. Ta zasada jest najprostsza do wprowadzenia w swoich programach i najbardziej uniwersalna.


# **O jak Open Close Principle**

Zasada, która mówi nam, że nasza klasa powinna być zamknięta na modyfikacje a otwarta na rozszerzenia. Każdy z Was na pewno doskonale wie i w pewien sposób intuicyjnie rozumie, że każda, nawet najmniejsza modyfikacja istniejącego kodu programu, który pracuje na produkcji może pociągnąć za sobą serie niefortunnych zdarzeń na skutek powstałych błędów, Dlatego nie dotykamy istniejącego kodu a raczej tworzymy nasze klasy w taki sposób aby były otwarte na rozszerzenia, które nie mają wpływu na aktualne zachowanie naszego programu. Powinniśmy tworzyć kod, który nie będzie musiał się zmieniać za każdym razem gdy zmienią się nasze wymagania biznesowe.

**Rzućmy okiem na poszczególny kod:**

```cs
public class BankAccount
{
    public virtual decimal getAccountFee(decimal amountFee, decimal percentage)
    {
        return amountFee * percentage;
    }
}

public class SpecialBankAccount : BankAccount
{
    public override decimal getAccountFee(decimal amountFee, decimal percentage)
    {
        return amountFee * percentage;
    }
}

public class VIPBankAccount : SpecialBankAccount
{
    public override decimal getAccountFee(decimal amountFee, decimal percentage)
    {
        return amountFee * percentage;
    }
}
```

Mamy bazową klasę `BankAccount`, która jest reprezentacją konta bankowego w banku. Posiada ona metodę `getAccountFee()`, która nalicza opłaty za utrzymanie konta. Jest metodą, która zostanie użyta dla różnych kont bankowych takich jak `SpecialBankAccount` czy `VIPBankAccount`. W tym momencie klasy te dziedziczą wszystko od siebie dlatego logika zawarta w metodzie `getAccountFee()` została wielokrotnie powtórzona. Co również wiąże się z koniecznością modyfikacji ich w wielu miejscach.

Powinniśmy starać się unikać powtórzeń naszego kodu, nie powinniśmy duplikować tych samych metod dla klas dla których na przykład opłaty za konto będą identyczne. W zamian trzeba skorzystać z kompozycji interfejsów. Zobaczcie sami:

Tworzymy oddzielny interfejs `IAccountFess`, który będzie zawierał pojedynczą deklaracje naszej metody:

```cs
public interface IAccountFees
{
    decimal getAccountFee(decimal amountFee, decimal percentage);
}
```

Następnie nasze klasy będą implementować nasz interfejs jak i jego metodę:

```cs
public class BankAccount
{
    public readonly IAccountFees _accountFees;
    public readonly string _accountType;

    public BankAccount(string accountType, IAccountFees accountFees)
    {
        _accountType = accountType;
        _accountFees = accountFees;
    }

    public decimal getAccountFee(decimal amountFee, decimal percentage)
    {
        return _accountFees.getAccountFee(amountFee, percentage);
    }
}

public class SpecialBankAccount : IAccountFees
{
    public readonly decimal _specialAccountFee;

    public SpecialBankAccount(decimal specialAccountFee)
    {
        _specialAccountFee = specialAccountFee;
    }

    public decimal getAccountFee(decimal amountFee, decimal percentage)
    {
        return _specialAccountFee*amountFee * percentage;
    }
}

public class VIPBankAccount : IAccountFees
{
    public readonly decimal _vipAccountFee;

    public VIPBankAccount(decimal vipAccountFee)
    {
        _vipAccountFee = vipAccountFee;
    }

    public decimal getAccountFee(decimal amountFee, decimal percentage)
    {
        return _vipAccountFee*amountFee * percentage;
    }
}
```

Oczywiście nie musi to być interfejs, może to być również klasa abstrakcyjna, jeśli takowa będzie lepiej dopasowana do kontekstu zagadnienia. Generalnie dopisaliśmy drobne rozszerzenie do istniejące funkcjonalności naszego programu i skorzystaliśmy z tej samej metody, jednakże dla każdego innego konta bankowego, opłaty mogą być inne (lub ciało metody może być również inne). Generalnie udało nam się na przykładzie zamknąć nasz program na modyfikacje a otworzyć na rozszerzenia.

Zobaczmy również na inny przykład. Mamy klasę dom `House` oraz klasę która będzie obliczać nam powierzchnie domu `SurfaceCalculator`, która będzie zawierać metodę do obliczania powierzchni w zależności czy dom jest prostokątny, kwadratowy czy inny:

```cs
public class House
{
    public double Width { get; set; }
    public double Height { get; set; }
    public string Type { get; set; }
}

public class SurfaceCalculator
{
    public double CalculateSurface(House house)
    {
        if (house.Type == "SquareHouse")
        {
            return Math.Pow(house.Width, 2);
        }
        else if (house.Type == "RectangularHouse")
        {
            return (2*house.Height + 2*house.Width);
        }
        else
        {
            return (house.Height * house.Width);
        }
        
    }
}
```


Nasza klasa bazowa `House` posiada trzy właściwości takie jak wysokość, szerokość i typ domu. Klasa `CalculateSurface` posiada metodę do obliczania powierzchni dla poszczególnych typów domów. Okej, wszystko fajnie, spełniliśmy wymagania Pana Mietka.

W tej chwili Pan Mietek będzie szczęśliwy, a co stanie się gdy przyjdzie za miesiąc i powie, że jego firma sprzedaje również domy okrągłe i trójkątne i prosi nas o dokonanie modyfikacji naszego programu w taki sposób, aby umożliwić mu obliczanie powierzchni również dla domów okrągłych jak i trójkątnych. Zmiana wydaje się prosta, jednakże w przypadku rzeczywistych programów, gdy kod jest bardzo skomplikowany i rozbudowany, ta zmiana nie koniecznie musi być prosta, szybka i bezpieczna.

**Dlatego aby spełnić idee zasady Open Close Principle powinniśmy oprogramować to w taki sposób:**

Tworzymy sobie bazową klasę abstrakcyjną lub interfejs `Facility` (nieruchomość):

```cs
public abstract class Facility
{
    public abstract double CalculateSurface();
}
```

Następnie rozszerzamy wszystkie dowolne typy domów o to rozszerzenie:

```cs
public class RectangularHouse : Facility
{
    public double Width { get; set; }
    public double Height { get; set; }

    public override double CalculateSurface()
    {
        return (2 * Height + 2 * Width);
    }
}

public class SquareHouse : Facility
{
    public double Width { get; set; }

    public override double CalculateSurface()
    {
        return Math.Pow(Width, 2);
    }
}

public class TriangleHouse : Facility
{
    public double Width { get; set; }
    public double Height { get; set; }

    public override double CalculateSurface()
    {
        return (1 / 2 * Width * Height);
    }
}

public class CircleHouse : Facility
{
    public double Radius { get; set; }

    public override double CalculateSurface()
    {
        return (Math.PI * Math.Pow(Radius, 2));
    }
}
```

Zwróćcie uwagę, że teraz Pan Mietek będzie zadowolony. Nie ma znaczenia ile dodatkowych typów domów jeszcze wprowadzi do swojej oferty. Czy to będą domy w kształcie trapezów, gwiazd, pentagramów, równoległoboków, fraktali czy innych fikuśnych kształtów geometrycznych. Totalnie nas to nie interesuje. Jeśli zmieni się logika biznesowa jak i dojdą nam nowe wymagania klienta to w takiej formie zadeklarujemy sobie tylko klasę dla nowego typu domu i będziemy rozszerzać ją o klasę bazową. Reszty istniejących domów w ogóle nie będziemy nawet dotykać co pozwoli na uniknięcie błędów.


# **L jak Liskov Substitution Principle**

Zasada opracowana przez Barbarę Liskov wydaje się troszkę skomplikowana, jednakże w prostych słowach mówi ona nam o tym, że każda funkcja w naszym programie powinna działać w sposób przewidywalny, bez względu na to czy jako parametr przekażemy jej klasę bazową lub klasę dziedziczącą.

Generalnie mówiąc klasa `Audi` nie koniecznie powinna dziedziczyć po klasie `Mercedes` a raczej powinny dziedziczyć po klasie `Car`, która jest bardziej ogólna i intuicyjna dla tego typu obiektów. Dlaczego?

Wyobraźmy sobie, że nasze spalanie `Audi` obliczane jest na podstawie prędkości i odległości w taki sam sposób jak `Mercedes`, jednak silnik `Mercedes` jest inny.

Zobaczmy na antyprzykład:

```cs
abstract class Vehicle
{
    public string Name { get; set; }
    public abstract void Drive();
}

class Taxi : Vehicle
{
    public override void Drive()
    {
        Console.WriteLine("Dog runs");
    }
}

class AirPlain : Vehicle
{
    public override void Drive()
    {
        throw new NotImplementedException();
    }
}
```

Zauważmy, że nasza klasa bazowa `Vehicle` posiada metodę `Drive()`. Naszą klasę bazową dziedziczy klasa `Taxi` jak również klasa `AirPlain` razem z metodą `Drive()`. Jednak samolot nie może przecież jeździć, jest raczej maszyną latającą. Dlatego w tym przypadku jest to złamanie zasady Liskov i nie możemy wykonać tego dziedziczenia w poprawny sposób. Nasz samolot nie będzie jeździł po ulicach, a raczej będzie latał. Nasze dziedziczenie musimy zaplanować w taki sposób, aby klasa pochodna mogła wykorzystać wszystkie metody klasy bazowej, które implementuje.

Zobaczmy na lepszy przykład:

```cs
class Weapon
{
    public string Name { get; set; }
    public virtual void Shoot()
    {
        Console.WriteLine("Use Your weapon to shoot or hit");
    }
}

class Sword : Weapon
{
    public override void Shoot()
    {
        base.Shoot();
        Console.WriteLine("Hit hit!");
    }
}

class Bow : Weapon
{
    public override void Shoot()
    {
        base.Shoot();
        Console.WriteLine("Fire aim!");
    }
}
```


Zwróćcie uwagę na powyższy przykład, gdzie udało nam się zachować zasadę LSP. W przypadku obiektów klasy pochodnej możemy je używać w miejscu klasy bazowej. Dodatkowo nie nadpisujemy metody klasy bazowej, a jedynie z niej korzystamy.

```cs
static void Main(string[] args)
{
    Weapon _weapon;

    Console.WriteLine("Using random weapon");
    _weapon = new Weapon();
    _weapon.Shoot();

    Console.WriteLine("Using sword");
    _weapon = new Sword();
    _weapon.Shoot();

    Console.WriteLine("Using bow");
    _weapon = new Bow();
    _weapon.Shoot();

    Console.ReadLine();
}
```

Brzmi to dość skomplikowanie i abstrakcyjnie. Może najbardziej prostym i książkowym przykładem jest przykład z prostokątem który czasami jest kwadratem, jednakże z matematycznego punktu widzenia to jest logicznem to z programistycznego nie koniecznie i tego typu założenie może przyczynić się do powstania wielu trudnych do wykrycia błędów.


# **I jak Interface Segregation Principle**

Ta zasada powinna być dla Was również w miarę prosta do użycia i intuicyjna. Generalnie chodzi o to aby nasze interfejsy czy klasy abstrakcyjne które implementujemy były w możliwy sposób jak najbardziej "odchudzone" i zawierały tylko metody najbardziej istotne, z których nasze klasy dziedziczące będą w danej chwili korzystać. Zasada ta pozwala uniknąć implementowania niepotrzebnej ilości, nadmiarowych metod, z których nie koniecznie będziemy korzystać.

Zobaczmy na następujący przykład rozwlekłego (spasłego) interfejsu:

```cs
public interface IPhone
{
    void Call(int number);
    void Text(int number, string textMessage);
    void TransferFiles(int blueID);
    void ConnectInternet();
    void UseGPS();
}

class Phone : IPhone
{
    public void Call(int number)
    {
        throw new NotImplementedException();
    }

    public void ConnectInternet()
    {
        throw new NotImplementedException();
    }

    public void Text(int number, string textMessage)
    {
        throw new NotImplementedException();
    }

    public void TransferFiles(int blueID)
    {
        throw new NotImplementedException();
    }

    public void UseGPS()
    {
        throw new NotImplementedException();
    }
}
```

W powyższym przykładzie mamy klasę bazową `Phone` (telefon), która implementuje interfejs `IPhone`, jednakże zwróćcie uwagę, na metody, które się w nim znajdują i zastanówcie się przez chwilę, czy każdy telefon w obecnych czasach z których korzystają wszyscy ludzie na ziemi posiadają możliwość np. łączenia z internetem, przesyłania plików przez bluetooth czy nawigowanie za pomocą nadajnika GPS???

W sumie to pewnie większość już tak, ale znajdzie się Pani Grażyna od Pana Mietka, która jednak będzie korzystać ciągle ze starej Nokii i tam nie będzie takich ficzerów. Dlatego telefon Pani Grażyny nie potrzebuje implementować metod z których nie będzie korzystać i powinien implementować tylko kilka z nich.

Jak to powinno być zrobione? Rozbijemy nasze interfejsy w bardziej praktyczny sposób:

```
public interface ICallable
{
    void Call(int number);
}

public interface ITextable
{
    void Text(int number, string textMessage);
}

public interface ITransferable
{
    void TransferFiles(int blueID);
}

public interface IConnectable
{
    void ConnectInternet();
}

public interface INavigable
{
    void UseGPS();
}
```


Następnie nasze klasy będą implementować tylko te interfejsy, których metody będą im potrzebne:

```cs
class OldNokiaPhone : ICallable, ITextable
{
    public void Call(int number)
    {
        throw new NotImplementedException();
    }

    public void Text(int number, string textMessage)
    {
        throw new NotImplementedException();
    }
}

class AppleIPhone : ICallable, ITextable, IConnectable, ITransferable, INavigable
{
    public void Call(int number)
    {
        throw new NotImplementedException();
    }

    public void ConnectInternet()
    {
        throw new NotImplementedException();
    }

    public void Text(int number, string textMessage)
    {
        throw new NotImplementedException();
    }

    public void TransferFiles(int blueID)
    {
        throw new NotImplementedException();
    }

    public void UseGPS()
    {
        throw new NotImplementedException();
    }
}
```


No i gra gitarka. Stary telefon Nokia, może tylko dzwonić i wysyłać SMSy. Nowy iPhone od Apple może robić już troszkę więcej. Idea jest bardzo fajna, nie ma sensu implementować metod, które danej klasie są w danej chwili nie potrzebne. Dlatego staramy się odchudzić nasze interfejsy w najbardziej możliwy sposób.


# **D jak Dependency Inversion Principle**


To już ostatnia zasada, która mówi nam o tym co powinno zależeć od czego. Inaczej mówiąc wszystkie obiekty powinny zależeć od warstwy abstrakcji a nie konkretnej klasy.  Idąc głębiej, w deklaracji żądnej klasy, funkcji czy metody nie powinniśmy bezpośrednio używać nazw klasy a jedynie naszych interfejsów lub klas abstrakcyjnych. Postaram się to przedstawić na kolejnych przykładach:

Mamy następujące klasy, które reprezentują różne metody wysyłania wiadomości (SMS, MMS, FAX i EMAIL)

```cs
public class SMS
{
    public string Number { get; set; }
    public string Subject { get; set; }
    public string Content { get; set; }
    public void SendSMS()
    {
        // implementation here
    }
}

public class MMS
{
    public string Number { get; set; }
    public string Subject { get; set; }
    public string Content { get; set; }
    public void SendMMS()
    {
        // implementation here
    }
}

public class FAX
{
    public string Number { get; set; }
    public string Subject { get; set; }
    public string Content { get; set; }
    public void SendFAX()
    {
        // implementation here
    }
}

public class EMAIL
{
    public string EmailAddress { get; set; }
    public string Subject { get; set; }
    public string Content { get; set; }
    public void SendEmail()
    {
        // implementation here
    }
}
```

oraz klasę, która powiadamia nas o wysłanych wiadomościach:

```cs
public class Messenger
{
    public SMS _sms { get; set; }
    public MMS _mms { get; set; }
    public FAX _fax { get; set; }
    public EMAIL _email { get; set; }

    public Messenger()
    {
        _sms = new SMS();
        _mms = new MMS();
        _fax = new FAX();
        _email = new EMAIL();
    }

    public void SendMessage()
    {
        _sms.SendSMS();
        _mms.SendMMS();
        _fax.SendFAX();
        _email.SendEmail();    
    }
}
```

Przeanalizujmy klasy przedstawione powyżej. Mamy nadrzędną klasę `Messenger`, która bezpośrednio zależy od klas podrzędnych takich jak `SMS`, `MMS`, `FAX` czy `EMAIL`.

Zbudowaliśmy stałe powiązania, które sprawiają, że nasz kod w tym momencie nie jest elastyczny. Nie jest również prosty w modyfikacjach i konserwacji. Nie możemy wynieść klasy `Messenger` do oddzielnej biblioteki bo posiada sztywne zależności. Tak na prawdę im więcej instancji `new` będziemy mieć w swoim kodzie tym więcej powiązań będziemy tworzyli. Nasz kod jest zależny od konkretnych klas a nie warstwy abstrakcji.

**Co możemy zrobić w zamian?**

Tak na prawdę aby pozbyć się niepotrzebnych powiązań między klasami i sprawić aby nasza klasa `Messenger` nie była bezpośrednio powiązana z klasami `SMS`, `MMS`, `FAX` czy `EMAIL` musimy wprowadzić dodatkową warstwę abstrakcji, która sprawi, że klasy podrzędne będą zależne od warstwy abstrakcji a nie bezpośrednio od klasy `Messenger`.

Dlatego dobrą praktyką jest wprowadzenie tutaj interfejsu `IMessage`, który będzie **zawierał jedną metodę `SendMessage()`**

```cs
public interface IMessage
{
    void SendMessage();
}
```

Następnie nasz interfejs musi zostać zaimplementowany jako dodatkowa warstwa abstrakcji poprzez nasze klasy podrzędne wiadomości:

```cs
public class SMS : IMessage
{
    public string Number { get; set; }
    public string Subject { get; set; }
    public string Content { get; set; }

    public void SendMessage()
    {
        // implementation of sms message
    }
}

public class MMS : IMessage
{
    public string Number { get; set; }
    public string Subject { get; set; }
    public string Content { get; set; }

    public void SendMessage()
    {
        // implementation of mms message
    }
}

public class FAX : IMessage
{
    public string Number { get; set; }
    public string Subject { get; set; }
    public string Content { get; set; }

    public void SendMessage()
    {
        // implementation of fax message
    }
}

public class EMAIL : IMessage
{
    public string EmailAddress { get; set; }
    public string Subject { get; set; }
    public string Content { get; set; }

    public void SendMessage()
    {
        // implementation of email message
    }
}
```


Generalnie teraz **nasza klasa `Messenger` jako klasa nadrzędna, może zależeć tylko od naszej warstwy abstrakcji `IMessage`**, a nie bezpośrednio od konkretnego typu wiadomości.

```cs
public class Messenger
{
    private IEnumerable<IMessage> _ourMessages;

    public Messenger(IEnumerable<IMessage> msgs)
    {
        _ourMessages = msgs;
    }

    public void Send()
    {
        _ourMessages.AsEnumerable().ToList().ForEach(n => n.SendMessage());
    }
}
```


Jest to o tyle fajne, że nie ma znaczenia ile mamy rodzajów ścieżek, którymi możemy przesyłać nasze wiadomości. Możemy dopisać sobie ich dowolną ilość i tylko uzależnić je od naszej warstwy abstrakcji, a reszta kodu pozostanie bez zmian. Dzieje się tak, ponieważ sam DIP principle został wprowadzony w celu minimalizacji powiązań w naszym kodzie, do czego dążymy i co jest naszym celem.


# Przemyślenia

Generalnie SOLID jest podejściem, który zapewnia nam na przejście z mocno powiązanego i mało spójnego kodu ze słabą hermetyzacją do kodu o luźnych powiązaniach czyli elastycznego i działającego bardzo spójnie oraz reagującego dobrze na zmiany. Sam SOLID sprawdza się bardzo dobrze w firmach gdzie stosuje się `Agile Development`. Samo zrozumienie niektórych zasad tego podejścia może sprawić nam pewną trudność, jednakże jak już raz się tego nauczymy, nasze aplikację będą działać, a nie będą się pytać czy mogą działać.
