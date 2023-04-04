<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\Page;

class Timer extends Page
{
    protected static string $resource = UserResource::class;

    protected static string $view = 'filament.resources.user-resource.pages.timer';

    public $items = [
        [
            "id" => 0,
            "title" => "Upskill Filament",
            "description" => "Improve your skills in using Laravel Filament, a beautiful and elegant admin panel for modern web applications."
        ],
        [
            "id" => 1,
            "title" => "Upskill Laravel",
            "description" => "Take your skills in Laravel to the next level by learning advanced techniques and best practices for building web applications."
        ],
        [
            "id" => 2,
            "title" => "Upskill Livewire",
            "description" => "Learn how to use Livewire, a powerful framework for building modern web applications with dynamic and interactive user interfaces."
        ],
        [
            "id" => 3,
            "title" => "Intern One-on-One Talk",
            "description" => "Have a private conversation with an experienced developer to get personalized feedback and advice on your coding skills and career goals."
        ]
    ];
}
