window.DeveloperSupport = {
  Models: {},
  Collections: {},
  Views: {},

  start: function(data) {

    const router = new DeveloperSupport.Router();



    let routes = ["about", "home", "login", "profile", "question", "register", "reset"];
    for (let route of routes) {
      router.on(`route:${route}`, function() {
        let name = route[0].toUpperCase() + route.slice(1);
        let view = new DeveloperSupport.Views[name]({
          model: new DeveloperSupport.Models.Test()
        });

        $('.main-container').html(view.render().$el);
      });
    }


    Backbone.history.start();
  }
};
