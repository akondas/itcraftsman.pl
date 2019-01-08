---
author: Adam Kawik
comments: true
date: 2017-10-14 11:59:50+00:00
extends: _layouts.post
link: https://itcraftsman.pl/uzyteczne-koncepty-projektowe-kiss-dry-yagni-tda-oraz-separation-of-concerns/
slug: uzyteczne-koncepty-projektowe-kiss-dry-yagni-tda-oraz-separation-of-concerns
title: Użyteczne koncepty projektowe. KISS, DRY , YAGNI, TDA oraz Separation of Concerns.
wordpress_id: 1787
categories:
- C#
- Wzorce
tags:
- C#
- design concepts
- dry
- kiss
- separation of concerns
- yagni
---

Dzisiaj kontynuujemy dalsze wprowadzenie do wzorców projektowych jak i samych dobrych praktyk projektowania. W sumie są to powszechnie znane koncepty z którymi już na pewno się wcześniej spotkaliście. Są to koncepty, które mają ułatwić Wam tworzenie kodu i sprawić aby wasz kod był bardziej zrozumiały. Przyjrzymy się dzisiaj zasadom KISS, DRY, YAGNI, TDA oraz SOC. Dlaczego warto je rozumieć i wprowadzić do swojego kodu? Zobaczcie sami.

<!-- more -->

# Zasada KISS czyli Keep It Simple Stupid

Generalnie ktoś chciał przez to powiedzieć, że **nasz kod powinien być tworzony i utrzymany w taki sposób aby był dla wszystkich jak najbardziej zrozumiały i jasny**. Zasada prawi, że **nasz kod powinien być jak najprostszy w zapisie, bez skomplikowanych udziwnień**, które zaciemniają jego zrozumienie.

**Chodzi tutaj nie tylko o sam sposób tworzenia jak i zapisu kodu ale również o nazewnictwo naszych klas**, metod, zmiennych oraz obiektów. Wszystko powinno być zapisywane w taki sposób aby nazwa zmiennej, obiektu, metody czy klasy broniła się sama i mówiła jakie jest jej przeznaczenie lub zastosowanie.

Nie powinno na pewno wyglądać to tak:

```cs
class notKISSClass1
{
    int num1;
    int num2;

    public int Calculate1(int n1, int n2)
    {
        return n1 / n2;
    }

    int res1;

    public notKISSClass1()
    {
        res1 = Calculate1(num1,num2);
    }
}
```

Zobaczcie jaki chaos panuje w powyższym przykładzie. Co mówią nam aktualne nazwy klasy czy zmiennych? Co mówi nam nazwa metody `Calculate1()`? Na pewno, że coś oblicza ale co konkretnie? A jak kalkulacji w naszej klasie będzie więcej i to różnego rodzaju? Dlaczego zmienne o dziwnych i skrótowych nazwach, są deklarowane wszędzie i porozrzucane po całej powierzchni klasy a nie znajdują się w jednym miejscu czyli np. na początku?

Jak można napisać to dużo czytelniej?

```cs
public class NumberCalculator
{
    public int Number1 { get; set; }
    public int Number2 { get; set; }
    public int Result { get; set; }

    public NumberCalculator()
    {
        Result = DivideNumbers(Number1, Number2);
    }

    public int DivideNumbers(int Number1, int Number2)
    {
        return (Number1 / Number2);
    }
}
```

Po takim zapisie od razu widać, co i za co odpowiada. Widać, że nasza klasa odpowiada za wykonywanie kalkulacji na liczbach. Nazwy pól czy właściwości są jasne i zrozumiałe. Nazwa metody również sama opisuje siebie. Musicie pamiętać o tym, że zwykle programy nad którymi pracujecie są tworzone, przez wielu programistów jednocześnie, dlatego dbajcie o nazewnictwo, o upraszczanie zapisów i o porządek w swoim kodzie, tak aby osoba, która będzie musiała pracować na waszym kodzie, mogła to robić komfortowo i szybko, bez problemów.


# Zasada DRY czyli Dont Repeat Yourself

