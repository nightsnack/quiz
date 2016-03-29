define(["Backbone"
        , "Handlebars"
        , "models/CoModel"
        , "collections/CoCollection"
        , 'text!../../page/navigate.html'
               , "views/CoView"], function (Backbone, Handlebars, Course, CourseCollection, Navigate, CourseView) {


    var CoCollectionView = Backbone.View.extend({
        template: Handlebars.compile(Navigate),
        el: '#mainview',
        initialize: function () {
            this.collection = new CourseCollection();
            this.collection.fetch({
                reset: true
            });
            this.render();


            this.listenTo(this.collection, 'add', this.renderCourse);
            this.listenTo(this.collection, 'reset', this.render);
        },

        render: function () {
            var json = {
                name: '新增'
            };
            this.$el.html(this.template(json));
            this.collection.each(function (item) {
                this.renderCourse(item);
            }, this);

        },

        renderCourse: function (item) {
            var courseView = new CourseView({
                model: item
            });
            this.$('#courses').append(courseView.render().el);
        },

        events: {
            'click #show': 'showModal',
            'click #add': 'addCourse',
        },

        showModal: function () {

            $('#myModal').modal('show');
        },

        addCourse: function (e) {
            e.preventDefault();
            var formData = {
                name: $('#name').val()
            };
            $('#name').val('');
            $('#myModal').modal('hide');
            this.collection.create(formData);
        },
    });
    return CoCollectionView;
});