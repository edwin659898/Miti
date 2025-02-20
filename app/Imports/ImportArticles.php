<?php

namespace App\Imports;

use App\Models\Article;
use App\Models\Magazine;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportArticles implements ToModel, WithHeadingRow
{
    public $issue_id;

    public function __construct($issue_no)
    {
        $this->issue_id = $issue_no;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $slug = Str::slug($row['title']);
        $magazine = Magazine::find($this->issue_id);
        
        Article::create([
            "magazine_id" => $this->issue_id,
            "title" => $row['title'],
            "slug" => $slug,
            "sub_title" => $row['sub_title'],
            "author" => $row['author'] ?? null,
            "date_authored" => $row['date'] ?? null,
            "category" => $row['category'] ?? null,
            "file" => 'Issue_'.$magazine->issue_no.'/'.$row['title'],
        ]);

    }
}
