<template>
  <div class="container">
    <h1 class="mt-4 text-center">Dogs</h1>
    <form>
      <div class="form-row">
        <div class="form-group col-md-6">
            <label for="name">Name</label>
            <input
            type="text"
            placeholder="Ex: Dog 1"
            v-model="name"
            class="form-control"
            />
        </div>
        <div class="form-group col-md-6">
            <label for="location">Breed</label>
            <input
            type="number"
            placeholder="Ex: 53453"
            v-model="breed"
            class="form-control"
            />
        </div>
      </div>
      <div class="form-group">
        <label for="location">AutoComplete Location Search</label>
        <autocomplete :items="placeData" :isAsync="false" @input="searchLocation" />
      </div>
      <button type="button" @click="onSubmit" class="btn btn-dark">
        Save
      </button>
    </form>
    <table class="table mt-5">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Breed</th>
          <th scope="col">Location</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(entry, i) in sortedList" :key="i">
          <th scope="row">{{ ++i }}</th>
          <td>{{ entry.name }}</td>
          <td>{{ entry.breed }}</td>
          <td>{{ entry.location }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template> 

<script>
import axios from 'axios';
import autocomplete from './SearchLocationAutocomplete.vue'

export default {
  name: "Dog",
  data: () => ({ name: "", location: "", allDogs: [], placeData: ['game'] }),
  methods: {
    onSubmit() {
      let dogPlace = [] 
      dogPlace.push({ name: this.name, breed: this.breed });
      this.clearForm();
    },
    clearForm() {
      this.name = "";
      this.location = "";
    },
    searchLocation(loc) {
      let self = this

      clearTimeout(window.autosearch)
      window.autosearch = setTimeout( () => 
      axios.put('/doggy/search-location', {
        place : loc
      }, {
            headers: {
                'x-auth-token': 'tokensample'
            } 
        }).then(response => {
            let combined_places = []
            response.data.response.response.predictions.forEach (element => {
                combined_places.push(element.description)
            })
            self.placeData = combined_places
        })
        , 2000)
    },
  },
  computed: {
    sortedList: function() {
      return this.allDogs.slice().sort(function(a, b) {
        return b.id - a.id;
      });
    },
  },
  mounted() {
      axios.get('/doggy/get-dogs', {
            headers: {
                'x-auth-token': 'tokensample'
            } 
        }).then(response => {
            this.allDogs = response.data.response
        })
  },
  components: {
    autocomplete
  },
};
</script>