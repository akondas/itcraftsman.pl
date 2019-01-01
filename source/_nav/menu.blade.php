<nav class="hidden lg:flex items-center justify-end text-lg">
    <a title="{{ $page->siteName }} Blog" href="/blog"
        class="ml-6 text-grey-darker hover:text-blue-dark {{ $page->isActive('/blog') ? 'active text-blue-dark' : '' }}">
        Blog
    </a>

    <a title="{{ $page->siteName }} About" href="/o-mnie"
        class="ml-6 text-grey-darker hover:text-blue-dark {{ $page->isActive('/o-mnie') ? 'active text-blue-dark' : '' }}">
        O mnie
    </a>
</nav>
