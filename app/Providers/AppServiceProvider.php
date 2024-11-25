<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Providers\RepositoryServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use App\Repository\Interfaces\BaseRepositoryInterface;
use App\Repository\Eloquents\BaseRepository;
use App\Repository\Interfaces\PostRepositoryInterface;
use App\Repository\Eloquents\PostRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(RepositoryServiceProvider::class);
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Builder::macro('whereLike', function ($attributes, string $searchTerm) {
            $like = 'LIKE';
            $this->where(function (Builder $query) use ($attributes, $searchTerm, $like) {
                foreach (Arr::wrap($attributes) as $attribute) {
                    $query->when(
                        Str::contains($attribute, '.'),
                        function (Builder $query) use ($attribute, $searchTerm, $like) {
                            [$relationName, $relationAttribute] = explode('.', $attribute);

                            $query->orWhereHas($relationName, function (Builder $query) use ($relationAttribute, $searchTerm, $like) {
                                $query->where($relationAttribute, $like, "%{$searchTerm}%");
                            });
                        },
                        function (Builder $query) use ($attribute, $searchTerm, $like) {
                            $query->orWhere($attribute, $like, "%{$searchTerm}%");
                        }
                    );
                }
            });
            return $this;
        });
    }
}
