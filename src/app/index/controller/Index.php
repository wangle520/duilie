<?php
namespace app\index\controller;
use Pheanstalk\Pheanstalk;

class Index{



    // 创建生产者  
    public function index()
    {
        //  创建队列生产者
        // 默认端口 11300
        $pda  = Pheanstalk::create('127.0.0.1');
        //   dump($pda->stats());
        // 模拟数据
        $data = [
            'name' => '消息队列信息1',
            'gid'  => mt_rand(1000,9999)
        ];
        //投入到管道中  等待消费者消费
        //  参数分别是  1 数据  2优先级   3设置延迟时间处理
        $id   = $pda->useTube('order')->put(json_encode($data),0,10);
        dump($id);
    }

    // 消费 stroe
    // 进程阻塞 
    public function store_test(){
        $pda = Pheanstalk::create('127.0.0.1');
        //  获取管道并消费
        $job  = $pda->watch('order')->ignore('default')->reserve();
        //  获取任务id
        $id   = $job->getId();
        dump($id);
        // 获取任务数据
        $data = $job->getData();
        dump($data);
        //  处理完任务后就删除掉
        $pda->delete($job);
    }

    
}
