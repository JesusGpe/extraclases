<template>
    <div id="app">
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-default pull-right" type="button" @click="abrirModal('registrar')"><i class="fa fa-plus-square"></i>Nuevo</button>
            </div>
            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10" style="margin-bottom:20px;">
                <h1>Listado de Extraclases</h1>
                <div class="input-group" >
                    <span class="input-group-addon">Buscar</span>
                    <select class="form-control" v-model="criterio">
                        <option value="codigo">Codigo</option>
                        <option value="nombre">Nombre</option>
                    </select>
                    <span class="input-group-addon" style="width:0px; padding-left:0px; padding-right:0px; border:none;"></span>
                    <input type="text" class="form-control" v-model="buscar" v-on:keyup.enter="listarExtraclase(1,criterio,buscar)">
                    <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary" @clik="listarExtraclase(1,criterio,buscar)">Buscar</button>
                    </span>
                </div>  
            </div>
        </div>
        <!--Inicio de la tabla para mostrar los datos-->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-condensed table-hover table-striped">
                        <thead class="bg-primary">
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Opciones</th>                           
                        </thead>
                        <tr v-for="extraclase in arrayExtraclase" :key="extraclase.id">
                            <td v-text="extraclase.codigo"></td>
                            <td v-text="extraclase.nombre"></td>
                            <td v-text="extraclase.descripcion"></td>
                            <td>
                            <button class="btn-small btn-info" @click="abrirModal('editar',extraclase)"><i class="fa fa-pencil"></i></button>
                            <button class="btn-small btn-danger" @click="eliminarExtraclase(extraclase.id)"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    </table>
                </div>
                <nav class="text-center">
                    <ul class="pagination">
                        <li v-if="pagination.current_page > 1">
                            <a href="#" @click="cambiarPagina(pagination.current_page - 1)">
                                <span>Atras</span>
                            </a>
                        </li>
                        <li v-for="page in pagesNumber" v-bind:class="[ page== isActived ? 'active' : '']" :key="page">
                            <a href="#" v-text="page" @click="cambiarPagina(page)">
                            </a>
                        </li>
                        <li v-if="pagination.current_page < pagination.last_page">
                            <a href="#" @click="cambiarPagina(pagination.current_page + 1)">
                                <span>Siguiente</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!--fin de la tabla para mostrar los datos-->
        <!--inicio modal registrar/actualizar-->
        <div class="modal fade" id="modalregistrar" tabindex="-1" role="dialog" aria-labelledby="modalregistrar" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header modal-header-primary">
                <button type="button" class="close" aria-label="Close" @click="cerrarModal()">
                  <span aria-hidden="true">&times;</span>z
                </button> 
                <h1 class="modal-title" v-text="titulo"></h1>
              </div>
              <div class="modal-body">
                <form autocomplete="off">
                    <div class="form-group">
                        <label for="nombre" class="col-form-label">Codigo</label>
                        <input type="text" name="codigo" v-model="codigo" disabled class="form-control">
                    </div>
                        <div class="form-group">
                        <label for="nombre" class="col-form-label">Nombre</label>
                        <input type="text" name="nombre" v-model="nombre" v-validate.initial="'required|alpha_spaces'" class="form-control">
                        <div v-show="errors.has('nombre')" class="help is-danger" v-text="errors.first('nombre') "></div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-form-label">Descripcion</label>
                        <textarea v-model="descripcion" cols="15" rows="4" class="form-control"></textarea>                        
                    </div>
                </form>
                <h3 class="text-center" id="mensaje"></h3>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                <button v-if="opcion==1" v-bind:disabled="errors.any()" id="btnregistrar" class="btn btn-primary" @click="registrarExtraclase()">Registrar</button>
                <button v-if="opcion==2" id="btnactualizar" type="button" class="btn btn-primary" @click="actualizarExtraclase()" v-bind:disabled="errors.any()">Editar</button>

              </div>
            </div>
          </div>
        </div>
    <!--fin modal registrar/actualizar-->
    </div>
    
