<?php

namespace AppBundle\Tests\Unit\DependencyInjection;

use AppBundle\DependencyInjection\AppExtension;
use Oro\Bundle\TestFrameworkBundle\Test\DependencyInjection\ExtensionTestCase;

class AppExtensionTest extends ExtensionTestCase
{
    /**
     * @var array
     */
    protected $extensionConfigs = [];

    /**
     * Test Load
     */
    public function testLoad()
    {
        $this->loadExtension(new AppExtension());

        $expectedDefinitions = [
            'app.form.type.issue',
            'app.issue_manager.api',
            'app.importexport.data_converter',
            'app.importexport.strategy.issue.add_or_replace',
            'app.importexport.processor.export',
            'app.importexport.processor.import.add_or_replace',
        ];
        $this->assertDefinitionsLoaded($expectedDefinitions);

    }
}
