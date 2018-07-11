<?= '<'.'?'.'xml version="1.0" encoding="UTF-8"?>'."\n" ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">

    @foreach ($urlset as $set)
        <url>
            @if (! empty($set['loc']))
                <loc>{{ $set['loc'] }}</loc>
            @endif

            @if (! empty($set['lastmod']))
                <lastmod>{{ $set['lastmod'] }}</lastmod>
            @endif

            @if (! empty($set['changefreq']))
                <changefreq>{{ $set['changefreq'] }}</changefreq>
            @endif

            @if (! empty($set['priority']))
                <priority>{{ $set['priority'] }}</priority>
            @endif
        </url>
    @endforeach

</urlset>