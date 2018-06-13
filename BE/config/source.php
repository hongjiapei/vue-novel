<?php
/**
 * Created by PhpStorm.
 * User: hongjiapei
 * Date: 2018/6/1
 * Time: 9:06
 */

/**
 * 小说源，暂时放在配置文件
 */
return [
    // 笔趣阁(m.biquge5200.cc)
    '001' => [
        'website' => 'm.biquge5200.cc',
        // 所有分类页
        'categories' => [
            'website' => 'm.biquge5200.cc/sort.html',
            'rules' => [
                'category_name' => ['.content a', 'text'],
                'category_url' => ['.content a', 'href']
            ]
        ],
        // 分类下书的列表页
        'lists' => [
            'rules' => [
                'book_name' => ['.line a:nth-child(2)', 'text'],
                'book_url' => ['.line a:nth-child(2)', 'href'],
                'book_author' => ['.line a:nth-child(3)', 'text'],
                'first_url' => ['.page a:contains("首页")','href'],
                'prev_url' => ['.page a:contains("上页")','href'],
                'next_url' => ['.page a:contains("下页")','href'],
                'last_url' => ['.page a:contains("尾页")','href'],
            ]
        ],
        // 某本书的详情页
        'detail' => [
            'rules' => [
                'book_name' => ['.block_txt2>h2>a', 'text'],
                'book_description' => ['.intro_info', 'html'],
                'get_chapters_url' => ['.ablum_read>span>a:contains("查看目录")', 'href'],
            ]
        ],
        // 书的章节列表页
        'chapters' => [
            'rules' => [
                'chapter_name' => ['.chapter>li>a', 'text'],
                'get_chapterDetail_url' => ['.chapter>li>a', 'href'],
                'first_url' => ['.page a:contains("首页")','href'],
                'prev_url' => ['.page a:contains("上一页")','href'],
                'next_url' => ['.page a:contains("下一页")','href'],
                'last_url' => ['.page a:contains("尾页")','href'],
            ]
        ],
        // 章节内容页
        'chapterDetail' => [
            'rules' => [
                'chapter_name' => ['.title', 'text'],
                'chapter_content' => ['div.text', 'html'],
                'get_chapters_url' => ['.navigator-nobutton>ul>li>a:contains("目录")','href'],
                'prev_url' => ['.navigator-nobutton>ul>li>a:contains("上一页")','href'],
                'next_url' => ['.navigator-nobutton>ul>li>a:contains("下一章")','href'],
            ]
        ],
        // 搜索
        'search' => [
            'website' => 'm.biquge5200.cc/modules/article/waps.php?keyword=',
            'rules' => [
                'book_name' => ['.line a:nth-child(2)', 'text'],
                'book_url' => ['.line a:nth-child(2)', 'href'],
                'book_author' => ['.line a:nth-child(3)', 'text'],
            ],
        ]
    ],

    // 三七中文(m.37zw.net)
    '002' => [
        'website' => 'm.37zw.net',
        // 所有分类页
        'categories' => [
            'website' => 'm.37zw.net/sort/',
            'rules' => [
                'category_name' => ['.content a', 'text'],
                'category_url' => ['.content a', 'href']
            ]
        ],
        // 分类下书的列表页
        'lists' => [
            'rules' => [
                'book_name' => ['.line a:nth-child(2)', 'text'],
                'book_url' => ['.line a:nth-child(2)', 'href'],
                'book_author' => ['.line', 'text'],
                'first_url' => ['.page a:contains("首页")','href'],
                'prev_url' => ['.page a:contains("上页")','href'],
                'next_url' => ['.page a:contains("下页")','href'],
                'last_url' => ['.page a:contains("尾页")','href'],
            ]
        ],
        // 某本书的详情页
        'detail' => [
            'rules' => [
                'book_name' => ['.block_txt2>h2>a', 'text'],
                'book_description' => ['.intro_info', 'html'],
                'get_chapters_url' => ['.book_more>a', 'href'],
            ]
        ],
        // 书的章节列表页
        'chapters' => [
            'rules' => [
                'chapter_name' => ['.chapter>li>a', 'text'],
                'get_chapterDetail_url' => ['.chapter>li>a', 'href'],
                'first_url' => ['.middle>select>option:first-child','value'],
                'prev_url' => ['.listpage a:contains("上一页")','href'],
                'next_url' => ['.listpage a:contains("下一页")','href'],
                'last_url' => ['.middle>select>option:last-child','value'],
            ]
        ],
        // 章节内容页
        'chapterDetail' => [
            'rules' => [
                'chapter_name' => ['#nr_title', 'text'],
                'chapter_content' => ['#nr1', 'html'],
                'get_chapters_url' => ['#pb_mulu','href'],
                'prev_url' => ['#pb_prev','href'],
                'next_url' => ['#pb_next','href'],
            ]
        ],
        // 搜索
        'search' => [
            'website' => 'm.37zw.net/s/so.php?type=articlename&s=',
            'rules' => [
                'book_name' => ['.line a:nth-child(2)', 'text'],
                'book_url' => ['.line a:nth-child(2)', 'href'],
                'book_author' => ['.line', 'text'],
            ],
        ]
    ],


];