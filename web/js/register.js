/**
 * Created by dell on 2016/10/15.
 */

(function($){
    canvasChange("#b5b5b5");
    $("#next1").click(function(){
        //��step1�е����һ��������step2
        $("#step1").hide();
        $("#step2").css("display","flex");
        canvasChange("#468bca","#b5b5b5");
    });
    $("#done").click(function(){
        //��step2�е����ɺ���֤���ύ���ݣ�������step3
        if(checkForm(document.getElementById("regForm"),8)){
            $.post("/ebook/action/register.jsp",$("#regForm").serialize(),function(response){
                var res=JSON.parse(response);
                if(res.state){
                    $("#step2").hide();
                    $("#step3").show();
                    canvasChange("#468bca","#468bca");
                    //��ʾ�·��Ƽ��鼮
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

//checkForm����������֤�û�����������Ƿ�ϸ�������Ӧ����ʾ
    function checkForm(form,length){
        // ��֤ÿ��������Ƿ�Ϊ��
        for(var i=0;i<length;i++){
            var ele=form.elements[i];
            if(ele.value==""){
                alert(ele.getAttribute("message")+"����Ϊ��");
                ele.focus();
                return false;
            }
        }
        //��֤�ֻ��Ÿ�ʽ
        var re=$("input[name='tell']").val().match(/1\d{10}/);
        if(re==null){
            alert("��������ȷ��ʽ���ֻ���");
            return false;
        }
        //��֤�����ȷ�������Ƿ���ͬ
        var pwd=$("input[name='pwd']");
        var repwd=$("input[name='repwd']");
        if(pwd.val()!=repwd.val()){
            alert("�����������벻һ�£�����������");
            return false;
        }
        return true;
    }

//���ݽ��Ȳ�ͬ�����Ϸ�ע�����
    function canvasChange(step2Color,step3Color){
        var myCanvas=document.getElementById("can");
        myCanvas.width=myCanvas.width;    //��������û���

        //����������Ϊ0���������֧�ֻ�����ֱ�ӷ���
        if(arguments.length==0||!myCanvas.getContext) return;

        var can=myCanvas.getContext("2d");
        can.textAlign="center";
        can.textBaseline="middle";
        can.font="14px ����";

        //���Ƶ�һ����Բ
        can.beginPath();
        can.fillStyle="#468bca";
        can.arc(50,25,16,0,2*Math.PI,true);
        can.fill();
        can.fillText("�˺���Ϣ",50,60);
        can.closePath();

        //���Ƶڶ�����ֱ�ߺ�Բ
        can.beginPath();
        can.fillStyle=step2Color;
        can.fillRect(65,24,200,2);
        can.arc(250,25,16,0,2*Math.PI,true);
        can.fill();
        can.fillText("������Ϣ",250,60);
        can.closePath();

        //���Ƶ�������ֱ�ߺ�Բ
        can.beginPath();
        can.fillStyle=step3Color;
        can.fillRect(265,24,200,2);
        can.arc(450,25,16,0,2*Math.PI,true);
        can.fill();
        can.fillText("���",450,60);
        can.fillStyle="#ffffff";
        can.fillText("1",50,25);
        can.fillText("2",250,25);
        can.fillText("3",450,25);
        can.closePath();
    }
})(jQuery);
