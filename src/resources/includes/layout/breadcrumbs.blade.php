<div id="breadcrumbs" class="contained tight">
    <div class="breadcrumbs">
        <ul>
            <li>
                <a href="/">Home</a>
            </li>
            @if($page->parent)
                <li>
                    <a href="{{ $page->parent->page_slug }}">{{ $page->parent->name }}</a>
                </li>
            @endif
            <li>
                <a href="{{ $page->page_slug }}">{{ $page->name }}</a>
            </li>
        </ul>
    </div>
</div>
