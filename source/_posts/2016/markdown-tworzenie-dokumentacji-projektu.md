---
comments: true
date: 2016-05-01 20:16:37+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2016/markdown-300x188.png
slug: markdown-tworzenie-dokumentacji-projektu
title: Markdown - tworzenie dokumentacji projektu
wordpress_id: 1307
categories:
- Dokumentacja
tags:
- dajsiepoznac
- dajsiepoznac2016
- docs
- dokumentacja
- markdown
---

Pierwszy post z serii wpisów na temat tworzenia i prowadzenia dokumentacji projektów. Skupimy się w nim na popularnym języku znaczników Markdown.<!-- more -->

Markdown został stworzony w 2004 roku przez [Johna Grubera](https://en.wikipedia.org/wiki/John_Gruber). Jego celem było stworzenie języka, który będzie zarazem "easy-to-read" oraz "easy-to-write", a przy okazji będzie konwertował się do ładnego HTMLa. Wyszło mu to całkiem sprawnie, bo jego składania jest wykorzystywana niemal wszędzie. Powstało również wiele dodatkowych modyfikacji (np. Github), które dodają nowe znaczniki.

Większość z Was za pewne miała już styczność z tym formatem i/lub używa go w swoich projektach. Dlatego zaczniemy od pytania:


## Dlaczego Markdown ?


**Jest prosty.**

Składania Markdowna jest na tyle prosta, że ledwo można ją tak nazywać. Jeżeli stosowałeś kiedyś emotikony to możesz stosować Markdown. Jego syntaktyka nie wymaga nauki i wchodzi do głowy już po pierwszym użyciu.

**Jest szybki.**

Dzięki jego prostocie szybkość pisania jest zdecydowania większa w porównaniu do pisania jego odpowiednika w HTML. Nie musisz nic wyklikiwać, ani korzystać z zaawansowanych edytorów. Dzięki takiej szybkości tworzenia jest wykorzystywany niemal przez wszystkich: od blogerów, przez programistów do (nawet) powieściopisarzy.

**Jest czysty.**

Jego skonwertowana postać to idealnie sformatowany HTML, który przechodzi poprawnie walidację. Brak błędów składniowych i niedomkniętych bloków. W kodzie nie ma żadnych dodatkowych stylów inline - czysty HTML. Nie możesz tego powiedzieć o dokumentach DOC :D

**Jest przenośny.**

Tworzone w nim teksty mogą być przeglądane i edytowane dosłownie wszędzie. Potrzebujesz do tego tylko najprostszego edytora tekstowego. Jego format zapisu nie wymaga żadnego dodatkowe kodowania czy archiwizowania.

**Jest elastyczny.**

Wykorzystanie Markdowna nie musi kończyć się na przeglądarce. Markdown może zostać bezproblemowo przekonwertowany do wielu innych przenośnych formatów (np, PDF, Word itp.).

## Jak wygląda Markdown ?

Markdown to zwyczajny czysty tekst udekorowany kilkoma specjalnymi znacznikami. Poniżej przykład:

```
Heading
=======

Sub-heading
-----------
 
### Another deeper heading
 
Paragraphs are separated
by a blank line.

Two spaces at the end of a line leave a  
line break.

Text attributes _italic_, *italic*, __bold__, **bold**, `monospace`.

Bullet list:

  * apples
  * oranges
  * pears

Numbered list:

  1. apples
  2. oranges
  3. pears

A [link](https://example.com).
```

Powyższy tekst po przetworzeniu (dowolnym narzędziem, np: [https://dillinger.io/](https://dillinger.io/)) zostanie skonwertowany to następującego HTMLa:

```
<h1>Heading</h1>
    
<h2>Sub-heading</h2>

<h3>Another deeper heading</h3>

<p>Paragraphs are separated
by a blank line.</p>

<p>Two spaces at the end of a line leave a<br />
line break.</p>

<p>Text attributes <em>italic</em>, <em>italic</em>, <strong>bold</strong>, <strong>bold</strong>, <code>monospace</code>.</p>

<p>Bullet list:</p>

<ul>
<li>apples</li>
<li>oranges</li>
<li>pears</li>
</ul>

<p>Numbered list:</p>

<ol>
<li>apples</li>
<li>oranges</li>
<li>pears</li>
</ol>

<p>A <a href="https://example.com">link</a>.</p>
```

## Markdown Cheatsheet

Na zakończenie krótka ściągawka GitHubowej odmiany Markdowna. W następnym wpisie zajmiemy się tematem: "Dlaczego dokumentacja jest ważna i jak ją pisać".

    # Headers 
    
    # H1
    ## H2
    ### H3
    #### H4
    ##### H5
    ###### H6
    
    # Text  
    
    Emphasis, aka italics, with *asterisks* or _underscores_.
    
    Strong emphasis, aka bold, with **asterisks** or __underscores__.
    
    Combined emphasis with **asterisks and _underscores_**.
    
    Strikethrough uses two tildes. ~~Scratch this.~~
    
    #Lists
    
    1. First ordered list item
    2. Another item
    ⋅⋅* Unordered sub-list. 
    1. Actual numbers don't matter, just that it's a number
    ⋅⋅1. Ordered sub-list
    4. And another item.
    
    * Unordered list can use asterisks
    - Or minuses
    + Or pluses
    
    # Links
    
    [I'm an inline-style link](https://www.google.com)
    
    [I'm an inline-style link with title](https://www.google.com "Google's Homepage")
    
    # Images
    
    Inline-style: 
    ![alt text](https://github.com/adam-p/markdown-here/raw/master/src/common/images/icon48.png "Logo Title Text 1")
    
    Reference-style: 
    ![alt text][logo]
    
    [logo]: https://github.com/adam-p/markdown-here/raw/master/src/common/images/icon48.png "Logo Title Text 2"
    Here's
    
    # Code and Syntax Highlighting
    
    Inline `code` has `back-ticks around` it.
    
    ```javascript
    var s = "JavaScript syntax highlighting";
    alert(s);
    ```
     
    ```python
    s = "Python syntax highlighting"
    print s
    ```
     
    ```
    No language indicated, so no syntax highlighting. 
    But let's throw in a <b>tag</b>.
    ```
    
    # Tables
    
    Colons can be used to align columns.
    
    | Tables        | Are           | Cool  |
    | ------------- |:-------------:| -----:|
    | col 3 is      | right-aligned | $1600 |
    | col 2 is      | centered      |   $12 |
    | zebra stripes | are neat      |    $1 |
    
    # Blockquotes
    
    > Blockquotes are very handy in email to emulate reply text.
    > This line is part of the same quote.
    
    Quote break.
    
    # Horizontal Rule
    
    Three or more...
    
    ---
    
    Hyphens
    
    ***
    
    Asterisks
    
    ___
    
    Underscores
