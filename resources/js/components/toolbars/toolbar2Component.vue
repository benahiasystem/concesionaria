 <template>
 <div>
    <v-toolbar app color="primary">

        <div class="hidden-md-and-up">
        <v-toolbar-side-icon class="toolbarsText--text" @click="drawer=!drawer"></v-toolbar-side-icon>
        </div>

        <v-toolbar-title @click="onClickHome()"><a>Concesionaria</a></v-toolbar-title>
       
         <v-btn fab color="white" @click="onClickHome()">
            <img class="" src="/svg/car.svg" alt="triangle with all three sides equal"
             height="45px" width="45px"></img>
        </v-btn>
         
        <v-spacer></v-spacer>
        <v-toolbar-items class="hidden-sm-and-down">
           
            <v-btn flat class="toolbarsText--text" @click="onClickClientes()">
                <v-icon v-text="'$vuetify.icons.userAlt'"></v-icon>
                <v-spacer class="mr-2"></v-spacer>
                <p class="mt3">Clientes</p>
            </v-btn>

            <v-btn flat class="toolbarsText--text" @click="onClickConcesionarios()">
                <v-icon v-text="'$vuetify.icons.tools'"></v-icon>
                <v-spacer class="mr-2"></v-spacer>
                <p class="mt3">Concesionarios</p>
            </v-btn>

            <v-btn flat class="toolbarsText--text" @click="onClickReportes()">
                <v-icon v-text="'$vuetify.icons.filePdf'"></v-icon>
                <v-spacer class="mr-2"></v-spacer>
                <p class="mt3">Reportes </p>
            </v-btn>
            
            <v-btn flat class="toolbarsText--text"> {{ user }}</v-btn>
           
                <v-toolbar-side-icon class="toolbarsText--text" @click="onClickLogout()">
                    <i class="fas fa-sign-in-alt fa-2x text-xs-center mt-1"></i>   
                </v-toolbar-side-icon>
        
        </v-toolbar-items>
    </v-toolbar>  

    
<v-navigation-drawer app v-model="drawer" temporary class="grey lighten-5">
<navigation2-component :user= "user" > </navigation2-component>
</v-navigation-drawer>  
</div>
</template>
    
<script>
export default {

     
    data(){
       // recibe el nombre de usuario desde la etiqueta meta 
         this.user = document.querySelector('meta[name="auth-user"]').getAttribute('content'); 

        return{
            drawer: false,
            items: [
          {
            src: 'svg/logo.svg'
          }
        ]
            
        };
    },
    mounted(){
       
          
    },
    methods:{
        onClickClientes(){
            window.location.href = "/clientes";
        },
        onClickConcesionarios(){
            window.location.href = "/concesionarios";
        },
        onClickLogout(){
            window.location.href = "logout";
            event.preventDefault();
            document.getElementById('logout-form').submit();
            
        },
         onClickHome(){
             window.location.href = "/home";
        },
        onClickReportes(){
             window.location.href = "/reporte/clientes";
        }
    }
    
}
</script>
