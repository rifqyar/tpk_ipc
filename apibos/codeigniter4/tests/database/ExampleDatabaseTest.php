<?php

use Tests\Support\Models\ExampleModel;

class ExampleDatabaseTest extends \Tests\Support\DatabaseTestCase
{
	public function setUp(): void
	{
		parent::setUp();

		// Extra code to run before each test
	}

	public function testModelFindAll()
	{
		$model = new ExampleModel();

		// Get every row created by ExampleSeeder
		$objects = $model->findAll();

		// Make sure the count is as expected
		$this->assertCount(3, $objects);
	}

	public function testSoftDeleteLeavesRow()
	{
		$model = new ExampleModel();
		$this->setPrivateProperty($model, 'useSoftDeletes', true);
		$this->setPrivateProperty($model, 'tempUseSoftDeletes', true);

		$object = $model->first();
		$model->delete($object->id);

		// The model should no longer find it
		$this->assertNull($model->find($object->id));

		// ... but it should still be in the database
		$result = $model->builder()->where('id', $object->id)->get()->getResult();

		$this->assertCount(1, $result);
	}
}
ications/XAMPP/xamppfiles/htdocs/ApiBos/app/Models/ClientModel.php(55): CodeIgniter\BaseModel->paginate(2)
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Client.php(22): App\Models\ClientModel->test()
#6 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Client->index()
#7 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Client))
#8 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#9 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#10 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#11 {main}
ERROR - 2021-07-26 05:20:51 --> Unknown column 'a.JNS_DOK' in 'on clause'
