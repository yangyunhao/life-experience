<?php
 /*
 ① 安装 Git
 Linux 做为服务器端系统，Windows 作为客户端系统，分别安装 Git
 服务器端：
 yum install -y git
 安装完后，查看 Git 版本
 [root@localhost ~]# git --version
 git version 1.7.1

 ② 服务器端创建 git 用户，用来管理 Git 服务，并为 git 用户设置密码
 [root@localhost home]# id git
 id: git：无此用户
 [root@localhost home]# useradd git
 [root@localhost home]# passwd git

 ③ 服务器端创建 Git 仓库
 设置 /home/data/git/gittest.git 为 Git 仓库
 然后把 Git 仓库的 owner 修改为 git
 [root@localhost home]# mkdir -p data/git/gittest.git
 [root@localhost home]# git init --bare data/git/gittest.git
 Initialized empty Git repository in /home/data/git/gittest.git/
 [root@localhost home]# cd data/git/
 [root@localhost git]# chown -R git:git gittest.git/

 ④ 客户端 clone 远程仓库
 $ git clone git@192.168.56.101:/home/data/gittest.git

 */
?>