<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="{{ $page->meta_description or $page->siteDescription }}">

        <meta property="og:title" content="{{ $page->title ?  $page->title . ' | ' : '' }}{{ $page->siteName }}"/>
        <meta property="og:type" content="website" />
        <meta property="og:url" content="{{ $page->getUrl() }}"/>
        <meta property="og:description" content="{{ $page->siteDescription }}" />

        <title>{{ $page->siteName }}{{ $page->title ? ' | ' . $page->title : '' }}</title>

        <link rel="home" href="{{ $page->baseUrl }}">
        <link rel="icon" href="/favicon.ico">
        <link href="/blog/feed.atom" type="application/atom+xml" rel="alternate" title="{{ $page->siteName }} Atom Feed">

        @stack('meta')

        @if ($page->production)
            <!-- Global site tag (gtag.js) - Google Analytics -->
                <script async src="https://www.googletagmanager.com/gtag/js?id=UA-52176613-2"></script>
                <script>
                    window.dataLayer = window.dataLayer || [];
                    function gtag(){dataLayer.push(arguments);}
                    gtag('js', new Date());

                    gtag('config', 'UA-52176613-2');
                </script>
            @endif

        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,300i,400,400i,700,700i,800,800i" rel="stylesheet">
        <link rel="stylesheet" href="{{ mix('css/main.css', 'assets/build') }}">
    </head>

    <body class="flex flex-col justify-between min-h-screen bg-grey-lightest text-grey-darkest leading-normal font-sans">
        <div id="vue-app">
            <header class="flex items-center shadow bg-white border-b h-24 py-4" role="banner">
                <div class="container flex items-center max-w-4xl mx-auto px-4 lg:px-8">
                    <div class="flex items-center">
                        <div class="flex flex-col">
                        <a href="/" title="{{ $page->siteName }} home" class="inline-flex items-center">
                            <img class="h-8 md:h-10 mr-3" src="/assets/img/logo.svg" alt="{{ $page->siteName }} logo" />

                            <h1 class="text-lg md:text-2xl text-blue-darkest font-semibold hover:text-blue-dark my-0">{{ $page->siteName }}</h1>
                        </a>
                        <p class="inline-flex m-0 pt-2">{{ $page->siteDescription  }}</p>
                        </div>
                    </div>

                    <div class="flex flex-1 justify-end items-center">
                        <search></search>

                        @include('_nav.menu')

                        @include('_nav.menu-toggle')
                    </div>
                </div>
            </header>

            @include('_nav.menu-responsive')

            <main role="main" class="flex-auto w-full container max-w-xl mx-auto py-16 px-6">
                @yield('body')
            </main>
        </div>

        <script src="{{ mix('js/main.js', 'assets/build') }}"></script>

        @stack('scripts')

        <footer class="bg-white text-center text-sm mt-12 py-4" role="contentinfo">
            <div class="container mx-auto">
                <div class="flex justify-between">
                    <ul class="list-reset">
                        <li class="md:mr-2">
                            &copy; <a href="https://arkadiuszkondas.com" title="Software architect">Arkadiusz Kondas</a> 2014 - {{ date('Y') }}.
                        </li>

                        <li>
                            Built with <a href="http://jigsaw.tighten.co" title="Jigsaw by Tighten">Jigsaw</a>
                            and <a href="https://tailwindcss.com" title="Tailwind CSS, a utility-first CSS framework">Tailwind CSS</a>.
                        </li>
                    </ul>
                    @include('_components.newsletter-signup')
                </div>

            </div>
        </footer>
    </body>
</html>
