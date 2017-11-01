<?php
/**
 * Created by PhpStorm.
 * User: xiashuang
 * Date: 2017/11/1
 * Time: 10:52
 */


//    public function test()
//    {
//        Redis::set('testa',time());
//    }
//
//    /**
//     * 'accumUserDealAmount'=>$this->getAccumUserDealAmount(),
//    'accumUserEarnings'=>$this->getAccumUserEarnings(),
//    'regUserCount'=>$this->getRegUserCount(),
//    'accumUserDealCount'=>$this->getAccumUserDealCount(),
//    'accumDueUser'=>$this->getAccumDueUser(),
//    'singleDueUser'=>$this->getSingleDueUser(),
//    'highestCountDueUser'=>$this->getHighestCountDueUser(),
//    'accumProvinceAmount'=>$this->getAccumProvinceAmount(),
//    'highestInvestSuccessUser'=>$this->getHighestInvestSuccessUser(),
//     */
//    public function test1()
//    {
//        $arr = [];
//        $arr1 = [];
//        $list = [
//            'getAccumUserDealAmount',
//            'getAccumUserEarnings',
//            'getRegUserCount',
////            'getAccumUserDealCount',
////            'getAccumDueUser',
//            'getSingleDueUser',
////            'getHighestCountDueUser',
////            'getAccumProvinceAmount',
////            'getHighestInvestSuccessUser',
//        ];
//
////        $this->getSingleDueUser();
//////
//        $th = new ApiController($this,'getSingleDueUser');
//        $th->start();
//         echo '<pre>';
//        while($th->isRunning()){
//            usleep(10);
//        }
//        if ($th->join()){
//             var_dump($th);
//        }
////        $st = microtime(true);
////        foreach ($list as $k => $v){
////            $arr[$k] = new ApiController($this,$v);
////            $arr[$k]->start();
////        }
////        foreach ($arr as $k => $v){
////            while($arr[$k]->isRunning()){
////                usleep(10);
////            }
////            if ($arr[$k]->join()){
////                var_dump($arr[$k]->data);
////            }
////        }
////        $et =  microtime(true);
////        var_dump($arr1);
////        echo '总用用时'.($et-$st);
//    }
