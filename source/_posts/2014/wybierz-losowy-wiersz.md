---
comments: true
date: 2014-08-06 07:11:47+00:00
extends: _layouts.post
cover_image: /assets/img/posts/2014/mysql_rand.jpg
slug: wybierz-losowy-wiersz
title: Wybierz losowy wiersz
wordpress_id: 120
categories:
- MySQL
tags:
- baza danych
- mysql
- rand
- sql
---

Wpis o tym jak skutecznie wylosować z bazy danych dowolny wiersz, nie korzystając z funkcji _rand()_ oraz nie sprawiając tym samym za dużo obciążenia.

<!-- more -->


## Geneza problemu


Bardzo często zdarza się że musisz uzyskać losową część danych z jakiegoś zbioru. Najczęściej będzie to jeden wiersz (i tym głównie się zajmiemy), ale przedstawione metody można z powodzeniem użyć do wylosowania większej ilości danych. Poniżej przedstawiam kilka klasycznych przykładów które zmuszają nas do losowości:

  * rotacyjne wyświetlanie reklam
  * losowe wyświetlanie promowanych treści, np: ogłoszeń lub wiadomości
  * generowanie danych losowych na potrzeby testów
  * przydzielanie dostępnych zasobów (np. dostępnych konsultantów lub samochodów)

W takich przypadkach najczęściej spotykanym rozwiązaniem jest zastosowanie losowego posortowania danych a następnie wybrania pierwszego rekordu z góry. W ten sposób mamy pewność że otrzymany wiersz zawsze będzie losowy z w miarę równo rozłożonym prawdopodobieństwem. Przykładowa implementacja (same dane celowo wycinam, nie są nam w tej chwili potrzebne):

```
mysql> select * from adverts order by rand() limit 1;
1 row in set (0.00 sec)
```

Na pierwszy rzut oka wszystko działa prawidłowo i bez najmniejszych problemów. Schody zaczynają się w momencie gdy tabela _adverts_ zacznie się rozrastać na serwerze produkcyjnym. W przypadku dostatecznie dużej tabeli tak proste zapytanie potrafi trwać wieki. Dla testów wypełnijmy tabelę _adverts_ danymi testowymi w ilości 100 tys. wierszy. Teraz wynik naszego zapytania wygląda inaczej:

```
mysql> select * from adverts order by rand() limit 1;
1 row in set (0.86 sec)
```

Jak widać czas wzrósł prawie do jednej sekundy. Na obciążonym serwerze sytuacja może wyglądać jeszcze gorzej a to dopiero 100 tys. wierszy. Co będzie przy większej ilości ?

Źródłem problemów jest funkcja _rand()_, która powoduje za każdym razem wygenerowanie tymczasowej kolumny z losową wartością liczbową dla każdego wiersza w naszej tabeli. Mało tego wynik tej funkcji i tak nie jest nigdzie zapisywany, więc za każdym razem gdy wykonujemy nasze zapytanie baza ponownie wygeneruje tysiące losowych wartości. W przypadku normalnego sortowania po kolumnie z indeksem następuje spora optymalizacja i sama baza nie potrzebuje skanować całej tabeli (table scan) w odróżnieniu od funkcji _rand()_. Używanie tej funkcji wydaje się również niepotrzebne z jeszcze jednego powodu: otóż zazwyczaj potrzebujemy otrzymać tylko jeden wiersz, a rand "przetrzepie" za nas całą tabelę.


## Sytuacje dopuszczalne


Nie wszystkie zapytania używające funkcje _rand()_ powinny zostać zoptymalizowane. Dopuszczalne jest stosowanie funkcji _rand()_ dla stosunkowo niewielkich zbiorów danych. Poniżej przykłady, dla których rozwiązania zaproponowane w tym wpisie, będą całkowicie niepotrzebne:

  * wybór losowego województwa (mamy ich tylko 16)
  * wybór losowego miesiąca (12)
  * przydzielenie losowej wersji strony (np. przy testach A/B)
  * każdy inny zbiór z małą ilością wierszy (w zależności od mocy serwera, od kilku setek do kilku tysięcy)


## Rozwiązania


**Wylosowanie wartości klucza z przedziału od 1 do ilości wierszy:**

