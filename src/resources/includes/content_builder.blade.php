@if(!empty($content))
    @foreach ($content as $content_item)
        <x:dynamic-component :component="$content_item->layout" :componentData="$content_item"/>
    @endforeach
@endif
