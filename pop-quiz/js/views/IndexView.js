define(["Backbone",
        "Handlebars",
        "../config", 
         'text!../../page/indexpage.html',
        ],
    function (Backbone,
        Handlebars,
        config,
        template
    ) {
        var IndexView = Backbone.View.extend({
            
            template: Handlebars.compile(template),
            el: '#mainview',
            initialize: function () {
                var logindata;
                $.ajax({
                    type: 'GET',
                    url: index_user,
                    success: function (data) {
                        if (data.errno) {
                            alert(data.error);
                            return false;
                        }
                        logindata = data;
                    },
                    dataType: 'json',
                    async: false
                });
                this.render(logindata);
            },
            render: function (data) {
                var json={echo:data.detail};
                this.$el.html(this.template(json));
            },
//            switch:function(errno) {
//                switch(errno) {
//                    case 101:
//           window.location.href="login.html"; 
//                }
//            }
        });

        return IndexView;
    });