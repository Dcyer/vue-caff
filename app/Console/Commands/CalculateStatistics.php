<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class CalculateStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dcynsd:calculate-statistics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成统计数据';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(User $user)
    {
        $this->info('开始计算...');

        $user->calculateAndCacheStatistics();

        $this->info('生成成功！');
    }
}