<div class="shadow-md p-4 bg-yellow-lighter">
Pozwolę sobie na drobne wtrącenie:<br />
Ta zasad jest bardzo często nadużywana przez młodych programistów i źle rozumiana przez ich starszych kolegów. Temat jest o wiele bardzoei skomplikwany, dlatego postaram się go opisać w osobnym poście.<br />
<i>Arkadiusz Kondas</i>
</div>

Zasada mówi nam o tym abyśmy się nie powtarzali. Co dokładnie autor ma na myśli? Chodzi mu o to,** abyśmy tworzyli kod, który pozwala uniknąć niepotrzebnych powtórzeń w kodzie, kodu, który robi to samo i się powtarza**. Idąc dalej, chodzi o to aby żadna część naszej aplikacji nie powtarzała się w wielu miejscach a znajdowała się tylko w miejscu, które jest dla danej funkcjonalności przeznaczone.

Generalnie gdy na przykład posiadamy metody, które dodają nasze obiekty do bazy danych to metody dodające ten obiekt powinny znajdować się w jednej, odpowiednio scentralizowanej i przygotowanej do tego klasie. Może to być repozytorium CRUDa czy jakiś service. Ale generalnie nie ma sensu deklarować wielokrotnie metod dodających coś do bazy danych w wielu miejscach oddzielnie.

```
public class Hamster
{
    public string HamsterName { get; set; }
    public int HamsterPhoneNumber { get; set; }

    public ICollection<Hamster> HamstersWorld { get; set; }
    public ICollection<Hamster> HamstersHouse { get; set; }

    public void AddHamsterWithSpecificPhoneNumber(Hamster _hamster)
    {
        var getHamsterByPhone = HamstersWorld.ToList().Where(n => n.HamsterPhoneNumber == _hamster.HamsterPhoneNumber).Single();

        HamstersHouse.Add(getHamsterByPhone);
    }

    public void RemoveHamsterWithSpecificPhoneNumber(Hamster _hamster)
    {
        var getHamsterByPhone = HamstersWorld.ToList().Where(n => n.HamsterPhoneNumber == _hamster.HamsterPhoneNumber).Single();

        HamstersHouse.Remove(getHamsterByPhone );
    }
}
```

Popatrzcie na powyższy przykład. Mamy klasę `Hamster`, a w niej dwie metody, które dodają naszego chomika do domku jak również go kasują. Zauważcie jednak, że zrobiliśmy tutaj duplikację linii kodu, które szukają chomika o specyficznym numerze telefonu. Wiemy, że na pewno będziemy musieli szukać naszych obiektów bardzo często, praktycznie zawsze przy okazji jakichkolwiek operacji na obiektach czy kolekcjach. Czy nie lepiej wyciągnąć ten kod i przenieść go do oddzielnej metody aby nie było konieczności modyfikowania go we wszystkich metodach na raz w różnych miejscach programu?

**Jak to mogło by wyglądać z zastosowaniem DRY:**

```cs
public class Hamster
{
    public string HamsterName { get; set; }
    public int HamsterPhoneNumber { get; set; }

    public ICollection<Hamster> HamstersWorld { get; set; }
    public ICollection<Hamster> HamstersHouse { get; set; }

    public void AddHamsterWithSpecificPhoneNumber(Hamster _hamster)
    {
        HamstersHouse.Add(FindHamsterByPhone(_hamster.HamsterPhoneNumber));
    }

    public void RemoveHamsterWithSpecificPhoneNumber(Hamster _hamster)
    {
        HamstersHouse.Remove(FindHamsterByPhone(_hamster.HamsterPhoneNumber));
    }

    public Hamster FindHamsterByPhone(int phone)
    {
        return HamstersWorld.ToList().Where(n => n.HamsterPhoneNumber == phone).Single();
    }
}
```

Teraz mamy oddzielną metodę odpowiadającą za szukanie chomika po numerze telefonu, którą wywołujemy w innych metodach. Teraz wszelkie zmiany logiki w wyszukiwaniu mogą być dokonywane w jednym miejscu programu a nie wielu miejscach. Nie musimy również duplikować niepotrzebnych linii kodu.

# Zasada YAGNI czyli You Ain't Gona Need It

