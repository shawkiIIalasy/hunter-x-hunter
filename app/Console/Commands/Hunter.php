<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Spatie\Crawler\Crawler;
use Spatie\Crawler\CrawlProfiles\CrawlInternalUrls;
use Spatie\Crawler\CrawlProfiles\CrawlSubdomains;

class Hunter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Hunter:work {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hunter will crawling for provided link';

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
     * @return int
     */
    public function handle()
    {
        $url = $this->argument('url');

        if(is_null($url)) {
            $url = $this->ask('Enter url link?', 'http://127.0.0.1');
        }

        $project = parse_url($url, PHP_URL_HOST);


        if(!File::isDirectory('storage/PDF/' . $project)) {
            File::makeDirectory('storage/PDF/' . $project);
        }

        Crawler::create()
            ->setCrawlObserver(new \App\Actions\Hunter($project))
            ->setCrawlObserver(new \App\Actions\Hunter($project))
            ->setCrawlObserver(new \App\Actions\Hunter($project))
            ->setCrawlObserver(new \App\Actions\Hunter($project))
            ->setCrawlProfile(new CrawlSubdomains($url))
            ->setTotalCrawlLimit(160000)
            ->startCrawling($url);

        return Command::SUCCESS;
    }
}
