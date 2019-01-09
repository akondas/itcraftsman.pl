@extends('_layouts.master')

@push('meta')
    <meta property="og:title" content="About {{ $page->siteName }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ $page->getUrl() }}"/>
    <meta property="og:description" content="A little bit about {{ $page->siteName }}" />
@endpush

@section('body')
    <div class="text-justify">
    <h1>O mnie</h1>

    <img src="/assets/img/arek.jpg"
        alt="About image"
        class="flex rounded-full h-64 w-64 bg-contain mx-auto md:float-right my-6 md:ml-10">

    <p class="mb-6">
        Witaj, nazywam się Arkadiusz Kondas i z zawodu jestem architektem oprogramowania. Moją uwagę skupiam głównie na PHP w parze z PostgresSQL/MySQL, oraz od jakiegoś czasu Machine Learningu, ale nie zamykam się na inne tematy/technologie.
        </p>

        <p class="mb-6">Zawodowo zajmuję się programowaniem od ponad 11 lat. Przez ten czas poznałem parę ciekawych framework’ów PHP: Kohana, Zend Framework 2, Laravel, Phalcon oraz Symfony. Od jakiegoś czasu jestem również przedsiębiorcą. Bycie właścicielem jednoosobowej firmy otwiera nowe perspektywy, ale wymaga też innego rodzaju pracy.</p>

        <p class="mb-6">Więcej o moim profilu zawodowym, zdobytych certyfikatach i odbytych szkoleniach możesz znaleźć na moim profilu LinkedIn: <a href="https://www.linkedin.com/in/arkadiuszkondas/" target="_blank">https://www.linkedin.com/in/arkadiuszkondas/</a></p>

    <p class="mb-6">
        Od trzech lat jestem również zapalonym biegaczem i uwielbiam dystansy ultra. Biorąc to wszystko pod uwagę, jak można się domyślić, mam ograniczoną ilość czasu dlatego w pracy skupiam się na produktywności.
    </p>

    <h2>Powody dla których piszę</h2>

    <p class="mb-6">Oto kilka podstawowych powodów dlaczego postanowiłem prowadzić tego bloga oraz które motywują mnie do pisania:

        <ul>
            <li>W naszej branży jest sporo gównokodu, którego chcę się pozbyć</li>
            <li>Lubię i chcę pomagać innym, może to jest banał ale wierzę że komuś się przydam 🙂</li>
            <li>Posiadam pewną porcję wiedzy oraz doświadczenia i chcę się nią dzielić. Często w pracy tłumaczyłem znajomym jak coś działa a potem łapałem się na tym że tłumaczę po raz któryś to samo. Teraz będą mogli przeczytać o tym sami o każdej porze dnia (gorąca Was pozdrawiam).
            <li>Jedna z moich zasad to: nigdy nie przestawaj się uczyć. Pisząc dla Ciebie czytelniku poznaję nowe rzeczy.</li>
            <li>Od zawsze chciałem mieć bloga tylko nigdy nie wiedziałem na czym się skupić. Pisząc o programowaniu mogę łączyć moją pasję i zdobywać nowe doświadczenia</li>
            <li>Lubię wyzwanie a ten blog jest jednym z nich i to nie małym …</li>
        </ul>
    </p>

    <p class="mb-6">
        Na koniec drobna uwaga: nie uważam się za guru programowania. Koduję bo lubię i sprawi mi to olbrzymią przyjemność. Jeżeli to jest możliwe to chciałbym uczynić programowanie jeszcze lepszym i łatwiejszym. Jeżeli cokolwiek na tym blogu pomoże Tobie stać się lepszym programistą to proszę powiedz mi o tym. Będzie to świetna motywacja do powstania kolejnych wpisów. Możesz również kwestionować moją twórczość w komentarza, do czego gorąco zachęcam.
    </p>

    <p class="mb-6">
        Pozdrawiam<br />
        Arkadiusz Kondas</p>
    </div>
@endsection
