<?php

namespace App\Console\Commands;

use App\Article;
use Illuminate\Console\Command;

class CalculateHotArticle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dcynsd:calculate-hot-article';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成热门文章';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Article $article)
    {
        $this->info('开始计算...');

        $article->calculateAndCacheHotArticles();

        $this->info('生成成功！');
    }
}
