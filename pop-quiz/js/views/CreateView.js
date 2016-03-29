define(["Backbone",
        "Handlebars",
        "../models/istModel",
 'text!../../page/editor.html',
        "../config", ,
        "htmleditor",
        "lang", 
        "../router", 
        "Validate"],
    function (Backbone,
        Handlebars,
        insertQuestion,
        Editor,
        config, 
        htmleditor,
        lang, 
        router, 
        Validate) {



        var CreateView = Backbone.View.extend({
            template: Handlebars.compile(Editor),
            el: '#mainview',
            coursejson: '',
            chapter_id: '',
            initialize: function (chapter_id) {
                this.chapter_id = chapter_id;
                this.render();
                this.changeSecond();
            },

            render: function () {
                var json = {
                    chapter_id: this.chapter_id
                };
                this.$el.html(this.template(json));

                window.K = KindEditor;
                    window.editor = K.create('#content', {
                        items: [
        'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
        'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
        'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
        'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
        'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
        'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
        'anchor', 'link', 'unlink'
],
                        uploadJson: 'http://127.0.0.1/~chiyexiao/quiz/index.php/Question/upload_json',
                        fileManagerJson: 'http://127.0.0.1/~chiyexiao/quiz/index.php/Question/file_manager_json',
                    });

            },
            events: {
                'change #type': 'changeSecond',
                'click #add': 'addCourse',
            },

            changeSecond: function () {
                var sel_val = $('#type').val();
                if (sel_val == 0) {
                    $('#textOne').show();
                    $('#textTwo').hide();
                    $('#textThree').hide();
                }
                if (sel_val == 1) {
                    $('#textOne').hide();
                    $('#textTwo').show();
                    $('#textThree').hide();
                }
                if (sel_val == 2) {
                    $('#textOne').hide();
                    $('#textTwo').hide();
                    $('#textThree').show();
                }
            },
            addCourse: function (e) {

                window.editor.sync('#content');
                var insert = new insertQuestion();
                var type = $('#type').val();
                var answer = this.switchType(type);
                var content = $('#content').val();
                 if (!content) {
                    alert("请填写题目详情");
                    return false;
                }
                if (!answer) {
                    alert("请填写答案详情");
                    return false;
                }
                insert.fetch({
                    type: 'POST',
                    data: {
                        chapter_id: this.chapter_id,
                        type: $('#type').val(),
                        content: $('#content').val(),
                        answer: answer,
                    },
                    success: function (model, response) {
                        if (response.errno == 0) {
                            alert("创建成功");
                        location.reload();
                        } else
                            alert("创建失败，请重试");

                    },
                });
            },


            switchType: function (num) {
                switch (num) {
                    case "0":
                        return $('#textOne').val();
                    case "1":
                        return $('#textTwo').val();
                    case "2":
                        return $('#textThree').val();
                }
            }

        });
        return CreateView;
    });