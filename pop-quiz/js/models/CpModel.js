define(["Backbone"], function(Backbone) {
  var Chapter = Backbone.Model.extend({
    defaults:{
        name:'',
    },
    idAttribute: 'id',
});
  return Chapter;
});