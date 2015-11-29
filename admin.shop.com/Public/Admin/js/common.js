$(function () {
    /**
     * ajax_post传输值并响应
     */
    $(".ajax_post").click(function () {
        var form = $(this).closest('form');
        var url = form.attr('action') != undefined ? form.attr('action') : $(this).attr('url');
        var param = form.attr('action') != undefined ? form.serialize() : $('.id:checked').serialize();
        //用ajax post方式发送请求
        $.post(url, param, function (data) {
            //提示框组件调用
            layerinfo(data);
        })
        //返回false是为了阻止默认操作
        return false;
    })


    /**
     * 添加点击事件,触发ajax get方法发送请求
     */
    $(".ajax_get").click(function () {
        var url = $(this).attr('href');
        //用ajax get方式发送请求
        $.get(url, function (data) {
            //提示框组件调用
            layerinfo(data);
        })
        //返回false是为了阻止默认操作
        return false;
    })


    /**
     * 提示框组件调用函数
     * @param data
     */
    function layerinfo(data) {
        layer.msg(data.info, {
            icon: data.status ? 1 : 0,
            offset: 0,
            shift: 6,
            time: 1000,
        }, function () {
            //显示提示框后跳转
            if (data.status) {
                location.href = data.url;//在这儿必须加入ajax接收到服务器的响应参数的url,如果自己调用{缓存}会不显示效果,直接跳转
            }
        });
    }

})