<?php

return [
    'baseUrl' => '',
    'production' => false,
    'siteName' => 'itcraftsman.pl',
    'siteDescription' => 'Blog programisty rzemieślnika o programowaniu',
    'siteAuthor' => 'Arkadiusz Kondas',

    // collections
    'collections' => [
        'posts' => [
            'author' => 'Arkadiusz Kondas', // Default author, if not provided in a post
            'sort' => '-date',
            'path' => '{filename}',
        ],
        'categories' => [
            'path' => '/category/{filename}',
            'posts' => function ($page, $allPosts) {
                return $allPosts->filter(function ($post) use ($page) {
                    return $post->categories ? in_array($page->getFilename(), array_map(function(string $category) use ($page) {
                        return $page->getSlug($category);
                    }, $post->categories), true) : false;
                });
            },
        ],
    ],

    // helpers
    'withTags' => function($allPosts) {
        dd(count($allPosts));
    },
    'getDate' => function($page) {
        return strftime('%d %B %Y', $page->date);
    },
    'excerpt' => function ($page, $length = 255) {
        $cleaned = strip_tags(
            preg_replace(['/<pre>[\w\W]*?<\/pre>/', '/<h\d>[\w\W]*?<\/h\d>/'], '', str_replace('<!-- more -->', 'READMORE', $page->getContent())),
            '<code>'
        );

        $readMore = strpos($cleaned, 'READMORE');
        if($readMore !== false) {
            $truncated = substr($cleaned, 0, $readMore);
        } else {
            $truncated = substr($cleaned, 0, $length);
        }

        if (substr_count($truncated, '<code>') > substr_count($truncated, '</code>')) {
            $truncated .= '</code>';
        }

        return strlen($cleaned) > $length
            ? preg_replace('/\s+?(\S+)?$/', '', $truncated) . '...'
            : $cleaned;
    },
    'isActive' => function ($page, $path) {
        return ends_with(trimPath($page->getPath()), trimPath($path));
    },
    'getSlug' => function($page, $title) {
        return (new \Cocur\Slugify\Slugify())->slugify($title);
    }
];
