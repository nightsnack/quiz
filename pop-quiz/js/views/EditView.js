define(["Backbone",
        "Handlebars",
        "../models/showModel",
        "../models/edtModel",
 'text!../../page/editor1.html',
        "../config",
        "htmleditor",
        "lang"],
    function (Backbone,
        Handlebars,
        showQuestion,
        editQuestion,
        Editor1,
        config, 
        htmleditor,
        lang) {

        var EditView = Backbone.View.extend({
            template: Handlebars.compile(Editor1),
            el: '#mainview',
            coursejson: '',
            question_id: '',
            initialize: function (question_id) {
                this.question_id = question_id;
                                this.model = new showQuestion();
                this.model.fetch({
                    type: 'POST',
                    data: {
                        question_id: this.question_id
                    },
                    async:false
                });
                this.$el.html(this.template(this.model.toJSON()));
                this.render();
                this.changeSecond(this.model.get('type'));
                this.addSelected(this.model.get('type'),this.model.get('answer'));
            },

            render: function () {


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
                    allowFileManager : true
                });

            },

            events: {
                'change #type': 'changeSecond',
                'click #update': 'updateQuestion',
            },

            addSelected:function(type,answer){
                $('option[value='+type+']').attr("selected",true); 
                $('option[value='+answer+']').attr("selected",true); 
            },
            changeSecond: function (sel_val) {
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
            updateQuestion: function (e) {

                window.editor.sync('#content');
                var edit = new editQuestion();
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
                edit.fetch({
                    url:question_update,
                    type: 'POST',
                    data: {
                        question_id: this.question_id,
                        type: $('#type').val(),
                        content: $('#content').val(),
                        answer: answer,
                    },
                    success: function (model, response) {
                        if (response.errno == 0) {
                            alert("修改成功");
                        location.reload();
                        } else
                            alert("修改失败，请重试");
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
        return EditView;
    });