
DeveloperSupport.Views.Test = Backbone.View.extend({
  template: _.template($('#template-test').html()),

  render: function() {
    var html = this.template(_.extend(this.model.toJSON(), {
      isNew: this.model.isNew()
    }));
    document.getElementsByTagName('body')[0].style.removeProperty("background-image");
    this.$el.append(html);
    return this;
  },

});

// About View
DeveloperSupport.Views.About = Backbone.View.extend({
  template: _.template($('#template-about').html()),

  render: function() {
    let html = this.template(_.extend(this.model.toJSON(), {
      isNew: this.model.isNew()
    }));
    document.getElementsByTagName('body')[0].style.backgroundImage = 'url("res/img/about.png")';
    this.$el.append(html);
    return this;
  }
});

// Home View
DeveloperSupport.Views.Home = Backbone.View.extend({
  template: _.template($('#template-home').html()),

  render: function() {
    var html = this.template();
    this.$el.append(html);
    document.getElementsByTagName('body')[0].style.backgroundImage = 'url("res/img/home.png")';

    function display_questions(questions) {
      let container = document.getElementById('question-container');
      container.innerHTML = '';

      for (let question of questions) {
        let view = document.createElement('div');
        view.innerHTML = `
                <div class="row" style="margin: 16px 32px; background-color: rgba(6,56,129,0.9); border-radius: 13px; padding: 24px">
                    <div class="col-1 align-self-center">
                        <div class="">
                            <button type="button" style="color: #602020; margin-bottom: 16px" class="btn bg-white"><i class="fa fa-thumbs-up"></i>&nbsp;&nbsp;${question.likes}</button>
                            <button type="button" style="color: #602020" class="btn bg-white"><i class="fa fa-thumbs-down"></i>&nbsp;&nbsp;${question.dislikes}</button>
                        </div>

                    </div>
                    <div class="col-9">
                        <div  role="button" onclick="window.location.assign('#question/${question.id}')" style="font-weight:bold; color: white; font-size: 19px">
                            ${question.question}
                        </div>

                        <div class="w-100 d-inline-flex">
                        ${JSON.parse(question.tags).map((tag, index) => {
          if (tag === null || tag === "") return '';
          return `<div style="font-weight:bold; color: #158D3E; font-size: 17px; background-color: white; padding: 6px; margin-top: 16px; margin-right: 16px; width: fit-content">${tag}</div>`;
        }).join('')}
<!--                            <div style="font-weight:bold; color: #158D3E; font-size: 17px; background-color: white; padding: 6px; margin-top: 16px; margin-right: 16px; width: fit-content">#Java</div>
                            <div style="font-weight:bold; color: #158D3E; font-size: 17px; background-color: white; padding: 6px; margin-top: 16px; margin-right: 16px; width: fit-content">#Java</div>
                            <div style="font-weight:bold; color: #158D3E; font-size: 17px; background-color: white; padding: 6px; margin-top: 16px; margin-right: 16px; width: fit-content">#Java</div>-->
                        </div>

                    </div>
                    <div class="col-2" style="display: flex;flex-direction: column;justify-content: space-between">
                        <div style="width: 100%; text-align: right">
                            <span style="font-weight:bold; color: black; font-size: 13px; background-color: white; padding: 6px;">${question.answers}</span>
                        </div>
                        <div style="width: 100%; text-align: right">
                        <div style="font-weight:bold; color: white; font-size: 12px; padding: 6px; padding-right: 0; margin-top: 16px;;">
                            ${question.time.split(" ")[0]}<br/>
                            ${question.user.username}
                            </div>
                        </div>


                    </div>
                </div>
          `;
        view.classList = "col-12";
        container.appendChild(view);

        let like = view.getElementsByTagName('button')[0];
        let dislike = view.getElementsByTagName('button')[1];
        like.onclick = async () => {
          let response = await fetch("/api/index.php/like/index/", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify({
              like: 1,
              question: question.id,
            })
          });

          let promise = await response.text();
          window.location.reload();

        }
        dislike.onclick = async () => {
          let response = await fetch("/api/index.php/like/index/", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify({
              like: 0,
              question: question.id,
            })
          });

          let promise = await response.text();
          window.location.reload();

        }
      }

    }

    function setup_ask() {
      let post = document.getElementById('post-question');
      post.onclick = async () => {
        let question = document.getElementById('ask-question-text').value;
        let a = document.getElementById('ask-question-tags');
        let tags = [];

        if (question === "") {
          alert("Question cannot be empty");
          return;
        }

        for (const t of a.getElementsByTagName('input')) {
          let v = t.value;
          if (v === "") continue;
          tags.push(v);
        };

        if (tags.length === 0) {
          alert("Tags cannot be empty");
          return;
        }

        let response = await fetch("/api/index.php/question/", {
          method: "POST",
          headers: {"Content-Type": "application/json"},
          body: JSON.stringify({
            question: question,
            tags: JSON.stringify(tags),
          })
        });

        let promise = await response.json();
        window.location.reload();
      }
    }

    setup_ask();

    async function load() {
      let response = await fetch("/api/index.php/question/", {
        method: "GET",
        headers: {"Content-Type": "application/json"}
      });

      let promise = await response.json();
      if (promise.success){
        let questions = promise.data;

        document.getElementById('question-search').addEventListener('input', (e) => {
          questions = promise.data.filter(q => q.question.toLowerCase().includes(e.target.value.toLowerCase()));
          display_questions(questions);
        });

        display_questions(questions);
      }

    }
    load();

    return this;
  }
});

