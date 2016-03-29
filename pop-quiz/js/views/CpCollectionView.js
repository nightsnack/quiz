define(["Backbone",
        "Handlebars",
        "models/CpModel",
        "collections/CpCollection", 'text!../../page/navigate.html',
        "views/CpView",
        "../config"],
    function (Backbone,
        Handlebars,
        Course,
        CourseCollection,
        Navigate,
        CourseView) {


        var CpCollectionView = Backbone.View.extend({
            template: Handlebars.compile(Navigate),
            el: '#mainview',
            coursejson: '',
            course_id: '',
            initialize: function (course_id) {
                this.course_id = course_id;
                this.collection = new CourseCollection();
                this.collection.fetch({
                    url: chapter_query,
                    type: "POST",
                    data: {
                        course_id: course_id
                    },
                    reset: true
                });
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

                this.collection.fetch({
                    url: chapter_insert,
                    type: "POST",
                    data: {
                        name: $('#name').val(),
                        course_id: this.course_id
                    },
                    success: function (model, response) {
                        $('#name').val('');
                        $('#myModal').modal('hide');
                        location.reload();
                    },
                });
            },
        });
        return CpCollectionView;
    });