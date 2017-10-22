require('../main.js')
import DataViewer from '../modules/dataviewer/gridView.vue'
import { Modal } from 'uiv'


import FormCategoria from '../forms/form_categoria.vue'
import FormConta from '../forms/form_conta.vue'

new Vue({
 el:'#app',
 components:{
   Modal,
   DataViewer,
   // ## note the form name must be resource route name ex: cat.categorias to form Categira
   'cat.categorias' : FormCategoria,
   'con.contas' : FormConta
 },
 data(){
   return {
     form_modal : false,

   }
 },
 mounted(){

 },
 methods:{
   closeform(){
     
   },
   create(){
    this.form_modal = true;
   },
   store(){

   },

   edit(){

   },
   update(){

   },
   destroy(){

   },

   show(){

   },
   report(){

   },
   download(){

   }
 }
})
