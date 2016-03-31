define(["Backbone",
        "Handlebars",
        "../models/CodeModel",
 'text!../../page/mycode.html',
        "../config", ,
        ],
    function (Backbone,
        Handlebars,
        Code,
        CodeTemplate,
        config
    ) {
        var MyCodeView = Backbone.View.extend({
            template: Handlebars.compile(CodeTemplate),
            el: '#mainview',
            chapter_id: '',
            initialize: function (chapter_id) {
                this.chapter_id = chapter_id;
                var codedata;
                $.ajax({
                    type: 'POST',
                    url: mycode,
                    data: {
                        chapter_id: chapter_id,
                    },
                    success: function (data) {

                        if (data.errno) {
                            alert(data.error);
                            return false;
                        }
                        codedata = data;
                    },
                    dataType: 'json',
                    async: false
                });
                this.render(codedata);
            },

            render: function (data) {
                var json={echo:data};
                this.$el.html(this.template(json));
            },

        });
        return MyCodeView;
    });