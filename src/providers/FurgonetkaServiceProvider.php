<?php

namespace DevPlus31\Furgonetka\providers;

use GuzzleHttp\Client;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use Kwarcek\FurgonetkaRestApi\FurgonetkaClient;
use Kwarcek\FurgonetkaRestApi\LoginCredential;

class FurgonetkaServiceProvider extends ServiceProvider implements DeferrableProvider {

    public function register() {

        $this->mergeConfigFrom(dirname(__DIR__, 2) . '/config/furgonetka.php', 'furgonetka');

        $this->app->singleton(FurgonetkaClient::class, function(Application $app)  {
            $config = $app['config']['furgonetka'];

            $client = new Client([
                'base_url' => $config['sandbox'] ? LoginCredential::FURGONETKA_DEFAULT_TEST_API_URL : LoginCredential::FURGONETKA_DEFAULT_TEST_LOGIN_API_URL,
                'timeout'  => 10,
                'verify'   => false
            ]);

            $credentials = new LoginCredential();
            $credentials->clientSecret = $config["clientSecret"];
            $credentials->clientId = $config['clientId'];
            $credentials->username = $config['username'];
            $credentials->password = $config['password'];

            return new FurgonetkaClient(
                $client,
                $credentials
            );
        });
    }

    public function boot() {
        $this->publishes(
            [
                dirname(__DIR__, 2) . '/config/furgonetka.php'=> $this->furgonetkaConfigPublishPath()
            ],
            'furgonetka'
        );
    }

    public function provides()
    {
        return [FurgonetkaClient::class];
    }

    public function furgonetkaConfigPublishPath()
    {
        if (function_exists('config_path')) {
            return config_path('furgonetka.php');
        }

        return 'config/furgonetka.php';
    }

}