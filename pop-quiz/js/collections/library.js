var app = app || {};

app.Library = Backbone.Collection.extend({
    model:app.Course,
    url:'http://127.0.0.1/~chiyexiao/quiz/index.php/Course/index'
});