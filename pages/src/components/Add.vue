<style scoped>
	.mt15{
		margin-top: 15px;
	}
	.ivu-input{
		height: 50px;
	}
</style>
<template>
	<div id="editor">
		<div class="mt15">
			<Row>
				<Col span="8">
					<Input v-model="$store.state.path_selected" placeholder="path" style="width: 100%; height:50;"></Input>
				</Col>
				<Col span="2"></Col>
				<Col span="14">
					<Input v-model="title" placeholder="title" style="width: 100%; height:50; margin-left:20px;"></Input>
				</Col>
			</Row>
		</div>
		<div class="mt15">
	      <Upload
		        multiple="false"
		        type="drag"
		        :on-error="errHandle"
		        :on-success="successHandle"
		        :on-remove="removeFile"
		        :default-file-list="default_files"
		        action="upload.php">
		        <div style="padding: 20px 0">
		            <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
		            <p>Click or drag attachments here to upload</p>
		        </div>
		    </Upload>
	    </div>
		<div class="mt15">
        	<mavon-editor style="height: 100%" ref=md @imgAdd="$imgAdd" @save="saveHtml" :value="html"></mavon-editor>
        </div>
    </div>
</template>
<script>
import { mavonEditor } from 'mavon-editor'
import { markdownIt as md } from 'mavon-editor'
import 'mavon-editor/dist/css/index.css'
import $ from 'jquery'
import axios from 'axios'
export default {
  name: 'Add',
  components: {
    mavonEditor
  },
  data () {
    return {
      tag: 0,
      title: '',
      attachments: [],
      default_files: [],
      html: '',
      edit: 0
    }
  },
  mounted () {
    if(this.$route.path==='/add'){
      this.$store.state.path_curent = ["", "新增文档"]
      this.$store.state.path_selected = '/'
      this.edit = 0
    }
    else{
      this.$store.state.path_curent = window.PATH
      let path_selected = window.PATH.slice(0, -1).join('/')
      this.$store.state.path_selected = (path_selected==='' ? '/' : '') + path_selected 
      this.title = window.TITLE
      this.default_files = window.ATTACHMENTS
      this.attachments = this.formatAttach(window.ATTACHMENTS)
      this.html = window.HTML.html
      this.edit = 1
    }
  },
  methods: {
    $imgAdd(pos, $file) {
      var formdata = new FormData();
      formdata.append('image', $file);
      formdata.append('type', 'image');
      axios({
        url: 'upload.php',
        method: 'post',
        data: formdata,
        headers: { 'Content-Type': 'multipart/form-data' },
      }).then((info) => {
        let data = info.data
        if(data.err == 0){
          this.$refs.md.$img2Url(pos, 'images/'+ data.file.url);
        }
        else{
          this.$Message.error(data.msg);
        }
      })
    },
  	successHandle(response, file, fileList){
      if(response.file){
        response.file.relname = file.name
      }
  		this.attachments.push(response.file)
  		if(response["err"] > 0){
  			this.$Message.error(response.msg)
  		}
  	},
    errHandle(err, file, fileList) {
    	this.$Message.error(err);
    },
    removeFile(file, fileList) {
    	let index = -1
    	for(let i in this.attachments){
    		if(this.attachments[i]['relname']===file['name']){
    			index = i
    		}
    	}
    	if(index!==-1){
    		this.attachments.splice(index, 1)
    	}
    },
    saveHtml(data) {
      if(this.title==''){
        this.$Message.error('请填写标题');
        return false;
      }
    	$.ajax({
    		url:'save.php',
    		method: 'post',
    		type: 'json',
    		data: {path: this.$store.state.path_selected, title: this.title, content: data, attachments: JSON.stringify(this.unformatAttach(this.attachments)), file: window.CURPATH, edit: this.edit},
    		success: (data) => {
    			if(data.err == 0){
    				this.$Message.success(data.msg)
    				window.location.href='index.php?to='+data.to
    			}
    			else{
    				this.$Message.error(data.msg);
    			}
    		}
    	})
    },
    formatAttach(attachs) {
      for(let i=0; i<attachs.length; i++){
        attachs[i]['relname'] = attachs[i]['name']
      }
      return attachs
    },
    unformatAttach(attachs){
      let data = []
      for(let i=0; i<attachs.length; i++){
        let dat = {}
        dat.name = attachs[i]['name']
        dat.url = attachs[i]['url']
        data.push(dat)
      }
      return data
    }

  }
}
</script>
