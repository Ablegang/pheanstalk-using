<?php
// +----------------------------------------------------------------------
// | other.php
// +----------------------------------------------------------------------
// | Description: 其他命令
// +----------------------------------------------------------------------
// | Time: 2019/1/16 上午10:48
// +----------------------------------------------------------------------
// | Author: Object,半醒的狐狸<2252390865@qq.com>
// +----------------------------------------------------------------------

include_once "vendor/autoload.php";

$conn = \Pheanstalk\Pheanstalk::create('beanstalkd');

//$conn->useTube('sms');
//$job = $conn->peek(new \Pheanstalk\Job(1,'')); // 根据 id 返回 job ，所有 tube 中，id 是唯一的，所以 watchOnly 对 peek 操作没有影响
//$job1 = $conn->peekReady();
//$job2 = $conn->peekDelayed();
//$job3 = $conn->peekBuried();
//
//print_r($job);
//echo '--';
//print_r($job1);
//echo '--';
//print_r($job2);
//echo '--';
//print_r($job3);
//echo '--';

//$conn->useTube('sms');
//$num = $conn->kick(10);
//print_r($num);

//$conn->useTube('sms');
//$conn->kickJob($job);

//$job = $conn->reserve();
//$stats = $conn->statsJob($job);
//print_r($stats);

//$res = $conn->statsTube('default');
//print_r($res);

//$res = $conn->listTubes();
//print_r($res);

//$res = $conn->listTubeUsed();
//print_r($res);

//$res = $conn->listTubesWatched();
//print_r($res);

//$conn->pauseTube('default',90);