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
                var indexView = new IndexView;
                this.switchRouter(indexView);
            },
            showCourse: function () {
                var coCollectionView = new CoCollectionView();
                this.switchRouter(coCollectionView);
            },
            showChapter: function (id) {
                var cpCollectionView = new CpCollectionView(id);
                this.switchRouter(CpCollectionView);

            },
            showQuestion: function (chapterid) {
                var quCollectionView = new QuCollectionView(chapterid);
                this.switchRouter(quCollectionView);
                
            },
            MyCode:function(id) {
                var myCodeView = new MyCodeView(id);
                this.switchRouter(myCodeView);

            },
            switchRouter:function (View) {
//                if(this.CurrentView) {
////                    this.CurrentView.remove();
//                    this.CurrentView.undelegateEvents();
//                    }
//                this.CurrentView=View;
            }


        });


        return AppRouter;
    });