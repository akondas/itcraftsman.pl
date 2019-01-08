---
author: Adam Kawik
comments: true
date: 2014-08-08 07:46:12+00:00
extends: _layouts.post
link: https://itcraftsman.pl/testy-automatyczne-interfejsu-uzytkownika-przy-uzyciu-selenium-ide/
slug: testy-automatyczne-interfejsu-uzytkownika-przy-uzyciu-selenium-ide
title: Testy automatyczne interfejsu użytkownika przy użyciu Selenium IDE
wordpress_id: 136
categories:
- Testy automatyczne
tags:
- Automation
- C#
- IDE
- Selenium
- Tests
---

**O narzędziu słów kilka.**

Selenium IDE to potężne narzędzie służące do skutecznego i szybkiego przeprowadzania testów automatycznych naszych aplikacji webowych lub normalnych stron WWW. Tkwi w nim potężny potencjał, który pozwala nam na uzyskanie pewnej niezawodności w wykonywanych i powtarzanych czynnościach (bo przecież dobrze zaprogramowana maszyna nie popełnia błędów) oraz oszczędności czasu, który możemy efektownie spożytkować na inne zadania.

Jest to chyba dotąd najlepsze darmowe narzędzie do wykonywania automatyzacji, dostępne dla każdego. W internecie na oficjalnej stronie wydawcy [https://www.seleniumhq.org/](https://www.seleniumhq.org/), w dziale download możemy znaleźć różnorodne pliki, które możemy za darmo pobrać i wykorzystać w naszej pracy, a które postaram się zaprezentować Wam w kolejnych wpisach.

Dzisiaj chciałbym skupić się na tym pierwszym - jest nim Selenium IDE, czyli wtyczka dedykowana do Firefoxa (i niestety tylko dla niego), którą instaluje się do naszej przeglądarki z poziomu plugin managera bądź ręcznie z linka strony producenta [https://release.seleniumhq.org/selenium-ide/2.5.0/selenium-ide-2.5.0.xpi](https://release.seleniumhq.org/selenium-ide/2.5.0/selenium-ide-2.5.0.xpi). Po zainstalowaniu odpowiedniej wtyczki, nasze narzędzie pojawi się w naszej przeglądarce w zakładce narzędzia na samym dole.

[![](/assets/img/posts/2014/selenium1.png)](/assets/img/posts/2014/selenium1.png)

**Opis Struktura interfejsu.**

Zobaczymy teraz co siedzi w środku. Po kliknięciu w przycisk Selenium IDE naszym oczom ukarze się wtyczka w całej, swojej okazałości. Na pierwszy rzut oka widać, że to nic skomplikowanego - macie rację! Zaraz postaram się pokrótce opisać Wam działanie tego narzędzia wraz z wszystkim dostępnymi opcjami.

[![2](/assets/img/posts/2014/selenium2.png)](/assets/img/posts/2014/selenium2.png)



Pewnie jesteście ciekawi jak to działa? Już tłumaczę. Zacznijmy od samej góry.** Base URL** to miejsce na adres bazowy strony, którą zamierzamy testować np. www.itcraftsman.pl. Może to być dowolna strona widniejąca w internecie lub nasz localhost.

[![3](/assets/img/posts/2014/selenium31.png)](/assets/img/posts/2014/selenium31.png)

Niżej, w lewym, górnym rogu widzimy **speed slider**, którym możemy kontrolować szybkość wykonywania poszczególnych testów. Slow - wolno a Fast - szybko. Ta opcja przyda nam się w przypadku tworzenia testów i kontrolowania czy faktycznie wszystko przebiegło dobrze.

Idąc dalej, na prawo od suwaka szybkości znajdują się przyciski kontroli, przy użyciu których uruchamiamy nagrane testy bądź wybraną grupę testów, zatrzymujemy wykonywanie testów w dowolnym momencie, ikonkę w kształcie entera, która pozwala nam na krokowe wykonywanie testu tak samo jak w przypadku debbugera. Kolejno widzimy fioletowy ślimak - **Rollup, **który służy do grupowania dowolnej liczby poleceń w jedną całość, podobnie jak w przypadku metod, które w swoim ciele zawierają różnego rodzaju sekwencję kodu, które możemy w każdej chwili wykorzystać przy użyciu wywołania jednej nazwy.

W prawym górnym rogu, pod Base URL znajduje się czerwona kropka, czyli **Record Button**, jest to chyba najważniejszy i najczęściej używany przycisk w całym IDE, służący do rozpoczęcie i zakończenia nagrywania poszczególnych kroków testu.

Następnym bardzo istotnym elementem jest sekcja **Test Case**. Zawiera ona wszystkie nagrane przez nas przypadki testowe, co pozwala na dokładną dokumentację i kontrolę zmian. Tak samo jak w przypadku testów jednostkowych powinniśmy się starać pisać jeden test dla jednej testowanej funkcjonalności, tak samo jest tutaj, chodź zawsze możemy nagrywać wszystko tylko dla jednego testowanego przypadku. Każdy test case może posiadać dowolną nazwę.

Na dole widzimy licznik testów, które udało nam się utworzyć przy użyciu Selenium IDE wraz z liczbą testów, które nie powiodły się.

[![4](/assets/img/posts/2014/selenium4.png)](/assets/img/posts/2014/selenium4.png)

Następnie widzimy duże puste pole **Table**. W nim będziemy mogli ręcznie deklarować poszczególne komendy, które mają zostać wykonywane automatycznie przez IDE. Tych komend jest bardzo dużo i opisywanie wszystkich zajęło by mi tutaj mnóstwo czasu, dlatego ciekawych zachęcam do zaglądania do dokumentacji (dostępnej [tutaj](https://docs.seleniumhq.org/docs/02_selenium_ide.jsp#commonly-used-selenium-commands)).

[![5](/assets/img/posts/2014/selenium5.png)](/assets/img/posts/2014/selenium5.png)



[![6](/assets/img/posts/2014/selenium6.png)](/assets/img/posts/2014/selenium6.png)

Oczywiście nie będziemy musieli niczego wypełniać ręcznie. Selenium podczas nagrywania sam wygeneruje kod w wybranym przez nas języku i sporządzi listę potrzebnych komend wymaganych do zrealizowania testu.

Oprócz tego na dole, znajduje się kilka ciekawych zakładek, które służą głównie do zwracania błędów, podpowiadania składni tworzonych komend i deklarowania rollupów o których wspominałem wcześniej.

[![7](/assets/img/posts/2014/selenium7.png)](/assets/img/posts/2014/selenium7.png)



Teraz zajmiemy się czymś bardzo ważnym, czyli wyborem języków w jakim chcemy nasz test sobie wygenerować. Przed rozpoczęciem pracy z naszym IDE musimy pamiętać aby w zakładce opcje, zaznaczyć sobie **"Enable experimental features"** czyli włącz funkcjonalności eksperymentalne. Aktywowanie tej opcji pozwoli nam na generowanie testów w wielu językach.

[![8](/assets/img/posts/2014/selenium8.png)](/assets/img/posts/2014/selenium8.png)

Jeśli już mowa o językach to rzućmy okiem na zakładkę **Format** znajdującą się również w Opcjach. Tutaj możemy wybierać języki w których nasze testy będą generowane, które później możemy przenieść do naszego SDK i dokonać odpowiedniego refaktoringu, ponieważ kod wygenerowany automatycznie jak to zwykle bywa, nie jest kodem idealnym. Domyślnie nasze IDE generuje testy w języku HTML.

[![9](/assets/img/posts/2014/selenium9.png)](/assets/img/posts/2014/selenium9.png)

Oprócz tego zwróćmy również uwagę na te napisy znajdujące się na prawo od nazwy języka takie jak np:

C# / NUnit / WebDriver

Mówią nam one o tym dla jakiej biblioteki ten test zostanie wygenerowany domyślnie, czyli w tym przypadku dla NUnita, ale nie martwmy się tym, gdyż możemy spokojnie zrefaktoryzować nasz kod aby działał z dowolną biblioteką.

Następnie patrząc na trzeci człon możemy dostrzec kilka różnych opcji takich jak **WebDriver, Remote Control czy Web Driver Backed. **Świadczą one o rodzaju sterownika, dla którego zostanie dany test wygenerowany. Ale nie zawracajmy sobie tym teraz głowy. Może pora na jakiś praktyczny przykład.

**Więc jak na prawdę to działa?**

Powiedzmy, że chcemy potestować sobie chyba każdemu znaną stronę Wikipedia.pl

Uruchamiamy nasze IDE, wybieramy język, w którym chcemy generować test, ja wybiorę C# / NUnit / Web Driver i zaznaczamy czerwoną kropkę nagrywania. Od teraz wszystkie nasze czynności wykonywane w przeglądarce Firefox będą rejestrowane i na ich podstawie Selenium IDE dokona generowania kodu.

W oknie przeglądarki wpisujemy adres strony Wikipedia.pl, przechodzimy po zakładkach, wpisujemy jakiś tekst do pola wyszukiwania. Bawimy się. Możemy sprawdzać na bieżąco, że nasze IDE generuje cały czas nowe linie kodu. Cały wygenerowany kod znajduje się w zakładce **Source**. Możemy go sobie w każdej chwili skopiować, zapisać prosto do pliku .cs bądź edytować w locie.

[![10](/assets/img/posts/2014/10.png)](/assets/img/posts/2014/10.png)

Cały kod możecie zobaczyć tutaj. Postaram się go krótko wyjaśnić, gdyż bardziej dokładnie zrozumiecie go podczas zabawy z Selenium Web Driver.

```cs
using System;
using System.Text;
using System.Text.RegularExpressions;
using System.Threading;
using NUnit.Framework;
using OpenQA.Selenium;
using OpenQA.Selenium.Firefox;
using OpenQA.Selenium.Support.UI;

namespace SeleniumTests { [TestFixture]
	public class Untitled {
		private IWebDriver driver;
		private StringBuilder verificationErrors;
		private string baseURL;
		private bool acceptNextAlert = true;

		[SetUp]
		public void SetupTest() {
			driver = new FirefoxDriver();
			baseURL = "https://wikipedia.pl/";
			verificationErrors = new StringBuilder();
		}

		[TearDown]
		public void TeardownTest() {
			try {
				driver.Quit();
			} catch(Exception) {
				// Ignore errors if unable to close the browser
			}
			Assert.AreEqual("", verificationErrors.ToString());
		}

		[Test]
		public void TheUntitledTest() {
			driver.Navigate().GoToUrl(baseURL + "//");
			driver.FindElement(By.Id("lang-pl")).Click();
			driver.FindElement(By.Id("txtSearch")).Clear();
			driver.FindElement(By.Id("txtSearch")).SendKeys("selenium");
			driver.FindElement(By.Id("cmdSearch")).Click();
			driver.FindElement(By.LinkText("Selen")).Click();
			driver.FindElement(By.XPath("//div[@id='toc']/ul/li[7]/a/span[2]")).Click();
		}
		private bool IsElementPresent(By by) {
			try {
				driver.FindElement(by);
				return true;
			} catch(NoSuchElementException) {
				return false;
			}
		}

		private bool IsAlertPresent() {
			try {
				driver.SwitchTo().Alert();
				return true;
			} catch(NoAlertPresentException) {
				return false;
			}
		}

		private string CloseAlertAndGetItsText() {
			try {
				IAlert alert = driver.SwitchTo().Alert();
				string alertText = alert.Text;
				if (acceptNextAlert) {
					alert.Accept();
				} else {
					alert.Dismiss();
				}
				return alertText;
			} finally {
				acceptNextAlert = true;
			}
		}
	}
}
```

Tak więc naszym oczom ukazała się klasa o domyślnej nazwie z wygenerowaną zawartością. Zawiera różnego rodzaju metody, oraz zmienne. Nad tymi metodami znajdują się różnego rodzaju dopiski domyślne dla biblioteki dotNetowej NUnit. Każda z nich odpowiada za inne czynności podczas, przed lub po wykonywaniu testu. Nie chcę tutaj tłumaczyć Wam całego NUnita ponieważ nie jest on przedmiotem naszych dzisiejszych rozważań. Postaram się tylko wyjaśnić w kilku słowach czym te prefiksy są.

**[TestFixture]** - oznacza klasę która jest testowana

**[SetUp]** - oznacza czynności, które wykonują się przed wykonywanie testu, zwykle może to być przygotowywanie środowiska, konfigurowanie drivera, inicjowanie zmiennych loga itp.

**[TearDown]** - oznacza czynności wykonywane po teście. Może to być zamykanie przeglądarki, czyszczenie bazy danych, usuwanie śmieci itp.

**[Test]** - to nasza perełka. Oznacza nasz właściwy test. Musimy pamiętać, że każdy test ( każda metoda ) musi zawierać nad sobą odpowiednią dyrektywę [Test]. W porównaniu do poprzedników takich dyrektyw będzie tyle ile testów. Poprzednie znaczniki nie mogą się powtarzać.

Reszta metod widocznych na dole nie jest w tej chwili istotna. Skupmy się teraz na samym teście wygenerowanym przez IDE.

```cs
 [Test]
 public void TheUntitledTest()
 {
     driver.Navigate().GoToUrl(baseURL + "//");
     driver.FindElement(By.Id("lang-pl")).Click();
     driver.FindElement(By.Id("txtSearch")).Clear();
     driver.FindElement(By.Id("txtSearch")).SendKeys("selenium");
     driver.FindElement(By.Id("cmdSearch")).Click();
     driver.FindElement(By.LinkText("Selen")).Click();
     driver.FindElement(By.XPath("//div[@id='toc']/ul/li[7]/a/span[2]")).Click();
 }
```

Zawiera on deklarację poszczególnych kroków, które ręcznie wykonywaliśmy przy użyciu myszy. Selenium IDE korzysta z metod Web Drivera, z jego klas i zmiennych. Każda z tych metoda tak jak np. **FindElement **przyjmuje odpowiednie parametry elementu DOM struktury strony HTMLa i lokalizuje je za pomocą znanych nam parametrów takich jak ID, XPath, CSSSelector, TagName, Class, LinkText itd. Parametry tych elementów najlepiej uzyskać poprzez  inspekcję wybranego elementu przy użyciu wbudowanych narzędzi przeglądarki lub skorzystać z **FireBuga**.

Pamiętajmy również, że tego typu wygenerowany kod, może być odtwarzany w IDE automatycznie po kliknięciu przycisku Play. Zobaczymy te same czynności, które ręcznie wykonywaliśmy, w zadanym przez nas czasie.

Na dzisiaj tyle. W następnym wpisie skupimy się na podejściu czysto programistycznym czyli Selenium Web Driver, gdzie praktycznie wyjaśnimy sobie działanie tej biblioteki.


