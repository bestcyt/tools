日常功能碎片的小东西 
  
  
### 功能1：翻译功能

使用了有道和谷歌翻译的api

  示例 | 请求 | 返回
---|---|---
中翻英 | http://tools.bestcyt.cn/translate?lanType=en&q=电脑 | computer
英翻中 | http://tools.bestcyt.cn/translate?lanType=cn&q=school | 学校

### 功能2：vue小例子
学习vue的一个小例子，但只有皮毛中的皮毛
  示例 | 请求 | 返回
---|---|---
原生 | http://local.tools.com/vue/todos | todolist
component形式 | http://local.tools.com/vue/todos-component | todolist

### 功能3：断路器设计
有点忘记了，大概就是当访问服务接口的时候通过中间件，看接口是否存在断开，如果是断开，可以直接用备用数据返回；当若干秒后，再开放接口，进入接口再次异常的话捕获到，就再开启断路器，返回降维数据；
  文件位置 | 文件名
---|---
controller | BreakerController
trait | RedisBreaker  
中间件 | BreakerMiddleware  
$routeMiddleware中添加breaker中间件;

```
在路由中添加中间件  
Route::get('breaker/testBreaker','BreakerController@testBreaker')
         ->middleware(['breaker']);
```


### 功能4：导入word解析
使用phpword解析word文档内容并返回，一般在富文本编辑器中使用到，上传word，接口返回解析后的word的html，黏贴进文本框里
  示例 | 请求 
---|---

### 功能5：爬虫-爬浏览器搜索结果获取链接
方法1：使用原生curl，设置cookie模拟发送关键字搜索请求，遍历每页解析html分页获取数据  
方法2：使用无头浏览器chromedriver，设置模拟点击，遍历每一页获取数据
  示例 | 请求 
---|---

