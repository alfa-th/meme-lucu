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
  <div id="app">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-7">
          <div class="card o-hidden border-0 shadow-lg">
            <div class="row" style="text-align: center;">
              <div class="col-lg">
                <div class="p-2 m-1">
                  <img src="<?= base_url($post_data["img_link"]) ?>" alt="Image" class="card-img-top img-fluid mb-3 pt-2">
                  <h2> <?= $post_data["judul"] ?> </h2>
                  <p class="card-text py-1">{{ ( post_votes + post_reactive_vote ) || 0 }} vote</p>
                  <p class="card-text py-1">
                    Di post oleh <?= $post_data["poster"] ?> pada <?= $post_data["created_at"] ?>
                  </p>
                  <a v-bind:href="base_url + 'kategori/' + category" class="badge badge-info mx-1 p-2" v-if="category != ''" v-for="(category, index) in post_category.split(',')">
                    {{ category }}
                  </a>
                  <div v-if="username != ''" class="mt-3">
                    <button v-on:click="vote('Y')" class="btn" v-bind:class="post_state == 'Y' ? activeClass : passiveClass">Upvote</button>
                    <button v-on:click="vote('N')" class="btn" v-bind:class="post_state == 'N' ? activeClass : passiveClass">Downvote</button>
                      <?php
                      if ($post_data["poster"] == $this->session->userdata("username")) {
                        echo '<button v-on:click="delete_post" class="btn btn-danger btn-md">Delete</a>';
                      } else {
                        echo '<button v-on:click="report" class="btn btn-danger btn-md">Lapor</a>';
                      }
                      ?>
                  </div>
                </div>
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
      username: "<?= $this->session->userdata("username") ?>",
      post_id: "<?= $post_id ?>",
      post_state: null,
      post_votes: null,
      post_reactive_vote: null,
      post_category: "<?= $post_data["kategori"] ?>",
      activeClass: "btn-primary",
      passiveClass: "btn-outline-primary"
    },
    created: function() {
      this.populatePostData();
    },
    methods: {
      populatePostData: function() {
        let voteMap = new Map([
          ["Y", +1],
          ["-", 0],
          ["N", -1],
          [null, 0]
        ]);
        axios
          .all([
            this.username != "" ? this.getVoteState(this.post_id) : null, this.getVotes(this.post_id)
          ])
          .then(axios.spread((...response) => {
            vote_state = response[0] ? response[0].data.state : null;
            this.post_state = vote_state;
            this.post_votes = response[1].data.count - voteMap.get(vote_state);
            this.post_reactive_vote = voteMap.get(vote_state);
          }))
          .catch(error => {
            console.log(error);
          })
      },
      getVoteState: function() {
        return axios.get(`${this.base_url}/api/v1/get_vote_state/${this.username}/${this.post_id}`);
      },
      getVotes: function() {
        return axios.get(`${this.base_url}/api/v1/get_votes/${this.post_id}`);
      },
      report: function() {
        axios
          .post(`${this.base_url}/post/action/report/${this.post_id}`)
          .then(response => {
            alert(this.post_id + " telah direport")
          })
          .catch(error => {
            console.log("error report ", error);
          })
      },
      vote: function(action) {
        action_url = action == "Y" ? "upvote" : "downvote";
        if (action == this.post_state) {
          action = "-";
          action_url = "neutralize";
          this.post_reactive_vote = 0;
        } else {
          this.post_reactive_vote = action == "Y" ? +1 : -1
        }
        axios
          .post(`${this.base_url}/post/action/${action_url}/${this.post_id}`)
          .then(response => {
            console.log(action_url + "d " + this.post_id + ", old state: " + this.post_state);
            this.post_state = action;
          })
          .catch(error => {
            console.log("error upvote ", error);
          })
      },
      delete_post: function() {
        axios
          .post(`${this.base_url}post/action/delete/${this.post_id}`)
          .then(response => {
            console.log(this.post_id + " telah didelete")
          })
          .catch(error => {
            console.log("error report ", error);
          })
      },
    }
  });
</script>