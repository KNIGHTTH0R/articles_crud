<?php

namespace App\Policies;

use App\User;
use App\Article;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    public function update(User $user, Article $article)
    {
      return $user->ownsArticle($article);
    }

    public function destroy(User $user, Article $article)
    {
      return $user->ownsArticle($article);
    }
}
