define([ "Backbone","Handlebars",'text!../../page/chapter.html'], function(Backbone,Handlebars,Chaptertemplate) {
	var ChapterView = Backbone.View.extend({
		tagName : 'div',
		className : 'col-lg-3 col-xs-6',
		template : Handlebars.compile(Chaptertemplate),

		events : {
			'click #delete' : 'deleteCourse',
			"dblclick #editdiv" : "edit",
			"blur .edit" : "close"
		},
		initialize : function() {
			// model发生变化就重新渲染视图
			this.listenTo(this.model, 'change', this.render);
			// 销毁model
			this.listenTo(this.model, 'destroy', this.remove);
		},
		deleteCourse : function() {
			if (confirm("您确定删除吗？删掉课程会连带章节题目一起删除！")) {
				this.model.destroy();
				this.remove();
			}
		},
		render : function() {
			this.$el.html(this.template(this.model.toJSON()));
			return this;
		},

		edit : function(e) {
			$(e.currentTarget).addClass("editing").find("input").focus();
		},

		close : function(e) {
			var input = $(e.currentTarget);

			if (input.attr('name') == "name") {
				if (!input.val()) {
					input.val(this.model.defaults().name);
				}
				this.model.save({
					"name" : input.val()
				});
			}
			input.parent().parent().removeClass("editing");
		},

	});

	return ChapterView;
});