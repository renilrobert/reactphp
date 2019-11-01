<?php

require_once __DIR__.'/bootstrap.php';
require_once __DIR__.'/V8Js.php';

$parts = api\getPath();

$users = api\getData();
$detail = null;

if ($parts[1] === 'users') {
	$detail = !empty($parts[2]) ? api\getData($parts[2]) : "";
}

$v8 = new V8Js();
$props = [
	'users' => $users, 
	'info' => $detail
];
$propsJson = json_encode($props);

// $react = [
//        file_get_contents(__DIR__.'/nodemodules/react.min.js'),
//        file_get_contents(__DIR__.'/nodemodules/react-dom.min.js'),
//        file_get_contents(__DIR__.'/bundle.js'),
//        'React.renderToString(React.createElement(App, ' . $propsJson . '))'
// ];

// try {
// 	$reactStr = $v8->executeString(implode(PHP_EOL, $react));
// } catch (Exception $e) {
// 	echo '<h1>', $e->getMessage(), '</h1>';
// 	echo '<pre>', $e->getTraceAsString(), '</pre>';
// 	exit;
// }

// $reactStr = null;


//$propsJson = '{}';
?><!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Easy Learn Tutorial - Isomorphic React.js with PHP</title>

    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .cell {
    	text-align: center;
    	border-bottom: 1px dashed #aaa;
    }
    .cell:nth-child(3n + 2) {
    	border-left: 1px dashed #aaa;
    	border-right: 1px dashed #aaa;
    }
    </style>
  </head>

  <body>
    <div class="container" style="margin-top: 20px;" id="app"></div>

    <script src="/reactphp/nodemodules/jquery-3.4.1.min.js"></script>
    <script src="https://unpkg.com/react@15/dist/react.js"></script>
    <script src="https://unpkg.com/react-dom@15/dist/react-dom.js"></script>
    <script src="/reactphp/bundle.js?t=<?= time(); ?>"></script>

    <script>
    ReactDOM.render(
    	React.createElement(App, <?= $propsJson; ?>), document.getElementById('app')
	);
    </script>
  </body>
</html>
