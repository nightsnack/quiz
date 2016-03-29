define(["Backbone", "models/QuModel","../config"], function(Backbone, Question) {
  var QuestionCollection = Backbone.Collection.extend({
    model:Question,
    url:question_index
  });
  return QuestionCollection;
});