Typecho-SimpleCDN
----

## 简介

本插件用于将页面内部分内容（在模板渲染前）按照设置的规则进行替换。可用于镜像缓存类CDN，同时也是此类需求最常见的场景，故取名为SimpleCDN。

注意此插件只是将内容在渲染前动态更改，即标题、文章的原文（如果是Markdown则是其进行MD解析之前的内容）；这样之后镜像CDN如果不用了或者进行更换，更改插件设置即可，就不用担心内容上的问题了。

## 安装

1. 首先将本项目克隆到本地：

    ```bash
    git clone git@github.com:mierhuo/Typecho-SimpleCDN.git
    ```

2. 将子文件夹 SimpleCDN 复制到 Typecho插件目录

    ```bash
    cp -r Typecho-SimpleCDN/SimpleCDN /path...to...your...typecho/usr/plugins/
    ```
3. 在Typecho后台点击启用并进行相关设置即可

## 设置说明

### 1.一般用法

启用插件之后点击设置，若如下图所示进行设置(规则分割符不修改、镜像CDN地址需根据情况自行设置)，则可以将上传的静态图片、附件在进行页面渲染前改到相应的镜像CDN地址：

**（请注意转义正则特殊字符）**

<img src="https://github.com/mierhuo/SimpleCDN/blob/master/example.png?raw=true" alt="一般用法配置例子">

### 2.正则替换

有时候，一般用法并不能满足需求，可能文章内容中也出现了博客地址且不需要更换，这时就体现出了正则替换的作用。只需要提供更详细的原文替换规则即可，例如对于Markdown中的图片地址进行替换，如下图：

<img src="https://github.com/mierhuo/SimpleCDN/blob/master/reg_example.png?raw=true" alt="正则替换配置例子">

**（正则捕获的值可根据需要进行引用）**

### 3.多条替换

多条替换则是配置的时候通过分割符分割替换规则，即可达到多条替换的效果。如下图：

<img src="https://github.com/mierhuo/SimpleCDN/blob/master/multi_example.png?raw=true" alt="多条替换配置例子">

## 相关

插件使用了PHP标准库函数： `preg_replace` ，使用插件时可根据需要进行参考：

<a href="http://php.net/manual/en/function.preg-replace.php" target="_blank">PHP: preg_replace - Manual</a>

## License

<a href="https://github.com/mierhuo/Typecho-SimpleCDN/blob/master/LICENSE.txt">The GNU General Public License (GPL) V2</a>
