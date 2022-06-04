# papi
papi is a client library for working with API in an object oriented style<br>
install: composer require noc-vissor/papi
<a href="#request">Request</a><br>
<a href="#auth">Authorization</a><br>
<a href="#api">Api</a><br>
<a href="#cache">Cache</a>

____
<h2 name="request">Request object</h2>
create Request object:<br>

```php
<?php
use NocVissor\Papi\Request;
$request = new Request([
    "headers" => [
       "token" => "..."
     ],
    "post" => [
       "data" => "somedata"
     ],
    "get" => [
       "page" => "2"
     ],
]);
```
Request constructor accepts an associative array with subarrays: headers, post, get (any of these subarrays may not be passed, then an empty array will be set for it)

```php
<?php
use NocVissor\Papi\Request;
$request = new Request([
    "headers" => [
       "token" => "..."
     ],
    "post" => [
       "data" => "somedata"
     ]
]);
```

Request object has get, post, headers propertyies, they can be changed after initializations:

```php
<?php
use NocVissor\Papi\Request;
$request = new Request();
$request->post['data'] = 'somebody';
```

<h3>Request methods:</h3>
  <h4>merge</h4>
  static function, accept an unlimited request objects and combines their properties, if several objects have the same properties, the properties of the object passed earlier are accepted


  ```php
  <?php
  use NocVissor\Papi\Request;
    $request1 = new Request([
        'post' => [
            'par1' => 'val1',
            'par2' => 'val2'
        ]
    ]);
    $request2 = new Request([
        'post' => [
            'par2' => 'newVal2',
            'par3' => 'val3'
        ]
    ]);
    // request2 passed by first parametr, so request2 has hightly priotity than request1
    $new_request = Request::merge($request2, $request1);
    print_r($new_request);

    // [post] => Array
    // (
    //     [par2] => newVal2
    //     [par3] => val3
    //     [par1] => val1
    // )
  ```
____
<h2 name="auth">Authorization</h2>
  Authorization is abstract class, use a ready-made class, or create a new class that inherits the class Auth (see examples/telegram.php)
  <h3>Methods</h3>
  <h4>link</h4>
  accept Api object, and called from Api object when it is called auth method, Api object pass itself to Auth, for Auth using Api object

  ```php
  <?php
  use NocVissor\Papi\Request;
  use NocVissor\Papi\Auth\Auth;
  use NocVissor\Papi\Api;

  class TokenAuth extends Auth{
    private $token;
    function __construct($token)
    {
      parent::__construct();
      $this->token = $token;
      $this->request = new Request([
          'headers' => [
              'token' => $token
          ]
      ]);
    }
    protected function link(Api $api){
      parent::link($api);
      $api->base_url = "https://site.com/api/$this->token"
    }  
  }

  $api = new Api();
  $token = 'token';
  $auth = new TokenAuth($token);
  $api->auth($auth);
  ```
____
<h2 name="api">Api</h2>
  Api is the general object, through it call api queries.
  Api constructor accept base_url param

  ```php
  <?php
  use NocVissor\Papi\Request;
  use NocVissor\Papi\Auth\BearerAuth;
  use NocVissor\Papi\Api;

  $api = new Api('https://example.com/api');
  // create bearer token auth
  $auth = new BearerAuth('token');
  // link auth object to api object
  $api->auth($auth);

  // set base request
  $api->setBase(new Request(['get'=>[
    'a' => 'b'
  ]]));

    // merge base request (original base request has priotity on passed request)
  $api->mergeBase(new Request(['get'=>[
    'a' => 'c',
    '222' => 'ttt'
  ]]));
  // result $api->based_request->get['a']    -   b



  // put, post, get, patch, delete methods accept url relative base_url and request object
  $api->put('/items/add', new Request([
    'post' => [
      'name' => 'test_name'
    ]
  ]));

  ```
  Api also method query for detailed query<br>
  accept data array, items:<br>
  url, method, is_absolute, ch, request<br>
  required: url, method
  
  ```php
  <?php
  use NocVissor\Papi\Request;
  use NocVissor\Papi\Api;
  $api = new Api('https://example.com/api');

  $custom_ch = curl_init();
  curl_setopt($custom_ch, CURLOPT_EXPECT_100_TIMEOUT_MS, 100000);
  $api->query([
    'url' => 'https://example.com/api2/items/add', // required
    'method' => 'put', // required, valid values: put, post, patch, get, delete 
    'is_absolute' => true, // bool
    'request' => new Request([  // request object
      'post' => [
        'name' => 'test_name'
        ]
    ]),
    'ch' => $custom_ch
  ]);

  ```


  ____
<h2 name="cache">Cache</h2>
Api oject property
default path: './cache'

  ```php
  <?php
  use NocVissor\Papi\Api;
  $api = new Api();
  $api->cache->setPath('../../path');
  $api->cache->put('token.json', json_encode([
    'access' => 'aaa',
    'refresh' => 'bbb'
  ]));
  $file = $api->cache->get('token.json');

  ```
  can be used in auth for save token or other data (see Auth/SkorozvonAuth.php)