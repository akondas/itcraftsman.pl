---
author: Adam Kawik
comments: true
date: 2014-09-23 19:46:43+00:00
extends: _layouts.post
link: https://itcraftsman.pl/zrozumiec-linq/
slug: zrozumiec-linq
title: 'C#: Zrozumieć LINQ'
wordpress_id: 495
categories:
- C#
tags:
- C#
- LINQ
- Query
---

**Czym jest LINQ?**

W dzisiejszym wpisie porozmawiamy sobie o bardzo użytecznej technologii jaką jest LINQ. Nazwa LINQ pochodzi z języka angielskiego i oznacza Language Integrated Query czyli zintegrowane zapytania językowe.

<!-- more -->

**Do czego tak na prawdę służy LINQ?**

Pozwala nam na szybkie i skuteczne tworzenie zapytań do obiektów. Ponieważ wszystko w języku C# jest obiektem dlatego możemy o te obiekty pytać pisząc proste zapytania i korzystać z metod rozszerzających działających na tych obiektach.

Tworzenie zapytań LINQ pozwala na wydzielenie pewnej części obiektów według naszych potrzeb tak samo jak dzieje się to z danymi w SQLu. Wprowadzamy warunki a następnie operujemy na kolekcjach obiektów.

Wszystko jest kolekcją obiektów...

**Notacja z kropką czy notacja standardowych zapytań?**

Pisząc zapytania w LINQu mamy do czynienia z dwoma rodzajami ich zapisu:

Notacja z kropką:

```cs
var querry = kolekcja.Select(n=>n).Where(s=>s <= 4).ToArray();
```

Notacja standardowych zapytań:

```sql
from n in numbers
where n <= 4
select n
```

**Jak to jest zrobione?**

Tak na prawdę technologia LINQ odnosi się do kolekcji obiektów pewnych typów oraz baz danych SQL a nawet danych XML. My na potrzeby ćwiczeń zajmiemy się prostymi zapytaniami dotyczącymi kolekcji.

W Visualu przestrzeń nazw, która umożliwia nam korzystanie z technologii LINQ jest już automatycznie dodana po utworzeniu projektu dlatego nie musimy się tym martwić :)

```cs
using System.Linq;
```

LINQ zawiera szereg metod rozszerzających pozwalających operować nam na kolekcjach obiektów. Do ćwiczeń wystarczy nam standardowa aplikacja konsolowa :)

Utworzymy sobie tablicę liczb całkowitych wypełnioną pewnymi wartościami:

```cs
static void Main(string[] args)
{
   int[] kolekcjaLiczb = new[] {1, 4, 6, 5, 3, 2, 8, 9, 0};
}
```

Wyobraźmy sobie teraz, że chcielibyśmy wszystkie te liczby pobrać za pomocą zapytania LINQa

```cs
 //tworzymy zapytanie w którym z naszej kolekcji pobieramy wszystkie elementy
 // i wrzucamy do kolejnej kolekcji
 var querry1 = kolekcjaLiczb.Select(n => n).ToArray();
```

Po pobraniu wyświetlamy je na ekran:

```cs
// czyli dla każdego itemu znajdującego się w naszej
// nowej kolekcji, wyświetlamy kolejne itemy
 foreach (var item in querry1)
 {
      Console.Write(item+" ");
 }
```

Na konsolce zobaczymy:

[![1](/assets/img/posts/2014/linq15.png)](/assets/img/posts/2014/linq15.png)

Oczywiście każdy powie teraz, a po co tak kombinować, skoro możemy sobie bezpośrednio wyświetlić zawartość naszej tablicy bez korzystania z tablicy pomocniczej. Oczywiście to będzie prawda tylko, to wiąże się z tworzeniem dużej ilości instrukcji iteracyjnych i warunkowych a stosowanie LINQ pozwala na wykonanie tej samej operacji w jednej linii :)

**Ok a co jeśli chcielibyśmy posortować sobie szybko te liczby?**

Normalnie, żeby to zrobić musielibyśmy zastosować jakiś algorytm sortujący, który po kolei sprawdzał by każdy element i zamieniał miejscami.

Oczywiście, ktoś teraz powie, że można to zrobić szybko i łatwo korzystając z metody Array.Sort() czyli tak:

```cs
 Array.Sort(querry1);
```

Jest to sposób dobry natomiast my zrobimy sobie to teraz za pomocą LINQa :)

```cs
var query2 = kolekcjaLiczb.Select(n => n).ToArray().OrderBy(b=>b);
```

[![2](/assets/img/posts/2014/linq22.png)](/assets/img/posts/2014/linq22.png)

Oczywiście możemy posortować sobie je również malejąco:

```cs
  var query3 = kolekcjaLiczb.Select(n => n).ToArray().OrderByDescending(c=>c);
```

Wyglądać to będzie tak:
[![3](/assets/img/posts/2014/linq32.png)](/assets/img/posts/2014/linq32.png)

Jak możemy łatwo zauważyć wszystko piszemy sobie w jednym wierszu, stosując metody rozszerzające LINQa i przekazując do nich lambdy.

**A co jeśli chcielibyśmy sobie ograniczyć wyświetlanie tylko do pewnej liczby?**

Aby to uczynić, będziemy musieli dodać do swoich zapytań dodatkowy człon Where czyli Gdzie :D Powiedzmy, że chcemy z naszej kolekcji wyświetlić tylko od 0 do 4 a resztę pominąć :)

```cs
var query4 = querry1.Select(n => n).Where(b => b <= 4).ToArray();
```

