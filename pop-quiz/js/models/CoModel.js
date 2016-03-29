define(["Backbone"], function(Backbone) {
  var Course = Backbone.Model.extend({
    defaults:{
        name:'',
    },
    idAttribute: 'id',
});
  return Course;
});