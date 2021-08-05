# duilie 2

消息队列 第三方包

# 使用步骤说明

1. Linux 系统 安装 beanstalkd

>> yum install -y beanstalkd

2. 后台启动

>> nohup beanstalkd &

3. 安装php消息队列包

>> composer require pda/pheanstalk

4. 进程 后台 监听启动[守护进程] ,防止阻塞

>> (1) nohup  php think subscribe &

>> (2) 命令代码 while(true) 后台一直运行 守护进程