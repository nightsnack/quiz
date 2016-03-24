var app = app || {};

app.Course = Backbone.Model.extend({
    defaults:{
        name:'',
    },
    idAttribute: 'id',
});