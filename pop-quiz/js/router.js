define([
    'Backbone',
    'views/IndexView',
    'views/CoCollectionView',
    'views/CpCollectionView',
    'views/QuCollectionView',
    'views/MyCodeView',
],
    function (Backbone,
        IndexView,
        CoCollectionView,
        CpCollectionView,
        QuCollectionView,
        MyCodeView) {

        var AppRouter = Backbone.Router.extend({
            /* define the route and function maps for this router */
            routes: {
                "": "showIndex",
                "course": "showCourse",
                "course/:id": "showChapter",
                "chapter/:id": "showQuestion",
                "code/:id": "MyCode",
            },
            showIndex: function () {
                this.switchRouter();
                var indexView = new IndexView();
            },
            showCourse: function () {
                this.switchRouter();
                var coCollectionView = new CoCollectionView();
            },
            showChapter: function (id) {
                this.switchRouter();
                var cpCollectionView = new CpCollectionView(id);
            },
            showQuestion: function (chapterid) {
                this.switchRouter();
                var quCollectionView = new QuCollectionView(chapterid);
                
            },
            MyCode:function(id) {
                var myCodeView = new MyCodeView(id);
            },
            switchRouter:function () {
//                if(this.View) {
//                    this.View.remove();
//                    }
            }


        });


        return AppRouter;
    });