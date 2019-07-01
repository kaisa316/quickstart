<?php

namespace Sentry\Laravel\Tests;

use Sentry\State\Hub;
use Illuminate\Config\Repository;

class SqlBindingsInBreadcrumbsWithOldConfigKeyDisabledTest extends SentryLaravelTestCase
{
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app['config']->set('sentry.dsn', 'http://publickey:secretkey@sentry.dev/123');

        $config = $app['config']->all();

        $config['sentry']['breadcrumbs.sql_bindings'] = false;

        $app['config'] = new Repository($config);
    }

    public function testIsBound()
    {
        $this->assertTrue(app()->bound('sentry'));
        $this->assertInstanceOf(Hub::class, app('sentry'));
    }

    /**
     * @depends testIsBound
     */
    public function testSqlBindingsAreRecordedWhenDisabledByOldConfigKey()
    {
        $this->assertFalse($this->app['config']->get('sentry')['breadcrumbs.sql_bindings']);

        $this->dispatchLaravelEvent('illuminate.query', [
            $query = 'SELECT * FROM breadcrumbs WHERE bindings = ?;',
            $bindings = ['1'],
            10,
            'test',
        ]);

        $breadcrumbs = $this->getScope(Hub::getCurrent())->getBreadcrumbs();

        /** @var \Sentry\Breadcrumb $lastBreadcrumb */
        $lastBreadcrumb = end($breadcrumbs);

        $this->assertEquals($query, $lastBreadcrumb->getMessage());
        $this->assertFalse(isset($lastBreadcrumb->getMetadata()['bindings']));
    }
}
