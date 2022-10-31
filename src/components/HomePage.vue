<template>
  <div class="bg-amber-200 p-10">
    <h1 class="text-4xl subpixel-antialiased font-semibold text-red-700 tracking-wide">{{ msg }}</h1>
    <div>
      <div class="mt-10 flex place-content-center">
        <input type="text"
               v-model="searchText"
               class="py-2 text-sm rounded-full p-3 mr-3">
        <div>
          <button class="bg-lime-500 px-5 py-2 text-sm rounded-full font-semibold text-white"
                  :class="{ 'hover:bg-lime-700': searchText }"
                  type="button"
                  :disabled="!searchText"
                  v-on:click="doSearch()">Search</button>
        </div>
      </div>
      <div class="flex place-content-center mt-4">
        <table class="table">
          <tbody>
            <tr>
              <td v-for="image in result.slice(0,5)" :key="image">
                <div class="gcs_container m-3 drop-shadow-lg">
                  <a :href="image.image" target="_blank">
                    <img class="w-full hover:opacity-60" :src="image.thumb" alt="">
                  </a>
                </div>
              </td>
            </tr>
            <tr>
              <td v-for="image in result.slice(5,10)" :key="image">
                <div class="gcs_container m-3 drop-shadow-lg">
                  <a :href="image.image" target="_blank">
                    <img class="w-full hover:opacity-60" :src="image.thumb" alt="">
                  </a>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div v-if="result && result.length > 0">
        <div class="flex place-content-center">
          <div>Page: {{ currentPage }}</div>
        </div>

        <div class="flex place-content-center">
          <button class="bg-lime-500 px-5 py-2 text-sm rounded-full font-semibold text-white m-5"
                  :class="{ 'hover:bg-lime-700': currentPage > 1 }"
                  type="button"
                  :disabled="currentPage === 1"
                  v-on:click="doSearch(false, true)">Prev</button>
          <button class="bg-lime-500 px-5 py-2 text-sm rounded-full font-semibold text-white m-5"
                  :class="{ 'hover:bg-lime-700': currentPage < 10 }"
                  type="button"
                  :disabled="currentPage === 10"
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
  name: 'HomePage',
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
  overflow: hidden;
}

.gcs_image {
  width: 100%;
}

/*.flex-center {*/
/*  display: flex;*/
/*  align-items: center;*/
/*  justify-content: center;*/
/*  !*flex-direction: column;*!*/
/*}*/

/*.button-box {*/
/*  width: 6em;*/
/*  height: 3.8vh;*/
/*  padding: 8px;*/
/*  border-radius: 8px;*/
/*  color: whitesmoke;*/
/*  background: cadetblue;*/
/*  font-weight: bold;*/
/*  position: relative;*/
/*  top: 1vh;*/
/*}*/

button:disabled {
  opacity: 20%;
}

/*.input-box {*/
/*  width: 33%;*/
/*  height: 3vh;*/
/*  border: gray 1px solid;*/
/*  border-radius: 8px;*/
/*  margin: 10px;*/
/*  padding: 4px;*/
/*}*/
</style>
