<template>
  <div>
      
      <v-toolbar app color="primary" >
          <div class="hidden-md-and-up">
            <v-toolbar-side-icon @click="drawer=!drawer" class="toolbarsText--text" slot="activator" > </v-toolbar-side-icon>
          </div>
          
            <v-toolbar-title @click="onClickHome()"><a>Concesionaria</a></v-toolbar-title>
            <v-btn fab color="white" @click="onClickHome()">
              <img class="" src="svg/car.svg" alt="triangle with all three sides equal"
              height="45px" width="45px"></img>
            </v-btn>
            <v-spacer></v-spacer>
            <v-toolbar-items class="hidden-sm-and-down">           
                  <v-btn flat class="toolbarsText--text" @click="onClickLogin()">Login</v-btn>
                  <v-btn flat class="toolbarsText--text" @click="onClickRegister()">register</v-btn>
            </v-toolbar-items>

      </v-toolbar>    

      <v-navigation-drawer app v-model="drawer" temporary >
        <navigation1-component> </navigation1-component>
      </v-navigation-drawer>

  </div>
</template>
<script>
  export default {
    data () {
      return {
        drawer: false,
        dark: true
      }
    },
    methods:{
        onClickLogin(){
            window.location.href = "login";
        },
         onClickRegister(){
            window.location.href = "register";
        }
    }
  }
</script>
