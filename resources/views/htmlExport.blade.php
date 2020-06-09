<!DOCTYPE html>
<html>
<head>
    <title>敏感词列表</title>
</head>
<body>
<table width="100%" border="1" style="TABLE-LAYOUT: fixed;">
    <caption><b>敏感词链接列表</b></caption>
    <tr>
        <td style="width: 3%">序号</td>
        <td style="width:5%">敏感词</td>
        <td style="width:20%">标题</td>
        <td style="width:40%">摘要</td>
        <td style="width:10%">from</td>
        <td style="width:10%">链接</td>
    </tr>
    @foreach($info as $item)
    <tr>
        <td >{{ $item->num }} </td>
        <td >{{ $item->word }} </td>
        <td >{!! $item->title !!} </td>
        <td >{!! $item->desc !!}</td>
        @if($item->from == 1)
            <td >百度搜索</td>
        @endif
        @if($item->from == 2)
            <td >360搜索</td>
        @endif
        @if($item->from == 3)
            <td >搜狗搜索</td>
        @endif
        <td style="word-break:break-all; word-wrap:break-word;"><a href="https://www.sogou.com/{{ $item->link }}" target="_blank">链接</a></td>
    </tr>
    @endforeach
{{--    <tr>--}}
{{--        <th>学雷锋</th>--}}
{{--        <th>禽兽</th>--}}
{{--    </tr>--}}
</table>

</body>
</html>
