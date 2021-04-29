<div id="breadcrumbs" class="contained tight">
    <div class="breadcrumbs">
        <ul>
            <li>
                <a href="/">Home</a>
            </li>
            @if($page->parent)
                <li>
                    <a href="{{ '/'.$page->parent->slug }}">{{ $page->parent->name }}</a>
                </li>
            @endif
            <li>
                <a href="{{ $page->renderUrl() }}">{{ $page->name }}</a>
            </li>
        </ul>
    </div>
</div>
