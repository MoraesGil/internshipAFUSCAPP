<template lang="html">
  <form :id="formId">
    <label for="cat_name">Titulo</label>
    <input type="text" id="cat_name" class="form-control"  placeholder="ex: desepesas, manutenção  ..." data-action="auto-focus" v-model="dataForm.label"/>
    <br>
    <label for="descricao">Descrição</label>
    <textarea id="descricao" placeholder="..." class="form-control" v-model="dataForm.descricao"></textarea>
    <br>
    <div class="center-block">
      <div class="pull-left">
        <label for="descricao">Selecione a cor categoria</label>
        <color-picker v-model="colorPicker" />
      </div>
      <div class="pull-right text-center">
        <label for="descricao">Cor selecionada</label>
        <br>
        <i class="fa fa-square fa-fw fa-3x " :style="'color :'+dataForm.color"></i>
      </div>
    </div>
  </form>
</template>

<script>
import { Slider } from 'vue-color'
import MainForm from './form_main.vue'
/**
 * @author Gilberto Prudêncio Vaz de Moraes <moraesdev@gmail.com>
 * @type {Object}
 */
var defaultProps = {
  hex:"#A579D2",
  a: 1
}

export default {
  extends: MainForm,
  components:{
    'color-picker': Slider
  },
  watch: {
    colorPicker(val){
      this.dataForm.color = val.hex
    }
  },
  data(){
    return {
      colorPicker:{},
      dataForm:{
        label:'',
        descricao:'',
        color:'',
      }
    }
  },
  mounted(){
    this.colorPicker = defaultProps
    if (this.entitySrc != null) {
      this.colorPicker.hex = this.entitySrc.color
    }
  },
  methods:{
    // this func by me me =) referes BY Pankaj Parashar https://codepen.io/pankajparashar/pen/oFzIg
    //unused yet
    hexToRGB(hexColor){
      var rgb = [],
      fail = false,
      original = hexColor,

      hex = (original+'').replace(/#/, '');

      if (hex.length == 3) hex = hex + hex;

      for (var i = 0; i < 6; i+=2) {
        rgb.push(parseInt(hex.substr(i,2),16));
        fail = fail || rgb[rgb.length - 1].toString() === 'NaN';
      }
      return fail ? '' : rgb;
    },
    // this function BY Pankaj Parashar https://codepen.io/pankajparashar/pen/oFzIg
    //unused yet
    rgbToHsl(r, g, b){

      r /= 255, g /= 255, b /= 255;
      var max = Math.max(r, g, b), min = Math.min(r, g, b);
      var h, s, l = (max + min) / 2;

      if (max == min) { h = s = 0; }
      else {
        var d = max - min;
        s = l > 0.5 ? d / (2 - max - min) : d / (max + min);

        switch (max){
          case r: h = (g - b) / d + (g < b ? 6 : 0); break;
          case g: h = (b - r) / d + 2; break;
          case b: h = (r - g) / d + 4; break;
        }

        h /= 6;
      }

      return [(h*100+0.5)|0, ((s*100+0.5)|0)/100, ((l*100+0.5)|0)/100];
    }
  }
}
</script>

<style lang="css">
</style>
