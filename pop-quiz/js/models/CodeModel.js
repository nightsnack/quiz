define(["Backbone","../config"], function(Backbone) {
  var CodeModel = Backbone.Collection.extend({
    url:mycode
  });
  return CodeModel;
});