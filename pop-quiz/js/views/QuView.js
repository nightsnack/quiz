define(["Backbone",
        "Handlebars",
        'text!../../page/question.html',
        "../handlebarshelper",
        "views/EditView"],
    function (Backbone,
        Handlebars,
        Questiontemplate,
        helper,
        Editview) {
        var QuestionView = Backbone.View.extend({
            tagName: 'div',
            className: 'col-xs-12',
            template: Handlebars.compile(Questiontemplate),

            events: {
                'click #delete': 'deleteQuestion',
                "click #updatequestion": "edit",
                //			"blur .edit" : "close"
            },
            initialize: function () {
                // model发生变化就重新渲染视图
                this.listenTo(this.model, 'change', this.render);
                // 销毁model
                this.listenTo(this.model, 'destroy', this.remove);
            },

            deleteQuestion: function () {
                if (confirm("您确定删除吗？")) {
                    this.model.destroy();
                    this.remove();
                }
            },
            render: function () {
                this.$el.html(this.template(this.model.toJSON()));
                return this;
            },

            edit: function (e) {
                new Editview(this.model.get('id'));
            },

            close: function (e) {
                var input = $(e.currentTarget);

                if (input.attr('name') == "name") {
                    if (!input.val()) {
                        input.val(this.model.defaults().name);
                    }
                    this.model.save({
                        "name": input.val()
                    });
                }
                input.parent().parent().removeClass("editing");
            },

        });

        return QuestionView;
    });