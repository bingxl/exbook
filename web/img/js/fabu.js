(function($){
    /**��ȡ�û�ͷ����������ҳ���Ͻ�ͷ��λ��*/
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
    /**�ϴ�ͼƬ��ͼƬ�ļ���Ԥ��*/
    $("._button").on("change","input[type='file']",function(){
        var filePath=$(this).val();
        if(filePath.indexOf("jpg")!=-1||filePath.indexOf("png")!=-1){
            //���ļ���ʽΪjpg����png
            var _path=filePath.split("\\");
            $("#mes").html(_path[_path.length-1]).show();
        }else{
            $("#mes").html("�����ϴ�jpg��png��ʽ���ļ���").show();
        }
    });
    /**��ͨ�ϴ���һ���ϴ��л�*/
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
    /**�ύ����������*/
    $("#fabuButton").click(function(){
        $.post("http://182.254.148.178/exbook.php/Home/Book/add/",$("#fabuForm").serialize(),function(response){
            var res=JSON.parse(response);
            if(res.state){
                alert("�ύ�ɹ�");
            }
            else{
                alert(res.msg);
            }
        });
    });
    /**ͼƬsubmit�¼��������*/
    $("#imgForm").on('submit',function(e){
        e.preventDefault();
        //���л���
        var myData=$(this).serialize();
        $.ajax({
            type:'POST',
            url:'http://182.254.148.178/exbook.php/Home/Index/upload',
            dataType:'json',
            data:"type=book&"+myData,

            contentType:false,  //???????
            cache:false,    //ȷ����������Ỻ����Ӧ
            processData:false,
            success:function(){

            },
            error:function(){
                alert("�ϴ�ͼƬʧ��");
            }
        });
    });
    /**���ļ�ѡ���¼���һ��ѡ����ͼƬ������ͼƬform�ύ*/
    $("input[type='file']").change(function(){
        $(this).parent().submit();
    });
})(jQuery);