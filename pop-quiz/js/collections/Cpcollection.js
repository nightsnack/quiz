define(["Backbone", "models/CpModel",,"../config"], function(Backbone, Chapter) {
  var ChapterCollection = Backbone.Collection.extend({
    model:Chapter,
    url:chapterindex
  });
  return ChapterCollection;
});