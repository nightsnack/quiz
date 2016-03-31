$(document).ready(function () {
    var GET = $.urlGet(); //获取URL的Get参数
    var open_id = GET['open_id']; //取得id的值
    var accesscode = GET['accesscode']; //取得id的值
    var testpaper_url = "http://127.0.0.1/~chiyexiao/quiz/index.php/Paper/get_testpaper";
    var post_url = "http://127.0.0.1/~chiyexiao/quiz/index.php/Paper/answer_compare";

    $.ajax({
        type: 'POST',
        url: testpaper_url,
        data: {
            open_id: open_id,
            accesscode: accesscode
        },
        success: function (data) {

            if (data.errno) {
                switch (data.errno) {
                    default: alert(data.error);
                    return false;
                    case 100:
                            alert(data.error);
                        window.location.href = login_url;
                        return false;
                }
            }
            render(data);



        },
        dataType: 'json',
        async: false
    });


    function render(data) {
        var source = $("#template").html();
        var template = Handlebars.compile(source);
        var html = template(data);
        $("#container").append(html);
    };

    $("#handin").click(function () {

            var answer = new Array;
        var validate;
            $('.col-xs-12').each(function () {
                var quesnum = $(this).find(".box-title").html();
                var id = $(this).find("#question_id").html();
                var value = $(this).find("#userkey").val();
                if (value == '') {
                    alert(quesnum+"还未答");
                    validate=false;
                    return false;
                }
                answer.push({
                    id: id,
                    answer: value
                });
            });
if(validate==false) {
    return false;
}
            $.ajax({
                    type: 'POST',
                    url: post_url,
                    data: {
                        accesscode: accesscode,
                        answer: answer
                    },
                    success: function (data) {
                        if (data.errno) {
                            alert(data.error);
                            return false;

                        }
                        showResponse(data);
                    
                },
                dataType: 'json',

            });

    });

function showResponse(data) {
    $('#container').empty();
    var source = $("#response").html();
    var template = Handlebars.compile(source);
    var html = template(data);
    $("#container").append(html);
}
});