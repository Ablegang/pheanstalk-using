<?php
// +----------------------------------------------------------------------
// | register.php
// +----------------------------------------------------------------------
// | Description: 注册
// +----------------------------------------------------------------------
// | Time: 2019/1/16 下午1:47
// +----------------------------------------------------------------------
// | Author: Object,半醒的狐狸<2252390865@qq.com>
// +----------------------------------------------------------------------

require_once "../vendor/autoload.php";

use Medoo\Medoo;
use Pheanstalk\Pheanstalk;

// demo 只为演示如何使用 pheanstalk  ，所以不做精细化处理，如注入、加密、字段设计等，只能用于简单测试
$param = getopt('u:p:e:m:');
$username = $param['u'];
$password = $param['p'];
$email = $param['e'];
$phone = $param['m'];

$db = new  Medoo([
    'database_type' => 'mysql',
    'database_name' => 'test',
    'server' => 'mysql',
    'username' => 'root',
    'password' => 'root',

    // [optional]
    'charset' => 'utf8',
    'port' => 3306,
]);

$alreadyIn = $db->has('user', [
    'OR' => [
        'username' => $username,
        'email' => $email,
        'phone' => $phone,
    ]
]);

if ($alreadyIn) {
    echo '用户已存在';
    die();
}

// 插入用户
$user = [
    'username' => $username,
    'email' => $email,
    'phone' => $phone,
    'password' => $password
];
$db->insert('user', $user);
$user['id'] = $db->id();

$jobData = json_encode($user);
$conn = Pheanstalk::create('beanstalkd', 11300, 10);
$conn->useTube('register_sms');
$smsJob = $conn->put($jobData);
$conn->useTube('register_email');
$emailJob = $conn->put($jobData);

echo '注册成功：<br>';
print_r($user);
print_r($smsJob);
print_r($emailJob);