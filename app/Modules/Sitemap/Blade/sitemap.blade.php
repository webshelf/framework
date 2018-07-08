<?= '<'.'?'.'xml version="1.0" encoding="UTF-8"?>'."\n" ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
    <url>
        <loc>http://example.test</loc>
        {{--@if (! empty($tag->url))--}}
            {{--<loc>{{ $tag->url }}</loc>--}}
        {{--@endif--}}

        {{--@if (count($tag->alternates))--}}
            {{--@foreach ($tag->alternates as $alternate)--}}
                {{--<xhtml:link rel="alternate" hreflang="{{ $alternate->locale }}" href="{{ $alternate->url }}" />--}}
            {{--@endforeach--}}
        {{--@endif--}}

        {{--@if (! empty($tag->lastModificationDate))--}}
            {{--<lastmod>{{ $tag->lastModificationDate->format(DateTime::ATOM) }}</lastmod>--}}
        {{--@endif--}}

        {{--@if (! empty($tag->changeFrequency))--}}
            {{--<changefreq>{{ $tag->changeFrequency }}</changefreq>--}}
        {{--@endif--}}

        {{--@if (! empty($tag->priority))--}}
            {{--<priority>{{ $tag->priority }}</priority>--}}
        {{--@endif--}}
    </url>
</urlset>