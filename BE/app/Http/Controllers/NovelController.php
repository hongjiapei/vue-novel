<?php

namespace App\Http\Controllers;

use App\Http\Models\NovelModel;
use Illuminate\Http\Request;

class NovelController extends Controller
{
    protected $source = '';

    public function __construct()
    {
        parent::__construct();
        // 默认小说源
        $this->source = '001';
    }

    public function categories (Request $request)
    {
        $P = $request->input();
        $source = config('source.'.(isset($P['source']) ? $P['source'] : $this->source));
        $categories = NovelModel::categories($source[__FUNCTION__]);
//        dd($categories);
        return $categories ? $categories : [];
    }

    public function lists (Request $request)
    {
        $P = $request->input();
        if (!isset($P['website'])) return [];
        $source = config('source.'.(isset($P['source']) ? $P['source'] : $this->source));
        $lists = NovelModel::lists([
            'website' => $P['website'],
            'rules' => $source[__FUNCTION__]['rules']
        ]);
//        dd($lists);
        return $lists ? $lists : [];
    }

    public function detail (Request $request)
    {
        $P = $request->input();
        if (!isset($P['website'])) return [];
        $source = config('source.'.(isset($P['source']) ? $P['source'] : $this->source));
        $detail = NovelModel::detail([
            'website' => $P['website'],
            'rules' => $source[__FUNCTION__]['rules']
        ]);
//        dd($detail);
        return $detail ? $detail : [];
    }

    public function chapters (Request $request)
    {
        $P = $request->input();
        if (!isset($P['website'])) return [];
        $source = config('source.'.(isset($P['source']) ? $P['source'] : $this->source));
        $chapters = NovelModel::chapters([
            'website' => $P['website'],
            'rules' => $source[__FUNCTION__]['rules']
        ]);
//        dd($chapters);
        return $chapters ? $chapters : [];
    }

    public function chapterDetail (Request $request)
    {
        $P = $request->input();
        if (!isset($P['website'])) return [];
        $source = config('source.'.(isset($P['source']) ? $P['source'] : $this->source));
        $chapter_detail = NovelModel::chapterDetail([
            'website' => $P['website'],
            'rules' => $source[__FUNCTION__]['rules']
        ]);
//        dd($chapter_detail);
        return $chapter_detail ? $chapter_detail : [];
    }

    public function search (Request $request)
    {
        $P = $request->input();
        if (!isset($P['keyword'])) return [];
        $source = config('source.'.(isset($P['source']) ? $P['source'] : $this->source));
        $lists = NovelModel::search([
            'website' => $source[__FUNCTION__]['website'].$P['keyword'],
            'rules' => $source[__FUNCTION__]['rules']
        ]);
//        dd($lists);
        return $lists ? $lists : [];
    }
}
