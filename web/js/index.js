/**
 * Created by dell on 2016/10/15.
 */

//��ȡ��ҳ�·�չʾ���鼮������
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
    /**��ʾ�·��Ƽ��鼮*/
    $("#my-book").show().next().hide().next().hide();
    $.get("http://182.254.148.178/exbook.php/Home/Book/read/",function(response){
        var res=JSON.parse(response);
        $("#my-book ul").each(function(i){
            $(this).find("img").attr("src",res.data.data[i].img);
            $(this).find("a").eq(0).html(res.data.data[i].bname);
            $(this).find("a").eq(1).html(res.data.data[i].author);
            $(this).find(".price").html(res.data.data[i].mprice);
        });
    });

    /**ʵ���·��Ƽ��鼮�����л���ȫ������ֻ���ɽ衯��ֻ�����ۡ�*/
    $("#my-bar-right").click(function(event){
        $("#my-bar-right").children().removeClass("my-focus");
        var string=$(event.target).addClass("my-focus").html();
        switch(string){
            case "ȫ��":
                $("#my-book").show().next().hide().next().hide();
                $.get("http://182.254.148.178/exbook.php/Home/Book/read/",function(response){
                    var res=JSON.parse(response);
                    $("#my-book ul").each(function(i){
                        $(this).find("img").attr("src",res.data.data[i].img);
                        $(this).find("a").eq(0).html(res.data.data[i].bname);
                        $(this).find("a").eq(1).html(res.data.data[i].author);
                        $(this).find(".price").html(res.data.data[i].mprice);
                    });
                });
                break;
            case "ֻ���ɽ�":
                $("#my-book").hide().next().show().next().hide();
                $.get("http://182.254.148.178/exbook.php/Home/Book/read/",{"tradetype":"��"},function(response){
                    var res=JSON.parse(response);
                    $("#my-book-lend ul").each(function(i){
                        $(this).find("img").attr("src",res.data.data[i].img);
                        $(this).find("a").eq(0).html(res.data.data[i].bname);
                        $(this).find("a").eq(1).html(res.data.data[i].author);
                        $(this).find(".price").html(res.data.data[i].mprice);
                    });
                });
                break;
            case "ֻ������":
                $("#my-book").hide().next().hide().next().show();
                $.get("http://182.254.148.178/exbook.php/Home/Book/read/",{"tradetype":"��"},function(response){
                    var res=JSON.parse(response);
                    $("#my-book-sell ul").each(function(i){
                        $(this).find("img").attr("src",res.data.data[i].img);
                        $(this).find("a").eq(0).html(res.data.data[i].bname);
                        $(this).find("a").eq(1).html(res.data.data[i].author);
                        $(this).find(".price").html(res.data.data[i].mprice);
                    });
                });
                break;
            default:break;

        }
    });
})(jQuery);