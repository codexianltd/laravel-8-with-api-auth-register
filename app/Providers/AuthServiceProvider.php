<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Sanctum\Sanctum;
use Laravel\Sanctum\PersonalAccessToken;
class AuthServiceProvider extends ServiceProvider
{
	/**
	 * The policy mappings for the application.
	 *
	 * @var array
	 */
	protected $policies = [
		// 'App\Models\Model' => 'App\Policies\ModelPolicy',
	];

	/**
	 * Register any authentication / authorization services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->registerPolicies();
		Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

		//
	}
}
