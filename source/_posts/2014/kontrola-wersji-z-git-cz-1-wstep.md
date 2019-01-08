---

comments: true
date: 2014-07-12 19:52:58+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2014/logo@2x1.png
slug: kontrola-wersji-z-git-cz-1-wstep
title: Kontrola wersji z Git cz. 1 - wstęp
wordpress_id: 81
categories:
- GIT
tags:
- git
- system kontroli wersji
---

Jeżeli zdarzyło ci się utworzyć kiedyś plik index1.html, tylko dlatego, żeby nie nadpisać index.html, to ten wpis jest dla Ciebie. Jeżeli zdarzyło ci się utworzyć dodatkowo index2.html, to ten wpis jest dla Ciebie obowiązkowy.

<!-- more -->


## Co to jest system kontroli wersji (VCS) ?


Cytując za Wikipedią:


<blockquote>System kontroli wersji (ang. version/revision control system) – oprogramowanie służące do śledzenia zmian głównie w kodzie źródłowym oraz pomocy programistom w łączeniu zmian dokonanych w plikach przez wiele osób w różnych momentach czasowych.</blockquote>


Dzięki systemowi kontroli wersji będziesz w stanie dowolnie cofać się w czasie, a praca w zespole nad tym samym projektem stanie się łatwiejsza. Będziesz mógł przeglądać historię zmian dokonanych przez samego siebie lub innych programistów. Otrzymasz również narzędzie, które pomoże łączyć Ci efekty pracy dwóch lub więcej osób.




## Jakie problemy rozwiązuje ?


**Problem 1:**

Zarządzanie wersjami w czasie. Dla lepszego zobrazowania tego problemu wystarczy zadać sobie pytanie: czy jestem w stanie sprawdzić lub odtworzyć to, co zmieniłem w kodzie w czwartek do południa ? Niektórzy próbują robić ręczne kopie swojej pracy. Co sprytniejsi, zapisują nawet datę w nazwach pliku lub folderach, ale czy to wystarcza ? Co jeżeli nadpiszesz plik w katalogu z nieprawidłową datą lub pomylisz się przy tworzeniu kolejnego katalogu ?

**Problem 2:**

Zarządzanie zmianami w zespole. Moim zdaniem, ważniejszy niż problem pierwszy i kluczowy przy większych grupach osób współpracujących. Może się zdarzyć, że ty i osoba, która pracuje nad tym samym projektem, zmienicie ten sam plik. Jak wtedy przeprowadzić scalenie wspólnych zmian ? A co, jeśli w między czasie, trzecia osoba też naniosła zmiany w tym samym pliku ?




## Odmiany systemów kontroli wersji


**Lokalny system kontroli wersji**

