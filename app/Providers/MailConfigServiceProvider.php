<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Options;
use Illuminate\Support\Facades\Config;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $option =new Options;
        $config = array(
            'host'       => $option->get_option("mail_host"),
            'port'       => $option->get_option("mail_port"),
            'from'       => array('address' => $option->get_option("mail_address"), 'name' => $option->get_option("mail_username")),
            'encryption' => $option->get_option("mail_encryption"),
            'username'   => $option->get_option("mail_username"),
            'password'   => $option->get_option("mail_password"),
        );
        Config::set('mail', $config);
    }
}