Jest to fajna zasada, która **mówi, że w naszym programie powinniśmy umieszczać najistotniejsze funkcjonalności, które w danej chwili będą nam potrzebne**. Mówi również aby nie pisać kodu, który w danym momencie się nam nie przyda, który będzie nadmiarowy i który będzie się tylko rozrastał niepotrzebnie w naszym programie. Piszmy w danej chwili tylko to co będzie nam potrzebne, jeśli nie mamy pewności, że dana metoda będzie nam potrzebna to jej nie definiujmy.

Fajnym przykładem zastosowania tej zasady jest podejście TDD (Test Driven Developement), w którym w danej chwili tworzymy test, który sprawdza tylko małą konkretną funkcjonalność programu a później definiujemy minimalną ilość kodu aby test przeszedł. Nie piszemy nic więcej, nie tworzymy nadmiarowego kodu.

Zobaczmy na poniższy przykład:

```cs
public class Hamster
{
    public string HamsterName { get; set; }
    public int HamsterPhoneNumber { get; set; }

    public ICollection<Hamster> HamstersWorld { get; set; }
    public ICollection<Hamster> HamstersHouse { get; set; }

    public void AddHamsterWithSpecificPhoneNumber(Hamster _hamster)
    {
        HamstersHouse.Add(FindHamsterByPhone(_hamster.HamsterPhoneNumber));
    }

    public void AddHamsterByName(Hamster _hamster)
    {
        HamstersHouse.Add(FindHamsterByPhone(_hamster.HamsterPhoneNumber));
    }

    public void RemoveHamsterWithSpecificPhoneNumber(Hamster _hamster)
    {
        HamstersHouse.Remove(FindHamsterByPhone(_hamster.HamsterPhoneNumber));
    }

    public Hamster FindHamsterByPhone(int phone)
    {
        return HamstersWorld.ToList().Where(n => n.HamsterPhoneNumber == phone).Single();
    }

    public void FeedHamster(Hamster _hamster, string breed)
    {
        Console.WriteLine("Hamster {0} breeded using {1}", _hamster.HamsterName, breed);
    }

    public void TransportHamster(Hamster _hamster, TravelDirection _direction)
    {
        Console.WriteLine("Hamster {0} has been transported to {1}", _hamster.HamsterName, _direction.DestinationOfTravel);
    }
}
```

Jako przykład weźmy sobie znowu hodowlę chomików Pana Zenka. Tworzymy dla niego skomplikowane oprogramowanie, które pozwala na zarządzanie i kontrolowanie życia jego podopiecznych. W aktualnym sprincie, Pan Zenek prosił o możliwość dodawania i usuwania chomików z chomikowego świata do domku jak i również wyszukiwanie chomika po numerze telefonu jak i wielu chomików na raz. Dodatkowo żona Pana Zenka prosiła i możliwość karmienia chomików dowolną karmą.

Popatrzmy teraz na wszystkie metody znajdujące się w klasie Hamster.** Czy metoda `TransportHamster()` w danej chwili była kluczowa? Czy na pewno w tej chwili mieliśmy się skupić na tworzeniu funkcjonalności zezwalającej naszym chomikom na podróżowanie w różnych kierunkach świata?** Raczej nie.

**Zasada YAGNI stara się zaoszczędzić czas niezbędny na tworzenie naszego oprogramowania i skupienie się na najbardziej istotnych wymaganiach w danym sprincie** (w danej chwili), dlatego skupiamy się na tym co teraz jest nam potrzebne. Inne wymagania dopiszemy gdy przyjdzie na to czas.


# Zasada TDA czyli Tell Don't Ask

<div class="shadow-md p-4 bg-yellow-lighter">
Ta zasada była również opisywana przezemnie w wpisie: <a href="/powiedz-nie-pytaj-czyli-prawo-demeter">Powiedz, nie pytaj czyli Prawo Demeter</a>.
<br /><i>Arkadius Kondas</i>
</div>

