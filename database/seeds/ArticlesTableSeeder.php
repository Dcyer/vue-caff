<?php

use App\User;
use App\Category;
use App\Article;
use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        // 所有用户 ID 数组，如：[1,2,3,4]
        $user_ids = User::all()->pluck('id')->toArray();

        // 所有分类 ID 数组，如：[1,2,3,4]
        $category_ids = Category::all()->pluck('id')->toArray();

        // 获取 Faker 实例
        $faker = app(Faker\Generator::class);

        $articles = factory(Article::class)
            ->times(100)
            ->make()
            ->each(function ($article, $index) use ($user_ids, $category_ids, $faker) {
                // 从用户 ID 数组中随机取出一个并赋值
                $article->user_id = $faker->randomElement($user_ids);

                // 话题分类，同上
                $article->category_id = $faker->randomElement($category_ids);
            });

        // 将数据集合转换为数组，并插入到数据库中
        Article::insert($articles->toArray());
    }
}
