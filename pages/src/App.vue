<style scoped>
.layout{
    border: 1px solid #d7dde4;
    background: #f5f7f9;
    position: relative;
    border-radius: 4px;
    overflow: hidden;
}
.layout-logo{
    width: 100px;
    height: 30px;
    background: #5b6270;
    border-radius: 3px;
    float: left;
    position: relative;
    top: 15px;
    left: 20px;
}
.layout-nav{
    width: 420px;
    margin: 0 auto;
    margin-right: 20px;
}
</style>
<template>
    <div class="layout">
        <Layout>
            <Header>
                <Menu mode="horizontal" theme="dark" active-name="1">
                    <div class="layout-logo"></div>
                    <div class="layout-nav">
                        <MenuItem name="1">
                          <router-link to="/add">
                            <Icon type="ios-navigate"></Icon>
                            新增
                          </router-link>
                        </MenuItem>
                    </div>
                </Menu>
            </Header>
            <Layout>
                <Sider hide-trigger :style="{background: '#fff'}">
                    <Tree :data="data" :render="renderContent"></Tree>
                </Sider>
                <Layout :style="{padding: '0 24px 24px'}">
                    <Breadcrumb :style="{margin: '24px 0'}">
                        <BreadcrumbItem>Home</BreadcrumbItem>
                        <BreadcrumbItem>Components</BreadcrumbItem>
                        <BreadcrumbItem>Layout</BreadcrumbItem>
                    </Breadcrumb>
                    <Content :style="{padding: '24px', minHeight: '280px', background: '#fff'}">
                        <router-view></router-view>
                    </Content>
                </Layout>
            </Layout>
        </Layout>
    </div>
</template>
<script>
  export default {
    name: 'App',
    components: {
      
    },
    data () {
        return {
            
        }
    },
    computed: {
      data: function() {
        let datas = []
        let menus = window.MENU
        return this.formatMenu(menus, '')
      }
    },
    methods: {
      formatMenu(menus, pmenu){
        let data = []
        for(let k in menus){
          let obj = {}
          if(!isNaN(k)){
            let path = pmenu + '/' + menus[k]
            obj.title = this.formatTitle(menus[k])
            obj.render = (h, { root, node, data }) => {
                            return h('span', {
                              style: {
                                display: 'inline-block',
                                width: '100%'
                              }
                            }, [
                              h('span', [
                                h('Icon', {
                                  props: {
                                    type: 'ios-paper-outline'
                                  },
                                  style: {
                                    marginRight: '8px'
                                  }
                                }),
                                h('Button', {
                                  props: {
                                      type: 'text'
                                  },
                                  on: {
                                      click: () => { this.goto(path) }
                                  }
                                }, data.title)
                              ]),
                            ]);
                          } 
            data.push(obj)
          }
          else{
            pmenu = pmenu + '/' + k
            obj.title = k
            obj.expand = true
            obj.render = (h, { root, node, data }) => {
                return h('span', {
                  style: {
                    display: 'inline-block',
                    width: '100%'
                  }
                }, [
                  h('span', [
                    h('Icon', {
                      props: {
                        type: 'ios-folder-outline'
                      },
                      style: {
                        marginRight: '8px'
                      }
                    }),
                    h('span', data.title)
                  ]),
                ]);
              }
            obj.children = this.formatMenu(menus[k], pmenu)
            data.push(obj)
          }
        }
        return data
      },
      formatTitle(name) {
        let names = name.split('_')
        let name2 = name.replace(names[0]+'_', '')
        let name3 = name2.replace('.qwk', '')
        return name3
      },
      goto(path) {
        window.location.href='index.php?to='+encodeURIComponent(path)
      }
    }

  }
</script>