// Login View
DeveloperSupport.Views.Login = Backbone.View.extend({
  template: _.template($('#template-login').html()),
  events: {
    'click #login': async () => {
      let username = document.getElementById('username').value;
      let password = document.getElementById('password').value;


      if (username === "" || password === "") {
        alert("Username and password cannot be empty");
        return;
      }
      let response = await fetch("/api/index.php/user/login/", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({
          username: username,
          password: password
        })
      });
      response = await response.json();
      if (response.success){
        window.location.assign('#home');
      }else {
        alert(response.message);
        return;
      }
    }
  },

  render: function() {
    var html = this.template();
    this.$el.append(html);
    document.getElementsByTagName('body')[0].style.backgroundImage = 'url("res/img/login.png")';

    fetch("/api/index.php/user/", {
      method: "DELETE",
      headers: {"Content-Type": "application/json"}
    });

    return this;
  }
});

// Profile View
DeveloperSupport.Views.Profile = Backbone.View.extend({
  template: _.template($('#template-profile').html()),


  render: function() {
    var html = this.template();
    this.$el.append(html);
    document.getElementsByTagName('body')[0].style.backgroundImage = 'url("res/img/signup.png")';

    async function load() {
      let response = await fetch("/api/index.php/user/", {
        method: "GET",
        headers: {"Content-Type": "application/json"},
      });

      response = await response.json();
      console.log(response);
      if (response.success){
        let user = response.data;
        document.getElementById('p_first_name').value = user.first_name;
        document.getElementById('p_last_name').value = user.last_name;
        document.getElementById('p_username').value = user.username;
        document.getElementById('p_email').value = user.email;

        document.getElementById('p_email').readOnly = true;

        document.getElementById('profile-update').onclick = async () => {
            let first_name = document.getElementById('p_first_name').value;
            let last_name = document.getElementById('p_last_name').value;
            let username = document.getElementById('p_username').value;

          if (first_name === "" || last_name === "" || username === ""){
            alert("All fields are required!");
            return;
          }

          response = await fetch("/api/index.php/user/", {
            method: "PATCH",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify({
              first_name,
              last_name,
              username
            })
          });

          response = await response.json();
          if (!response.success){
            alert(response.message);
          } else {
            alert("Profile updated successfully");
            window.location.reload();
          }

        }
      }

    }

    load();

    return this;
  }
});

