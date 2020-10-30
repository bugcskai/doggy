<template>
  <div class="container">
    <h2 class="mt-4 text-center">Add Dog Sightings</h2>
    <form @submit.prevent="onSubmit" ref="addDogForm">
      <div class="form-row">
        <div class="form-group col-md-6">
            <label for="name">Dog Name</label>
            <input
            type="text"
            placeholder="Ex: Dog 1"
            name="dog.name"
            class="form-control"
            />
        </div>
        <div class="form-group col-md-6">
            <label for="location">Breed</label>
            <input
            type="text"
            placeholder="Ex: Rottie"
            name="dog.breed"
            class="form-control"
            />
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
            <label for="name">Time Located</label>
            <input
            type="text"
            placeholder="Time format YY-MM-DD hh-ii-ss"
            name="dog.time_located"
            class="form-control"
            />
        </div>
        <div class="form-group col-md-6">
        </div>
      </div>
      <div class="form-group">
        <label for="location">AutoComplete Location Search</label>
        <autocomplete :items="placeData" :isAsync="false" @input="searchLocation" @selected="autcompleteSelectedResult" />
      </div>
      <button type="submit" class="btn btn-dark">
        Save
      </button>
    </form>
    <h2>Dog Sighting List</h2>
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
          <td><a href="#" @click="changeMapLocation(entry.place)" >View Location</a></td>
        </tr>
      </tbody>
    </table>
    <h2>Google Map Widget</h2>
    <google-map :currentMapCoords="currentMapLocation" />
  </div>
</template> 

<script>
import axios from 'axios';
import autocomplete from './SearchLocationAutocomplete.vue'
import GoogleMap from './GoogleMap.vue'

export default {
  name: "Dog",
  data: () => ({ name: "", location: {}, locationString: "", allDogs: [], placeData: ['game'], currentMapLocation: {} }),
  methods: {
    changeMapLocation(location) {
        const self = this
        self.location = location
        let searchLocation = location.name

        if ({}.hasOwnProperty.call(location, "name")) {            
            axios.put('/doggy/search-location', {
            place : searchLocation
            }, {
                headers: {
                    'x-auth-token': 'tokensample'
                } 
            }).then(response => {           
                response = response.data.response.response.predictions     
                searchLocation = response[0]

                axios.put('/doggy/get-place-details', {
                    place_id : searchLocation.place_id
                }, {
                    headers: {
                        'x-auth-token': 'tokensample'
                    } 
                }).then(response => {         
                    console.log(response.data.response.response.result.geometry.location)  
                    self.currentMapLocation = response.data.response.response.result.geometry.location
                })
            })
        }
        
    },

    onSubmit() {        
        const formData = new FormData(this.$refs.addDogForm) // reference to form element      
        const data = {} // need to convert it before using not with XMLHttpRequest
        for (let [key, val] of formData.entries()) {
            let subname
            [key, subname] = key.split(".")
            if (subname)
            {
                if ({}.hasOwnProperty.call(data, key))
                {
                    Object.assign(data[key], { [subname] : val })    
                } else {
                    Object.assign(data, { [key]: { [subname] : val } })    
                }
            } else {
                Object.assign(data, { [key]: val })
            }
        }

        const locationData = JSON.parse(JSON.stringify(this.location))
        Object.assign(data, locationData)

        axios.put('/doggy/add-dog-place', data, {
            headers: {
                'x-auth-token': 'tokensample'
            } 
        }).then(() => {
            this.populateDogs()
        })
    },

    searchLocation(loc) {
      let self = this
      self.locationString = loc

      clearTimeout(window.autosearch)
      window.autosearch = setTimeout(()=> {
        const combined_places = []

        axios.put('/doggy/search-location', {
        place : loc
        }, {
            headers: {
                'x-auth-token': 'tokensample'
            } 
        }).then(response => {                
            response = response.data.response.response.predictions
            response.forEach (element => {
                combined_places.push(element.description)
            })
            self.placeData = combined_places    
        })
        
      }, 2000)
    },

    populateDogs() {
      axios.get('/doggy/get-dogs', {
            headers: {
                'x-auth-token': 'tokensample'
            } 
        }).then(response => {
            this.allDogs = response.data.response
        })
    },

    autcompleteSelectedResult(result) {
        this.locationString = result
        this.location = {"location": {"name": result, "location": result}}
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
    this.populateDogs()
  },
  components: {
    autocomplete,
    GoogleMap
  },
};
</script>