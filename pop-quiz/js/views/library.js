/*global Backbone, jQuery, _, ENTER_KEY, ESC_KEY */
var app = app || {};

app.AllCourseView = Backbone.View.extend({
    el:'#courses',
    initialize: function(initialcourses) {
        this.collection = new app.Library( initialcourses );
        this.collection.fetch({reset:true});
        this.render();
        
        this.listenTo(this.collection,'add',this.renderCourse);
        this.listenTo(this.collection, 'reset',this.render);
    },
    
    render:function(){
        this.collection.each(function(item){
            this.renderCourse(item);
        },this);
    },
    
    renderCourse:function(item) {
        var courseView = new app.CourseView({
            model:item
        });
        this.$el.append(courseView.render().el);
    },
    
    events:{
    'click #add':'addCourse',
},

addCourse:function(e){
    e.preventDefault();
    var formData = {name:encodeURI($('#name').val())};
$('#name').val('');
    $('#myModal').modal('hide');
this.collection.create(formData);
},
});