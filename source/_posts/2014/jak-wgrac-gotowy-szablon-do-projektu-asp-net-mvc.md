---
author: Adam Kawik
comments: true
date: 2014-09-29 11:00:17+00:00
extends: _layouts.post
link: http://itcraftsman.pl/jak-wgrac-gotowy-szablon-do-projektu-asp-net-mvc/
slug: jak-wgrac-gotowy-szablon-do-projektu-asp-net-mvc
title: Jak wgrać gotowy szablon do projektu ASP .NET MVC?
wordpress_id: 589
categories:
- ASP .NET
- C#
- CSS
- HTML
tags:
- ASP .NET
- Bundles
- C#
- Layouts
- MVC
- Templates
- Themes
---

Dzisiaj postaram się wyjaśnić jak w prosty sposób pobrać i wgrać sobie inny szablon dla naszej aplikacji ASP .NET MVC. Wszyscy wiemy, że domyślnie po założeniu nowego projektu posiada on standardowego frameworka Twitter Bootstrap. Natomiast co w przypadku gdy chcielibyśmy zmienić go sobie na jakiś inny?

<!-- more -->

**Gdzie mogę pobrać inne szablony dla ASP ?**

Najlepiej poszukać ich sobie tutaj: [http://www.html5webtemplates.co.uk/](http://www.html5webtemplates.co.uk/)

Strona ta posiada mnóstwo gotowych szablonów przygotowanych przy użyciu HTMLa 5 i CSS 3. Można je bez problemu wykorzystać za darmo do celów komercyjnych lub nie komercyjnych ponieważ udostępniane są na podstawie licencji CC ( Creative Common )

Wybieramy sobie szablon, który się Nam podoba, ja wybrałem Colour_Blue, szablon należy wypakować z archiwum ZIP :)

**Co dalej?**

Na początku musimy skupić się na 2 katalogach. Pierwszy z nich nazywa się Content, zawiera wszelkie pliki związane ze stylami CSS, domyślnie po utworzeniu projektu MVC zawiera style Bootstrapa, do tego katalogu będziemy wgrywać nasz nowy szablon :)

[![1](/assets/img/posts/2014/16.png)](/assets/img/posts/2014/16.png)

Drugi z nich to katalog Views zawierający widoki dla naszych akcji oraz inne podfoldery takie jak SHARED, zawierający plik** _Layout.cshtml** stanowiący główny szkielet naszej aplikacji:

[![2](/assets/img/posts/2014/23.png)](/assets/img/posts/2014/23.png)

Wewnątrz _Layout.cshtml znajduje się zdefiniowana struktura kodu html wraz z odpowiednimi linkami :

```html
<!DOCTYPE html>
<html>
   <head>
     <meta charset="utf-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>@ViewBag.Title - My ASP.NET Application</title>
     @Styles.Render("~/Content/css")
     @Scripts.Render("~/bundles/modernizr")
</head>
<body>
   <div class="navbar navbar-inverse navbar-fixed-top">
     <div class="container">
       <div class="navbar-header">
         <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
           <span class="icon-bar"></span>
           <span class="icon-bar"></span>
           <span class="icon-bar"></span>
         </button>
      @Html.ActionLink("Application name", "Index", "Home", new { area = "" }, new { @class = "navbar-brand" })
    </div>

    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li>@Html.ActionLink("Home", "Index", "Home")</li>
        <li>@Html.ActionLink("About", "About", "Home")</li>
        <li>@Html.ActionLink("Contact", "Contact", "Home")</li>
      </ul>
    </div>
  </div>
</div>

<div class="container body-content">
  @RenderBody()
   <hr />

<footer>
   <p>&copy; @DateTime.Now.Year - My ASP.NET Application</p>
</footer>

</div>

   @Scripts.Render("~/bundles/jquery")
   @Scripts.Render("~/bundles/bootstrap")
   @RenderSection("scripts", required: false)
</body>
</html>
```

Oprócz tego naszą uwagę powinien przyciągnąć również plik **ViewStart.cshtml**, który zawiera ścieżkę do plików naszego layouta:

