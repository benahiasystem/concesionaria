<template>
<div v-bind:style="{ bottom:'0px', position: 'fixed', width: '100%'}" >
  <v-footer  dark height="auto">
    <v-card class="flex" flat tile >

      <v-card-actions class="footer  justify-center">
        &copy;2019 — Benahia System C.A Todos los derechos reservados.
      </v-card-actions>
    </v-card>
  </v-footer>
  </div>
</template>

<script>
export default {

  
  data: () => ({
  
  methods: {
    menuItems () {
      return this.menu
    }
  }
})
}
  
</script>
