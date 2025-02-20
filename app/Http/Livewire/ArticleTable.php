<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Article;

class ArticleTable extends DataTableComponent
{
    protected $model = Article::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Magazine", "magazine_id")
                ->sortable(),
            Column::make("Title", "title")
                ->sortable(),
            Column::make("Sub Title", "sub_title")
                ->sortable(),
            Column::make("Author", "author")
                ->sortable(),
            Column::make("Date Authored", "date_authored")
                ->sortable(),
        ];
    }

    
}
