# tools
this is a tool project for solve some problems

1.一个是机票数据处理  
2.vue的todos  
3.忘记了  
4.新增翻译功能  
中文翻英文http://tools.bestcyt.cn/translate?lanType=en&q=电脑
英文翻中文http://tools.bestcyt.cn/translate?lanType=cn&q=school

###断路器
controller BreakerController  
trait RedisBreaker  
BreakerMiddleware  
$routeMiddleware中添加breaker中间件   
在路由中添加中间件  
Route::get('breaker/testBreaker','BreakerController@testBreaker')
         ->middleware(['breaker']);