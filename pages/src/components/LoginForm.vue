<style scoped>
  
</style>
<template>
    <div>
        <Row>
            <Col span="8">
                
            </Col>
            <Col span="8">
                <Form ref="form" :model="formInline" :rules="rule">
                    <FormItem prop="user">
                        <Input type="text" v-model="form.user" placeholder="Username">
                            <Icon type="ios-person-outline" slot="prepend"></Icon>
                        </Input>
                    </FormItem>
                    <FormItem prop="password">
                        <Input type="password" v-model="form.password" placeholder="Password">
                            <Icon type="ios-locked-outline" slot="prepend"></Icon>
                        </Input>
                    </FormItem>
                    <FormItem>
                        <Button type="primary" @click="handleSubmit('form')">Signin</Button>
                    </FormItem>
                </Form>
            </Col>
            <Col span="8">
                
            </Col>
        </Row>
    </div>
</template>
<script>
  import $ from 'jquery'  
  export default {
    name: 'LoginForm',
    components: {
      
    },
    data () {
        return {
            form: {
                user: '',
                password: ''
            },
            rule: {
                user: [
                    { required: true, message: 'Please fill in the user name', trigger: 'blur' }
                ],
                password: [
                    { required: true, message: 'Please fill in the password.', trigger: 'blur' },
                    { type: 'string', min: 6, message: 'The password length cannot be less than 6 bits', trigger: 'blur' }
                ]
            }
        }
    },
    methods: {
        handleSubmit(name) {
            this.$refs[name].validate((valid) => {
                if (valid) {
                    $.ajax({
                        url:'login.php',
                        method: 'post',
                        type: 'json',
                        data: this.form,
                        success: function(data) {
                            if(data.err===0){
                                this.$Message.success(data.msg)
                                if(data.root!==1){
                                    window.location.href='index.php'
                                }
                            }
                            else{
                                this.$Message.error(data.msg);
                            }
                        }
                    })
                } else {
                    this.$Message.error('Fail!');
                }
            })
        }
    }
  }
</script>