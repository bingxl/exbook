/**
 * Created by dell on 2016/10/18.
 */
(function($){
    $("input[name='tell']").focus();
    $("#enterButton").click(function(){
        //��֤�ֻ��Ÿ�ʽ�Ƿ���ȷ
        var re=$("input[name='tell']").val().match(/1\d{10}/);
        if(re==null){
            alert("��������ȷ��ʽ���ֻ���");
        }else{
            //�ύ�ֻ��ź���������
            $.get("http://182.254.148.178/exbook.php/Home/User/login",$("#enterForm").serialize(),function(response){
                var res=JSON.parse(response);
                if(res.state){
                    sessionStorage.userTel=re[0];
                    location.href="/ebook/index.html";
                }
                else{
                    alert(res.msg);
                }
            });
        }
    });
})(jQuery);

