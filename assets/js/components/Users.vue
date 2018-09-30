<template>
    <div class="container">
        <loader :loading="isLoading" ></loader>
        <div class="content">
            <ul>
                <template v-for="user in users.data">
                    <li v-bind:key="user.id">
                        <div class="info">
                            <h2>{{ user.last_name }}</h2>
                            <h3>{{ user.first_name }}</h3>
                            <p>ID: {{ user.id }}</p>
                        </div>
                        <p><img v-bind:src="user.avatar" /></p>
                    </li>
                </template>
            </ul>
            <div class="pagination">
              <button @click="prevPage" :disabled="isLoading">
                Previous
              </button>
              <button @click="nextPage" :disabled="isLoading">
                Next
              </button>
            </div>
        </div>
    </div>
</template>


<script>
import axios from 'axios';
import Loader from './Loader.vue';

export default {

    data() {
        return {
            users: [],
            errors: [],
            isLoading: false
        }
   },
   methods:{
        nextPage(){
            if(this.users.page < this.users.total_pages) {
                this.getUsers(this.users.page + 1);
            }
        },
        prevPage(){
            if(this.users.page > 1) {
                this.getUsers(this.users.page - 1);
            }
        },
        getUsers:  function (page = 1) {
            var vm = this
            this.isLoading = true;
            axios.get(`/api/users`, {
               params: {
                 page: page
               }
             })
            .then(function (response) {
              vm.users = response.data;
              this.isLoading = false;
            })
            .catch(e => {
              vm.errors.push(e);
              this.isLoading = false;
            })
        }
  },
  components: {
      Loader
  },
  created() {
        this.getUsers();
  }
}
</script>