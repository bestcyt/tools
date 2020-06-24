<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <p>导入word解析返回html</p>
        <div>
            <input type="file" accept=".docx" id="wordupload" name="word" value="word"><button id="post">提交</button>
        </div>
        <div id="wordHtml"></div>
    </body>
</html>
<script language="JavaScript" src="http://libs.baidu.com/jquery/2.1.4/jquery.min.js"></script>

<script>
    // KindEditor.plugin('postwordplugin', function (K) {
    //     //这个self表示编辑器对象
    //     var self = this;
    //     var name = 'postwordplugin';
    //     var tagid = $('input[name=tagid]').val();
    //     if (tagid == '') {
    //         tagid = window.location.href.match(/tagid-(\d+)/)[1];
    //     };
    //     var html_str = '<div style="padding:20px;">' +
    //         //url
    //         '<div class="ke-dialog-row">' +
    //         '<input class="ke-input-text" style="width:100%;height: 60px" accept=".docx" type="file" id="wordupload" name="wordupload" value="上传文件"  /></div>' +
    //         '<p style="width:100%;margin: 0 auto">文档最大20MB，仅支持docx格式</p>' +
    //         '<p><span style="color: red;">*</span>目前支持文档中插入本地图片。部分文本样式（如列表、部分超链接）暂不支持。发布前请确认图片、文字内容。</p>' +
    //         '</div>';
    //     self.clickToolbar(name, function () {
    //         console.log('postwordplugin');
    //         var lang = self.lang(name + '.'),
    //             html = html_str,
    //             dialog = self.createDialog({
    //                 name: name,
    //                 width: 450,
    //                 title: self.lang(name),
    //                 body: html,
    //                 yesBtn: {
    //                     name: self.lang('yes'),
    //                     click: function (e) {
    //                         //触发文件上传
    //                         postWord();
    //                     }
    //                 }
    //             })
    //     });
    //
    //     //word文档上传方法
    //     function postWord(){
    //         //判断文件大小是否超出20M
    //         var fileSize =  document.getElementById('wordupload').files[0];
    //         if (fileSize.size > 20971520) {
    //             alert('请上传不超过20M的word文档');
    //             return ;
    //         }
    //         var formData = new FormData();
    //         formData.append("wordupload",$("#wordupload")[0].files[0]);
    //         formData.append("_AJAX_",1);
    //         $.ajax({
    //             url:'/word-toHtml', //word上传接口
    //             type:'post',
    //             data: formData,
    //             contentType: false,
    //             processData: false,
    //             success:function(res){
    //
    //                 // self.appendHtml(res).hideDialog().focus();
    //
    //                 var data = $.parseJSON(res);
    //                 switch (data.code) {
    //                     case 101:
    //                         alert(data.msg);
    //                         self.hideDialog();
    //                         break;
    //                     case 100: //塞进文本框
    //                         self.appendHtml(data.result.html).hideDialog().focus();
    //                 }
    //             },
    //             error:function (e) {
    //                 console.log('error');
    //                 console.log(e);
    //                 self.insertHtml('error').hideDialog().focus();
    //             }
    //         })
    //     }
    //
    // });

    $(function () {
        $('#post').click(function () {
            postWord();
        });
        //word文档上传方法
        function postWord(){
            //判断文件大小是否超出20M
            var fileSize =  document.getElementById('wordupload').files[0];
            if (fileSize.size > 20971520) {
                alert('请上传不超过20M的word文档');
                return ;
            }
            var formData = new FormData();
            formData.append("wordupload",$("#wordupload")[0].files[0]);
            formData.append("is_ajax",1);
            $.ajax({
                url:'/word-post', //word上传接口
                type:'post',
                data: formData,
                contentType: false,
                processData: false,
                success:function(res){

                    // self.appendHtml(res).hideDialog().focus();

                    var data = $.parseJSON(res);
                    switch (data.code) {
                        case 101:
                            alert(data.msg);
                            self.hideDialog();
                            break;
                        case 100: //塞进文本框
                            self.appendHtml(data.result.html).hideDialog().focus();
                    }
                },
                error:function (e) {
                    console.log('error');
                    console.log(e);
                    self.insertHtml('error').hideDialog().focus();
                }
            })
        }
    })

</script>
