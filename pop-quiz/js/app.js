require.config({
  paths: {
    'jquery': '../node_modules/jquery/dist/jquery',
     'underscore':'../node_modules/underscore/underscore',
      'Backbone':'../node_modules/backbone/backbone-min',
      'Handlebars':'../node_modules/handlebars/dist/handlebars',
      'Bootstrap':'../node_modules/bootstrap/dist/js/bootstrap',
      'AdminLTE':'../node_modules/admin-lte/dist/js/app',
       'text':'../node_modules/requirejs-text/text',
       'router': 'router',
      'htmleditor':'../node_modules/kindeditor/kindeditor-all-min',
      'lang':'../node_modules/kindeditor/lang/zh_CN',
      "Validate":'../node_modules/jquery-validation/dist/jquery.validate'
  },
  shim: {
    'underscore': {
      exports: 'underscore'
    },
    'Backbone': {
      deps: ["jquery"],
      exports: 'Backbone'
    },
    'Handlebars':{
        exports: 'Handlebars'
    },
     'Bootstrap':{
         deps: ["jquery"],
         exports: 'Bootstrap'
     },
      'htmleditor':{
          exports:'htmleditor'
      },
      'AdminLTE':{
          deps: ["jquery","Bootstrap"],
         exports: 'AdminLTE'
      },
      'lang':{
          deps: ["jquery","htmleditor"],
         exports: 'lang'
      },
      "Validate":{
          deps: ["jquery"],
          exports: 'Validate'
      }
      
  }
});

require(
  ["jquery",
   'Bootstrap',
   'AdminLTE',
    "underscore",
    "Backbone",
    "router",
   "AdminLTE"
  ],
  function($,Bootstrap,AdminLTE, _, Backbone, AppRouter,AdminLTE) {
    $(function() {
            var appRouter = new AppRouter();
            Backbone.history.start();

    });
  }
);