Jak widzimy tym razem wybieramy wszystko z kolekcji querry1 ( ponieważ jest ona posortowana ) a następnie wybieramy wszystkie elementy <= 4. Jest to zapis bardzo intuicyjny i podobny do standardowych zapytań SQLa.

Czyli otrzymamy liczby 0,1,2,3,4 bez pozostałych elementów:

[![4](/assets/img/posts/2014/linq42.png)](/assets/img/posts/2014/linq42.png)

**A co jeśli chodzi o tekst?**

Zapytania LINQ operujące na danych tekstowych wyglądają praktycznie identycznie. Stworzymy sobie teraz tablicę stringów zawierającą kilka stringowych elementów.

```cs
string[] tekstArray = new string[]{"ala", "ma", "kota", "a", "kot", "lubi", "ale"};
```

Powiedzmy, że chcemy wypisać sobie wszystkie wyrazy 3 literowe a resztę odrzucić. Tworzymy sobie nowe query:

```cs
var q1 = tekstArray.Select(n => n).Where(a => a.Length == 3).ToArray();
```

Czyli wybieramy wszystkie elementy z naszej kolekcji wyrazów, których długość Length() jest dokładnie równa 3 i zapisujemy do nowej tablicy.

Oczywiście na wyjściu otrzymujemy taki efekt:

[![5](/assets/img/posts/2014/linq52.png)](/assets/img/posts/2014/linq52.png)

Wszystkie pozostałe elementy zostały odrzucone ponieważ nie spełniły warunku zawartego w Where(). Oczywiście tworzone przez nas zapytania zapisywane są w notacji z kropką a również można stosować notację zapytań identyczną jak w SQLu.

```cs
from word in tekstArray
where word.Length == 3
select word
```

Tego typu zapytanie działa dokładnie tak samo jak te w notacji z kropką, natomiast zajmuje dużo więcej miejsca, dlatego zaleca się stosowanie zapisu z kropką.

**A co z bardziej skomplikowanymi typami?**

Wcześniej przedstawiłem Wam kilka prostych przykładów dotyczących liczb i stringów. A co z klasami i obiektami tych klas? Oczywiście można tak samo z powodzeniem stosować LINQa, z tym ,że zapytania będą trochę bardziej skomplikowane :)

Stworzymy sobie przykładową klasę Pojazd.cs zawierającą kilka właściwości oraz konstruktor z parametrami:

```cs
public enum Rodzaj {
	Osobowy,
	Ciezarowy
}

public class Pojazd {
	public string Marka {
		get;
		set;
	}
	public Rodzaj RodzajPojazdu {
		get;
		set;
	}
	public decimal Cena {
		get;
		set;
	}
	public string Kolor {
		get;
		set;
	}

	public Pojazd(string marka, Rodzaj rodzaj, decimal cena, string kolor) {
		this.Marka = marka;
		this.RodzajPojazdu = rodzaj;
		this.Cena = cena;
		this.Kolor = kolor;
	}
}
```

W pliku Program.cs stworzymy sobie listę obiektów klasy Pojazd i stworzymy kilka przykładowych elementów:

```cs
List<Pojazd> NaszePojazdy = new List<Pojazd>()
{
    new Pojazd("Audi A6 Quatro", Rodzaj.Osobowy, 360.000, "Czarny"),
    new Pojazd("Mercedes Benz", Rodzaj.Osobowy, 390.000, "Bialy"),
    new Pojazd("Volvo Truck", Rodzaj.Ciezarowy, 160.000, "Niebieski"),
    new Pojazd("Iveco Horse", Rodzaj.Ciezarowy, 120.000, "Czarny"),
    new Pojazd("Ford Mondeo", Rodzaj.Osobowy, 70.000, "Czarny"),
};
```

Po wyświetleniu powinniśmy otrzymać coś takiego:

```cs
foreach (var i in NaszePojazdy)
{
    Console.WriteLine("Marka: {0} | Rodzaj: {1} | Cena: {2} tys. zł| Kolor: {3} |",i.Marka, i.RodzajPojazdu, i.Cena, i.Kolor);
}

```

A na wyjściu:

[![6](/assets/img/posts/2014/linq62.png)](/assets/img/posts/2014/linq62.png)

Powiedzmy, że chcielibyśmy teraz napisać LINQowe zapytanie, które wyświetli wszystkie samochody osobowe, koloru czarnego, tańsze niż 100 tyś złotych :)

Sprawa wygląda praktycznie identycznie jak w przypadku liczb:

```cs
var queryCar =
NaszePojazdy.Select(n => n)
.Where(n => n.RodzajPojazdu == Rodzaj.Osobowy)
.Where(n => n.Kolor == "Czarny")
.Where(n => n.Cena <= 100)
.ToList();
```

Piszemy praktycznie identyczne zapytanie z tą różnicą, że w naszej lambdzie po kropce wybieramy do jakiej właściwości czy pola chcemy się odnieść, w naszym przypadku np. kolor, marka, cena itp.

Oczywiście jak pewnie zdążyliście zauważyć powinniśmy otrzymać tylko 1 element, bo tylko jeden jest zgodny z naszymi warunkami :) Jest nim Ford Mondeo :)

[![7](/assets/img/posts/2014/linq71.png)](/assets/img/posts/2014/linq71.png)

W sumie to już wszystko co chciałem Wam dzisiaj pokazać :) Zachęcam do eksperymentowania samemu i testowaniu technologii :)
