<style scoped>
@import "github-markdown-css/github-markdown.css";
.attachs {
  margin-top:20px;
}
.attachs ul li {
  list-style-type:none;
}
</style>
<template>
  <div>
    <div v-html="html" class="markdown-body"></div>  
    <div class="attachs" v-if="attachments.length > 0">
        <div>附件</div>
        <ul>
          <li v-for="(item, index) in attachments">
            <a :href="'attachments/'+item.url" target="_blank"><Icon type="android-attach"></Icon> {{ item.name }}</a>
          </li>
        </ul>
    </div>
  </div>
</template>

<script>
import { markdownIt as md } from 'mavon-editor'
export default {
  name: 'Index',
  data () {
    return {
      attachments: window.ATTACHMENTS
    }
  },
  computed: {
    html: function() {
      let content = window.HTML.html
      let html = md.render(content)
      return this.nl2br(html)
    }
  },
  methods: {
    nl2br (str, is_xhtml) {
      var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';    
      return (str + '').replace(/([^>\r\n]?)(\r\n\n|\n\n\r|\r\r|\n\n)/g, '$1'+ breakTag +'$2');
    }
  }
}
</script>