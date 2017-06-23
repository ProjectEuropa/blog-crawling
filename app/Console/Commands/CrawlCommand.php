<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Notifications\InvoicePaid;
use Maknz\Slack\Facades\Slack;
use Illuminate\Support\Facades\Config;
use DateTime;

class CrawlCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is blog crawling command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new Client();

        $blogs = collect(config('const.blogs'));
    
        foreach ($blogs as $index => $blog) {
            // This is SSL protocol error connection measures.
            $guzzle = new GuzzleClient(array(
                'curl.options' => array(
                    'CURLOPT_SSLVERSION' => 'CURL_SSLVERSION_TLSv1_1',
                )
            ));
            $client->setClient($guzzle);
            $crawler = $client->request('GET', $blog['blogUrl']);

            switch ($blog['blogTitle']) {
                case 'いつも隣にITのお仕事':
                    $dateITWork = new DateTime(trim($crawler->filter('span .published')->first()->text()));
                    $blogData = $this->getBlogData($index);
                    $this->insertOrUpdateBlogData($blogData, $blog, $index, $dateITWork->format('Y-m-d'));
                    break;
                case 'ミニマリスト日和':
                    $dateMinimalist = new DateTime(trim($crawler->filter('div .first')->first()->text()));
                    $blogData = $this->getBlogData($index);
                    $this->insertOrUpdateBlogData($blogData, $blog, $index, $dateMinimalist->format('Y-m-d'));
                    break;
                case '美人になれるたくさんの魔法':
                    $date = str_replace('NEW!', '', trim($crawler->filter('time')->first()->text()));
                    $format = 'Y年m月d日';
                    $dateBecomeBeauty = DateTime::createFromFormat($format, $date);
                    $blogData = $this->getBlogData($index);
                    $this->insertOrUpdateBlogData($blogData, $blog, $index, $dateBecomeBeauty->format('Y-m-d'));
                    break;
                default:
                    break;
            }
        }
    }
     /**
     * Insert into blog data to Blogs table.
     * @param String $blogTitle
     * @param String $blogUrl
     * @param String $blogUpdateDate
     * @return void
     */
    function insertBlogData(String $blogTitle, String $blogUrl, String $blogUpdateDate)
    {
        DB::table('blogs')->insert([
            'blog_title' => $blogTitle,
            'blog_url' => $blogUrl,
            'blog_update_date' => $blogUpdateDate
        ]);
    }
     /**
     * Get array data from Blogs table.
     * @param String $index(id of Blogs table)
     * @return array or null
     */
    private function getBlogData(String $index)
    {
        return DB::table('blogs')->where('id', $index)->first();
    }

     /**
     * Update Blogs table(column of column is only blog_update_date).
     * @param String $index(id of Blogs table)
     * @param String $blogUpdateDate
     * @return void
     */
    private function updateBlogData(String $index, String $blogUpdateDate)
    {
        DB::table('blogs')->where('id', $index)->update(['blog_update_date' => $blogUpdateDate]);
    }

     /**
     * If $blogData is not null, insert blog data to Blogs table.
     * If $blogData is array, update Blogs table and send message to Slack.
     * @param array or null  blogData
     * @param array $blog
     * @param String $index(id of Blogs table)
     * @param String $blogUpdateDate(yyyy-mm-dd)
     * @return void
     */
    private function insertOrUpdateBlogData($blogData, $blog, String $index, String $blogUpdateDate)
    {
        if (!($blogData)) {
            $this->insertBlogData($blog['blogTitle'], $blog['blogUrl'], $blogUpdateDate);
        } else {
            if (!($blogData->blog_update_date == $blogUpdateDate)) {
                $this->updateBlogData($index, $blogUpdateDate);
                $this->sendToSlack($blog['blogTitle'], $blog['blogUrl']);
            }
        }
    }
 
     /**
     * Send message to Slack.
     * @param String $blogTitle
     * @return void
     */
    private function sendToSlack(String $blogTitle, String $blogUrl)
    {
        Slack::send('> '.$blogTitle.'が更新されました。リンク：'.$blogUrl);
    }
}