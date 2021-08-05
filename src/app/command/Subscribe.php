<?php
namespace app\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use Pheanstalk\Pheanstalk;
// 接受消息的command
class Subscribe extends Command
{
    // private $redis = null;

    // 配置指令 命令
    // 给php 配置对应的 操作命令
    protected function configure()
    {
        $this->setName('subscribe')->setDescription('命令的备注信息:接收订阅频道的消息');
    }

    protected function execute(Input $input, Output $output){
        while(true){
            $pda = Pheanstalk::create('127.0.0.1');
            //  获取管道并消费
            $job  = $pda->watch('order')->ignore('default')->reserve();
            //  获取任务id
            $id   = $job->getId();
            // 获取任务数据
            $data = $job->getData();
            //  处理完任务后就删除掉
            $pda->delete($job);
            $output->writeln($id);
            sleep(5);
            // 备注:重要 测试使用 php ..../think subscribe 命令 启动 
        }
    }
}