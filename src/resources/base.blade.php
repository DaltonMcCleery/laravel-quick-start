<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('includes.layout.header')
    <body>
        @production
            <!-- Google Tag Manager (noscript) -->
        @endproduction

        <span id="scroll-to-top"></span>

        <x:promo-banner />
        <header>
            @include('includes.layout.navigation')
        </header>

        <div id="body">
            @yield('content')
            @yield('second-content')

            @include('includes.layout.footer')
        </div>

        @include('includes.layout.scripts')

        @auth
            <a id="edit-page" href="{{ url('/manage/resources/pages/'.$page->id.'/edit?viaResource&viaResourceId&viaRelationship') }}">
                EDIT THIS PAGE
            </a>
        @endauth
    </body>

</html>