Może wydawać się Wam dziwna i nie koniecznie znana, ale warto również wiedzieć o czym ta zasada mówi. Mianowicie **mówi o konkretnym podziale obowiązków pomiędzy naszymi klasami i obiektami a ich zadaniami**. Jest ściśle związana z hermetyzacją. **Powinniśmy mówić naszym obiektom jakie są ich obowiązki (zadania do wykonania) a nie pytać w jakim są stanie**. Zasada ta również pomaga nam unikać niepotrzebnych powiązań pomiędzy obiektami naszych klas. Popatrzmy na przykład:

```cs
public class PaymentAccount
{
    public int CustomerID { get; set; }

    public int TotalBalance { get; set; }
}

public class PaymentService
{
    public void StandardCustomer(int amount, int customerId)
    {
        var currentAcc = AccountsRepository.FindAccountByCustomerId(customerId);

        if (currentAcc.TotalBalance < amount)
        {
            throw new Exception("Not enough funds.");
        }
            
        currentAcc.TotalBalance -= amount;
    }

    public void PremiumCustomer(int amount, int customerId)
    {
        var currentAcc = AccountsRepository.FindAccountByCustomerId(customerId);

        if (currentAcc.TotalBalance < amount)
        {
            throw new Exception("Not enough funds.");
        }

        currentAcc.TotalBalance += amount;
    }
}

public static class AccountsRepository
{
    public static PaymentAccount FindAccountByCustomerId(int customerId)
    {
        return new PaymentAccount
        {
            TotalBalance = 200,
            CustomerID = customerId
        };
    }
}
```

W aktualnym przykładzie wykonujemy operacje na kontach użytkownika i naliczamy opłaty w zależności czy jest to użytkownik Standardowy czy Premium. Nasz `PaymentService` posiada nadmierny kod, który sprawdza jaki jest stan naszych obiektów, czy kwota, którą chcemy pobrać z konta płatnika jest większa od kwoty na jego koncie.

**Jak zrobić to lepiej i zgodnie z zasadą TDA?**

```cs
public class PaymentAccount
{
    public int CustomerID { get; set; }

    public int TotalBalance { get; set; }

    public PaymentAccount(int customerID, int totalBalance)
    {
        this.CustomerID = customerID;
        this.TotalBalance = totalBalance;
    }

    public void StandardCharge(int amount)
    {
        if (TotalBalance < amount)
        {
            throw new Exception("Not enough funds.");
        }

        TotalBalance -= amount;
    }

    public void PremiumCharge(int amount)
    {
        if (TotalBalance < amount)
        {
            throw new Exception("Not enough funds.");
        }

        TotalBalance += amount;
    }
}

public class PaymentService
{
    public void StandardCustomer(int amount, int customerId)
    {
        var currentAcc = AccountsRepository.FindAccountByCustomerId(customerId);

        currentAcc.StandardCharge(amount);
    }

    public void PremiumCustomer(int amount, int customerId)
    {
        var currentAcc = AccountsRepository.FindAccountByCustomerId(customerId);

        currentAcc.PremiumCharge(amount);
    }
}

public static class AccountsRepository
{
    public static PaymentAccount FindAccountByCustomerId(int customerId)
    {
        return new PaymentAccount(customerId, 1200);
    }
}
```

Zauważmy, że udało nam się przenieść logikę związaną z obsługą konta płatnika do pierwotnej i odpowiedniej klasy. Udało nam się również oczyścić nasz `PaymentService`, w którym nie tworzymy żadnej logiki związanej ze sprawdzaniem stanu obiektu a wywołujemy metody z odpowiedniej klasy. Mówimy co nasze obiekty mają robić a nie pytamy w jakim są stanie.


# Zasada SCA czyli Separation of Concerns

Zasada ta jest bardzo istotna, jeśli chcecie aby Wasz kod był modułowy, łatwo testowalny i łatwy w konserwacji. Mówi nam ona o tym, że **żadna klasa naszego programu nie powinna dzielić odpowiedzialności z innymi klasami w naszym programie**. Chodzi o to, aby każda klasa miała oddzielne zmartwienia i nie musiała martwić się o zadania klas pobocznych. **Wszystkie klasy powinny być zaś rozłączne i osobliwe**.

Aby lepiej sobie to wyobrazić, zauważcie, że takie podejście zostało zastosowane we wzorcu MVC (Model View Controller) w którym wszystkie warstwy o różnych odpowiedzialnościach, zostały od siebie odseparowane.

