<?php
// +----------------------------------------------------------------------
// | consumer.php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Time: 2019/1/8 下午6:06
// +----------------------------------------------------------------------
// | Author: Object,半醒的狐狸<2252390865@qq.com>
// +----------------------------------------------------------------------

include_once "vendor/autoload.php";

$conn = \Pheanstalk\Pheanstalk::create('beanstalkd');

//$job = $conn->reserve(); // 默认情况会接收 default tube 的 job
//print_r($job); // 如果 reserve 没能得到 job ，就会一直阻塞在上面

//$conn->watch('test')->watch('big');
//$conn->ignore('default');
//$conn->watchOnly('order');

try {
    $job2 = $conn->reserveWithTimeout(10);  // 阻塞接收，10秒之后超时，就不再接收了
    print_r($job2);
    if ($job2 === null) {
        throw new Exception('超时了');
    }

    // 处理 job ...

   $conn->delete($job2); // 处理成功，删除这个 job

    $conn->release($job2); // 处理没成功，将 job 从 reserved 状态改回 ready

    $conn->bury($job2); // 不具备处理 job 的条件，将 job 状态改为 buried

    $conn->touch($job2); // 处理时间过长，ttr 不够用，延长一次 ttr

} catch (\Pheanstalk\Exception\DeadlineSoonException $e) {
    print_r('deadline soon' . $e->getMessage());
} catch (Exception $e) {
    print_r($e->getMessage());
}
