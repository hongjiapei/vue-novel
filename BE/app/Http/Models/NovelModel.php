<?php

namespace App\Http\Models;

use QL\QueryList;

class NovelModel
{
    /**
     * 获取小说分类
     * @param array $params
     * @return array
     */
    public static function categories ($params=[])
    {
        if (!isset($params['website']) || !isset($params['rules'])) return [];
        $categories = QueryList::get($params['website'])->rules($params['rules'])->removeHead()->encoding('UTF-8')->query()->getData()->all();
        //截取根网址
        $website_root = explode('/',$params['website'])[0];
        // 如果不用过滤则直接返回
        if (!isset($params['filter']) || !is_array($params['filter'])) {
            return array_map(function ($m) use ($website_root) {
                $m['category_url'] = $website_root.$m['category_url'];
                return $m;
            },$categories);
        }

        $results = [];
        foreach ($categories as $category) {
            if (!in_array($category['name'],$params['filter'])) array_push($results,$category);
        }
        return array_map(function ($m) use ($website_root) {
            $m['category_url'] = $website_root.$m['category_url'];
            return $m;
        },$results);
    }

    /**
     * 获取指定分类下 小说列表
     * @param array $params
     * @return array
     */
    public static function lists ($params=[])
    {
        if (!isset($params['website']) || !isset($params['rules'])) return [];
        $lists = QueryList::get($params['website'])->rules($params['rules'])->removeHead()->encoding('UTF-8')->query()->getData()->all();
        if (!$lists) return $lists;
        //截取根网址
        $website_root = explode('/',$params['website'])[0];
        return array_map(function ($m) use ($website_root) {
            $m['book_url'] = $website_root.$m['book_url'];
            if (isset($m['first_url'])) $m['first_url'] = $website_root.$m['first_url'];
            if (isset($m['prev_url'])) $m['prev_url'] = $website_root.$m['prev_url'];
            if (isset($m['next_url'])) $m['next_url'] = $website_root.$m['next_url'];
            if (isset($m['last_url'])) $m['last_url'] = $website_root.$m['last_url'];
            return $m;
        },$lists);
    }

    /**
     * 获取小说详情
     * @param array $params
     * @return array
     */
    public static function detail ($params=[])
    {
        if (!isset($params['website']) || !isset($params['rules'])) return [];
        $detail = QueryList::get($params['website'])->rules($params['rules'])->removeHead()->encoding('UTF-8')->query()->getData()->all();
        if (!$detail) return $detail;
        $detail = $detail[0];
        //截取根网址
        $website_root = explode('/',$params['website'])[0];
        $detail['get_chapters_url'] = $website_root.$detail['get_chapters_url'];
        return $detail;
    }

    /**
     * 获取小说章节列表
     * @param array $params
     * @return array
     */
    public static function chapters ($params=[])
    {
        if (!isset($params['website']) || !isset($params['rules'])) return [];
        $chapters = QueryList::get($params['website'])->rules($params['rules'])->removeHead()->encoding('UTF-8')->query()->getData()->all();
        if (!$chapters) return $chapters;
        //截取根网址
        $website_root = explode('/',$params['website'])[0];
        return array_map(function ($m) use ($website_root) {
            $m['get_chapterDetail_url'] = $website_root.$m['get_chapterDetail_url'];
            if (isset($m['first_url'])) $m['first_url'] = $website_root.$m['first_url'];
            if (isset($m['prev_url'])) $m['prev_url'] = $website_root.$m['prev_url'];
            if (isset($m['next_url'])) $m['next_url'] = $website_root.$m['next_url'];
            if (isset($m['last_url'])) $m['last_url'] = $website_root.$m['last_url'];
            return $m;
        },$chapters);
    }

    /**
     * 获取小说章节详情
     * @param array $params
     * @return array
     */
    public static function chapterDetail ($params=[])
    {
        if (!isset($params['website']) || !isset($params['rules'])) return [];
        $detail = QueryList::get($params['website'])->rules($params['rules'])->removeHead()->encoding('UTF-8')->query()->getData()->all();
        if (!$detail) return $detail;
        $detail = $detail[0];
        //截取根网址
        $website_root = explode('/',$params['website'])[0];
        $detail['get_chapters_url'] = $website_root.$detail['get_chapters_url'];
        $detail['prev_url'] = $website_root.$detail['prev_url'];
        $detail['next_url'] = $website_root.$detail['next_url'];
        return $detail;
    }

    /**
     * 搜索小说
     * @param array $params
     * @return array
     */
    public static function search ($params=[])
    {
        if (!isset($params['website']) || !isset($params['rules'])) return [];
        $lists = QueryList::get($params['website'])->rules($params['rules'])->removeHead()->encoding('UTF-8')->query()->getData()->all();
        if (!$lists) return $lists;
        //截取根网址
        $website_root = explode('/',$params['website'])[0];
        return array_map(function ($m) use ($website_root) {
            $m['book_url'] = $website_root.$m['book_url'];
            return $m;
        },$lists);
    }
}