</template>

<script>
export default {
  data() {
    return {
      id: 0,
      codigo: "",
      nombre: "",
      descripcion: "",
      opcion: 1,
      titulo: "",
      modal: "",
      criterio: "codigo",
      buscar: "",
      arrayExtraclase: [],
      pagination: []
    };
  },
  computed: {
    isActived() {
      return this.pagination.current_page;
    },
    pagesNumber() {
      if (!this.pagination.to) {
        return [];
      }

      var from = this.pagination.current_page - 2; //TODO

      if (from < 1) {
        from = 1;
      }

      var to = from + 2 * 2; //TODO

      if (to >= this.pagination.last_page) {
        to = this.pagination.last_page;
      }

      var pagesArray = [];

      while (from <= to) {
        pagesArray.push(from);
        from++;
      }
      return pagesArray;
    }
  },
  methods: {
    listarExtraclase(page, criterio, buscar) {
      let me = this;
      var url="/extraclase?page=" +page +"&criterio=" +criterio +"&buscar=" +buscar;
      axios
        .get(url)
        .then(function(response) {
          var respuesta = response.data;
          me.arrayExtraclase = respuesta.extraclases.data;
          me.pagination = respuesta.pagination;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    registrarExtraclase() {
      let me = this;
      $("#mensaje").html("Registrando...");
      axios
        .post("/extraclase/registrar", {
          codigo: this.codigo,
          nombre: this.nombre,
          descripcion: this.descripcion
        })
        .then(function(response) {
          $("#mensaje").html("");
          me.listarExtraclase(1, me.criterio, me.buscar);
          me.cerrarModal();
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    actualizarExtraclase() {
      let me = this;
      axios
        .put("/extraclase/actualizar", {
          id: this.id,
          codigo: this.codigo,
          nombre: this.nombre,
          descripcion: this.descripcion
        })
        .then(function(response) {
          me.message = response.data.message;
          me.succes = 1;
          me.listarExtraclase(1, me.criterio, me.buscar);
          me.cerrarModal();
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    eliminarExtraclase(id) {
      swal({
        title: "Esta seguro de eliminar la extraclase?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, eliminalo!"
      }).then(result => {
        if (result.value) {
          let me = this;
          axios
            .put("/extraclase/eliminar", {
              id: id
            })
            .then(function(response) {
              swal("Eliminado!", "La extraclase se ha eliminado.", "success");
              me.listarExtraclase(1, me.criterio, me.buscar);
            })
            .catch(function(error) {
              console.log(error);
            });
        }
      });
    },
    abrirModal(accion, data) {
      switch (accion) {
        case "registrar":
          this.codigo=this.generarCodigo();
          this.titulo = "Registrar extraclase";
          $("#modalregistrar").modal("show");
          break;
        case "editar":
          this.titulo = "Editar extraclase";
          this.opcion = 2;
          this.id = data["id"];
          this.codigo = data["codigo"];
          this.nombre = data["nombre"];
          this.descripcion = data["descripcion"];
          $("#modalregistrar").modal("show");
          break;
      }
    },
    cerrarModal() {
      this.opcion = 1;
      this.codigo = "";
      this.nombre = "";
      this.descripcion = "";
      $("#modalregistrar").modal("hide");
    },
    cambiarPagina(page) {
      this.pagination.current_page = page;
      this.listarExtraclase(page, this.criterio, this.buscar);
    },
    generarCodigo(){
      var caracteres = "abcdefghijkmnpqrtuvwxyz12346789";
      var contraseña = "";
      for (var i=0; i<10; i++){
      contraseña += caracteres.charAt(Math.floor(Math.random()*caracteres.length));
      }
      return contraseña;
    }
   },
  mounted() {
    this.listarExtraclase(1, this.criterio, this.buscar);
    this.generarCodigo()
  }
};
</script>
<style>
.simple-root {
  margin-top: 20%;
  margin-left: auto;
  margin-right: auto;
}
.help.is-danger {
  color: red;
}
</style>