Jak wspomniałem na wstępie, najprostszą metodą wersjonowania własnej pracy jest stworzenie kopi plików w nowym katalogu. Tak działa też lokalny system kontroli wersji. Przetrzymuje on wszystkie zmiany dokonane na plikach w lokalnej bazie danych. Dzięki niej możliwe jest odtwarzanie zmian dokonanych na plikach z przeszłości. Najbardziej popularnym tego typu systemem jest [rcs](http://pl.wikipedia.org/wiki/Revision_Control_System).

[![lokalny-system-kontroli-wersji](/assets/img/posts/2014/lokalny-system-kontroli-wersji.png)](/assets/img/posts/2014/lokalny-system-kontroli-wersji.png)

**Scentralizowany system kontroli wersji**

Niestety, lokalny model nie sprawdza się przy współpracy kilku osób, dlatego wymyślono centralny system kontroli wersji. W tym przypadku za kontrolę odpowiada wyznaczona maszyna (serwer), która przetrzymuje całą historię zmian. Reszta użytkowników (klientów) łączy się w celu wgrania zmian lub pobrania nowszych wersji. Główną wadą takiego rozwiązania jest problem awarii serwera, która uniemożliwia dalszą współpracę czy choćby zapisywanie zmian. Do zalet można zaliczyć: jedno wspólne miejsce gdzie przetrzymywany jest kod, każdy z uczestników może sprawdzić aktualną wersję oraz łatwość w zarządzania (tylko jedna maszyna). Model ten był bardzo długo popularny i uznawany za powszechny standard. Przykładowe implementacje: Subversion, CVS, Perforce.

[![centralny-system-kontroli-wersji](/assets/img/posts/2014/centralny-system-kontroli-wersji.png)](/assets/img/posts/2014/centralny-system-kontroli-wersji.png)



**Rozproszony system kontroli wersji**

Distributed Version Control System, w skrócie DVCS, to teraz najbardziej popularny model w którym każdy z klientów kopiuje całą historię zmian (repozytorium) na swój lokalny komputer. W przypadku awarii możliwe jest więc przywrócenie danych - wystarczy skopiować repozytorium, które znajduje się na dysku dowolnego użytkownika. Co więcej, każdy z użytkowników posiada u siebie lokalną wersję dostępną off-line i może w każdej chwili zapisywać nowe zmiany. Rozproszony system pozwala też na bardziej elastyczne metody współpracy, które omówię w kolejnych wpisach. Popularne systemy DVCS: Git, Mercurial lub Darcs.

[![rozproszony-system-kontroli-wersji](/assets/img/posts/2014/rozproszony-system-kontroli-wersji.png)](/assets/img/posts/2014/rozproszony-system-kontroli-wersji.png)




## Dlaczego Git ?





	
  1. Open Source - Git jest projektem otwartym, co oznacza, że każdy może go rozwijać i usprawniać. Jeżeli ktoś wymyśli ciekawą lub pomocną funkcję może niemal od razu "wskoczyć" w projekt i pomóc. Otwartość kodów oznacza też, że mnóstwo osób koryguje znalezione błędy.

	
  2. Darmowy - za korzystanie z Git'a nie zapłacisz ani grosza, natomiast twoja wartość na pewno wzrośnie.

	
  3. Niezależny od platformy - możesz zainstalować go na systemach: Windows, Linux i Mac. Na każdym z tych systemów będzie działał tak samo doborze i bezproblemowo.

	
  4. Niesamowicie szybki i wydajny - Git został zaprojektowany z myślą o szybkości i w odróżnieniu od innych systemów wygrywa już na starcie.

	
  5. Rozproszony - posiada wszystkie zalety rozproszonego systemu kontroli wersji. Możesz podpinać wiele zdalnych źródeł które zapewnią ci bezpieczeństwo oraz współpracę z innymi pracownikami

	
  6. Popularny - spora liczba programistów posługuje się biegle Git'em dzięki czemu łatwiej ci będzie współpracować z innymi.

	
  7. Gałęzie i tagi są lekkie - w odróżnieniu od innych systemów utworzenie gałęzi czy tagu trwa ułamek sekundy i pozwala na nowy rodzaj pracy (zostanie to szczegółowo omówione w kolejnych artykułach).

	
  8. Obsługiwany zarówno tekstowo jak i graficznie - możesz korzystać z niego w tradycyjny sposób przez linię komend lub przez graficzne oprogramowanie "wyklikiwać" polecenia.

	
  9. Oparty wyłącznie na plikach - dzięki temu łatwo wykonać kopię zapasową (wystarczy skopiować katalog). Możesz także wykorzystać Dropbox (lub inna usługę dyskową w chmurze) jako swój osobisty serwer.

	
  10. Bo istnieją takie narzędzia jak github.com  bitbucket.org, może trochę na siłę, ale, jak skorzystasz, to zrozumiesz co miałem na myśli.




## Wady ?


No dobrze, ale czy Git ma jakieś wady ? Ma, i warto je znać:



	
  1. Trudny do nauki - dla osoby nie korzystającej z VSC rozpoczęcie przygody z Gitem trochę potrwa, jest spory materiał do opanowania a czasu za pewne mało :). Profesjonalne materiały do nauki są najczęściej płatne.

	
  2. Trudny do przestawienia  - dla osoby korzystającej z zcentralizowanego systemu Git może wydać się w paru miejscach dziwny i trudno będzie odzwyczaić się od niektórych nawyków wypracowanych przy korzystaniu z centralnego systemu

	
  3. Elastyczny - może to wydawać się dziwne, ale dzięki wszystkim funkcją jakie daje nam Git, elastyczność bywa zmorą. Każdy może inaczej pracować z Git'em a wypracowanie wspólnych nawyków może być czasochłonne.

	
  4. Brak możliwości śledzenia pustych folderów.

	
  5. Brak wbudowanego mechanizmu zarządzania prawami użytkowników.

	
  6. Skomplikowany - w scentralizowanym VSC wykonuje się zwykły commit i zmiany zostają zapisane w repozytorium. W Git ścieżka może być nieco dłuższa: dodanie nowych plików (git add), lokalny commit (git commit), scalenie zmian (git merge), wypchanie zmian na serwer (git push).


Jak widać Git nie jest dla wszystkich, ale na pewno, jeżeli jesteś programistą, to umiejętność korzystania z niego może być bardzo pomocna.

To tyle jak na pierwszą część mojej serii "Kontrola wersji z Git". W kolejnym wpisie przejdziemy przez proces instalacji oraz zapoznamy się z podstawowymi komendami. Dziękuję za przeczytanie oraz, jak zawsze zapraszam, do pozostawienia komentarza.


