<template>
<v-container class="my-5" grid-list-md>
  <v-card
    class="mx-auto px-4"
    color= ""
    max-width="450"
  >
    <v-card-title>
      <span class="title font-weight-light">Reporte Clientes</span>
    </v-card-title>

            <v-card-text>
                <v-layout wrap>
                
                    <v-flex xs12 sm6 md12>
                        <v-select
                            v-model="select"
                            :items="selectConcesionario"
                            item-value="id"
                            item-text="nombre"
                            label="Concesionarios"
                            persistent-hint
                            return-object
                        ></v-select>
                    </v-flex>
                    <br>
                    <v-flex xs12 sm6 md12>
                        <v-select
                            class="toolbarsText--text" 
                            v-model="select2"
                            :items="selectConcesionario"
                            item-value="id"
                            item-text="localidad"
                            label="Localidad"
                            persistent-hint
                            return-object
                        ></v-select>
                    </v-flex>
            
                </v-layout>
            </v-card-text>
            
        <v-flex xs12 sm6 md12>
          <v-card-text >
            <div class="text-md-center">
              <v-btn @click="generar(select.id,select.nombre,select2.id,select2.localidad)" color="secondary" >
                  Generar PDF
              <v-spacer class="mr-2"></v-spacer>
              <v-icon v-text="'$vuetify.icons.pdf'"></v-icon>
              </v-btn>
            </div>
          </v-card-text>
        </v-flex>
       
  </v-card>
</v-container>
</template> 

<script>

import axios from 'axios'
import { SnotifyPosition, SnotifyToast, SnotifyToastConfig } from 'vue-snotify';
import "vue-snotify/styles/material.css";

  export default {
    data: () => ({
        select: [],
        select2: [],
        selectConcesionario: []
    }),
    mounted () {
         // agregar autorización API token 
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + document.querySelector('meta[name="api_token"]').getAttribute('content');
        
        this.dataConcesionario()
    },
    methods: {
         async dataConcesionario () {
        try {
          const urlCliente = '/reporte/datosconcesionarios';
          await axios.get(urlCliente).then((Response) => {
            let status = Response.data.status;
            let data = Response.data.data; 
            
                  if(status){
                    this.selectConcesionario = data;
                    console.log(data);
                  }else{
                    //this.SnotifyError(this.body= Response.data.msg, this.titulo='Cliente');
                  }
          }); 
        } catch (error) {
         
        }
         
    },
    async generar(idc,concesionario,idl,localidad) {
      const urlCliente = `/reporte/clientespdf/${idc}/${idl}`;
         await axios.get(urlCliente).then((Response) => {
            let data = Response.data;
            console.log(data);
          }); 
      //alert(idc + "-" + concesionario);
    }
  }
  }
</script>