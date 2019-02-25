<?php
// +----------------------------------------------------------------------
// | email.php
// +----------------------------------------------------------------------
// | Description: 
// +----------------------------------------------------------------------
// | Time: 2019/1/16 下午1:47
// +----------------------------------------------------------------------
// | Author: Object,半醒的狐狸<2252390865@qq.com>
// +----------------------------------------------------------------------

include_once "../vendor/autoload.php";

use Pheanstalk\Pheanstalk;

$conn = Pheanstalk::create('beanstalkd', 11300, 10);
$conn->watchOnly('register_email');

function sendEmail($user)
{
    return random_int(0, 1); //  取随机数，模拟发送成功与失败
}

while (1) {
    try {
        $job = $conn->reserve();

        // 发送邮件
        if (sendEmail($job->getData())) {
            //  处理成功
            $conn->delete($job);
        } else {
            // 处理失败
            print_r("处理失败，调用 release 后重新处理");
            $conn->release($job);
        }
    } catch (Exception $e) {
        print_r($e->getMessage());
    }

    echo "欢迎邮件发送成功\r\n";
    usleep(500000); //  每 500ms 接收 job
}