// Question View
DeveloperSupport.Views.Question = Backbone.View.extend({
  template: _.template($('#template-question').html()),

  render: function() {
    var html = this.template();
    this.$el.append(html);
    document.getElementsByTagName('body')[0].style.backgroundImage = 'url("res/img/home.png")';

    let question_id = document.location.href.split("#question/")[1].split("?")[0];
    async function load_question(){
      let url = "/api/index.php/question/index/" + question_id+ "/";
      let response = await fetch(url, {
        method: "GET",
        headers: {"Content-Type": "application/json"}
      });

      let promise = await response.json();
      if (promise.success){
        let question = promise.data;
        console.log(question);
        document.getElementById("answer-question-date").innerText = question.time + " " + question.user.username;
        document.getElementById("answer-question-text").innerText = question.question;
        document.getElementById("answer-question-likes").innerHTML += question.likes;
        document.getElementById("answer-question-dislikes").innerHTML += question.dislikes;

        document.getElementById("answer-question-likes").onclick = async () => {
          let response = await fetch("/api/index.php/like/index/", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify({
              like: 1,
              question: question_id,
            })
          });

          let promise = await response.text();
          window.location.reload();

        }
        document.getElementById("answer-question-dislikes").onclick = async () => {
          let response = await fetch("/api/index.php/like/index/", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify({
              like: 0,
              question: question_id,
            })
          });

          let promise = await response.text();
          window.location.reload();

        }

        let tag_ctr = document.getElementById("answer-question-tags");
        tag_ctr.innerHTML = "";
        for (let tag of JSON.parse(question.tags)) {
            tag_ctr.innerHTML += `<div style="font-weight:bold; color: #158D3E; font-size: 17px; background-color: white; padding: 6px; margin-right: 16px; width: fit-content">#${tag}</div>`;
        }
      }
    }

    load_question();

    function display_answers(questions) {
      let container = document.getElementById('answer-container');
      container.innerHTML = '';

      for (let question of questions) {
        question.tags = JSON.stringify([]);

        let view = document.createElement('div');
        view.innerHTML = `
                <div class="row" style="margin: 16px 32px; background-color: rgba(6,56,129,0.9); border-radius: 13px; padding: 24px">
                    <div class="col-1 align-self-center">
                        <div class="">
                            <button type="button" style="color: #602020; margin-bottom: 16px" class="btn bg-white"><i class="fa fa-thumbs-up"></i>&nbsp;&nbsp;${question.likes}</button>
                            <button type="button" style="color: #602020" class="btn bg-white"><i class="fa fa-thumbs-down"></i>&nbsp;&nbsp;${question.dislikes}</button>
                        </div>

                    </div>
                    <div class="col-9">
                        <div  role="button" style="font-weight:bold; color: white; font-size: 19px">
                            ${question.answer}
                        </div>

                        <div class="w-100 d-inline-flex">
                        ${JSON.parse(question.tags).map((tag, index) => {
          if (tag === null || tag === "") return '';
          return `<div style="font-weight:bold; color: #158D3E; font-size: 17px; background-color: white; padding: 6px; margin-top: 16px; margin-right: 16px; width: fit-content">${tag}</div>`;}).join('')}
                        </div>

                    </div>
                    <div class="col-2" style="display: flex;flex-direction: column;justify-content: space-between">
                        <div style="width: 100%; text-align: right">
<!--                            <span style="font-weight:bold; color: black; font-size: 13px; background-color: white; padding: 6px;">11</span>-->
                        </div>
                        <div style="width: 100%; text-align: right">
                        <div style="font-weight:bold; color: white; font-size: 12px; padding: 6px; padding-right: 0; margin-top: 16px;;">
                              ${question.time.split(" ")[0]}<br/>
                              ${question.user.username}
                        </div>
                        </div>


                    </div>
                </div>
          `;
        view.classList = "col-12";
        container.appendChild(view);

        let like = view.getElementsByTagName('button')[0];
        let dislike = view.getElementsByTagName('button')[1];
        like.onclick = async () => {
          let response = await fetch("/api/index.php/like/index/", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify({
              like: 1,
              answer: question.id,
            })
          });

          let promise = await response.text();
          window.location.reload();

        }
        dislike.onclick = async () => {
          let response = await fetch("/api/index.php/like/index/", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify({
              like: 0,
              answer: question.id,
            })
          });

          let promise = await response.text();
          window.location.reload();

        }
      }

    }

    function setup_ask() {
      let post = document.getElementById('post-answer');
      post.onclick = async () => {
        let question = document.getElementById('post-answer-text').value;

        if (question === "") {
          alert("Answer cannot be empty");
          return;
        }


        let response = await fetch("/api/index.php/answer/index/" + question_id, {
          method: "POST",
          headers: {"Content-Type": "application/json"},
          body: JSON.stringify({
            question: question,
            tags: JSON.stringify([]),
          })
        });

        let promise = await response.json();
        window.location.reload();
      }
    }

    setup_ask();

    async function load() {
      let response = await fetch("/api/index.php/answer/index/" + question_id, {
        method: "GET",
        headers: {"Content-Type": "application/json"}
      });

      let promise = await response.json();
      if (promise.success){
        let questions = promise.data;

        display_answers(questions);
      }

    }
    load();



    return this;
  }
});

