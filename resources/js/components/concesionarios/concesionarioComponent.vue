<template>
<v-container class="my-5">

  <div>
    <v-toolbar flat color="white">
        
      <v-toolbar-title>Gestión Concesionario</v-toolbar-title>
      <v-divider class="mx-2" inset vertical></v-divider>
      <v-spacer></v-spacer>

      <v-dialog v-model="dialog" max-width="700px">
        <template v-slot:activator="{ on }">
         <v-flex xs12 sm6 md3>
          <v-text-field
            v-model="search"
            append-icon="search"
            label="Buscar"
            single-line
            hide-details
          ></v-text-field>
        </v-flex>
    
            <v-divider class="mx-2" inset vertical></v-divider>
           <v-btn fab dark color="secondary" @click="newItem()"><v-icon dark>add</v-icon></v-btn>
        </template>
        <v-card>
          <v-card-title>
             <v-icon v-text="formIcon"></v-icon>
              <v-divider class="mx-2" inset vertical></v-divider>
            <span class="headline">{{ formTitle }}</span>
           
          </v-card-title>
          <v-divider inset horizontal></v-divider>
          <!-- dialogo modal-->
          <v-card-text>
            <v-form ref="form" v-model="valid" lazy-validation>
              <v-container grid-list-md>
                <v-layout wrap>
                    <v-flex xs12 sm6 md6>
                      <v-text-field v-model="editedItem.nombre" :rules='nombreRules' v-mask="'SSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS'" label="Nombre"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md6>
                      <v-text-field v-model="editedItem.localidad" :rules='localidadRules' :maxlength="100" label="Localidad"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md6>
                      <v-text-field v-model="editedItem.ciudad" :rules='ciudadRules' v-mask="'SSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS'" label="Ciudad"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md6>
                      <v-text-field v-model="editedItem.region" :rules='regionRules' label="Región" :maxlength="200"></v-text-field>
                    </v-flex>
                </v-layout>
              </v-container>
            </v-form>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="error" @click="close()">
              <v-icon v-text="'$vuetify.icons.cancel'"></v-icon>
              <v-spacer class="mr-2"></v-spacer>
              Cancel
            </v-btn>
            <v-btn :disabled="!valid" color="primary" @click="validate()" class="toolbarsText--text">
              <v-icon v-text="'$vuetify.icons.save'"></v-icon>
              <v-spacer class="mr-2"></v-spacer>
              Guardar
            </v-btn>
             
          </v-card-actions>
        </v-card>
      </v-dialog>
      
    </v-toolbar>
    <v-data-table
      :headers="headers"
      :items="desserts"
      :search="search"
      class="elevation-1"
    >
      
      <template v-slot:items="props">
        <td class="font-weight-regular body-2">{{ props.item.nombre }}</td>
        <td class="text-xs-left body-2">{{ props.item.localidad }}</td>
        <td class="text-xs-left body-2">{{ props.item.ciudad }}</td>
        <td class="text-xs-left body-2">{{ props.item.region }}</td>
        <td class="justify-center layout px-0">
        <v-icon v-text="'$vuetify.icons.edit'" @click="editItem(props.item)"></v-icon>
          <v-divider class="mx-2" inset vertical></v-divider>
          <v-icon v-text="'$vuetify.icons.trash'" @click="modalDeleteItem(props.item)"></v-icon>
        </td>
      </template>
      <template v-slot:no-data>
        <v-btn color="primary" @click="dataConcesionario">Recargar</v-btn>
      </template>
      <template v-slot:no-results>
        <v-alert :value="true" color="error" icon="warning">
          La busqueda para "{{ search }}" no tiene resultados.
        </v-alert>
      </template>
    </v-data-table>


    <div class="text-xs-center">
      <v-dialog v-model="dialogEliminar" width="400">

        <v-card>
            <v-card-title class="headline error" primary-title>
              <v-icon v-text="$vuetify.icons.radiation"></v-icon>
              <v-divider class="mx-2" inset vertical></v-divider>
              Alerta
            </v-card-title>

              <v-card-text class="body-2">
                Desea eliminar este registro de forma permanente ?
              </v-card-text>

                <v-divider></v-divider>

                  <v-card-actions>
                    <v-spacer></v-spacer>
                      <v-btn color="primary" flat @click="dialogEliminar = false">
                        <v-spacer class="mr-2"></v-spacer>
                        Cancelar
                      </v-btn>

                      <v-btn color="primary" flat @click="deleteItem()">
                          <v-spacer class="mr-2"></v-spacer>
                          Eliminar
                      </v-btn>
                  </v-card-actions>

        </v-card>
      </v-dialog>
    </div>

      <div>
      <vue-snotify></vue-snotify>
      </div>
   
  </div>
</v-container>
</template>

<script>
// libreria para formatear campos de texto
// https://vuejs-tips.github.io/vue-the-mask/

