<template>
    <v-list>
          <v-list-tile
            v-for="item in items"
            :key="item.title"
            :icon="item.icon"
            @click="onClick(item.title)"
          >
            <v-list-tile-action>
               <v-icon v-text="item.icon"></v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title v-text="item.title"></v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </v-list>
</template>

<script>
export default {
    data(){
        return {
        items: [
          {title: 'Login',icon:'$vuetify.icons.user'},
          {title: 'Register',icon:'$vuetify.icons.register'}
        ]
      }
    },
    methods:{
        onClick(item){
            
            if(item == 'Login'){
                window.location.href = "login";
            }else{
                window.location.href = "register";
            }
        }
    }
}

</script>
