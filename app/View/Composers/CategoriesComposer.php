<?php

namespace App\View\Composers;

use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Support\Facades\Http;

class CategoriesComposer
{
  public function compose(View $view)
  {
    $view->categories = Category::where('fk_parent', 715)->orderBy('rowid', 'asc')->get();

    $view->sectors = Category::where('fk_parent', 693)->orderBy('rowid', 'asc')->get();
  }
}