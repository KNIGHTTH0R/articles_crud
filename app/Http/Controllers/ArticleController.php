<?php

namespace App\Http\Controllers;

use App\Article;
use App\Transformers\ArticleTransformer;
use Illuminate\Http\Request;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use App\Policies\ArticlePolicy;

class ArticleController extends Controller
{
    public function index()
    {
      $articles = Article::orderBy('created_at','desc')->paginate(10);
      $articlesCollection = $articles->getCollection();

      return fractal()
              ->collection($articles)
              ->parseIncludes(['user'])
              ->transformWith(new ArticleTransformer)
              ->paginateWith(new IlluminatePaginatorAdapter($articles))
              ->toArray();
    }

    public function store(StoreArticleRequest $request)
    {
      $article = new Article;
      $article->title = $request->title;
      $article->body = $request->body;
      $article->user()->associate($request->user());

      $article->save();

      return fractal()
              ->item($article)
              ->parseIncludes(['user'])
              ->transformWith(new ArticleTransformer)
              ->toArray();
    }

    public function show(Article $article)
    {
      return fractal()
              ->item($article)
              ->parseIncludes(['user'])
              ->transformWith(new ArticleTransformer)
              ->toArray();
    }

    public function update(UpdateArticleRequest $request, Article $article)
    {
      try {
        $this->authorize('update', $article);
      } catch (\Exception $e) {
        return response()->json(['error' => 'Not authorized', 'status' => '403'], 403);
      }

      $article->title = $request->get('title', $article->title);
      $article->body = $request->get('body', $article->body);
      $article->save();
      return fractal()
              ->item($article)
              ->parseIncludes(['user'])
              ->transformWith(new ArticleTransformer)
              ->toArray();
    }

    public function destroy(Article $article)
    {
      try {
        $this->authorize('destroy', $article);
      } catch (\Exception $e) {
        return response()->json(['error' => 'Not authorized', 'status' => '403'], 403);
      }

      $article->delete();
      
      return response(null, 204);
    }
}
