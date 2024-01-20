<?php

namespace App\Http\Middleware;

use App\Models\Product;
use App\Models\User;
use Closure;
use Faker\Factory as Faker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FakeData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (User::count() === 0){
            $faker = Faker::create();
            $user = User::create([
                'name' => 'Sirwiss',
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => bcrypt($faker->password),
            ]);
        } else {
            $user = User::inRandomOrder()->first();
        }
        if (Product::count() === 0){
            $faker = Faker::create();
            for ($i = 0; $i < 3; $i++){
                Product::create([
                    'name' => $faker->word(),
                    'price' => '20.99',
                    'status' => 'active',
                    'seller' => 'Sirwiss',
                    'type' => 'service'
                ]);
            }
        }

        Auth::login($user);

        return $next($request);
    }
}
