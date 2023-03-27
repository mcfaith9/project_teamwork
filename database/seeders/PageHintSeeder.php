<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Discoverlance\FilamentPageHints\Models\PageHint;

class PageHintSeeder extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {

        $allPageHints = '[{"url":"http:\/\/127.0.0.1:8000\/admin","route":"filament.resources.users.index","title":"What is Dashboard","hint":"<p>A website <strong>dashboard<\/strong> is a user interface that displays important information and key performance indicators (KPIs) related to a website's performance. It provides a quick and easy way for users to access and analyze data in real-time, helping them make informed decisions about their website's content, user engagement, traffic, and other metrics. <br><br>A website<strong> dashboard<\/strong> typically includes charts, graphs, tables, and other visual elements to help users quickly understand the data. It can also include tools for managing and optimizing website content, such as editing tools, analytics integrations, and social media sharing buttons.<br><br> A well-designed website <strong>dashboard<\/strong> can help website owners and administrators monitor their website's performance, track progress towards goals, and identify areas for improvement.<\/p>"}]';

        static::makePageHints($allPageHints);

        $this->command->info('Page Hints Seeding Completed.');
    }

    protected static function makePageHints(string $allPageHints): void
    {
        if (! blank($pageHints = json_decode($allPageHints,true))) {

            PageHint::truncate();
            foreach ($pageHints as $hint) {

                PageHint::create([
                    'url' => $hint['url'],
                    'route' => $hint['route'],
                    'title' => $hint['title'],
                    'hint' => $hint['hint']
                ]);
            }
        }
    }
}
