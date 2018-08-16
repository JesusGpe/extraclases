<template>
  <div>
    <div class="row">
      <div class="col-md-10">
        <div class="input-group">
          <input type="text" class="form-control" v-model="comentario" >
          <span class="input-group-btn">
            <button class="btn btn-primary" type="button" @click="relizarComentario()">Comentar</button>
          </span>
        </div>
        <h3 id="mensaje"></h3>
      </div>
      <div class="col-md-12">
        <div class="page-header">
          <h1><small class="pull-right">{{arrayComentarios.length}} comentarios</small> Comentarios </h1>
        </div> 
        <div class="comments-list" v-for="comentario in arrayComentarios">
          <div class="dropdown pull-right" style="margin-left:5px;">
                    <span class="dropdown-toggle" type="button" data-toggle="dropdown">
                        <span class="fa fa-angle-down"></span>
                    </span>
                    <ul class="dropdown-menu" role="menu">
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
                        <li role="presentation" class="divider"></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
                    </ul>
                </div>
          <div class="media" >

            <p class="pull-right"><small v-text="comentario.created_at"></small></p>
            <a class="media-left" href="#">
             <img src="">
            </a>
            <div class="media-body">
              <h4 class="media-heading user_name" v-text="comentario.nombre"></h4>
                          {{comentario.comentario}}
              <p><small><a href="">Like</a> - <a href="">Share</a></small></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import Publicacion from './Publicacion.vue'
    export default {
      created: function () {
        let me= this;
          this.$bus.$on('publicacion', function () {
          me.arrayComentarios=[];
         });
        },
      data(){
            return{
              comentario:'',
              arrayComentarios:[]
            }
        },
        props:['idpublicacion'],
        methods:{
          relizarComentario(){
            let me = this;
            $("#mensaje").html('Comentando...');
            axios
            .post("/publicacion/comentar",{
              'comentario':this.comentario,
              'idpublicacion':this.idpublicacion
            })
            .then(function(response) {
              me.comentario='';
              me.listarComentarios();
              $("#mensaje").html('');
            })
            .catch(function(error) {
              console.log(error);
            });
          },
          listarComentarios(){
            let me = this;
            axios.get("/comentarios"+"?idpublicacion="+this.idpublicacion
              )
            .then(function(response) {
              me.arrayComentarios=response.data.comentarios;
            })
            .catch(function(error) {
              console.log(error);
            });
          }   
        },
        mounted() {
          this.listarComentarios();
        }
    };
</script>
<style>
.user_name{
    font-size:14px;
    font-weight: bold;
}
.comments-list .media{
    border-bottom: 1px dotted #ccc;
}
</style>