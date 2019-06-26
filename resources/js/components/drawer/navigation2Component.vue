<template>

    <v-list>
    <v-list-tile @click="onClickHome()">
        <v-list-tile-action>
                <i class="fas fa-home fa-lg"></i>
        </v-list-tile-action>
        <v-list-tile-title>Home</v-list-tile-title>
    </v-list-tile>

    <v-list-group>
        
            <template v-slot:activator>
            <v-list-tile>
                    <v-list-tile-action>
                            <v-icon v-text="'$vuetify.icons.user'"></v-icon>
                    </v-list-tile-action>
                <v-list-tile-title>{{ user }}</v-list-tile-title>
            </v-list-tile>
            </template>
        
                <v-list-tile
                    v-for="item in items"
                    :key="item.title"
                    :icon="item.icon"
                    @click="onClick(item.title)"
                >
                    <v-list-tile-action>        
                    </v-list-tile-action>

                        <v-list-tile-title> 
                            Cerrar sesión
                        </v-list-tile-title>
                
                    <v-list-tile-action>
                    <v-icon v-text="item.icon"></v-icon>
                    </v-list-tile-action>
                </v-list-tile>

    </v-list-group>

    </v-list>

</template>

<script>
export default {
    props: ['user'],

    data(){

        return{
          items: [
          {title: 'Logout',icon:'$vuetify.icons.logout'}
        ]
        };
    },
    methods:{
        onClick(){
            window.location.href = "logout";
            event.preventDefault();
            document.getElementById('logout-form').submit();
        },
        onClickHome(){
             window.location.href = "/home";
        }
       
    }
    
}
</script>
