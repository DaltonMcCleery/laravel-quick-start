<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('includes.layout.header')
    <body>
        @production
            <!-- Google Tag Manager (noscript) -->
        @endproduction

        <span id="scroll-to-top"></span>

        <x:promo-banner />
        <header role="banner">
            @include('includes.layout.navigation')
        </header>

        <main id="body" role="main">
            @yield('content')
            @yield('second-content')

            @include('includes.layout.footer')
        </main>

        @include('includes.layout.scripts')

        @auth
            <a id="edit-page" href="{{ url('/manage/resources/pages/'.$page->id.'/edit?viaResource&viaResourceId&viaRelationship') }}">
                EDIT THIS PAGE
            </a>
        @endauth
    </body>

</html>
