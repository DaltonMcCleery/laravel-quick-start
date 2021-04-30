<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($pages as $page)
        <url>
            @if ($page->slug === 'home')
                <loc>{{ config('app.url') }}</loc>
            @else
                <loc>{{ config('app.url') }}/{{ $page->page_slug }}</loc>
            @endif
            @if ($page->page_date)
                <lastmod>{{ $page->page_date->tz('UTC')->toAtomString() }}</lastmod>
            @else
                <lastmod>{{ $page->created_at->tz('UTC')->toAtomString() }}</lastmod>
            @endif
            <changefreq>weekly</changefreq>
            <priority>0.5</priority>
        </url>
    @endforeach
</urlset>
