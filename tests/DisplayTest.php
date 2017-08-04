<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DisplayTest extends TestCase
{
    /**
     * Find blog titles test.
     *
     * @return void
     */
    public function testFindBlogTitles()
    {
        $this->visit('/')
             ->get('/getblogsdata')
             ->seeJson([
                'blog_title' => 'いつも隣にITのお仕事',
                'blog_title' => 'ミニマリスト日和',
                'blog_title' => '美人になれるたくさんの魔法',
                'blog_title' => '農林水産省ホームページ',
                'blog_title' => 'ビストロクルル「まだむの寝言」',
                'blog_title' => '東京・練馬のパーソナルカラー診断・骨格診断　MEIBI',
                'blog_title' => '〈熊本〉ファッション＆メイクで美人になるレッスン 望月順子',
                'blog_title' => 'インテリアと暮らしのヒント',
                'blog_title' => 'ほんとうに必要な物しか持たない暮らし',
             ]);;
    }
}