```cs
@{
   Layout = "~/Views/Shared/_Layout.cshtml";
}
```

**Implementacja szablonu.**

W katalogu `Content` dodajemy folder `themes`, w folderze `themes` dodajemy katalog `coloredblue` a w nim katalog `images`.

[![3](/assets/img/posts/2014/33.png)](/assets/img/posts/2014/33.png)

Następnie z pobranego szablonu kopiujemy plik style.css i wklejamy go do katalogu coloredblue. Oprócz tego obrazki wklejamy do folderu images.

[![4](/assets/img/posts/2014/43.png)](/assets/img/posts/2014/43.png)

Następnie w pliku App_Starts w klasie BundleConfig.cs ( oczywiście jeśli korzystamy z wygenerowanego projektu MVC a nie pustego ) znajdują się bundle zawierające odnośniki do wszystkich zasobów naszego projektu takich jak właśnie style, skrypty. Bundle to miejsce, które pozwala na definiowanie zasobów naszej aplikacji w jednym miejscu a nie w każdym pliku z osobna.

[![5](/assets/img/posts/2014/53.png)](/assets/img/posts/2014/53.png)

Po uruchomieniu aplikacji widzimy, że już coś się zmieniło. Zaaplikowane zostały style, dla naszych nagłówków i tekstu, natomiast szablon nie posiada jeszcze właściwej formy.

[![6](/assets/img/posts/2014/63.png)](/assets/img/posts/2014/63.png)

Musimy nad nim jeszcze troszkę popracować :)

**Dlaczego nasz szablon nie generuje się poprawnie?**

Wróćmy teraz pamięcią do naszego pliku Layout.cshtml, zawierającego główną strukturę naszej aplikacji ( swoisty szkielet ) na którym będziemy opierać cały jej wygląd.

Został on domyślnie wygenerowany i dostosowany do Bootstrapa. Natomiast my zmieniliśmy plik ze stylami i nazwy naszych klas i znaczników uległy zmianie. Dlatego teraz musimy dokonać modyfikacje naszego pliku Layout.cshtml, wywalić wszystko co się w nim znajdowało i wkleić zawartość pliku index.html z pobranego szablonu :)

```html
<!DOCTYPE html>

<html>

<head>
<meta name="viewport" content="width=device-width" />
<title>@ViewBag.Title</title>

<!-- Dodajemy ponownie link do naszych stylów nowego szablonu tak samo jak w bundlach -->
<link rel="stylesheet" type="text/css" href="@Url.Content("~/Content/template/coloredblue/style.css")" />
</head>

<body>
<div id="main">

<div id="header">
<div id="logo">
<div id="logo_text">
<h1><a href="/">IT<span class="logo_colour">Craftsman</span></a></h1>
<h2>Writings, Experiments and More...</h2>
</div>
</div>
<div id="menubar">
<ul id="menu">
<li><a href="#">Posts</a></li>
<li><a href="#">Contact</a></li>
<li><a href="#">About Me</a></li>
</ul>
</div>

</div>

<div id="site_content">
@RenderBody()
</div>

<div id="footer">
Copyright © @DateTime.Now.Year
</div>
</div>
</body>
</html>
```

Aktualnie tak wygląda nasz nowy szablon, czyli tak jak miał wyglądać :)

[![7](/assets/img/posts/2014/72.png)](/assets/img/posts/2014/72.png)

**A jaki sens ma dodawanie linku do styli na górze skoro ładujemy je sobie w Bundlach?**

Nie ma żadnego :) Dlatego zakomentujemy sobie teraz ten <link> do nowych styli szablonów i dodamy dyrektywę nakazującą automatyczne ładowanie styli z BundleConfig :)

[![8](/assets/img/posts/2014/81.png)](/assets/img/posts/2014/81.png)

Tak jak widzimy nasz zapis długiej i rozlazłej linii skrócił się Nam do 3 czy 4 wyrazów :)

I to już wszystko :) W ten samo sposób możecie załadować sobie jakikolwiek szablon dla swojej aplikacji :)
