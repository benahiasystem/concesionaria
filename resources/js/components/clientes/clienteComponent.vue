<template>
<v-container class="my-5">

  <div>
    <v-toolbar flat color="white">
        
      <v-toolbar-title>Gestión Clientes</v-toolbar-title>
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
                      <v-text-field v-model="editedItem.nombre" :rules='nombreRules' v-mask="'SSSSSSSSSSSSSSSSSSSSSSSSSSSSSS'" label="Nombre"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md6>
                      <v-text-field v-model="editedItem.apellido" :rules='apellidoRules' v-mask="'SSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS'" label="Apellido"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md3>
                      <v-text-field v-model="editedItem.identificacion" :rules='identificacionRules' v-mask="'###############'" label="Cedula"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md3>
                      <v-text-field v-model="editedItem.telefono" :rules='telefonoRules' v-mask="'####-###  ####'" label="Telefono"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md6>
                      <v-text-field v-model="editedItem.email" :rules='emailRules' label="Email"></v-text-field>
                    </v-flex>
                    <v-flex xs12 sm6 md12>
                      <v-select
                          v-model="select"
                          :items="selectConcesionario"
                          item-value="id"
                          item-text="nombre"
                          label="Concesionario"
                          persistent-hint
                          return-object
                        ></v-select>
                    </v-flex>
                    <v-flex xs12 sm6 md12>
                      <v-textarea v-model="editedItem.direccion" :rules='direccionRules' 
                      :maxlength="200"
                      rows="1"
                      auto-grow
                      label="Dirección">
                      </v-textarea>
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
        <td class="text-xs-left body-2">{{ props.item.apellido }}</td>
        <td class="text-xs-left body-2">{{ props.item.identificacion }}</td>
        <td class="text-xs-left body-2">{{ props.item.direccion }}</td>
        <td class="text-xs-left body-2">{{ props.item.telefono }}</td>
        <td class="text-xs-left body-2">{{ props.item.email }}</td>
        <td class="justify-center layout px-0">
        <v-icon v-text="'$vuetify.icons.edit'" @click="editItem(props.item)"></v-icon>
          <v-divider class="mx-2" inset vertical></v-divider>
          <v-icon v-text="'$vuetify.icons.trash'" @click="modalDeleteItem(props.item)"></v-icon>
        </td>
      </template>
      <template v-slot:no-data>
        <v-btn color="primary" @click="dataCliente">Recargar</v-btn>
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
      dialog: false,
      search: '',
      valid: true,
      
      desserts: [],
      selectConcesionario: [],
      dialogEliminar: false,
      itemEliminar: '',
      indexEliminar:  '',

      defaultItem: {
        nombre: '',
        apellido:'',
        identificacion:'',
        telefono: '',
        Email:'',
        direccion: '' 
      },

      // reglas de validación
      editedItem: {
        nombre: '',
        apellido:'',
        identificacion:'',
        telefono: '',
        Email:'',
        direccion: ''
      },

      select:[],
      

      nombreRules: [v => !!v || "Este campo es requerido",
      v => (v && v.length <= 30) || 'El campo no debe ser mayor a 30 characters'],

      apellidoRules: [v => !!v || "Este campo es requerido",
      v => (v && v.length <= 40) || 'El campo no debe ser mayor a 40 characters'],

      identificacionRules: [v => !!v || "Este campo es requerido",
      v => (v && v.length <= 15) || 'El campo no debe ser mayor a 15 characters'],

      telefonoRules: [v => !!v || "Este campo es requerido",
      v => (v && v.length <= 15) || 'El campo no debe ser mayor a 15 characters'],

      direccionRules: [v => !!v || "Este campo es requerido",
      v => (v && v.length <= 200) || 'El campo no debe ser mayor a 200 characters'],
     
      emailRules: [
        v => !!v || "Este campo es requerido",
        v => /.+@.+/.test(v) || "El email no es valido",
        v => /.+.com+/.test(v) || "El email no es valido"
      ],
  
      // Cabecera de data-table
      headers: [
        {
          text: 'Nombre', align: 'left', value: 'nombre'},
        { text: 'Apellido', value: 'apellido' },
        { text: 'Cédula', value: 'cedula' },
        { text: 'Dirección', value: 'direccion' },
        { text: 'Telefono', value: 'telefono' },
        { text: 'Email', value: 'email' },
        { text: 'Acción', value: 'name', align: 'center', sortable: false }
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
    
      this.dataCliente()
      this.dataConcesionario()
    },
    
    methods: {
      async dataCliente () {
        try {
          const urlCliente = 'api/cliente';
          await axios.get(urlCliente).then((Response) => {
            let status = Response.data.status;
            let data = Response.data.data; 
                  if(status){
                    this.desserts = data; 
                  }else{
                    this.SnotifyError(this.body= Response.data.msg, this.titulo='Cliente');
                  }
          }); 
        } catch (error) {
          this.SnotifyWarning(this.body='Hubo un error de comunicación con el servidor', this.titulo='Cliente');
        }
         
      },
       async dataConcesionario () {
        try {
          const urlCliente = 'api/concesionario';
          await axios.get(urlCliente).then((Response) => {
            let status = Response.data.status;
            let data = Response.data.data; 
                  if(status){
                    this.selectConcesionario = data;
                  }else{
                    this.SnotifyError(this.body= Response.data.msg, this.titulo='Cliente');
                  }
          }); 
        } catch (error) {
          this.SnotifyWarning(this.body='Hubo un error de comunicación con el servidor', this.titulo='Cliente');
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
        this.select = ''
        this.$refs.form.resetValidation()
      },
      editItem (item) {
        this.editedIndex = this.desserts.indexOf(item)
        this.editedItem = Object.assign({}, item)
        let idConcesionario = (this.desserts[this.editedIndex].concesionarios_id);
        this.select = {id: idConcesionario};
        
        this.dialog = true
      
      },
      modalDeleteItem(item){
        this.editedIndex = this.desserts.indexOf(item);
        this.itemEliminar = (this.desserts[this.editedIndex].id);
        this.dialogEliminar = true;
        this.indexEliminar = this.desserts.indexOf(item)
      },
      async deleteItem (item) {
        const id    = this.itemEliminar;
        const index = this.indexEliminar;
          try {
            await axios.patch(`api/cliente/${id}`).then((Response) => {
              let status = Response.data.status;
              let msg = Response.data.msg;  

              if (status){
                this.desserts.splice(index, 1)
                this.dialogEliminar = false;
                this.SnotifyError(this.body= msg, this.titulo='Cliente');
              }
            });   
          } catch (error) {
             this.SnotifyWarning(this.body='Hubo un error de comunicación con el servidor', this.titulo='Cliente');
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
            await axios.put(`api/cliente/${id}?&concesionarios_id=${this.select.id}&nombre=${this.editedItem.nombre}&apellido=${this.editedItem.apellido}&identificacion=${this.editedItem.identificacion}&direccion=${this.editedItem.direccion}&telefono=${this.editedItem.telefono}&email=${this.editedItem.email}`).then((Response) => {
                let status = Response.data.status;
                let msg = Response.data.msg; 
                  if(status){
                    this.SnotifySucces(this.body= msg, this.titulo='Cliente');
                  }else{
                    this.SnotifyError(this.body= msg, this.titulo='Cliente');
                  }
          });
          Object.assign(this.desserts[this.editedIndex], this.editedItem)  
          } catch (error) {
            this.SnotifyWarning(this.body='Hubo un error de comunicación con el servidor', this.titulo='Cliente');
          }
          
        } else {
          try {
             await axios.post(`api/cliente?concesionarios_id=${this.select.id}&nombre=${this.editedItem.nombre}&apellido=${this.editedItem.apellido}&identificacion=${this.editedItem.identificacion}&direccion=${this.editedItem.direccion}&telefono=${this.editedItem.telefono}&email=${this.editedItem.email}`).then((Response) => {
                let status = Response.data.status;
                let msg = Response.data.msg; 
                    if(status){
                      this.SnotifySucces(this.body= msg, this.titulo='Cliente');
                    }else{
                      this.SnotifyError(this.body= msg, this.titulo='Cliente');
                    }
          });
          this.desserts.push(this.editedItem)  
          } catch (error) {
            this.SnotifyWarning(this.body='Hubo un error de comunicación con el servidor', this.titulo='Cliente');
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
