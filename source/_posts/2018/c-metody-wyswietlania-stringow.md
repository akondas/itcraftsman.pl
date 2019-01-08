---
author: Adam Kawik
comments: true
date: 2018-02-16 16:19:45+00:00
extends: _layouts.post
link: http://itcraftsman.pl/c-metody-wyswietlania-stringow/
slug: c-metody-wyswietlania-stringow
title: 'C#: Console.WriteLine() na różne sposoby'
wordpress_id: 1799
categories:
- C#
tags:
- C#
- ConsoleApp
- String.Format. Interpolation
---

Witajcie. Dzisiaj natchnęło mnie na bardzo krótki artykuł, być może przyda się komuś początkującemu, który dopiero zaczyna zabawę z językiem programowania C#. Wszyscy wiemy, że w miarę rozwoju standardów, język nam trochę ewoluuje i zmienia się pod kątem składni jak i wprowadza dodatkowe udogodnienia odnośnie pisania kodu. Tym razem chciałbym krótko przejść z Wami przez metody wyświetlania stringów.

<!-- more -->

**Metoda 1: Z plusem**

W tym przypadku zwracamy wartość obiektu, zawartość jego właściwości i łączymy go ze stringiem za pomocą znaku dodawania "+" tak jak widzicie tutaj:

```cs
Planet planet = new Planet()
{
    Name = "Earth",
    Size = 123123123
};

Console.WriteLine("Planet " + planet.Name + " with size " + planet.Size);
Console.ReadLine();
```

W sumie jest to zapis chyba najbardziej pospolity, najmniej elegancki. Nie różni się zbytnio swoim działaniem niczym.

**Metoda 2: Na wąsacza**

Ta metoda różni się od poprzedniej tym, że miejsce w którym wyświetlony zostanie string, jest ustalane przez wartości numeryczne zawarte pomiędzy nawiasami klamrowymi {0}. Musimy pamiętać tutaj o kolejności w której przekazujemy parametry do wyświetlenia. Znajdują się one zwykle na końcu Console,WriteLine() i wyglądają tak:

```cs
Planet planet = new Planet()
{
    Name = "Earth",
    Size = 123123123
};

Console.WriteLine("Planet {0} with size {1}", planet.Name, planet.Size);
Console.ReadLine();
```

Zapis tego typu jest bardziej schludny. Jednak może być uciążliwy w przypadku dużej ilości parametrów, które mogą się mnożyć.

**Metoda 3: Poprzez interpolacje**

Ten zapis został wprowadzony dopiero od C# w wersji 6.0. Jest godny uwagi ze względu na swoją przejrzystość i czytelność. Różni się tym od swoich poprzedników, że na początku każdego stringa stawiamy znak dolara $" ". Wewnątrz stringa, który budujemy, będziemy wpisywać bezpośrednio parametry do wyświetlenia w nawiasach wąsatych. Nie trzeba tutaj wpisywać numerów zamiast tego bezpośrednio podaje się obiekt do wyświetlenia.

    
```cs
Planet planet = new Planet()
{
    Name = "Earth",
    Size = 123123123
};

Console.WriteLine($"Planet {planet.Name} with size {planet.Size}");
Console.ReadLine();
```


Moim zdaniem, interpolacja stringów jest bardzo wygodną metodą łączenia zwykłego tekstu i właściwości. Piszemy wszystko in line, nie martwimy się kolejnością parametrów, nie musimy o nich pamiętać. Wszystko jest bardzo czytelne.

Na konsoli widzimy praktycznie to samo, efekt wyświetlanie nie zmienia się.

Z którego podejścia skorzystamy? To zależy od Nas oraz sposobu, którego my i nasz zespół trzymamy się podczas budowania i rozwijania naszej aplikacji. Jednak warto znać te trzy podstawowe metody, bo spotkacie je wszędzie.
