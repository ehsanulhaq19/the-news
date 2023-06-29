<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NewsOrg;
use App\Services\TheGuardian;
use App\Services\NewYorkTimes;
use App\Repository\ArticleRepository;
use Symfony\Component\Console\Output\ConsoleOutput;

class FetchArticlesFromSources extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch articles from different sources and save them in database';

    /**
     * The NewsOrg instance.
     *
     * @var NewsOrg
     */
    private NewsOrg $newsOrg;
    
    /**
     * The TheGuardian instance.
     *
     * @var TheGuardian
     */
    private TheGuardian $theGuardian;

    /**
     * The NewYorkTimes instance.
     *
     * @var NewYorkTimes
     */
    private NewYorkTimes $newYorkTimes;

    /**
     * The ArticleRepository instance.
     *
     * @var ArticleRepository
     */
    private ArticleRepository $articleRepository;

    
    /**
     * Create a new command instance.
     *
     * @return void
     */

    public function __construct(
        NewsOrg $newsOrg,
        TheGuardian $theGuardian,
        NewYorkTimes $newYorkTimes,
        ArticleRepository $articleRepository
    ) {
        parent::__construct();

        $this->newsOrg = $newsOrg;
        $this->theGuardian = $theGuardian;
        $this->newYorkTimes = $newYorkTimes;
        $this->articleRepository = $articleRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $output = new ConsoleOutput();

        $output->writeln("Started...");
        $newsOrgArticles = $this->newsOrg->fetchAllArticles();
        $output->writeln("News.org data is fetched");

        $theGuardianArticles = $this->theGuardian->fetchAllArticles();
        $output->writeln("The Guardian data is fetched");

        $newYorkTimesArticles = $this->newYorkTimes->fetchAllArticles();
        $output->writeln("New York Times data is fetched");

        $articles = array_merge($newsOrgArticles, $theGuardianArticles, $newYorkTimesArticles);
        
        $output->writeln("Data is being saved in database");
        $this->articleRepository->saveArticles($articles);
        $output->writeln("Completed");

        return 0;
    }
}
