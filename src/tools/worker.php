<?php
/**
 * Created by PhpStorm.
 * User: xiashuang
 * Date: 2017/10/29
 * Time: 09:28
 */

namespace Tools\tools;


class worker  extends \Worker
{
   public function __construct()
   {
   }

   public function run()
   {
       parent::run();
   }
}