import { TheMask } from 'vue-the-mask'
import axios from 'axios'
import { SnotifyPosition, SnotifyToast, SnotifyToastConfig } from 'vue-snotify';
import "vue-snotify/styles/material.css";

  export default {
    data: () => ({

      components: {TheMask},
      dialog:         false,
      search:         '',
      valid:          true,
      dialogEliminar: false,
      itemEliminar:   '',
      indexEliminar:  '',

      desserts: [],
      editedIndex: -1,
      editedItem: {
        nombre: '',
        localidad:'',
        ciudad:'',
        region: ''
      },
       defaultItem: {
        nombre: '',
        localidad:'',
        ciudad:'',
        region: ''
       },
      
      // reglas de validación

      nombreRules: [v => !!v || "Este campo es requerido",
      v => (v && v.length <= 50) || 'El campo no debe ser mayor a 30 characters'],

      localidadRules: [v => !!v || "Este campo es requerido",
      v => (v && v.length <= 100) || 'El campo no debe ser mayor a 40 characters'],

      ciudadRules: [v => !!v || "Este campo es requerido",
      v => (v && v.length <= 100) || 'El campo no debe ser mayor a 15 characters'],

      regionRules: [v => !!v || "Este campo es requerido",
      v => (v && v.length <= 200) || 'El campo no debe ser mayor a 15 characters'],
  
      // Cabecera de data-table
      headers: [
        {
          text: 'Nombre',    value: 'nombre'},
        { text: 'Localidad', value: 'localidad' },
        { text: 'Ciudad',    value: 'ciudad' },
        { text: 'Region',    value: 'region' }
      ]

    }),
    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'Nuevo Cliente' : 'Editar Cliente'
      },
       formIcon () {
        return this.editedIndex === -1 ? '$vuetify.icons.usersPlus' : '$vuetify.icons.usersEdit'
      }
    },
    watch: {
      dialog (val) {
        val || this.close()
      }
    },
    mounted () {
      // agregar autorización API token 
      axios.defaults.headers.common['Authorization'] = 'Bearer ' + document.querySelector('meta[name="api_token"]').getAttribute('content');
    
      this.dataConcesionario()

    },
    
    methods: {
      async dataConcesionario () {
        try {
          const urlConcesionario = 'api/concesionario';
          await axios.get(urlConcesionario).then((Response) => {
            let status = Response.data.status;
            let data = Response.data.data; 
                  if(status){
                    this.desserts = data; 
                  }else{
                    this.SnotifyError(this.body= Response.data.msg, this.titulo='Concesionario');
                  }
         }); 
        } catch (error) {
          this.SnotifyWarning(this.body='Hubo un error de comunicación con el servidor', this.titulo='Concesionario');
        }
         
      },
      validate () {
        if (this.$refs.form.validate()) {
          this.snackbar = true
          this.save();
        }
      },
       newItem() {
        this.resetValidation()
        
         this.dialog = true
      },
      resetValidation () {
        this.$refs.form.resetValidation()
      },
      editItem (item) {
        this.editedIndex = this.desserts.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      
      },
      modalDeleteItem(item){
        this.editedIndex = this.desserts.indexOf(item);
        this.itemEliminar = (this.desserts[this.editedIndex].id);
        this.dialogEliminar = true;
        this.indexEliminar = this.desserts.indexOf(item)
      },

      async deleteItem () {
        const id = this.itemEliminar;

         try {
           await axios.patch(`api/concesionario/${id}`).then((Response) => {
              let status = Response.data.status;
              let msg = Response.data.msg;  

              if (status){
                this.desserts.splice(this.indexEliminar, 1)
                this.dialogEliminar = false;
                this.SnotifyError(this.body= msg, this.titulo='Concesionario');
              }
            })
         } catch (error) {
           this.SnotifyWarning(this.body='Hubo un error de comunicación con el servidor', this.titulo='Concesionario');
         }
      },
      close () {
        this.dialog = false
        setTimeout(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        }, 300)
        this.resetValidation();
      },
      async save () {
       
        if (this.editedIndex > -1 ) {
          const id = (this.desserts[this.editedIndex].id);
          try {
            await axios.put(`api/concesionario/${id}?nombre=${this.editedItem.nombre}&localidad=${this.editedItem.localidad}&ciudad=${this.editedItem.ciudad}&region=${this.editedItem.region}`).then((Response) => {
                let status = Response.data.status;
                let msg = Response.data.msg; 
                  if(status){
                    this.SnotifySucces(this.body= msg, this.titulo='Concesionario');
                  }else{
                    this.SnotifyError(this.body= msg, this.titulo='Concesionario');
                  }
            });
          } catch (error) {
             this.SnotifyWarning(this.body='Hubo un error de comunicación con el servidor', this.titulo='Concesionario');
          }
          

          Object.assign(this.desserts[this.editedIndex], this.editedItem)
        } else {
          try {
            await axios.post(`api/concesionario?nombre=${this.editedItem.nombre}&localidad=${this.editedItem.localidad}&ciudad=${this.editedItem.ciudad}&region=${this.editedItem.region}`).then((Response) => {
                let status = Response.data.status;
                let msg = Response.data.msg; 
                    if(status){
                      this.SnotifySucces(this.body= msg, this.titulo='Concesionario');
                    }else{
                      this.SnotifyError(this.body= msg, this.titulo='Concesionario');
                    }
            });
            this.desserts.push(this.editedItem) 
          } catch (error) {
            this.SnotifyWarning(this.body='Hubo un error de comunicación con el servidor', this.titulo='Concesionario');
          }
           
        }
        this.close() 
      },
      //alertas toast
      SnotifySucces(){
        this.$snotify.success(this.body, this.titulo);
      },
      SnotifyInfo(){
        this.$snotify.info(this.body, this.titulo);
      },
      SnotifyWarning(){
        this.$snotify.warning(this.body, this.titulo);
      },
      SnotifyError(){
        this.$snotify.error(this.body, this.titulo);
      }
    }
  }
</script>




















