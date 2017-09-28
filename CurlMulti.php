<?php
/**
 * Created by PhpStorm.
 * User: Jaeger <JaegerCode@gmail.com>
 * Date: 2017/9/27
 * Curl multi threading
 */

namespace QL\Ext;

use Ares333\CurlMulti\Core;
use QL\Contracts\PluginContract;
use QL\QueryList;
use Closure;

class CurlMulti implements PluginContract
{
    protected $urls;
    protected $queryList;
    protected $successCallback;
    protected $curl;


    public function __construct(QueryList $queryList,$urls)
    {
        $this->queryList = $queryList;
        $this->urls = $urls;
        $this->curl = new Core();
    }


    public static function install(QueryList $queryList, ...$opt)
    {
        $queryList->bind('curlMulti',function (array $urls){
            return new CurlMulti($this,$urls);
        });
    }

    public function success(Closure $callback)
    {
        $this->successCallback = function ($r) use($callback){
            $this->queryList->setHtml($r['body']);
           $callback($this->queryList,$r);
        };
        return $this;
    }

    public function error(Closure $callback)
    {
        $this->curl->cbFail = $callback;
        return $this;
    }

    public function start(array $opt = [])
    {
        $this->bindOpt($opt);
        $this->addTask();
        $this->curl->start();
    }

    protected function bindOpt($opt)
    {
        foreach ($opt as $key => $value) {
            $this->curl->$key = $value;
        }
    }

    protected function addTask()
    {
        foreach ($this->urls as $url) {
            $this->curl->add([
                'opt' => array(
                    CURLOPT_URL => $url
                )
            ],$this->successCallback);
        }
    }

}