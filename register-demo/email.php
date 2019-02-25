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
        if ($job === null) {
            throw new Exception('没有任务');
        }

        // 发送邮件
        if (sendEmail($job->getData())) {
            //  处理成功
            $conn->delete($job);
        } else {
            // 处理失败
            $conn->release();
        }
    } catch (Exception $e) {
        print_r($e->getMessage());
        die();
    }

    echo "欢迎邮件发送成功<br>";
    usleep(500000); //  每 500ms 接收 job
}