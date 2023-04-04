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
            "description" => "Improve your skills in using Laravel Filament, a beautiful and elegant admin panel for modern web applications.",
            "time" => 0,
            "previous_time" => "00:00:40",
            "created_at" => "2023-04-04 14:30:15",
            "updated_at" => "2023-04-04 14:30:15",
        ],
        [
            "id" => 1,
            "title" => "Upskill Laravel",
            "description" => "Take your skills in Laravel to the next level by learning advanced techniques and best practices for building web applications.",
            "time" => 0,
            "previous_time" => "00:00:00",
            "created_at" => "2023-04-04 14:30:15",
            "updated_at" => "2023-04-04 14:30:15",
        ],
        [
            "id" => 2,
            "title" => "Upskill Livewire",
            "description" => "Learn how to use Livewire, a powerful framework for building modern web applications with dynamic and interactive user interfaces.",
            "previous_time" => "00:00:00",
            "created_at" => "2023-04-04 14:30:15",
            "updated_at" => "2023-04-04 14:30:15",
        ],
        [
            "id" => 3,
            "title" => "Intern One-on-One Talk",
            "description" => "Have a private conversation with an experienced developer to get personalized feedback and advice on your coding skills and career goals.",
            "time" => 0,
            "previous_time" => "00:00:00",
            "created_at" => "2023-04-04 14:30:15",
            "updated_at" => "2023-04-04 14:30:15",
        ]
    ];
}
