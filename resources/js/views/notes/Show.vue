<template>
  <div class="container">
    <div class="card mb-3 shadow rounded">
      <img :src="'/img/profile/' + note.image" class="card-img-top" alt="..." />
      <div class="card-body">
        <h5 class="card-title">{{note.title}}</h5>
        <small class="mt-2 badge badge-success">Category</small>
        {{note.subject}}
        <hr />
        <p class="card-text">{{note.description}}</p>
        <p class="card-text">
          <small class="mt-2 badge badge-primary">Publish On</small>
          {{note.published}}
          <br />
          <small class="mt-2 badge badge-secondary">Update On</small>
          {{note.updated}}
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      div: ["image"],
      note: []
    };
  },

  mounted() {
    this.getNote();
  },

  methods: {
    async getNote() {
      let { data } = await axios.get(
        "/api/notes/" + this.$route.params.noteSlug
      );
      this.note = data.data;
    },
    get_image() {
      let photo =
        this.form.image.length > 100
          ? this.form.image
          : "img/profile/" + this.form.image;
      return photo;
    }
  }
};
</script>