// Register View
DeveloperSupport.Views.Register = Backbone.View.extend({
  template: _.template($('#template-register').html()),
  events: {
    'click #r_signup': async function () {
      let firstname = document.getElementById("r_first_name").value;
      let lastname = document.getElementById("r_last_name").value;
      let username = document.getElementById("r_username").value;
      let email = document.getElementById("r_email").value;
      let password = document.getElementById("r_password").value;
      let password_cnf = document.getElementById("r_confirm_password").value;

      if (password !== password_cnf){
        alert("Passwords does not match!");
        return;
      }

      if (password.length < 8){
        alert("Password must be at least 8 characters!");
        return;
      }

      if (firstname === "" || lastname === "" || username === "" || email === "" || password === "" || password_cnf === ""){
        alert("All fields are required!");
        return;
      }

      if (email.indexOf("@") === -1 || email.indexOf(".") === -1){
        alert("Invalid email!");
        return;
      }

      let response = await fetch("/api/index.php/user/", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({
          first_name: firstname,
          last_name: lastname,
          username: username,
          email: email,
          password: password,
          confirm_password: password_cnf
        })
      });

      response = await response.json();
      if (response.success === true){
        alert("Registered successfully!");
        window.location.href = "#home";
      } else {
        alert(response.message);
      }

    }
  },
  render: function() {
    var html = this.template();
    this.$el.append(html);
    document.getElementsByTagName('body')[0].style.backgroundImage = 'url("res/img/signup.png")';
    return this;
  }
});

// Reset View
DeveloperSupport.Views.Reset = Backbone.View.extend({
  template: _.template($('#template-reset').html()),

  render: function() {
    var html = this.template();
    this.$el.append(html);
    document.getElementsByTagName('body')[0].style.backgroundImage = 'url("res/img/signup.png")';

    async function load() {
      let response = await fetch("/api/index.php/user/", {
        method: "GET",
        headers: {"Content-Type": "application/json"},
      });

      response = await response.json();
      console.log(response);
      if (response.success){
        let user = response.data;
        document.getElementById('res_email').value = user.email;
        document.getElementById('res_email').readOnly = true;

      }

      document.getElementById('r_change').onclick = async () => {
        let email = document.getElementById('res_email').value;
        let verification = document.getElementById('r_verification').value;
        let password = document.getElementById('r_res-password').value;
        let password_cnf = document.getElementById('res_confirm_password').value;

        if (password !== password_cnf){
          alert("Passwords does not match!");
          return;
        }

        if (password.length < 8){
          alert("Password must be at least 8 characters!");
          return;
        }

        if (email === "" || verification === "" || password === "" || password_cnf === ""){
          alert("All fields are required!");
          return;
        }
        if (verification !== "1234"){
          alert("Invalid verification code!");
          return;
        }
        response = await fetch("/api/index.php/user/", {
          method: "PATCH",
          headers: {"Content-Type": "application/json"},
          body: JSON.stringify({
            password,
            verification, email
          })
        });

        response = await response.json();
        console.log(response);

        if (!response.success){
          alert(response.message);
        } else {
          alert("Password was changed!");
          window.history.back();
        }

      }

    }

    load();


    return this;
  }
});
