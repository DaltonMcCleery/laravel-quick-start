<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($pages as $page)
        @if($page->product)
            <url>
                <loc>https://brownequipment.net{{ $page->product->renderUrl() }}</loc>
                <lastmod>{{ $page->created_at->tz('UTC')->toAtomString() }}</lastmod>
                <changefreq>weekly</changefreq>
                <priority>0.6</priority>
            </url>
        @else
            <url>
                @if ($page->slug === 'home')
                    <loc>https://brownequipment.net/</loc>
                @else
                    <loc>https://brownequipment.net{{ $page->renderUrl() }}</loc>
                @endif
                @if ($page->page_date)
                    <lastmod>{{ $page->page_date->tz('UTC')->toAtomString() }}</lastmod>
                @else
                    <lastmod>{{ $page->created_at->tz('UTC')->toAtomString() }}</lastmod>
                @endif
                <changefreq>weekly</changefreq>
                <priority>0.5</priority>
            </url>
        @endif
    @endforeach
</urlset>
