<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Discoverlance\FilamentPageHints\Resources\PageHintsResource\Pages\ListPageHints as IndexHints;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class Hints extends IndexHints
{
    use HasPageShield;
}
