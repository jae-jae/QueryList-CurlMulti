# QueryList-CurlMulti
QueryList Plugin: Curl multi threading. 

QueryList插件: Curl多线程.

> QueryList:[https://github.com/jae-jae/QueryList](https://github.com/jae-jae/QueryList)

## Installation for QueryList4
```
composer require jaeger/querylist-curl-multi
```

## API
-  CurlMulti **curlMulti($urls = [])**: Set the list of URLs to be collected.

-  class **CurlMulti** 
	- CurlMulti **add($urls)**:Add url task.
	- array **getUrls()**:Get all url.
	- CurlMulti **success(Closure $callback)**:Called if task is success.
	-  CurlMulti **error(Closure $callback)**:Callback for failed tasks.
	-  CurlMulti **start(array $opt = [])**:Start all tasks.This is a blocked method.

## Installation options

 **QueryList::use(CurlMulti::class,$opt1)**
- **$opt1**:`curlMulti` function alias.

## Usage

- Installation Plugin

```php
use QL\QueryList;
use QL\Ext\CurlMulti;

$ql = QueryList::getInstance();
$ql->use(CurlMulti::class);
//or Custom function name
$ql->use(CurlMulti::class,'curlMulti');
```
- Example1

Collecting GitHub Trending:
```php
$ql->rules([
    'title' => ['h3 a','text'],
    'link' => ['h3 a','href']
])->curlMulti([
    'https://github.com/trending/php',
    'https://github.com/trending/go'
])->success(function (QueryList $ql,CurlMulti $curl,$r){
    echo "Current url:{$r['info']['url']} \r\n";
    $data = $ql->query()->getData();
    print_r($data->all());
})->start();
```
Out:
```
Current url:https://github.com/trending/php
Array
(
    [0] => Array
        (
            [title] => jupeter / clean-code-php
            [link] => /jupeter/clean-code-php
        )
    [1] => Array
        (
            [title] => laravel / laravel
            [link] => /laravel/laravel
        )
    [2] => Array
        (
            [title] => spatie / browsershot
            [link] => /spatie/browsershot
        )
   //....
)

Current url:https://github.com/trending/go
Array
(
    [0] => Array
        (
            [title] => DarthSim / imgproxy
            [link] => /DarthSim/imgproxy
        )
    [1] => Array
        (
            [title] => jaegertracing / jaeger
            [link] => /jaegertracing/jaeger
        )
    [2] => Array
        (
            [title] => jdkato / prose
            [link] => /jdkato/prose
        )
  //...
)

```