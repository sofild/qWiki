<style scoped>
  .login_form {
    margin-top: 200px;
  }
  .form-logo {
    text-align: center;
    margin-bottom: 10px;
    font-size: 20px;
  }
</style>
<template>
    <div class="login_form">
        <Row>
            <Col span="9">
                <div>&nbsp;</div>
            </Col>
            <Col span="6">
                <Form ref="formInline" :model="formInline" :rules="ruleInline">
                    <div class="form-logo">qWiKi</div>
                    <FormItem prop="user">
                        <Input type="text" v-model="formInline.user" placeholder="Username">
                            <Icon type="ios-person-outline" slot="prepend"></Icon>
                        </Input>
                    </FormItem>
                    <FormItem prop="password">
                        <Input type="password" v-model="formInline.password" placeholder="Password">
                            <Icon type="ios-locked-outline" slot="prepend"></Icon>
                        </Input>
                    </FormItem>
                    <FormItem>
                        <Button type="primary" @click="handleSubmit('formInline')">Signin</Button>
                    </FormItem>
                </Form>
            </Col>
            <Col span="9">
                <div>&nbsp;</div>
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
            formInline: {
                user: '',
                password: ''
            },
            ruleInline: {
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
            $.ajax({
                url:'login.php',
                method: 'post',
                type: 'json',
                data: this.formInline,
                success: (data) => {
                    if(data.err == 0){
                        this.$Message.success(data.msg)
                        if(data.root!==1){
                            window.location.href='/#/add'
                        }
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