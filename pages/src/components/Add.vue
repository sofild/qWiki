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
					<Input v-model="path" placeholder="path" style="width: 100%; height:50;"></Input>
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
        	<mavon-editor style="height: 100%" ref=md @imgAdd="$imgAdd" @save="saveHtml"></mavon-editor>
        </div>
    </div>
</template>
<script>
import { mavonEditor } from 'mavon-editor'
import { markdownIt as md } from 'mavon-editor'
import 'mavon-editor/dist/css/index.css'
import $ from 'jquery'
export default {
  name: 'Add',
  components: {
    mavonEditor
  },
  data () {
    return {
      tag: 0,
      path: '',
      title: '',
      attachments: [],
      default_files: [],
      html: '',
    }
  },
  methods: {
    $imgAdd(pos, $file) {
       var formdata = new FormData();
       formdata.append('image', $file);
       axios({
           url: 'upload.php',
           method: 'post',
           data: formdata,
           headers: { 'Content-Type': 'multipart/form-data' },
       }).then((url) => {
           $vm.$img2Url(pos, url);
       })
    },
	successHandle(response, file, fileList){
		this.attachments.push(response.file)
		if(response["err"] > 0){
			this.$Message.error(response.msg)
		}
		console.log(this.attachments)
	},
    errHandle(err, file, fileList) {
    	this.$Message.error(err);
    },
    removeFile(file, fileList) {
    	let index = -1
    	for(let i in fileList){
    		if(fileList[i]['name']===file['name']){
    			index = i
    		}
    	}
    	console.log(index, file, fileList)
    	if(index!==-1){
    		this.attachments.splice(index, 1)
    	}
    	console.log(this.attachments)
    },
    saveHtml(data) {
    	let html = md.render(data)
    	$.ajax({
    		url:'save.php',
    		method: 'post',
    		type: 'json',
    		data: {path: this.path, title: this.title, content: html, attachments: JSON.stringify(this.attachments)},
    		success: function(data) {
    			if(data.err===0){
    				this.$Message.success(data.msg)
    				window.location.href='index.php?to='+data.to
    			}
    			else{
    				this.$Message.error(data.msg);
    			}
    		}
    	})
    }
  }
}
</script>