Możemy wybrać losową wartość z przedziału wszystkich dostępnych wierszy i na jej podstawie wyciągnąć losowy rekord. poniżej przykładowa implementacja tego rozwiązania:

```
select a.* from adverts as a
join (select ceil(rand() * (select max(id) from adverts)) as rand_id) as temp
on (a.id = temp.rand_id);
1 row in set (0.02 sec)
```

Jak widać wzrost wydajności tego zapytania jest olbrzymi. Niestety stosowanie go ma jedną wadę: zakładamy że nasza kolumna id nie może mieć luk. W przypadku gdy istnieją jakieś przerwy w numeracji (nie wchodzimy teraz w szczegóły skąd się tam wzięły) możemy otrzymać pusty wiersz.

Technika ta ma więc tylko sens gdy mamy pewność że nasza kolumna wykorzystuje wszystkie wartości z przedziału od 1 do wartości maksymalnej (ilości wierszy).

** Wylosowanie następnej większej wartości klucza**:

Ta technika jest lekką modyfikacją rozwiązania z poprzedniego punktu. Tym razem w przypadku wylosowania nie istniejącego wiersza wybierzemy kolejny dostępny wiersz:

```
select a.* from adverts as a
join (select ceil(rand() * (select max(id) from adverts)) as rand_id) as temp
where a.id >= temp.rand_id
order by a.id
limit 1;
1 row in set (0.02 sec)
```

Tak więc tą metodą możemy z powodzenie stosować w przypadku braku ciągłości klucza głównego naszej tabeli. Pamiętajmy że pomysł ten nie zapewni nam równomiernego rozkładu losowości, ale dla większości systemów będzie wystarczająco dobry.

**Wykorzystanie przesunięcia za pomocą offset**

Wszędzie tam gdzie musimy zapewnić że prawdopodobieństwo wylosowanie każdego wiersza będzie takie samo możemy wykorzystać technikę przesunięcia. W bazach danych MySQL słowem kluczowym tego rozwiązania  będzie _offset_. Pozwala on "przesunąć się" o zadaną ilość wierszy. W tym celu będziemy musieli wykonać najpierw zapytanie pomocnicze które wylosuje wartość z przedziału 0 do ilości wierszy, a następnie jego wynik wykorzystać w naszym docelowym zapytaniu:

```
mysql> select round(rand() * (select count(*) from adverts));
+------------------------------------------------+
| round(rand() * (select count(*) from adverts)) |
+------------------------------------------------+
|                                          10918 |
+------------------------------------------------+
1 row in set (0.02 sec)
```

Otrzymaną liczbę możemy zastosować w docelowym zapytaniu:

```
mysql> select * from adverts limit 1 offset 10918
1 row in set (0.02 sec)
```

**Wyliczanie prawdopodobieństwa:**

Kolejna technika została odnaleziona pod adresem: [https://explainextended.com/2009/03/01/selecting-random-rows/](https://explainextended.com/2009/03/01/selecting-random-rows/). Sprawdza się ona w przypadku gdy chcemy wylosować więcej niż jeden wiersz (ale dla jednego wiersza również działa). Nie będziemy jej szczegółowo tłumaczyć gdyż zrobił to sam autor w podanym artykule :)

```
SELECT * FROM  (
        SELECT  @cnt := COUNT(*) + 1,
                @lim := 1 /* tutaj możemy zdefiniować ilość zwracanych wierszy */
        FROM    adverts
        ) vars
STRAIGHT_JOIN
        (
        SELECT  a.*,
                @lim := @lim - 1
        FROM    adverts as a
        WHERE   (@cnt := @cnt - 1)
                AND RAND() < @lim / @cnt
        );
```

Metoda ta może nie jest najefektywniejsza ale zapewnia równomierny rozkład i na pewno jest parę razy szybsza niż standardowy _rand()_.

Tym sposobem chciałbym zakończyć ten wpis. Nie wyczerpuje on oczywiście wszystkich możliwości ale przedstawia ciekawe rozwiązania. Zachęcam również do poszukiwania innych skutecznych technik. Jak zawsze dziękuję za poświęcony czas oraz zapraszam do komentowania (lub ewentualnie krytyki).
