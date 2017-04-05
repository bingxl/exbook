/**
 * Created by dell on 2016/10/15.
 */

//获取主页下方展示的书籍的数据
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
    /**显示下方推荐书籍*/
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

    /**实现下方推荐书籍类别的切换‘全部’‘只看可借’‘只看可售’*/
    $("#my-bar-right").click(function(event){
        $("#my-bar-right").children().removeClass("my-focus");
        var string=$(event.target).addClass("my-focus").html();
        switch(string){
            case "全部":
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
            case "只看可借":
                $("#my-book").hide().next().show().next().hide();
                $.get("http://182.254.148.178/exbook.php/Home/Book/read/",{"tradetype":"借"},function(response){
                    var res=JSON.parse(response);
                    $("#my-book-lend ul").each(function(i){
                        $(this).find("img").attr("src",res.data.data[i].img);
                        $(this).find("a").eq(0).html(res.data.data[i].bname);
                        $(this).find("a").eq(1).html(res.data.data[i].author);
                        $(this).find(".price").html(res.data.data[i].mprice);
                    });
                });
                break;
            case "只看可售":
                $("#my-book").hide().next().hide().next().show();
                $.get("http://182.254.148.178/exbook.php/Home/Book/read/",{"tradetype":"买"},function(response){
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