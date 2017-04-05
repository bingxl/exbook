/**
 * Created by dell on 2016/10/15.
 */

(function($){
    canvasChange("#b5b5b5");
    $("#next1").click(function(){
        //在step1中点击下一步，进入step2
        $("#step1").hide();
        $("#step2").css("display","flex");
        canvasChange("#468bca","#b5b5b5");
    });
    $("#done").click(function(){
        //在step2中点击完成后验证并提交数据，并进入step3
        if(checkForm(document.getElementById("regForm"),8)){
            $.post("/ebook/action/register.jsp",$("#regForm").serialize(),function(response){
                var res=JSON.parse(response);
                if(res.state){
                    $("#step2").hide();
                    $("#step3").show();
                    canvasChange("#468bca","#468bca");
                    //显示下方推荐书籍
                    $.get("http://182.254.148.178/exbook.php/Home/Book/read/",function(response){
                        var res=JSON.parse(response);
                        $("#step3-main>ul").each(function(i){
                            $(this).find("img").attr("src",res.data.data[i].img);
                            $(this).find("a").eq(0).html(res.data.data[i].bname);
                            $(this).find("a").eq(1).html(res.data.data[i].author);
                            $(this).find(".price").html(res.data.data[i].mprice);
                        });
                    });
                }
            });
        }
    });
    $("#back").click(function(){
        $("#step2").hide();
        $("#step1").show();
        canvasChange("#b5b5b5","#b5b5b5");
    });

//checkForm函数用来验证用户输入的数据是否合格并作出相应的提示
    function checkForm(form,length){
        // 验证每个输入框是否为空
        for(var i=0;i<length;i++){
            var ele=form.elements[i];
            if(ele.value==""){
                alert(ele.getAttribute("message")+"不能为空");
                ele.focus();
                return false;
            }
        }
        //验证手机号格式
        var re=$("input[name='tell']").val().match(/1\d{10}/);
        if(re==null){
            alert("请输入正确格式的手机号");
            return false;
        }
        //验证密码和确认密码是否相同
        var pwd=$("input[name='pwd']");
        var repwd=$("input[name='repwd']");
        if(pwd.val()!=repwd.val()){
            alert("两次密码输入不一致，请重新输入");
            return false;
        }
        return true;
    }

//根据进度不同绘制上方注册进度
    function canvasChange(step2Color,step3Color){
        var myCanvas=document.getElementById("can");
        myCanvas.width=myCanvas.width;    //清除并重置画布

        //如果传入参数为0或浏览器不支持画布则直接返回
        if(arguments.length==0||!myCanvas.getContext) return;

        var can=myCanvas.getContext("2d");
        can.textAlign="center";
        can.textBaseline="middle";
        can.font="14px 黑体";

        //绘制第一步的圆
        can.beginPath();
        can.fillStyle="#468bca";
        can.arc(50,25,16,0,2*Math.PI,true);
        can.fill();
        can.fillText("账号信息",50,60);
        can.closePath();

        //绘制第二步的直线和圆
        can.beginPath();
        can.fillStyle=step2Color;
        can.fillRect(65,24,200,2);
        can.arc(250,25,16,0,2*Math.PI,true);
        can.fill();
        can.fillText("个人信息",250,60);
        can.closePath();

        //绘制第三步的直线和圆
        can.beginPath();
        can.fillStyle=step3Color;
        can.fillRect(265,24,200,2);
        can.arc(450,25,16,0,2*Math.PI,true);
        can.fill();
        can.fillText("完成",450,60);
        can.fillStyle="#ffffff";
        can.fillText("1",50,25);
        can.fillText("2",250,25);
        can.fillText("3",450,25);
        can.closePath();
    }
})(jQuery);
