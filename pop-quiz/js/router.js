define([
    'Backbone',
    'views/IndexView',
    'views/CoCollectionView',
    'views/CpCollectionView',
    'views/QuCollectionView',
    'views/CreateView',
],
    function (Backbone,
        IndexView,
        CoCollectionView,
        CpCollectionView,
        QuCollectionView,
        CreateView) {

        var AppRouter = Backbone.Router.extend({
            /* define the route and function maps for this router */
            routes: {
                "": "showIndex",
                "course": "showCourse",
                "course/:id": "showChapter",
                "chapter/:id": "showQuestion",
//                "chapter/:id/editor": "createQuestion",
            },
            showIndex: function () {
                var indexView = new IndexView();
            },
            showCourse: function () {
                var coCollectionView = new CoCollectionView();
            },
            showChapter: function (id) {
                var cpCollectionView = new CpCollectionView(id);
            },
            showQuestion: function (chapterid) {
                var quCollectionView = new QuCollectionView(chapterid);
            }
//            createQuestion: function (id) {
//                var createView = new CreateView(id);
//            }

        });


        return AppRouter;
    });