```cs
public interface IUserService
{
    void RegisterUser(ICollection<User> users, User _user);
    User FindUserByEmail(ICollection<User> users, string email);
    bool ValidateUserCredentials(ICollection<User> users, User _user);
    void LogUserActivity(User _user, string pathToLog);
}

public class UserService : IUserService
{
    public User FindUserByEmail(ICollection<User> users, string email)
    {
        return users.ToList().Where(n => n.Email == email).Single();
    }

    public void LogUserActivity(User _user, string pathToLog)
    {
        using (StreamWriter sw = new StreamWriter(pathToLog))
        {
            sw.WriteLine("Currently {0} {1} activity in at {2}",_user.Email, _user.Password, DateTime.UtcNow);
        }
    }

    public void RegisterUser(ICollection<User> users, User _user)
    {
        users.Add(_user);
    }

    public bool ValidateUserCredentials(ICollection<User> users, User _user)
    {
        var getCurrentUser = FindUserByEmail(users, _user.Email);

        if (getCurrentUser != null)
        {
            if (getCurrentUser.Email == _user.Email && getCurrentUser.Password == _user.Password)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
}

public class User
{
    public string Email { get; set; }
    public string Password { get; set; }
}
```

Przeanalizujmy powyższy przykład, która generalnie pokazuje nam, że separation of concepts zostało tutaj złamane. Mamy klasę User, która reprezentuje użytkownika oraz zawiera jego email oraz hasło. Dodatkowo mamy nasz `UserService`, który posiada metody operacji na użytkowników, ale oprócz tego zawiera również metodę `LogUserActivity()`, która nie koniecznie powinna znajdować się w `UserService`. Czy nie lepiej odseparować ją do innego service bo być może będziemy musieli wykorzystać tą metodą również na innych obiektach? Podobnie sprawa wygląda z metodami walidacyjnymi.

**Jak to powinno wyglądać zgodnie z Separation of Concepts:**

```cs
public interface IUserService
{
    void RegisterUser(ICollection<User> users, User _user);
    User FindUserByEmail(ICollection<User> users, string email);
}

public interface IActivityService
{
    void LogActivity(User _user, string pathToLog);
}

public interface IValidationService
{
    bool ValidateUserCredentials(ICollection<User> users, User _user);
}

public class ActivityService : IActivityService
{
    public void LogActivity(User _user, string pathToLog)
    {
        using (StreamWriter sw = new StreamWriter(pathToLog))
        {
            sw.WriteLine("Currently {0} {1} activity in at {2}", _user.Email, _user.Password, DateTime.UtcNow);
        }
    }
}

public class ValidationService : IValidationService
{
    public bool ValidateUserCredentials(ICollection<User> users, User _user)
    {
        UserService _userService = new UserService();

        var getCurrentUser = _userService.FindUserByEmail(users, _user.Email);

        if (getCurrentUser != null)
        {
            if (getCurrentUser.Email == _user.Email && getCurrentUser.Password == _user.Password)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
}

public class UserService : IUserService
{
    public User FindUserByEmail(ICollection<User> users, string email)
    {
        return users.ToList().Where(n => n.Email == email).Single();
    }

    public void RegisterUser(ICollection<User> users, User _user)
    {
        users.Add(_user);
    }
}

public class User
{
    public string Email { get; set; }
    public string Password { get; set; }
}
```

W ten sposób odseparowaliśmy sobie naszą logikę i przenieśliśmy odpowiedzialności do poszczególnych serwisów naszej aplikacji. Każdy service powinien świadczyć usługi jednego typu i nie powinniśmy nigdy ich łączyć ze sobą.


# Refleksje końcowe

Udało nam się przejść przez kilka bardzo ciekawych zasad i konceptów projektowych, których warto się nauczyć i starać się stosować podczas projektowania swoich aplikacji. Oczywiście zdaję sobie sprawę, że niektóre z nich mogą być nadal dla Was mało jasne, dlatego warto próbować wprowadzić je do swojego kodu stopniowo i porozkminiać troszkę samemu. Warto powtarzać je jak mantrę a jakoś Waszego kodu wzrośnie.
