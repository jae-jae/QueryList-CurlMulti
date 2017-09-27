<?php
/**
 * Created by PhpStorm.
 * User: Jaeger <JaegerCode@gmail.com>
 * Date: 2017/9/27
 */

namespace QL\Ext;

use QL\Contracts\PluginContract;
use QL\QueryList;

class CurlMulti implements PluginContract
{
    protected $urls;

    /**
     * CurlMulti constructor.
     * @param $urls
     */
    public function __construct($urls)
    {
        $this->urls = $urls;
    }


    public static function install(QueryList $queryList, ...$opt)
    {
        $queryList->bind('curlMulti',function (array $urls){

        });
    }

    public function success()
    {

    }

    public function error()
    {

    }

    public static function start()
    {

    }

}