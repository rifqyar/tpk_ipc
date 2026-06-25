<?php

use Config\Services;

class HealthTest extends \CodeIgniter\Test\CIUnitTestCase
{
	public function setUp(): void
	{
		parent::setUp();
	}

	public function testIsDefinedAppPath()
	{
		$test = defined('APPPATH');

		$this->assertTrue($test);
	}

	public function testBaseUrlHasBeenSet()
	{
		$validation = Services::validation();
		$env        = false;

		// Check the baseURL in .env
		if (is_file(HOMEPATH . '.env'))
		{
			$env = (bool) preg_grep('/^app\.baseURL = ./', file(HOMEPATH . '.env'));
		}

		if ($env)
		{
			// BaseURL in .env is a valid URL?
			// phpunit.xml.dist sets app.baseURL in $_SERVER
			// So if you set app.baseURL in .env, it takes precedence
			$config = new Config\App();
			$this->assertTrue(
				$validation->check($config->baseURL, 'valid_url'),
				'baseURL "' . $config->baseURL . '" in .env is not valid URL'
			);
		}

		// Get the baseURL in app/Config/App.php
		// You can't use Config\App, because phpunit.xml.dist sets app.baseURL
		$reader = new \Tests\Support\Libraries\ConfigReader();

		// BaseURL in app/Config/App.php is a valid URL?
		$this->assertTrue(
			$validation->check($reader->baseURL, 'valid_url'),
			'baseURL "' . $reader->baseURL . '" in app/Config/App.php is not valid URL'
		);
	}
}
tions/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#9 {main}
CRITICAL - 2021-07-27 05:40:57 --> 22 : The requested URL returned error: 401 Unauthorized
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/HTTP/CURLRequest.php(796): CodeIgniter\HTTP\Exceptions\HTTPException::forCurlError('22', 'The requested U...')
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/HTTP/CURLRequest.php(409): CodeIgniter\HTTP\CURLRequest->sendRequest(Array)
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/HTTP/CURLRequest.php(125): CodeIgniter\HTTP\CURLRequest->send('GET', 'http://localhos...')
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(18): CodeIgniter\HTTP\CURLRequest->request('GET', 'http://localhos...')
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#6 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#7 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#8 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#9 {main}
CRITICAL - 2021-07-27 05:41:43 --> 22 : The requested URL returned error: 401 Unauthorized
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/HTTP/CURLRequest.php(796): CodeIgniter\HTTP\Exceptions\HTTPException::forCurlError('22', 'The requested U...')
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/HTTP/CURLRequest.php(409): CodeIgniter\HTTP\CURLRequest->sendRequest(Array)
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/HTTP/CURLRequest.php(125): CodeIgniter\HTTP\CURLRequest->send('GET', 'http://localhos...')
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(18): CodeIgniter\HTTP\CURLRequest->request('GET', 'http://localhos...')
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#6 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#7 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#8 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#9 {main}
CRITICAL - 2021-07-27 05:41:45 --> 22 : The requested URL returned error: 401 Unauthorized
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/HTTP/CURLRequest.php(796): CodeIgniter\HTTP\Exceptions\HTTPException::forCurlError('22', 'The requested U...')
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/HTTP/CURLRequest.php(409): CodeIgniter\HTTP\CURLRequest->sendRequest(Array)
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/HTTP/CURLRequest.php(125): CodeIgniter\HTTP\CURLRequest->send('GET', 'http://localhos...')
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(18): CodeIgniter\HTTP\CURLRequest->request('GET', 'http://localhos...')
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#6 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#7 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#8 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#9 {main}
CRITICAL - 2021-07-27 05:44:43 --> 22 : The requested URL returned error: 401 Unauthorized
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/HTTP/CURLRequest.php(796): CodeIgniter\HTTP\Exceptions\HTTPException::forCurlError('22', 'The requested U...')
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/HTTP/CURLRequest.php(409): CodeIgniter\HTTP\CURLRequest->sendRequest(Array)
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/HTTP/CURLRequest.php(125): CodeIgniter\HTTP\CURLRequest->send('GET', 'http://localhos...')
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(18): CodeIgniter\HTTP\CURLRequest->request('GET', 'http://localhos...')
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#6 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#7 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#8 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#9 {main}
CRITICAL - 2021-07-27 05:51:06 --> Array to string conversion
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(26): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Array to string...', '/Applications/X...', 26, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 05:51:33 --> Array to string conversion
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(26): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Array to string...', '/Applications/X...', 26, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 05:58:25 --> Illegal string offset 'data'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(37): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 37, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 05:59:04 --> Illegal string offset 'data'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(39): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 39, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 05:59:28 --> Illegal string offset 'data'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(39): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 39, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:03:47 --> Trying to get property 'data' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(39): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 39, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:05:03 --> Trying to get property 'data' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(39): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 39, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:05:54 --> Trying to get property 'data' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(39): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 39, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:06:20 --> Trying to get property 'Data' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(39): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 39, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:06:43 --> Trying to get property 'Data' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(39): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 39, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:07:54 --> Object of class stdClass could not be converted to string
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(39): CodeIgniter\Debug\Exceptions->errorHandler(4096, 'Object of class...', '/Applications/X...', 39, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:08:03 --> Array to string conversion
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(39): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Array to string...', '/Applications/X...', 39, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:08:21 --> Cannot use object of type stdClass as array
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#5 {main}
CRITICAL - 2021-07-27 06:08:31 --> Undefined index: NO_DOK
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(39): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined index...', '/Applications/X...', 39, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:09:19 --> Cannot use object of type stdClass as array
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#5 {main}
CRITICAL - 2021-07-27 06:10:41 --> Trying to get property 'Data' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(39): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 39, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:10:59 --> Trying to get property 'Data' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(39): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 39, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:11:55 --> Trying to get property 'message' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(39): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 39, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:13:25 --> Undefined property: stdClass::$data
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(39): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined prope...', '/Applications/X...', 39, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:14:26 --> Trying to get property 'Data' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(39): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 39, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:16:31 --> Trying to get property 'Data' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(39): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 39, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:16:34 --> Trying to get property 'Data' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(39): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 39, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:16:46 --> Trying to get property 'Data' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(39): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 39, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:18:01 --> Trying to get property 'Data' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(39): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 39, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:18:22 --> Object of class stdClass could not be converted to string
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(39): CodeIgniter\Debug\Exceptions->errorHandler(4096, 'Object of class...', '/Applications/X...', 39, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:18:43 --> Array to string conversion
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(39): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Array to string...', '/Applications/X...', 39, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:20:51 --> Trying to get property 'message' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(40): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 40, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:23:32 --> Illegal string offset 'TYPE_DOK'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(41): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 41, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:24:36 --> Trying to get property 'message' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(41): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 41, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:24:45 --> Trying to get property 'message' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(41): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 41, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:26:57 --> Trying to get property 'message' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(41): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 41, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:27:31 --> Trying to get property 'message' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(41): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 41, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:27:52 --> Illegal string offset 'data'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(41): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 41, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:28:01 --> Illegal string offset 'message'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(41): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 41, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:28:17 --> Uninitialized string offset: 1
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(41): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Uninitialized s...', '/Applications/X...', 41, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:28:50 --> Illegal string offset 'data'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(41): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 41, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:29:24 --> Illegal string offset 'message'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(41): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 41, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:30:11 --> Array to string conversion
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(41): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Array to string...', '/Applications/X...', 41, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:31:54 --> Array to string conversion
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(41): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Array to string...', '/Applications/X...', 41, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:37:27 --> Array to string conversion
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(41): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Array to string...', '/Applications/X...', 41, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:43:41 --> Trying to get property 'message' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(41): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 41, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:44:26 --> Trying to get property 'message' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(39): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 39, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:45:08 --> Undefined offset: 0
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(39): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined offse...', '/Applications/X...', 39, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:45:29 --> Trying to get property 'message' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(39): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 39, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:45:58 --> Trying to get property 'message' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(39): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 39, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:48:46 --> Object of class stdClass could not be converted to string
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(39): CodeIgniter\Debug\Exceptions->errorHandler(4096, 'Object of class...', '/Applications/X...', 39, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:49:28 --> Array to string conversion
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(39): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Array to string...', '/Applications/X...', 39, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:50:03 --> Trying to get property 'Data' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(39): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 39, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:50:26 --> Trying to get property 'Data' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(39): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 39, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:51:23 --> Trying to get property 'Data' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(39): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 39, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:52:10 --> Trying to get property 'Data' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(39): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 39, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:54:10 --> Array to string conversion
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(39): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Array to string...', '/Applications/X...', 39, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:55:23 --> Array to string conversion
#0 [internal function]: CodeIgniter\Debug\Exceptions->errorHandler(8, 'Array to string...', '/Applications/X...', 39, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(39): implode(' ', Array)
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#6 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#7 {main}
CRITICAL - 2021-07-27 06:56:39 --> Undefined offset: 0
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(39): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined offse...', '/Applications/X...', 39, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:56:53 --> Trying to get property 'message' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(39): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 39, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:58:08 --> Trying to get property 'message' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(41): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 41, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:58:51 --> Undefined offset: 0
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(41): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined offse...', '/Applications/X...', 41, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:59:25 --> Illegal string offset 'Data'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(41): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 41, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 06:59:56 --> Array to string conversion
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(43): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Array to string...', '/Applications/X...', 43, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 07:00:28 --> Array to string conversion
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(43): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Array to string...', '/Applications/X...', 43, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 07:00:29 --> Array to string conversion
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(43): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Array to string...', '/Applications/X...', 43, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 07:02:02 --> Undefined offset: 0
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(41): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined offse...', '/Applications/X...', 41, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 07:02:15 --> Array to string conversion
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(43): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Array to string...', '/Applications/X...', 43, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 07:02:50 --> Illegal string offset 'Data'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(41): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 41, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 07:04:43 --> Array to string conversion
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(44): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Array to string...', '/Applications/X...', 44, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 07:05:15 --> Array to string conversion
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(43): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Array to string...', '/Applications/X...', 43, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 07:06:28 --> Undefined index: data
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(41): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Undefined index...', '/Applications/X...', 41, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 07:06:55 --> Array to string conversion
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(43): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Array to string...', '/Applications/X...', 43, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 07:13:38 --> Trying to get property 'NO_DOK' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(44): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 44, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 07:14:35 --> Trying to get property 'NO_DOK' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(44): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 44, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 07:15:03 --> Array to string conversion
#0 [internal function]: CodeIgniter\Debug\Exceptions->errorHandler(8, 'Array to string...', '/Applications/X...', 43, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(43): str_replace(Array, '', '{\n    "message"...')
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#6 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#7 {main}
CRITICAL - 2021-07-27 07:18:40 --> Trying to get property 'NO_DOK' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(41): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 41, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 07:19:05 --> Trying to get property 'array' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(41): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 41, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 07:19:52 --> Trying to get property 'Data' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(41): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 41, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 07:23:45 --> Illegal string offset 'Data'
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(45): CodeIgniter\Debug\Exceptions->errorHandler(2, 'Illegal string ...', '/Applications/X...', 45, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 07:24:36 --> Object of class stdClass could not be converted to string
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(4096, 'Object of class...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Applications/X...')
#6 {main}
CRITICAL - 2021-07-27 07:26:59 --> Trying to get property 'TYPE_DOK' of non-object
#0 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/app/Controllers/Curl.php(49): CodeIgniter\Debug\Exceptions->errorHandler(8, 'Trying to get p...', '/Applications/X...', 49, Array)
#1 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(928): App\Controllers\Curl->index()
#2 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(436): CodeIgniter\CodeIgniter->runController(Object(App\Controllers\Curl))
#3 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/CodeIgniter.php(336): CodeIgniter\CodeIgniter->handleRequest(NULL, Object(Config\Cache), false)
#4 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/public/index.php(37): CodeIgniter\CodeIgniter->run()
#5 /Applications/XAMPP/xamppfiles/htdocs/ApiBos/vendor/codeigniter4/framework/system/Commands/Server/rewrite.php(45): require_once('/Appl