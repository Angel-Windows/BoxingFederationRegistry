<?php
namespace App\Providers;
use App\Repositories\Category\CategoryFederationRepository;
use App\Repositories\Category\SportsmanFederationRepository;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Support\ServiceProvider;
class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
//            CategoryRepositoryInterface::class,
            CategoryFederationRepository::class,
        );
        $this->app->bind(
//            CategoryRepositoryInterface::class,
            SportsmanFederationRepository::class,
        );
    }
}
