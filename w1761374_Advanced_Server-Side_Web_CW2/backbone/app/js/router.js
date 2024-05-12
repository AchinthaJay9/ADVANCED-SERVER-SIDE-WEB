DeveloperSupport.Router = Backbone.Router.extend({
  routes: {
    '': 'home',

    'about': 'about',
    'home': 'home',
    'login': 'login',
    'profile': 'profile',
    'question/:id': 'question',
    'register': 'register',
    'reset': 'reset'
  }
});
