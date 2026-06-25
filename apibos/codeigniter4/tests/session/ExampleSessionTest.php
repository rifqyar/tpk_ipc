<?php

class ExampleSessionTest extends \Tests\Support\SessionTestCase
{
	public function setUp(): void
	{
		parent::setUp();
	}

	public function testSessionSimple()
	{
		$this->session->set('logged_in', 123);

		$value = $this->session->get('logged_in');

		$this->assertEquals(123, $value);
	}
}
codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 02:45:47 --> Undefined variable: alamat
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(75): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined varia...', '/Applications/X...', 75, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 02:57:51 --> Illegal string offset 'NO_DOK'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(113): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 113, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 03:00:18 --> Illegal string offset 'NO_DOK'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(113): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 113, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 03:01:01 --> Illegal string offset 'NO_DOK'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(113): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 113, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 03:01:16 --> Illegal string offset 'NO_DOK'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(113): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 113, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 03:01:56 --> Illegal string offset 'TGL_DOK'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(115): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 115, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 03:03:51 --> Illegal string offset 'NO_DOK'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(115): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 115, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 03:04:34 --> Illegal string offset 'NO_DOK'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(115): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 115, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 03:06:23 --> Illegal string offset 'NO_DOK'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(115): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 115, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 03:08:10 --> Illegal string offset 'TGL_DOK'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(116): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 116, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 03:09:18 --> Illegal string offset 'NO_DOK'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(115): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 115, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 03:09:37 --> Trying to get property 'NO_DOK' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(115): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 115, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 03:10:32 --> Trying to get property 'NO_DOK' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(115): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 115, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 03:10:53 --> Illegal string offset 'NO_DOK'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(115): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 115, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 03:15:25 --> Illegal string offset 'NO_DOK'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(116): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 116, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 03:17:35 --> Illegal string offset 'NO_DOK'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(116): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 116, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 03:19:15 --> Illegal string offset 'NO_DOK'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(116): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 116, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 03:19:16 --> Illegal string offset 'NO_DOK'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(116): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 116, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 03:19:17 --> Illegal string offset 'NO_DOK'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(116): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 116, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 03:19:36 --> Illegal string offset 'NO_DOK'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(116): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 116, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 03:20:03 --> Illegal string offset 'NO_DOK'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(116): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 116, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 03:20:06 --> Illegal string offset 'NO_DOK'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(116): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 116, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 03:20:10 --> Illegal string offset 'NO_DOK'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(116): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 116, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 03:20:19 --> Illegal string offset 'NO_DOK'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(116): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 116, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 03:21:15 --> Illegal string offset 'NO_DOK'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(118): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 118, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 03:26:53 --> Undefined index: Data
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(48): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined index...', '/Applications/X...', 48, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 03:38:55 --> Illegal string offset 'NO_DOK'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(118): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 118, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 03:43:46 --> Trying to get property 'NO_DOK' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(117): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 117, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 03:48:13 --> Illegal string offset 'NO_DOK'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(119): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 119, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 03:49:15 --> Illegal string offset 'NO_DOK'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(119): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 119, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 03:50:34 --> Illegal string offset 'NO_DOK'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(119): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 119, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 03:53:59 --> Undefined offset: 283658
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(115): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined offse...', '/Applications/X...', 115, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 03:54:25 --> Uninitialized string offset: 283658
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(115): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Uninitialized s...', '/Applications/X...', 115, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 03:59:27 --> Undefined offset: 0
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(113): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined offse...', '/Applications/X...', 113, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 04:00:15 --> Undefined offset: 1
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(113): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined offse...', '/Applications/X...', 113, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 04:08:28 --> Illegal string offset 'NO_DOK'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(117): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 117, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 04:09:06 --> Illegal string offset 'NO_DOK'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(117): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 117, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 04:10:33 --> Array to string conversion
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(117): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Array to string...', '/Applications/X...', 117, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 04:13:40 --> Trying to get property 'no_dok' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(117): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 117, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 04:14:23 --> Undefined offset: 283658
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(117): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined offse...', '/Applications/X...', 117, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 04:14:33 --> Undefined index: NO_DOK
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(117): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined index...', '/Applications/X...', 117, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 04:16:22 --> Undefined offset: 1
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(117): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined offse...', '/Applications/X...', 117, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 04:16:54 --> Undefined index: data
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(110): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined index...', '/Applications/X...', 110, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 04:17:06 --> Illegal string offset 'no_dok'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(113): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 113, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 04:24:15 --> Illegal string offset 'NO_DOK'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(115): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 115, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 04:38:07 --> Undefined offset: 283658
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(114): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined offse...', '/Applications/X...', 114, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 04:39:56 --> Illegal string offset 'NO_DOK'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(115): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 115, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 04:40:39 --> Undefined offset: 283658
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(115): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined offse...', '/Applications/X...', 115, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 04:52:01 --> Undefined index: data
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(113): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined index...', '/Applications/X...', 113, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 05:26:05 --> Illegal string offset 'NO_DOK'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(113): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 113, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 05:26:36 --> Illegal string offset 'NO_DOK'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(113): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 113, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 05:32:36 --> A non-numeric value encountered
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(114): CodeIgniter\Debug\Exceptions->errorHandler(2, 'A non-numeric v...', '/Applications/X...', 114, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 05:32:53 --> A non-numeric value encountered
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(114): CodeIgniter\Debug\Exceptions->errorHandler(2, 'A non-numeric v...', '/Applications/X...', 114, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->postData()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 05:43:43 --> Invalid argument supplied for foreach()
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(50): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Invalid argumen...', '/Applications/X...', 50, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 05:44:16 --> Invalid argument supplied for foreach()
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Invalid argumen...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 05:44:33 --> Invalid argument supplied for foreach()
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Invalid argumen...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 05:45:02 --> Invalid argument supplied for foreach()
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Invalid argumen...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 07:23:57 --> Invalid argument supplied for foreach()
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Invalid argumen...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 07:24:26 --> Invalid argument supplied for foreach()
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Invalid argumen...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 10:35:18 --> curl_setopt(): You must pass either an object or an array with the CURLOPT_HTTPHEADER argument
#0 [internal function]: CodeIgniter\Debug\Exceptions->errorHandler(2, 'curl_setopt(): ...', '/Applications/X...', 74, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(74): curl_setopt(Resource id #120, 10023, 0)
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#6 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#7 {main}
CRITICAL - 2021-07-28 10:35:52 --> curl_setopt(): You must pass either an object or an array with the CURLOPT_HTTPHEADER argument
#0 [internal function]: CodeIgniter\Debug\Exceptions->errorHandler(2, 'curl_setopt(): ...', '/Applications/X...', 74, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(74): curl_setopt(Resource id #120, 10023, 1)
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#6 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#7 {main}
CRITICAL - 2021-07-28 11:27:14 --> Too few arguments to function App\Controllers\Curl::curl_get(), 0 passed in /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php on line 928 and at least 1 expected
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->curl_get()
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#5 {main}
CRITICAL - 2021-07-28 11:27:42 --> Too few arguments to function App\Controllers\Curl::curl_get(), 0 passed in /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php on line 928 and at least 1 expected
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->curl_get()
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#5 {main}
CRITICAL - 2021-07-28 19:15:23 --> Invalid argument supplied for foreach()
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Invalid argumen...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:15:23 --> Uncaught CodeIgniter\Format\Exceptions\FormatException: Failed to parse json string, error: "Type is not supported". in /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php:42
Stack trace:
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php(42): CodeIgniter\Format\Exceptions\FormatException::forInvalidJSON('Type is not sup...')
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(423): CodeIgniter\Format\JSONFormatter->format(Array)
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(114): CodeIgniter\Debug\Exceptions->format(Array)
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Debug/Exceptions.php(141): CodeIgniter\Debug\Exceptions->respond(Array, 500)
#4 [internal function]: CodeIgniter\Debug\Exceptions->exceptionHandler(Object(ErrorException))
#5 {mai
#0 [internal function]: CodeIgniter\Debug\Exceptions->shutdownHandler()
#1 {main}
CRITICAL - 2021-07-28 19:15:57 --> Invalid argument supplied for foreach()
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Invalid argumen...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:15:57 --> Uncaught CodeIgniter\Format\Exceptions\FormatException: Failed to parse json string, error: "Type is not supported". in /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php:42
Stack trace:
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php(42): CodeIgniter\Format\Exceptions\FormatException::forInvalidJSON('Type is not sup...')
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(423): CodeIgniter\Format\JSONFormatter->format(Array)
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(114): CodeIgniter\Debug\Exceptions->format(Array)
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Debug/Exceptions.php(141): CodeIgniter\Debug\Exceptions->respond(Array, 500)
#4 [internal function]: CodeIgniter\Debug\Exceptions->exceptionHandler(Object(ErrorException))
#5 {mai
#0 [internal function]: CodeIgniter\Debug\Exceptions->shutdownHandler()
#1 {main}
CRITICAL - 2021-07-28 19:16:10 --> Invalid argument supplied for foreach()
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Invalid argumen...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:16:10 --> Uncaught CodeIgniter\Format\Exceptions\FormatException: Failed to parse json string, error: "Type is not supported". in /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php:42
Stack trace:
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php(42): CodeIgniter\Format\Exceptions\FormatException::forInvalidJSON('Type is not sup...')
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(423): CodeIgniter\Format\JSONFormatter->format(Array)
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(114): CodeIgniter\Debug\Exceptions->format(Array)
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Debug/Exceptions.php(141): CodeIgniter\Debug\Exceptions->respond(Array, 500)
#4 [internal function]: CodeIgniter\Debug\Exceptions->exceptionHandler(Object(ErrorException))
#5 {mai
#0 [internal function]: CodeIgniter\Debug\Exceptions->shutdownHandler()
#1 {main}
CRITICAL - 2021-07-28 19:16:25 --> Invalid argument supplied for foreach()
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Invalid argumen...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:16:25 --> Uncaught CodeIgniter\Format\Exceptions\FormatException: Failed to parse json string, error: "Type is not supported". in /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php:42
Stack trace:
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php(42): CodeIgniter\Format\Exceptions\FormatException::forInvalidJSON('Type is not sup...')
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(423): CodeIgniter\Format\JSONFormatter->format(Array)
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(114): CodeIgniter\Debug\Exceptions->format(Array)
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Debug/Exceptions.php(141): CodeIgniter\Debug\Exceptions->respond(Array, 500)
#4 [internal function]: CodeIgniter\Debug\Exceptions->exceptionHandler(Object(ErrorException))
#5 {mai
#0 [internal function]: CodeIgniter\Debug\Exceptions->shutdownHandler()
#1 {main}
CRITICAL - 2021-07-28 19:17:04 --> Invalid argument supplied for foreach()
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Invalid argumen...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:17:04 --> Uncaught CodeIgniter\Format\Exceptions\FormatException: Failed to parse json string, error: "Type is not supported". in /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php:42
Stack trace:
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php(42): CodeIgniter\Format\Exceptions\FormatException::forInvalidJSON('Type is not sup...')
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(423): CodeIgniter\Format\JSONFormatter->format(Array)
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(114): CodeIgniter\Debug\Exceptions->format(Array)
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Debug/Exceptions.php(141): CodeIgniter\Debug\Exceptions->respond(Array, 500)
#4 [internal function]: CodeIgniter\Debug\Exceptions->exceptionHandler(Object(ErrorException))
#5 {mai
#0 [internal function]: CodeIgniter\Debug\Exceptions->shutdownHandler()
#1 {main}
CRITICAL - 2021-07-28 19:17:27 --> Invalid argument supplied for foreach()
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Invalid argumen...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:17:53 --> Invalid argument supplied for foreach()
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Invalid argumen...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:18:18 --> Invalid argument supplied for foreach()
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Invalid argumen...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:19:10 --> Invalid argument supplied for foreach()
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Invalid argumen...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:20:08 --> Invalid argument supplied for foreach()
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Invalid argumen...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:20:59 --> Invalid argument supplied for foreach()
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Invalid argumen...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:21:00 --> Invalid argument supplied for foreach()
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Invalid argumen...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:22:22 --> Undefined index: Data
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined index...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:22:23 --> Undefined index: Data
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined index...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:23:34 --> Undefined index: data
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined index...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:23:34 --> Uncaught CodeIgniter\Format\Exceptions\FormatException: Failed to parse json string, error: "Type is not supported". in /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php:42
Stack trace:
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php(42): CodeIgniter\Format\Exceptions\FormatException::forInvalidJSON('Type is not sup...')
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(423): CodeIgniter\Format\JSONFormatter->format(Array)
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(114): CodeIgniter\Debug\Exceptions->format(Array)
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Debug/Exceptions.php(141): CodeIgniter\Debug\Exceptions->respond(Array, 500)
#4 [internal function]: CodeIgniter\Debug\Exceptions->exceptionHandler(Object(ErrorException))
#5 {mai
#0 [internal function]: CodeIgniter\Debug\Exceptions->shutdownHandler()
#1 {main}
CRITICAL - 2021-07-28 19:23:35 --> Undefined index: data
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined index...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:23:35 --> Uncaught CodeIgniter\Format\Exceptions\FormatException: Failed to parse json string, error: "Type is not supported". in /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php:42
Stack trace:
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php(42): CodeIgniter\Format\Exceptions\FormatException::forInvalidJSON('Type is not sup...')
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(423): CodeIgniter\Format\JSONFormatter->format(Array)
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(114): CodeIgniter\Debug\Exceptions->format(Array)
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Debug/Exceptions.php(141): CodeIgniter\Debug\Exceptions->respond(Array, 500)
#4 [internal function]: CodeIgniter\Debug\Exceptions->exceptionHandler(Object(ErrorException))
#5 {mai
#0 [internal function]: CodeIgniter\Debug\Exceptions->shutdownHandler()
#1 {main}
CRITICAL - 2021-07-28 19:23:37 --> Undefined index: data
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined index...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:23:37 --> Uncaught CodeIgniter\Format\Exceptions\FormatException: Failed to parse json string, error: "Type is not supported". in /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php:42
Stack trace:
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php(42): CodeIgniter\Format\Exceptions\FormatException::forInvalidJSON('Type is not sup...')
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(423): CodeIgniter\Format\JSONFormatter->format(Array)
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(114): CodeIgniter\Debug\Exceptions->format(Array)
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Debug/Exceptions.php(141): CodeIgniter\Debug\Exceptions->respond(Array, 500)
#4 [internal function]: CodeIgniter\Debug\Exceptions->exceptionHandler(Object(ErrorException))
#5 {mai
#0 [internal function]: CodeIgniter\Debug\Exceptions->shutdownHandler()
#1 {main}
CRITICAL - 2021-07-28 19:23:55 --> Undefined index: data
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined index...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:23:55 --> Uncaught CodeIgniter\Format\Exceptions\FormatException: Failed to parse json string, error: "Type is not supported". in /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php:42
Stack trace:
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php(42): CodeIgniter\Format\Exceptions\FormatException::forInvalidJSON('Type is not sup...')
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(423): CodeIgniter\Format\JSONFormatter->format(Array)
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(114): CodeIgniter\Debug\Exceptions->format(Array)
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Debug/Exceptions.php(141): CodeIgniter\Debug\Exceptions->respond(Array, 500)
#4 [internal function]: CodeIgniter\Debug\Exceptions->exceptionHandler(Object(ErrorException))
#5 {mai
#0 [internal function]: CodeIgniter\Debug\Exceptions->shutdownHandler()
#1 {main}
CRITICAL - 2021-07-28 19:25:02 --> Undefined index: data
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined index...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:25:20 --> Undefined index: Data
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined index...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:27:06 --> Undefined index: Data
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined index...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:27:40 --> Undefined index: Data
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined index...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:28:21 --> Undefined index: Data
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined index...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:28:21 --> Uncaught CodeIgniter\Format\Exceptions\FormatException: Failed to parse json string, error: "Type is not supported". in /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php:42
Stack trace:
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php(42): CodeIgniter\Format\Exceptions\FormatException::forInvalidJSON('Type is not sup...')
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(423): CodeIgniter\Format\JSONFormatter->format(Array)
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(114): CodeIgniter\Debug\Exceptions->format(Array)
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Debug/Exceptions.php(141): CodeIgniter\Debug\Exceptions->respond(Array, 500)
#4 [internal function]: CodeIgniter\Debug\Exceptions->exceptionHandler(Object(ErrorException))
#5 {mai
#0 [internal function]: CodeIgniter\Debug\Exceptions->shutdownHandler()
#1 {main}
CRITICAL - 2021-07-28 19:29:39 --> Undefined index: Data
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(50): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined index...', '/Applications/X...', 50, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:29:39 --> Uncaught CodeIgniter\Format\Exceptions\FormatException: Failed to parse json string, error: "Type is not supported". in /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php:42
Stack trace:
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php(42): CodeIgniter\Format\Exceptions\FormatException::forInvalidJSON('Type is not sup...')
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(423): CodeIgniter\Format\JSONFormatter->format(Array)
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(114): CodeIgniter\Debug\Exceptions->format(Array)
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Debug/Exceptions.php(141): CodeIgniter\Debug\Exceptions->respond(Array, 500)
#4 [internal function]: CodeIgniter\Debug\Exceptions->exceptionHandler(Object(ErrorException))
#5 {mai
#0 [internal function]: CodeIgniter\Debug\Exceptions->shutdownHandler()
#1 {main}
CRITICAL - 2021-07-28 19:38:50 --> Undefined index: Data
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined index...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:44:07 --> Undefined index: Data
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined index...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:44:07 --> Uncaught CodeIgniter\Format\Exceptions\FormatException: Failed to parse json string, error: "Type is not supported". in /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php:42
Stack trace:
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php(42): CodeIgniter\Format\Exceptions\FormatException::forInvalidJSON('Type is not sup...')
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(423): CodeIgniter\Format\JSONFormatter->format(Array)
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(114): CodeIgniter\Debug\Exceptions->format(Array)
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Debug/Exceptions.php(141): CodeIgniter\Debug\Exceptions->respond(Array, 500)
#4 [internal function]: CodeIgniter\Debug\Exceptions->exceptionHandler(Object(ErrorException))
#5 {mai
#0 [internal function]: CodeIgniter\Debug\Exceptions->shutdownHandler()
#1 {main}
CRITICAL - 2021-07-28 19:46:33 --> Undefined index: Data
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined index...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:46:33 --> Uncaught CodeIgniter\Format\Exceptions\FormatException: Failed to parse json string, error: "Type is not supported". in /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php:42
Stack trace:
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php(42): CodeIgniter\Format\Exceptions\FormatException::forInvalidJSON('Type is not sup...')
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(423): CodeIgniter\Format\JSONFormatter->format(Array)
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(114): CodeIgniter\Debug\Exceptions->format(Array)
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Debug/Exceptions.php(141): CodeIgniter\Debug\Exceptions->respond(Array, 500)
#4 [internal function]: CodeIgniter\Debug\Exceptions->exceptionHandler(Object(ErrorException))
#5 {mai
#0 [internal function]: CodeIgniter\Debug\Exceptions->shutdownHandler()
#1 {main}
CRITICAL - 2021-07-28 19:46:49 --> Undefined index: Data
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined index...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:46:49 --> Uncaught CodeIgniter\Format\Exceptions\FormatException: Failed to parse json string, error: "Type is not supported". in /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php:42
Stack trace:
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php(42): CodeIgniter\Format\Exceptions\FormatException::forInvalidJSON('Type is not sup...')
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(423): CodeIgniter\Format\JSONFormatter->format(Array)
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(114): CodeIgniter\Debug\Exceptions->format(Array)
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Debug/Exceptions.php(141): CodeIgniter\Debug\Exceptions->respond(Array, 500)
#4 [internal function]: CodeIgniter\Debug\Exceptions->exceptionHandler(Object(ErrorException))
#5 {mai
#0 [internal function]: CodeIgniter\Debug\Exceptions->shutdownHandler()
#1 {main}
CRITICAL - 2021-07-28 19:47:32 --> Undefined index: Data
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined index...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:47:32 --> Uncaught CodeIgniter\Format\Exceptions\FormatException: Failed to parse json string, error: "Type is not supported". in /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php:42
Stack trace:
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php(42): CodeIgniter\Format\Exceptions\FormatException::forInvalidJSON('Type is not sup...')
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(423): CodeIgniter\Format\JSONFormatter->format(Array)
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(114): CodeIgniter\Debug\Exceptions->format(Array)
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Debug/Exceptions.php(141): CodeIgniter\Debug\Exceptions->respond(Array, 500)
#4 [internal function]: CodeIgniter\Debug\Exceptions->exceptionHandler(Object(ErrorException))
#5 {mai
#0 [internal function]: CodeIgniter\Debug\Exceptions->shutdownHandler()
#1 {main}
CRITICAL - 2021-07-28 19:48:41 --> Undefined index: no_dok
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(52): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined index...', '/Applications/X...', 52, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:48:41 --> Uncaught CodeIgniter\Format\Exceptions\FormatException: Failed to parse json string, error: "Type is not supported". in /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php:42
Stack trace:
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php(42): CodeIgniter\Format\Exceptions\FormatException::forInvalidJSON('Type is not sup...')
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(423): CodeIgniter\Format\JSONFormatter->format(Array)
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(114): CodeIgniter\Debug\Exceptions->format(Array)
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Debug/Exceptions.php(141): CodeIgniter\Debug\Exceptions->respond(Array, 500)
#4 [internal function]: CodeIgniter\Debug\Exceptions->exceptionHandler(Object(ErrorException))
#5 {mai
#0 [internal function]: CodeIgniter\Debug\Exceptions->shutdownHandler()
#1 {main}
CRITICAL - 2021-07-28 19:48:43 --> Undefined index: no_dok
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(52): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined index...', '/Applications/X...', 52, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:48:43 --> Uncaught CodeIgniter\Format\Exceptions\FormatException: Failed to parse json string, error: "Type is not supported". in /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php:42
Stack trace:
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php(42): CodeIgniter\Format\Exceptions\FormatException::forInvalidJSON('Type is not sup...')
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(423): CodeIgniter\Format\JSONFormatter->format(Array)
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(114): CodeIgniter\Debug\Exceptions->format(Array)
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Debug/Exceptions.php(141): CodeIgniter\Debug\Exceptions->respond(Array, 500)
#4 [internal function]: CodeIgniter\Debug\Exceptions->exceptionHandler(Object(ErrorException))
#5 {mai
#0 [internal function]: CodeIgniter\Debug\Exceptions->shutdownHandler()
#1 {main}
CRITICAL - 2021-07-28 19:49:00 --> Undefined index: Data
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined index...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:49:00 --> Uncaught CodeIgniter\Format\Exceptions\FormatException: Failed to parse json string, error: "Type is not supported". in /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php:42
Stack trace:
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php(42): CodeIgniter\Format\Exceptions\FormatException::forInvalidJSON('Type is not sup...')
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(423): CodeIgniter\Format\JSONFormatter->format(Array)
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(114): CodeIgniter\Debug\Exceptions->format(Array)
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Debug/Exceptions.php(141): CodeIgniter\Debug\Exceptions->respond(Array, 500)
#4 [internal function]: CodeIgniter\Debug\Exceptions->exceptionHandler(Object(ErrorException))
#5 {mai
#0 [internal function]: CodeIgniter\Debug\Exceptions->shutdownHandler()
#1 {main}
CRITICAL - 2021-07-28 19:49:01 --> Undefined index: Data
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined index...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:49:01 --> Uncaught CodeIgniter\Format\Exceptions\FormatException: Failed to parse json string, error: "Type is not supported". in /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php:42
Stack trace:
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php(42): CodeIgniter\Format\Exceptions\FormatException::forInvalidJSON('Type is not sup...')
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(423): CodeIgniter\Format\JSONFormatter->format(Array)
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(114): CodeIgniter\Debug\Exceptions->format(Array)
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Debug/Exceptions.php(141): CodeIgniter\Debug\Exceptions->respond(Array, 500)
#4 [internal function]: CodeIgniter\Debug\Exceptions->exceptionHandler(Object(ErrorException))
#5 {mai
#0 [internal function]: CodeIgniter\Debug\Exceptions->shutdownHandler()
#1 {main}
CRITICAL - 2021-07-28 19:49:02 --> Undefined index: Data
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined index...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:49:02 --> Uncaught CodeIgniter\Format\Exceptions\FormatException: Failed to parse json string, error: "Type is not supported". in /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php:42
Stack trace:
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php(42): CodeIgniter\Format\Exceptions\FormatException::forInvalidJSON('Type is not sup...')
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(423): CodeIgniter\Format\JSONFormatter->format(Array)
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(114): CodeIgniter\Debug\Exceptions->format(Array)
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Debug/Exceptions.php(141): CodeIgniter\Debug\Exceptions->respond(Array, 500)
#4 [internal function]: CodeIgniter\Debug\Exceptions->exceptionHandler(Object(ErrorException))
#5 {mai
#0 [internal function]: CodeIgniter\Debug\Exceptions->shutdownHandler()
#1 {main}
CRITICAL - 2021-07-28 19:49:06 --> Undefined index: Data
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined index...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:49:06 --> Uncaught CodeIgniter\Format\Exceptions\FormatException: Failed to parse json string, error: "Type is not supported". in /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php:42
Stack trace:
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php(42): CodeIgniter\Format\Exceptions\FormatException::forInvalidJSON('Type is not sup...')
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(423): CodeIgniter\Format\JSONFormatter->format(Array)
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(114): CodeIgniter\Debug\Exceptions->format(Array)
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Debug/Exceptions.php(141): CodeIgniter\Debug\Exceptions->respond(Array, 500)
#4 [internal function]: CodeIgniter\Debug\Exceptions->exceptionHandler(Object(ErrorException))
#5 {mai
#0 [internal function]: CodeIgniter\Debug\Exceptions->shutdownHandler()
#1 {main}
CRITICAL - 2021-07-28 19:50:03 --> Undefined index: Data
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined index...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:50:03 --> Uncaught CodeIgniter\Format\Exceptions\FormatException: Failed to parse json string, error: "Type is not supported". in /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php:42
Stack trace:
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php(42): CodeIgniter\Format\Exceptions\FormatException::forInvalidJSON('Type is not sup...')
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(423): CodeIgniter\Format\JSONFormatter->format(Array)
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(114): CodeIgniter\Debug\Exceptions->format(Array)
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Debug/Exceptions.php(141): CodeIgniter\Debug\Exceptions->respond(Array, 500)
#4 [internal function]: CodeIgniter\Debug\Exceptions->exceptionHandler(Object(ErrorException))
#5 {mai
#0 [internal function]: CodeIgniter\Debug\Exceptions->shutdownHandler()
#1 {main}
CRITICAL - 2021-07-28 19:50:04 --> Undefined index: Data
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined index...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:50:04 --> Uncaught CodeIgniter\Format\Exceptions\FormatException: Failed to parse json string, error: "Type is not supported". in /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php:42
Stack trace:
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Format/JSONFormatter.php(42): CodeIgniter\Format\Exceptions\FormatException::forInvalidJSON('Type is not sup...')
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(423): CodeIgniter\Format\JSONFormatter->format(Array)
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/API/ResponseTrait.php(114): CodeIgniter\Debug\Exceptions->format(Array)
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Debug/Exceptions.php(141): CodeIgniter\Debug\Exceptions->respond(Array, 500)
#4 [internal function]: CodeIgniter\Debug\Exceptions->exceptionHandler(Object(ErrorException))
#5 {mai
#0 [internal function]: CodeIgniter\Debug\Exceptions->shutdownHandler()
#1 {main}
CRITICAL - 2021-07-28 19:51:28 --> Undefined index: Data
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined index...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:51:53 --> Undefined index: no_dok
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(52): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined index...', '/Applications/X...', 52, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:53:52 --> Invalid argument supplied for foreach()
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Invalid argumen...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:54:16 --> Invalid argument supplied for foreach()
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Invalid argumen...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:54:50 --> Invalid argument supplied for foreach()
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Invalid argumen...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 19:56:55 --> Invalid argument supplied for foreach()
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(83): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Invalid argumen...', '/Applications/X...', 83, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 20:02:57 --> Invalid argument supplied for foreach()
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(83): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Invalid argumen...', '/Applications/X...', 83, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 20:06:46 --> Invalid argument supplied for foreach()
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(83): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Invalid argumen...', '/Applications/X...', 83, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 20:07:31 --> Invalid argument supplied for foreach()
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Invalid argumen...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 20:09:03 --> Undefined index: Data
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined index...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-28 22:52:04 --> parse_ini_file(path/to/the/ini/file/I/pasted/above): failed to open stream: No such file or directory
#0 [internal function]: CodeIgniter\Debug\Exceptions->errorHandler(2, 'parse_ini_file(...', '/Applications/X...', 121, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(121): parse_ini_file('path/to/the/ini...')
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#6 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#7 {main}
CRITICAL - 2021-07-28 22:52:14 --> parse_ini_file(path/to/the/ini/file/I/pasted/above): failed to open stream: No such file or directory
#0 [internal function]: CodeIgniter\Debug\Exceptions->errorHandler(2, 'parse_ini_file(...', '/Applications/X...', 121, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(121): parse_ini_file('path/to/the/ini...')
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#6 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#7 {main}
CRITICAL - 2021-07-28 22:54:45 --> parse_ini_file(path/to/the/ini/file/I/pasted/above): failed to open stream: No such file or directory
#0 [internal function]: CodeIgniter\Debug\Exceptions->errorHandler(2, 'parse_ini_file(...', '/Applications/X...', 165, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(165): parse_ini_file('path/to/the/ini...')
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#6 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#7 {main}
CRITICAL - 2021-07-28 22:55:26 --> parse_ini_file(path/to/the/ini/file/I/pasted/above): failed to open stream: No such file or directory
#0 [internal function]: CodeIgniter\Debug\Exceptions->errorHandler(2, 'parse_ini_file(...', '/Applications/X...', 165, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(165): parse_ini_file('path/to/the/ini...')
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#6 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#7 {main}
CRITICAL - 2021-07-28 22:57:02 --> parse_ini_file(path/to/the/ini/file/I/pasted/above): failed to open stream: No such file or directory
#0 [internal function]: CodeIgniter\Debug\Exceptions->errorHandler(2, 'parse_ini_file(...', '/Applications/X...', 170, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(170): parse_ini_file('path/to/the/ini...')
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#6 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#7 {main}
CRITICAL - 2021-07-28 22:58:54 --> curl_getinfo(): supplied resource is not a valid cURL handle resource
#0 [internal function]: CodeIgniter\Debug\Exceptions->errorHandler(2, 'curl_getinfo():...', '/Applications/X...', 160, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(160): curl_getinfo(Resource id #120)
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#6 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#7 {main}
CRITICAL - 2021-07-28 22:59:55 --> curl_getinfo(): supplied resource is not a valid cURL handle resource
#0 [internal function]: CodeIgniter\Debug\Exceptions->errorHandler(2, 'curl_getinfo():...', '/Applications/X...', 169, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(169): curl_getinfo(Resource id #120)
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#6 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#7 {main}
CRITICAL - 2021-07-28 23:04:07 --> curl_getinfo(): supplied resource is not a valid cURL handle resource
#0 [internal function]: CodeIgniter\Debug\Exceptions->errorHandler(2, 'curl_getinfo():...', '/Applications/X...', 169, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(169): curl_getinfo(Resource id #120, 2097154)
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#6 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#7 {main}
CRITICAL - 2021-07-28 23:17:28 --> curl_getinfo(): supplied resource is not a valid cURL handle resource
#0 [internal function]: CodeIgniter\Debug\Exceptions->errorHandler(2, 'curl_getinfo():...', '/Applications/X...', 169, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(169): curl_getinfo(Resource id #120, 2097154)
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#6 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#7 {main}
