<template>
  <div>
    <div class="row">
      <div class="col-md-10 ">
        <div class="panel panel-primary" style="height: 200px">
          <div class="panel-heading">
            <h3 class="panel-title">Realizar publicacion</h3>
          </div>
          <div class="panel-body">
            <form method="POST" enctype="multipart/form-data">
              <div class="form-group">
              <textarea class="form-control" placeholder="Escribe algo"
              v-model="publicacion"></textarea>
                <input type="file" class="form-control" @change="getImage" accept="image/*">
              </div>
              <div class="pull-right">
                <div class="form-group">
                  <button class="btn btn-primary" type="button" @click="registrarPublicacion()">Publicar</button>
                </div>
              </div>
            </form>
            <h3 id="publicacion"></h3>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
    export default {
      data(){
            return{
              publicacion:'',
              imagen:null,
              notification:0
            }
        },
        props:['idextraclase'],
        methods:{
           registrarPublicacion(){
            let me = this;
            var data = new  FormData();
              data.append('imagen', this.imagen);
              data.append('publicacion', this.publicacion);
              data.append('idextraclase', this.idextraclase);
            $("#publicacion").html('Publicando...');
            axios
            .post("/publicacion/registrar",data)
            .then(function(response) {
              me.$bus.$emit('publicacion');
              me.publicacion='';
              $("#publicacion").html('');
            })
          .catch(function(error) {
            console.log(error);
          });
        },
        getImage(event){
          this.imagen=event.target.files[0];
        }    
        },
        mounted() {
          Push.create("Hello world!", {
              body: "How's it hangin'?",
              onClick: function () {
              window.focus();
              this.close();
              }
          });

        }
    };
</script>
<style>
.bubble {
  position: relative;
  width: 100%;
  min-height: 65px;
  padding: 15px;
  background: #fff;
  border-radius: 10px;
  border: 1px solid #ccc;
  margin-bottom: 20px;
}



.comment-form .form-group {
  width: 100%;
}

.comment-form input {
  width: 100%;
}

.comment-avatar img{
  width: 40px;
  margin-right: 5px;
}
</style>