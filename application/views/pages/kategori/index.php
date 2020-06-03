<!DOCTYPE html>
<html lang="en">

<head>
  <title>MEME-LUCU</title>

  <!-- Load meta -->
  <?php $this->load->view("components/meta") ?>

  <!-- Load semua stylesheets -->
  <?php $this->load->view("components/stylesheets") ?>

  <!-- Load semua script library -->
  <?php $this->load->view("components/scripts") ?>
</head>

<!-- Load navbar -->
<?php $this->load->view("components/navbar") ?>

<body>
  <div id="app" class="pt-5 mt-2">
    <div class="mb-4" v-if="errors != null || success != null">
      <div v-if="errors != null">
        <div v-for="(item, index) in errors">
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ item }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        </div>
      </div>

      <div v-if="success != null">
        <div v-for="(item, index) in success">
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ item }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="pb-5 pt" style="position: relative; z-index: 8;">
      <div class="container">
        <div class="card-columns">
          <div class="card" v-for="(post, index) in posts" v-bind:key="index">
            <a v-bind:href="base_url + 'post/' + post.id">
              <img v-bind:src="base_url + post.img_link" alt="Image" class="card-img-top img-fluid mb-3">
            </a>
            <div class="card-body">
              <h3 class="card-title">{{ post.judul }}</h3>
              <p class="card-text">Di post oleh {{ post.poster }}</p>
              <p class="card-text pb-2">{{ ( post.vote + post.reactive_vote ) || 0 }} vote</p>
              <a v-bind:href="base_url + 'kategori/' + category" class="badge badge-info mr-1 p-2" v-if="category != ''" v-for="(category, index) in post.kategori.split(',')">
                {{ category }}
              </a>
              <div v-if="username != ''" class="mt-3">
                <button v-on:click="vote(post, 'Y')" class="btn" v-bind:class="posts[index].state == 'Y' ? activeClass : passiveClass">Upvote</button>
                <button v-on:click="vote(post, 'N')" class="btn" v-bind:class="posts[index].state == 'N' ? activeClass : passiveClass">Downvote</button>
                <button v-on:click="report(post)" class="btn btn-danger btn-md">Lapor</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

<!-- Custom Script -->
<script>
  var app = new Vue({
    el: "#app",
    data: {
      base_url: "<?= base_url("") ?>",
      errors: <?= json_encode($this->session->flashdata("error")) ?>,
      success: <?= json_encode($this->session->flashdata("success")) ?>,
      sort_state: "",
      posts: <?= json_encode($categorized_data) ?>,
      username: "<?= $this->session->userdata("username") ?>",
      activeClass: "btn-primary",
      passiveClass: "btn-outline-primary"
    },
    created: function() {
      this.populatePostsData();
    },
    methods: {
      populatePostsData: function(i = 0) {
        let voteMap = new Map([
          ["Y", +1],
          ["-", 0],
          ["N", -1],
          [null, 0]
        ]);
        for (i; i < this.posts.length; i++) {
          let index = i;
          axios
            .all([
              this.username != "" ? this.getVoteState(index) : null, this.getVotes(index)
            ])
            .then(axios.spread((...response) => {
              vote_state = response[0] ? response[0].data.state : null;
              app.$set(app.posts[index],
                "state", vote_state);
              app.$set(app.posts[index],
                "vote", response[1].data.count - voteMap.get(vote_state));
              app.$set(app.posts[index],
                "reactive_vote", voteMap.get(vote_state));
              console.log(response[1].data.count);
            }))
            .catch(error => {
              console.log(error);
            })
        }
      },
      getVoteState: function(i) {
        return axios.get(`${this.base_url}/api/v1/get_vote_state/${this.username}/${this.posts[i].id}`);
      },
      getVotes: function(i) {
        return axios.get(`${this.base_url}/api/v1/get_votes/${this.posts[i].id}`);
      },
      report: function(post) {
        axios
          .post(`${this.base_url}/post/action/report/${post.id}`)
          .then(response => {
            console.log("Post " + post.id + " telah direport")
          })
          .catch(error => {
            console.log("Error report ", error);
          })
      },
      vote: function(post, action) {
        action_url = action == "Y" ? "upvote" : "downvote";
        if (action == post.state) {
          action = "-";
          action_url = "neutralize";
          post.reactive_vote = 0;
        } else {
          post.reactive_vote = action == "Y" ? +1 : -1
        }
        axios
          .post(`${this.base_url}/post/action/${action_url}/${post.id}`)
          .then(response => {
            console.log(action_url + "d " + post.id + ", old state: " + post.state);
            post.state = action;
          })
          .catch(error => {
            console.log("error upvote ", error);
          })
      }
    }
  });
</script>

</html>