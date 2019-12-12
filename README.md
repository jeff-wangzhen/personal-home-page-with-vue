# grwz-vue

## 缘起

  最近投了几份简历，似乎很多公司对实习生的要求都很高，生怕自己要失业，连实习都找不到，于是最近一周多忙赶 vue 的程序，希望能够以此证明自己学过 vue，了解 vue，当然目前还没到熟练掌握的程度。
  里面的内容我之前用普通网页做过，[点击这里](http://106.15.124.64/)访问，或者[点击这里](http://106.15.124.64/grwz-vue)访问本项目。

## BUG

-   留言板上传图片组件没有后缀过滤选项，可以上传一切类型文件，只好在后台 php 文件中添加，可是前端不会产生提示，就是没有图片，替换为文字 image，想配置不知道怎么配
-   左右切换动画不够流畅，而且可能有元素定位的原因，位置会突变，调了很久也没解决办法

## 其他不足之处

-   没有用到 directive
-   没有留言回复功能
-   导航条本想参照模板，但是参考了很多，要么不知道怎么部分引入（官网说的也不一定准，花费了大量时间），要么效果不理想，于是界面使用了 Bootsrap-vue，路由跳转导致的背景颜色改变在自己写的函数里
-   考虑到注册表单验证的复杂性，又没有找到现成的可移植，自己以前做的都使用了 JQuery，而用 vue 又要避免 JQ，于是放弃
-   网上找了一个回到顶部的组件，背景图像我设置了但是不起作用，可能是动态生成的原因，本来引用了网络图片，这不利于 TCP 优化，考虑到是小文件，就使用了 base64 编码
-   打包之后文件过大，可是在 main.js 中，我已经做了优化，引入组件都是部分引入，只能怪我需求杂得很，东拼西凑

## 使用须知

-   最重要的是修改后台接口，在 vue.config.js 里
-   修改 php 文件连接配置
-   src/views/messages.vue 里有上传文件 php 文件的地址，也要改
-   数据库只有一张 tb_vue_messages 表，文件在 data/中
-   使用了 history 模式，这个需要服务器支持

## 一切配置好后

```
npm install
```

### Compiles and hot-reloads for development

```
npm run serve
```

### Compiles and minifies for production

```
npm run build
```

### Customize configuration

See [Configuration Reference](https://cli.vuejs.org/config/).
