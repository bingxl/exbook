(function($){
    /**获取用户头像等填充于首页左上角头像位置*/
    if(sessionStorage.userTel){
        $.get("http://182.254.148.178/exbook.php/Home/User/read",{"tell":sessionStorage.userTel},function(response){
            var res=JSON.parse(response);
            $(".top-bar-right>.menu").children().eq(2).html("<img>").find("img").attr("src",res.data.head).addClass("head-img").mouseenter(function(event){
                $("#head-text").show().css({"top":"65px","left":event.pageX-50}).mouseleave(function(){
                    $(this).hide();
                });
            });
        });
    }
    /**上传图片及图片文件名预览*/
    $("._button").on("change","input[type='file']",function(){
        var filePath=$(this).val();
        if(filePath.indexOf("jpg")!=-1||filePath.indexOf("png")!=-1){
            //若文件格式为jpg或者png
            var _path=filePath.split("\\");
            $("#mes").html(_path[_path.length-1]).show();
        }else{
            $("#mes").html("您需上传jpg或png格式的文件！").show();
        }
    });
    /**普通上传和一键上传切换*/
    $("#coLoad").mouseenter(function(){
        $("#coLoad").attr("class","upload-clicked");
        $("#quLoad").attr("class","");
        $("table").show();
        $("#_quick").hide();
    });
    $("#quLoad").mouseenter(function(){
        $("#coLoad").attr("class","");
        $("#quLoad").attr("class","upload-clicked");
        $("table").hide();
        $("#_quick").show();
    });
    /**提交发布的数据*/
    $("#fabuButton").click(function(){
        $.post("http://182.254.148.178/exbook.php/Home/Book/add/",$("#fabuForm").serialize(),function(response){
            var res=JSON.parse(response);
            if(res.state){
                alert("提交成功");
            }
            else{
                alert(res.msg);
            }
        });
    });
    /**图片submit事件处理程序*/
    $("#imgForm").on('submit',function(e){
        e.preventDefault();
        //序列化表单
        var myData=$(this).serialize();
        $.ajax({
            type:'POST',
            url:'http://182.254.148.178/exbook.php/Home/Index/upload',
            dataType:'json',
            data:"type=book&"+myData,

            contentType:false,  //???????
            cache:false,    //确保浏览器不会缓存响应
            processData:false,
            success:function(){

            },
            error:function(){
                alert("上传图片失败");
            }
        });
    });
    /**绑定文件选择事件，一旦选择了图片，就让图片form提交*/
    $("input[type='file']").change(function(){
        $(this).parent().submit();
    });
})(jQuery);