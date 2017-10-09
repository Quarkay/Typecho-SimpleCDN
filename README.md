Typecho-SimpleCDN
----

### 简介

本插件用于将页面内部分内容（在模板渲染前）按照设置的规则进行替换。可用于镜像缓存类CDN，同时也是此类需求最常见的场景，故取名为SimpleCDN。

注意此插件只是将内容在渲染前动态更改，这样之后镜像CDN如果不用了或者出问题，关闭插件即可，就不用担心内容怎么处理了。

### 安装

1. 首先将本项目克隆到本地：

    ```bash
    git clone git@github.com:mierhuo/Typecho-SimpleCDN.git
    ```

2. 将子文件夹 SimpleCDN 复制到 Typecho插件目录

    ```bash
    cp -r Typecho-SimpleCDN/SimpleCDN /path...to...your...typecho/usr/plugins/
    ```
3. 在Typecho后台点击启用并进行相关设置即可

### 设置说明

#### 一般用法

启用插件之后点击设置，若如下图所示进行设置(规则分割符留空、镜像CDN地址需根据情况自行设置)，则可以将上传的静态图片、附件在渲染的时候改到相应的镜像CDN地址：

<img src="https://github.com/mierhuo/SimpleCDN/blob/master/example.png?raw=true" alt="example.jpg">

#### 正则替换



#### 多条替换
