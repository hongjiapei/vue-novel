# 前言  
刚开始学vue的时候想在网上找个项目练练手，结果要么是太简单的就一个列表demo，要么就是太复杂的看不懂，就想着自己写一个，想了半天决定写个小说应用，因为小说应用难度中等，后端数据用爬虫也比较方便拿到。  

# 技术栈  
>- 前端：vue2 + vuex + vue-router + webpack + ES6/7 + Muse-UI  
>- 后端：php7 + lumen5.6  

# 项目运行  
```
git clone https://github.com/hongjiapei/vue-novel.git  

cd vue-novel/FE

npm install

npm start
```  
访问 http://localhost:8080 就可以看到效果了  

# 项目线上运行  

## 前端部署  
在vue-novel/FE目录运行npm run build，得到一个dist目录，配置一下nginx，贴一下我的配置：  
```
server {
    listen 80;
    server_name xs.hjply.com;
    index index.html;
    root  /vue-novel/FE/dist;
}

```  
## 后端部署  
刚才用npm start运行调的是我的接口，现在讲一下自己搭建：     
```
cd vue-novel/BE

composer install

```  
然后配置一下nginx,贴一下我的配置：  
```
server {
    listen 80;
    server_name xsbe.hjply.com;
    root /vue-novel/BE/public;
    index index.php;
    location ~ \.php$ {
      fastcgi_split_path_info ^(.+\.php)(/.+)$;
      fastcgi_pass  unix:/tmp/php-cgi.sock;
      fastcgi_index index.php;
      include fastcgi_params;
      fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    if (!-e $request_filename) {
        rewrite ^/(.*)$ /index.php/$1 last;
    }

}

```  
前端接口地址在vue-novel/FE/src/ajax/config.js配置，后端允许跨域的域名在vue-novel/BE/app/Http/Middleware/CorsMiddleware里配置  

