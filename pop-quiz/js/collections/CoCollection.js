define(["Backbone", "models/CoModel","../config"], function(Backbone, Course) {
  var CourseCollection = Backbone.Collection.extend({
    model:Course,
    url:courseindex
  });
  return CourseCollection;
});