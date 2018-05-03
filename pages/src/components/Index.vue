<template>
  <div>
    <div v-html="html"></div>  
    <div>
        <ul>
          <li v-for="(item, index) in attachments"><a :href="'attachments/'+item.url">{{ item.name }}</a></li>
        </ul>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Index',
  data () {
    return {
      html: window.HTML,
      attachments: window.ATTACHMENTS
    }
  }
}
</script>