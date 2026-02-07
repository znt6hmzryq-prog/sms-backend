<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

use Illuminate\Http\Request;

$data = ['email' => 'admin@sms.local', 'password' => 'password'];
$request = Request::create('/api/login', 'POST', [], [], [], ['CONTENT_TYPE' => 'application/json'], json_encode($data));
$response = $kernel->handle($request);
echo $response->getContent();
$kernel->terminate($request, $response);
