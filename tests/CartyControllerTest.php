<?php
/**
 * User: Sam
 * Date: 1/17/2015
 * Time: 11:45 AM
 */

class CartyControllerTest extends Orchestra\Testbench\TestCase {
    protected function getPackageProviders()
    {
        return ['Dersam\Carty\CartyServiceProvider'];
    }

    public function setUp()
    {
        parent::setUp();

        $artisan = $this->app->make('Illuminate\Contracts\Console\Kernel');

        $this->app['path.database'] = __DIR__;

        $artisan->call('migrate', [
            '--database' => 'testbench'
        ]);
    }

    public function tearDown(){
        $artisan = $this->app->make('Illuminate\Contracts\Console\Kernel');

        $this->app['path.database'] = __DIR__;

        $artisan->call('migrate:rollback', [
            '--database' => 'testbench'
        ]);
    }

    public function testHarness(){
        echo "Testing";
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', array(
            'host'      => 'localhost',
            'database'  => 'testbench',
            'username'  => 'root',
            'password'  => 'superman',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ));
    }
}