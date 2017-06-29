<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Notifications\InvoicePaid;
use Maknz\Slack\Facades\Slack;
use Illuminate\Support\Facades\Config;

/*
function insertBlogData(String $blogTitle, String $blogUrl, String $blogUpdateDate)
{
    DB::table('blogs')->insert([
    'blog_title' => $blogTitle,
    'blog_url' => $blogUrl,
    'blog_update_date' => $blogUpdateDate
    ]);
}

function selectBlogData(String $index)
{
    return DB::table('blogs')->where('id', $index)->first();
}

function updateBlogData(String $index, String $blogUpdateDate)
{
    DB::table('blogs')->where('id', $index)->update(['blog_update_date' => $blogUpdateDate]);
}


function insertOrUpdateBlogData($blogData, $blog, String $index, String $blogUpdateDate)
{
    if (!($blogData)) {
        insertBlogData($blog['blogTitle'], $blog['blogUrl'], $blogUpdateDate);
    } else {
        if (!($blogData->blog_update_date == $blogUpdateDate)) {
            updateBlogData($index, $blogUpdateDate);
            Slack::send('> '.$blog['blogTitle'].'が更新されました。リンク：'.$blog['blogUrl']);
        }
    }
}*/

Route::get('/', function () {
    return view('welcome');
    // $client = new Client();

    // $blogs = collect(config('const.blogs'));

    // // $array = array(
    // //     '0' => array('blogTitle'=>'いつも隣にITのお仕事', 'blogUrl'=>'https://tonari-it.com/'),
    // //     '1' => array('blogTitle'=>'いつも隣にITのお仕事', 'blogUrl'=>'https://tonari-it.com/'),
    // //     '2' => array('blogTitle'=>'いつも隣にITのお仕事', 'blogUrl'=>'https://tonari-it.com/'));

    // // $blogMinimalist  = array(
    // //     'blogTitle' => 'ミニマリスト日和',
    // //     'blogUrl' => 'http://mount-hayashi.hatenablog.com/',
    // // );
    // // $blogBecomeBeauty  = array(
    // //     'blogTitle' => '美人になれるたくさんの魔法',
    // //     'blogUrl' => 'https://ameblo.jp/hiromin-yuki/',
    // // );

    
    // foreach ($blogs as $index => $blog) {
    //     $guzzle = new GuzzleClient(array(
    //         'curl.options' => array(
    //             'CURLOPT_SSLVERSION' => 'CURL_SSLVERSION_TLSv1_1',
    //         )
    //     ));
    //     $client->setClient($guzzle);
    //     $crawler = $client->request('GET', $blog['blogUrl']);

    //     switch ($blog['blogTitle']) {
    //         case 'いつも隣にITのお仕事':
    //         /*
    //             $dateITWork = new DateTime(trim($crawler->filter('span .published')->first()->text()));
    //             $blogData = selectBlogData($index);

    //             insertOrUpdateBlogData($blogData, $blog, $index, $dateITWork->format('Y-m-d'));

    //             var_dump($dateITWork->format('Y/m/d'));
    //             var_dump($blog['blogTitle']);
    //             var_dump($index);*/
    //             break;
    //         case 'ミニマリスト日和':
    //         /*
    //             $dateMinimalist = new DateTime(trim($crawler->filter('div .first')->first()->text()));
    //             $blogData = selectBlogData($index);

    //             insertOrUpdateBlogData($blogData, $blog, $index, $dateMinimalist->format('Y-m-d'));


    //             var_dump($dateMinimalist->format('Y/m/d'));
    //             var_dump($blog['blogTitle']);
    //             var_dump($index);/*
    //             break;
    //         case '美人になれるたくさんの魔法':
    //         /*
    //             $date = str_replace('NEW!', '', trim($crawler->filter('time')->first()->text()));
    //             $format = 'Y年m月d日';
    //             $dateBecomeBeauty = DateTime::createFromFormat($format, $date);
    //             $blogData = selectBlogData($index);

    //             insertOrUpdateBlogData($blogData, $blog, $index, $dateBecomeBeauty->format('Y-m-d'));


    //             var_dump($dateBecomeBeauty->format('Y/m/d'));
    //             var_dump($blog['blogTitle']);
    //             var_dump($index);*/
    //             break;
                
    //         case '農林水産省ホームページ':
    //         /*
    //             $japaneseDate = $crawler->filter('.list_item_date')->first()->text();
    //             $adYyyy = (string)(config('const.heiseiYyyy')+ str_replace('平成', '', $japaneseDate));
    //             $date = $adYyyy.preg_replace('/^平成[0-9][0-9]/', '', $japaneseDate);
    //             $format = 'Y年m月d日';
    //             $dateMinistryAFF = DateTime::createFromFormat($format, $date);
    //             $blogData = selectBlogData($index);
    //             insertOrUpdateBlogData($blogData, $blog, $index, $dateMinistryAFF->format('Y-m-d'));

    //             # code...
    //             break;*/
    //     }
    // }
});


Route::get('/getblogsdata', function () {
    return json_encode(DB::table('blogs')->get());
});