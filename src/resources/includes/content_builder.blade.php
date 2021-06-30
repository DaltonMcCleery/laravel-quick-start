@if(!empty($content))
    @foreach ($content as $content_item)
        <x:page-builder-component :componentData="$content_item" :loop="$loop->index"/>
    @endforeach
@endif
