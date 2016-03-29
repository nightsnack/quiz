define(["Backbone"], function (Backbone) {
    var Question = Backbone.Model.extend({
        defaults: {
            chapter_id: '',
            type: '',
            content_type: '',
            content: '',
            answer: '',
            sum: '',
            correct: '',
            percentation: '',
            recent_sum: '',
            recent_correct: '',
            percentation_re: ''

        },
        idAttribute: 'id',
    });
    return Question;
});