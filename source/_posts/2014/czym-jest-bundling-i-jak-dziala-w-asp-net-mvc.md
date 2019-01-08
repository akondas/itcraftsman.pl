---
author: Adam Kawik
comments: true
date: 2014-09-29 11:46:56+00:00
extends: _layouts.post
link: http://itcraftsman.pl/czym-jest-bundling-i-jak-dziala-w-asp-net-mvc/
slug: czym-jest-bundling-i-jak-dziala-w-asp-net-mvc
title: Czym jest bundling i jak działa w ASP .NET MVC?
wordpress_id: 608
categories:
- ASP .NET
- C#
tags:
- ASP .NET
- Bundles
- C#
- MVC
---

We wcześniejszym wpisie rzuciliśmy się na podmianę stylu dla wybranego przez nas szablonu. Było to bardzo silnie związane z Bundlami z których korzystaliśmy.

<!-- more -->

**Czym jest Bundle i gdzie się znajduje?**

Klasa BundleConfig.cs jest klasą generowaną automatycznie przez naszą aplikację ASP .NET MVC. Znajduje się ona domyślnie w katalogu **App_Start**.

[![1](/assets/img/posts/2014/17.png)](/assets/img/posts/2014/17.png)


Zawiera ona definicję wszystkich potrzebnych zasobów do działania naszej aplikacji takich jak skrypty czy style.css.

```cs
using System.Web;
using System.Web.Optimization;

namespace bundles
{
public class BundleConfig
{
   public static void RegisterBundles(BundleCollection bundles)
   {
      bundles.Add(new ScriptBundle("~/bundles/jquery").Include(
      "~/Scripts/jquery-{version}.js"));

      bundles.Add(new ScriptBundle("~/bundles/jqueryval").Include(
      "~/Scripts/jquery.validate*"));

      bundles.Add(new ScriptBundle("~/bundles/modernizr").Include(
      "~/Scripts/modernizr-*"));

      bundles.Add(new ScriptBundle("~/bundles/bootstrap").Include(
      "~/Scripts/bootstrap.js",
      "~/Scripts/respond.js"));

      bundles.Add(new StyleBundle("~/Content/css").Include(
      "~/Content/bootstrap.css",
      "~/Content/site.css"));

     }
   }
}
```

Zobaczmy, że domyślnie wygenerowana aplikacja ASP .NET MVC posiada już kilka zdefiniowanych Bundli dla frameworka Tweeter Bootstrap, stylów css obowiązujących na podstronach oraz skryptów przez naszą aplikacje wykorzystywanych.

Klasa Bundle służy do grupowania potrzebnych zasobów w pakiety i używanie ich automatycznie przez silnik ASP .NET MVC podczas uruchamiania aplikacji. Wszystko dzieje się w tle. Silnik ASP .NET sam wybiera który plik zostanie w danej chwili użyty. Decyduje on również o wersji z której chce skorzystać.

Np. dodając jquerry do naszych bundli mamy do wyboru dwa pliki:
- jquerry
- jquerry.min
itd

To ASP .NET sam decyduje z którego pliku wystarczy w danej chwili skorzystać co pozwala w jakiś sposób odciążyć przeglądarkę i nie wymaga wczytywania wszystkich zasobów na raz.

**Jak to faktycznie działa?**

Zobaczmy jakie typy bundli możemy sobie definiować w naszej klasie BundleConfig.cs. Tak na prawdę do wyboru mamy dwa rodzaje zasobów, które możemy upchać w naszych bundlach :)

Są to:
 * StyleBundles ( pozwalają na ładowanie stylów do naszej aplikacji )
 * ScriptBundles ( pozwalają do ładowania skryptów w naszej aplikacji )

[![2](/assets/img/posts/2014/24.png)](/assets/img/posts/2014/24.png)

Przykładowo wygląda to tak:

```cs
bundles.Add(new ScriptBundle("~/bundles/nazwabundla").Include(
              "~/Scripts/nazwaskryptu1*",
              "~/Scripts/nazwaskryptu.version*"));
```

W taki sam sposób definiujemy bundle ze stylami:

```cs
bundles.Add(new StyleBundle("~/Content/css").Include(
"~/Content/bootstrap.css",
"~/Content/site.css"));
```

Ok. Zdefiniowaliśmy sobie swoje przykładowe bundle.

**Jak teraz z tego skorzystać?**

Nasze wcześniej zdefiniowane bundle mogą zostać w łatwy sposób wywołane w widoku przy użyciu prostej dyrektywy (pozwala to zastąpić linkowanie tych skryptów za pomocą `<link>` na każdej z podstron, która musi z tych zasobów skorzystać )

Wystarczy, że poprosimy o wyrenderowanie tych Bundli:

```cs
@Styles.Render("~/Content/css")
@Scripts.Render("~/bundles/nazwabundla")
```

Natomiast teraz po uruchomieniu aplikacji nasze skrypty po zbadaniu źródła strony będą dostępne na zewnątrz, co nie jest zbyt dobrym rozwiązaniem. Aby tego uniknąć na samym dole w klasie BundleConfig.cs wklejamy następującą linie kodu:

```cs
BundleTable.EnableOptimizations = true;
```

Bądź, jeśli wolimy grzebać w WebConfigu to wstawiamy:

```xml
<system.web>
    <compilation debug="true" />
</system.web>
```


Teraz po podejrzeniu źródła strony będziemy mogli zobaczyć, że nasze standardowe skrypty zostały podmienione na te zoptymalizowane :)

Dziękuję za uwagę :) Temat bardzo krótki dlatego nie ma się tutaj o czym za bardzo rozpisywać :)
