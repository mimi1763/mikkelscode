<template>
  <div class="hello">
    <h1>{{ msg }}</h1>
    <p>
      <a href="https://cli.vuejs.org" target="_blank" rel="noopener">vue-cli documentation</a>.
    </p>
    <h3>Installed CLI Plugins</h3>
    <ul>
      <li><a href="https://github.com/vuejs/vue-cli/tree/dev/packages/%40vue/cli-plugin-babel" target="_blank" rel="noopener">babel</a></li>
      <li><a href="https://github.com/vuejs/vue-cli/tree/dev/packages/%40vue/cli-plugin-eslint" target="_blank" rel="noopener">eslint</a></li>
    </ul>
    <h3>Ecosystem</h3>
    <ul>
      <li><a href="https://router.vuejs.org" target="_blank" rel="noopener">vue-router</a></li>
      <li><a href="https://vuex.vuejs.org" target="_blank" rel="noopener">vuex</a></li>
      <li><a href="https://github.com/vuejs/vue-devtools#vue-devtools" target="_blank" rel="noopener">vue-devtools</a></li>
      <li><a href="https://vue-loader.vuejs.org" target="_blank" rel="noopener">vue-loader</a></li>
      <li><a href="https://github.com/vuejs/awesome-vue" target="_blank" rel="noopener">awesome-vue</a></li>
    </ul>
    <div>
      <pre>{{api_url}}</pre>
      <h3>Google Custom Search API</h3>
      <div class="input-group mb-3" style="display: flex; justify-content: center;">
        <input type="text"
               v-model="searchText"
               class="form-control">
        <div class="input-group-append">
          <button class="btn btn-primary"
                  type="button"
                  v-on:click="doSearch()">Search</button>
        </div>
      </div>
      <table class="table">
        <tbody>
          <tr>
            <td v-for="image in result" :key="image">
              <div style="padding: 5px;">
                <img :src="image" alt="">
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <!--<component v-bind:is="script" :src="api_url" async></component>-->
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
    doSearch: function() {
      axios.get(this.api_url, {
        headers: {
          "Access-Control-Allow-Origin": "*",
          "Access-Control-Allow-Methods": "GET, POST, PATCH, PUT, DELETE, OPTIONS",
          "Access-Control-Allow-Headers": "Origin, Content-Type, X-Auth-Token"
        }
      }).then(response => {
          this.setupImages(response.data);
      }).catch(error => {
          console.log(error);
      })
    },
    setupImages: function(data) {
      this.result = [];

      data.items.forEach(item => {
        if (item.pagemap !== undefined) {
          if (item.pagemap.cse_thumbnail !== undefined) {
            if (item.pagemap.cse_thumbnail.length > 0) {
              this.result.push(item.pagemap.cse_thumbnail[0].src)
            }
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

        return '/customsearch/v1?key=' + apiKey + '&cx=' + apiCx + '&num=10&q=' + this.searchText
        // return '/cse?cx=' + apiCx
      }
  },
  data() {
    return {
      searchText: '',
      result: [],
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
</style>