## 后端数据来源说明  
后端数据都是用[QueryList](https://github.com/jae-jae/QueryList)从小说网站爬的  

# 效果演示  
[查看demo](http://xs.hjply.com)（请用chrome手机模式预览）  

# 功能说明  
- [x] 小说书架    
- [x] 继续上次阅读      
- [x] 小说搜索  
- [x] 切换书源  
- [x] 清除缓存  
- [x] 小说分类缓存  
- [x] 夜间模式    
- [x] 字体大小设置      
- [x] 左右点击翻页    
- [x] 超时自动重新加载       

# 打包成app 
vue写的应用可以打包成app，虽然没办法调用系统接口，但是对小说app来说也无所谓。  

## 打包方法     
>- [下载HBuilder](http://www.dcloud.io/)  
>- 打开HBuilder->文件->打开目录，选中刚才的dist文件夹，然后右键->转换成移动app，就会生成一个manifest.json文件，里面是一些配置项，可以自己配置，也可以用它默认的。  
>- 配置完了之后，右键->发行->云打包-打原生安装包，等它打包完了会自动下载app。  

## 问题  
这样打包会有一个问题：安卓手机的返回键只要按一下，就会回到桌面，这是因为我们的应用是单页应用。所以需要监听一下返回键，具体方法请参考：[使用vue开发webApp，安卓手机自带回退键的问题解决](https://www.cnblogs.com/maomao93/p/7287000.html)  

## app上架  
现在各大应用商店审核比较严格，每一家的规定都不一样，但是上架app一般都要求你有著作权证书，并且对侵权、广告等都有要求，以应用宝为例：[应用宝接入审核原则](http://wiki.open.qq.com/wiki/%E5%BA%94%E7%94%A8%E6%8E%A5%E5%85%A5%E5%AE%A1%E6%A0%B8%E5%8E%9F%E5%88%99)  

## app安全  
应用宝上架的时候会要求你加固app，它有个免费的加固工具叫乐固，按照它给的说明一步一步做就行了。  
加固的时候要重新签名，由于打包的时候用的是Dcloud公有证书，这里贴一下它的信息：  
```
KeyStore下载地址：http://download.dcloud.net.cn/HBuilder.keystore  
证书别名：hbuilder  
证书密码：123456  
keystore密码：123456 
```  

## 打包+加固后的app示例  
[app下载](https://pan.baidu.com/s/1Dk4Q0MjjbCon7KhUYF4eFg)  

# 应用截图  
![1](https://github.com/hongjiapei/vue-novel/blob/master/screenshots/%E7%AE%80%E4%BB%8B1.png)
![2](https://github.com/hongjiapei/vue-novel/blob/master/screenshots/%E7%AE%80%E4%BB%8B2.png)
![3](https://github.com/hongjiapei/vue-novel/blob/master/screenshots/%E7%AE%80%E4%BB%8B3.png)
![4](https://github.com/hongjiapei/vue-novel/blob/master/screenshots/%E7%AE%80%E4%BB%8B4.png)
![5](https://github.com/hongjiapei/vue-novel/blob/master/screenshots/%E7%AE%80%E4%BB%8B5.png)
![6](https://github.com/hongjiapei/vue-novel/blob/master/screenshots/%E7%AE%80%E4%BB%8B6.png)
![7](https://github.com/hongjiapei/vue-novel/blob/master/screenshots/%E7%AE%80%E4%BB%8B7.png)
![8](https://github.com/hongjiapei/vue-novel/blob/master/screenshots/%E7%AE%80%E4%BB%8B8.png) 

# 项目心得  

## 关于前端  
>- 底部菜单active状态问题：刷新页面后要保证active状态是对的  

>- 分类页面数据不会经常更新，用localStorage做缓存  

>- localStorage本身没有过期时间，所以存的时候自己存一个expire字段，取的时候判断是否过期  

>- 移动端开始搜索后，要让搜索框失去焦点，这样手机键盘会收回去  

>- 加载动画必须要，不然体验太差了  

>- 请求的时候要判断是否正在进行别的请求，如果是就取消本次请求  

>- 进入某些页面要 window.scroll(0,0) 滚动到顶部  

>- vue页面数据交互可以用vuex，也可以在路由配置的时候加上参数，也可以跟以前一样用?a=1&b=1这种方式  

>- 这个项目中，由于翻页的时候路由不会变，只是参数在变，所以从详情页返回列表页的时候，总是会返回第一页，要保存一下翻页的进度  

>- 由于保存了翻页进度，换一个分类进入列表页，会显示已保存的翻页进度，所以进入分类页要删除翻页进度，同理，进入书籍详情页也要删掉章节的翻页进度      

>- 书架功能也是用localStorage来存的，由于小说可能重名，所以键名用书的url  

>- 书架有继续上次阅读的功能，所以每次离开章节内容页的时候，要判断是否在书架，如果在则把该章节存到localStorage  

>- localStorage缓存大小计算：其实缓存大小就是所有键值加起来的字节数，单位Byte  

>- axios请求失败的处理：要在配置文件里配置，可以重新发起请求，也可以直接报错  

>- 本来想用vue-router的路由缓存的，但是发现不该缓存的都缓存了，就算了，没有深入研究  

>- 夜间模式、字体大小这些都是存localStorage，触发条件就是点击屏幕中间，所以要做点击位置的判断  

>- 移动端一般用滑动翻页，但是我觉得下滑的时候容易误操作为翻页，所以改为左右点击翻页    

>- 由于浏览器访问http经常被植入js广告(估计是运营商搞的)，所以打算用https，但是我用lnmp一键安装包搭的环境，它自己安的证书有点问题，访问时好时坏，就算了    

## 关于后端  
>- lumen注意路由要书写的顺序，避免上一条路由会拦截下面一条路由的情况，我之前就被这个坑过    

>- QueryList爬取网页的时候都removeHead,然后强制设置UTF-8，因为很多小说网站都是GBK的    

>- ajax跨域问题：laravel有个lavavel-cors包可以直接用，lumen没有，网上找或者自己写一个全局路由中间件  

>- lumen的storage文件夹的权限问题：一定要可读可写  

>- lumen自定义配置文件后，要在bootstrap/app.php里加上 $app->configure('配置文件名');  

>- 后端本来也打算用https，但也是访问时好时坏，还是算了  

## 关于打包成app  
>- HBuilder打包的时候要注意资源的路径，不能用绝对路径，要用相对的  

>- 如果打算上架应用商店，打包的时候记得把包名记下来   

# License  
[MIT](https://raw.githubusercontent.com/hongjiapei/vue-novel/master/LICENSE)

