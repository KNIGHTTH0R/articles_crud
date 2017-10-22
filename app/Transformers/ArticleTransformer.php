<?php

namespace App\Transformers;
use App\Article;

class ArticleTransformer extends \League\Fractal\TransformerAbstract
{
  protected $availableIncludes = ['user'];

  public function transform(Article $article)
  {
    return [
      'id' => $article->id,
      'title' => $article->title,
      'body' => $article->body,
      'created_at' => $article->created_at->toDateTimeString(),
      'created_at_human' => $article->created_at->diffForHumans(),
    ];
  }

  public function includeUser(Article $article)
  {
    return $this->item($article->user, new UserTransformer);
  }
}
