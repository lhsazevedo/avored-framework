<?php

namespace AvoRed\Framework\Tests;

use AvoRed\Framework\AvoRedProvider;
use Faker\Generator as FakerGenerator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Notification;
use AvoRed\Framework\Database\Models\AdminUser;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use AvoRed\Framework\Database\Models\Permission;

abstract class BaseTestCase extends OrchestraTestCase
{
    /**
     * Admin User.
     * @var \AvoRed\Framework\Database\Models\AdminUser
     */
    protected $user;

    protected $faker;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->faker = $this->app->make(FakerGenerator::class);

        $this->withFactories(__DIR__ . '/../database/factories');

        $this->setUpDatabase();
        Notification::fake();
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application   $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.key', 'base64:UTyp33UhGolgzCK5CJmT+hNHcA+dJyp3+oINtX+VoPI=');
    }

    /**
     * Reset the Database.
     * @return void
     */
    private function resetDatabase(): void
    {
        $this->artisan('migrate:fresh');
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            AvoRedProvider::class,
        ];
    }

    /**
     * Setup database for the unit test.
     * @return void
     */
    protected function setUpDatabase(): void
    {
        $this->resetDatabase();
    }

    /**
     * Get package aliases.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageAliases($app): array
    {
        return [
            //'AdminMenu' => 'AvoRed\\Framework\\AdminMenu\\Facade',
            //'AdminConfiguration' => 'AvoRed\\Framework\\AdminConfiguration\\Facade',
            //'DataGrid' => 'AvoRed\\Framework\\DataGrid\\Facade',
            //'Image' => 'AvoRed\\Framework\\Image\\Facade',
            'Breadcrumb' => \AvoRed\Framework\Support\Facades\Breadcrumb::class,
            'Menu' => \AvoRed\Framework\Support\Facades\Menu::class,
            'Module' => \AvoRed\Framework\Support\Facades\Module::class,
            'Permission' => \AvoRed\Framework\Support\Facades\Permission::class,
            'Cart' => AvoRed\Framework\Support\Facades\Cart::class,
            'Payment' => AvoRed\Framework\Support\Facades\Payment::class,
            'Shipping' => AvoRed\Framework\Support\Facades\Shipping::class,
            //'Tabs' => 'AvoRed\\Framework\\Tabs\\Facade',
            //'Theme' => 'AvoRed\\Framework\\Theme\\Facade',
            //'Widget' => 'AvoRed\\Framework\\Widget\\Facade'
        ];
    }

    /**
     * Create an Admin user model.
     * 
     * @param array $data
     * 
     * @return self
     */
    protected function createAdminUser($data = ['is_super_admin' => 1]): self
    {
        if (null === $this->user) {
            $this->user = factory(AdminUser::class)->create($data);
        }

        return $this;
    }

    /**
     * Create and new permission for a given user.
     * 
     * @param AvoRed\Framework\Database\Models\AdminUser $user
     * @param string $name
     * 
     * @return void
     */
    protected function createPermissionForUser(AdminUser $user, string $name)
    {
        $permission = new Permission(['name' => $name]);
        $user->role->permissions()->save($permission);
        $user->load('role.permissions');
    }
}
