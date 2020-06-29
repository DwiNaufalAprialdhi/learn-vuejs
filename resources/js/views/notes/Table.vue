<template>
  <div class="container">
    <div class="d-flex justify-between">
      <h3>Table Of Note</h3>
      <hr />
      <router-link :to="{name:'notes.create'}">
        <button class="btn btn-primary btn-sm shadow rounded">
          New Note
          <i class="fa fa-plus"></i>
        </button>
      </router-link>
    </div>
    <hr />

    <table class="table mb-5 shadow bg-white rounded">
      <thead class="bg-primary">
        <tr class="text-white">
          <th>Title</th>
          <th>Subject</th>
          <th>Published</th>
          <th colspan="2">
            <center>Action</center>
          </th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="note in notes" :key="note.id">
          <td>
            <router-link :to="{ name: 'notes.show', params: {noteSlug: note.slug} }">{{note.title}}</router-link>
          </td>
          <td>{{note.subject.name}}</td>
          <td>{{note.created_at}}</td>
          <td>
            <router-link :to="{ name: 'notes.edit', params: {noteSlug: note.slug} }">
              <button class="btn btn-success btn-sm">
                <i class="fa fa-pencil"></i>
              </button>
            </router-link>
          </td>
          <td>
            <delete-note :endpoint="note.slug" />
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from "axios";
import DeleteNote from "./Delete";
export default {
  components: {
    DeleteNote
  },

  data() {
    return {
      notes: []
    };
  },

  mounted() {
    this.getNotes();
  },

  methods: {
    async getNotes() {
      let { data } = await axios.get("/api/notes");
      this.notes = data.data;
    }
  }
};
</script>
