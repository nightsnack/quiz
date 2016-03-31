define(["Backbone",
        "Handlebars",
        "models/QuModel",
        "collections/QuCollection", 
        'text!../../page/composition.html',
        "views/QuView",
        'views/CreateView',
        "../config",
       "htmleditor",
        "lang"],
    function (Backbone,
        Handlebars,
        Question,
        QuestionCollection,
        Composition,
        QuestionView,
        CreateView,
        config,
        htmleditor,
        lang
       ) {

        var QuCollectionView = Backbone.View.extend({
            template: Handlebars.compile(Composition),
            el: '#mainview',
            chapter_id: '',
            initialize: function (chapter_id) {
                this.chapter_id = chapter_id;
                this.collection = new QuestionCollection();
                this.collection.fetch({
                    url: question_query,
                    type: "POST",
                    data: {
                        chapter_id: chapter_id
                    },
                    reset: true
                });
                this.listenTo(this.collection, 'reset', this.render);
//                this.$('#newquestion').click(this.newQuestion);
            },

            render: function () {
                var json = {
                    name: '新增',
                    href: code_null+this.chapter_id
                };

                this.$el.html(this.template(json));

                this.collection.each(function (item) {
                    this.renderQuestion(item);
                }, this);
            },

            renderQuestion: function (item) {
                var Questionview = new QuestionView({
                    model: item
                });
                this.$('#courses').append(Questionview.render().el);
            },

            events: {
                'click #newquestion': 'newQuestion',
            },

            newQuestion: function () {
//                window.location.replace(question_null + this.chapter_id+'/editor');
                new CreateView(this.chapter_id);
            },

        });
        return QuCollectionView;
    });