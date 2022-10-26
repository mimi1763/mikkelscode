<template>
  <div class="hello">
    <h1>{{ msg }}</h1>
    <div>
      <h3>Google Custom Search API</h3>
      <div style="display: flex; justify-content: center;">
        <input type="text"
               v-model="searchText"
               class="input-box">
        <div>
          <button class="button-box bg-sky-500 hover:bg-sky-700 ..."
                  type="button"
                  :disabled="!searchText"
                  v-on:click="doSearch()">Search</button>
        </div>
      </div>
      <div class="flex-center margin-top-20">
        <table class="table">
          <tbody>
            <tr>
              <td v-for="image in result.slice(0,5)" :key="image">
                <div class="gcs_container">
                  <a :href="image.image" target="_blank">
                    <img class="gcs_image" :src="image.thumb" alt="">
                  </a>
                </div>
              </td>
            </tr>
            <tr>
              <td v-for="image in result.slice(5,10)" :key="image">
                <div class="gcs_container">
                  <a :href="image.image" target="_blank">
                    <img class="gcs_image" :src="image.thumb" alt="">
                  </a>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div v-if="result && result.length > 0">
        <div class="flex-center">
          <div>Page: {{ currentPage }}</div>
        </div>

        <div class="flex-center">
          <button class="button-box"
                  type="button"
                  :disabled="currentPage === 1"
                  v-on:click="doSearch(false, true)">Prev</button>
          <button class="button-box margin-20"
                  type="button"
                  :disabled="currentPage > 9"
                  v-on:click="doSearch(true, false)">Next</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

axios.defaults.baseURL = '';

export default {
  name: 'HelloWorld',
  props: {
    msg: String
  },
  methods: {
    doSearch: function(nextPage, prevPage) {
      nextPage = nextPage || false
      prevPage = prevPage || false

      if (nextPage) {
        this.currentPage++
      } else if (prevPage) {
        this.currentPage--

        if (this.currentPage < 1) {
          this.currentPage = 1
        }
      } else {
        this.currentPage = 1
      }

      axios.get(this.api_url, {
        headers: {
          "Access-Control-Allow-Origin": "*",
          "Access-Control-Allow-Methods": "GET, POST, PATCH, PUT, DELETE, OPTIONS",
          "Access-Control-Allow-Headers": "Origin, Content-Type, X-Auth-Token"
        }
      }).then(response => {
          this.setupImages(response.data)
      }).catch(error => {
          console.log(error)
      })
    },
    setupImages: function(data) {
      this.result = []

      data.items.forEach(item => {
        if (item.pagemap !== undefined) {
          let newImage = {
            thumb: null,
            image: null
          }

          if (item.pagemap.cse_thumbnail !== undefined) {
            if (item.pagemap.cse_thumbnail.length > 0) {
              newImage.thumb = item.pagemap.cse_thumbnail[0].src
            }
          }

          if (item.pagemap.cse_image !== undefined) {
            if (item.pagemap.cse_image.length > 0) {
              newImage.image = item.pagemap.cse_image[0].src
            }
          }

          if (newImage.thumb) {
            this.result.push(newImage)
          }
        }
      })
    }
  },
  mounted() {
  },
  computed: {
      api_url() {
        const apiKey = 'AIzaSyAFdzTJ0NJ3sZptkNYPb7YETH-v2FUPjvM'
        const apiCx = 'c59c8903e3b6d47ab'

        const start = 1 + (10 * (this.currentPage - 1))

        return '/customsearch/v1?key=' + apiKey + '&cx=' + apiCx + '&num=10&start=' + start + '&q=' + this.searchText
        //alternative: https://cse.google.com/cse?cx=c59c8903e3b6d47ab#gsc.tab=1&gsc.sort=&gsc.q=tintin //separate page
      }
  },
  data() {
    return {
      searchText: '',
      result: [],
      currentPage: 1
    }
  }
}
</script>
<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h3 {
  margin: 40px 0 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}

.margin-20 {
  margin: 20px;
}

.margin-top-10 {
  margin-top: 10px;
}

.margin-top-20 {
  margin-top: 20px;
}

.margin-bottom-10 {
  margin-bottom: 10px;
}

.margin-bottom-20 {
  margin-bottom: 20px;
}

.flex-container {
  display: flex;
}

.gcs_container {
  width: 160px;
  height: 160px;
  padding: 10px;
  margin: 15px;
  border: #a0aec0 1px solid;
  border-radius: 5px;
  overflow: hidden;
}

.gcs_image {
  width: 100%;
}

.flex-center {
  display: flex;
  align-items: center;
  justify-content: center;
  /*flex-direction: column;*/
}

.button-box {
  width: 6em;
  height: 3.8vh;
  padding: 8px;
  border-radius: 8px;
  color: whitesmoke;
  background: cadetblue;
  font-weight: bold;
  position: relative;
  top: 1vh;
}

button:disabled {
  opacity: 20%;
}

.input-box {
  width: 33%;
  height: 3vh;
  border: gray 1px solid;
  border-radius: 8px;
  margin: 10px;
  padding: 4px;
}
</style>
