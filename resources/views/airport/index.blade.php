<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>机场数据上传</title>
</head>
<body>

<p>输出json文件</p>
<form action="{{ url('/airport') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="file" name="air" >
    <input type="submit" value="提交">
</form>

<p>写入PHP文件</p>
<form action="{{ url('/airportarray') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="file" name="air" >
    <input type="submit" value="提交">
</form>

</body>
</html>