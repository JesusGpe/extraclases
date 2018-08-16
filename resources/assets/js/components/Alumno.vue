<template>
    <div id="app">
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-default pull-right" type="button" @click="abrirModal('registrar')"><i class="fa fa-plus-square"></i>Nuevo</button>
                <button type="file" class="btn btn-default pull-right" style="margin-right:10px;" @click="abrirModal('subir')"><i class="fa fa-download"></i>Importar</button>
            </div>
            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10" style="margin-bottom:20px;">
                <h1>Listado de Alumnos</h1>
                <div class="input-group" >
                    <select class="form-control" v-model="criterio">
                        <option value="matricula">Matriucula</option>
                        <option value="nombre">Nombre</option>
                    </select>
                    <span class="input-group-addon" style="width:0px; padding-left:0px; padding-right:0px; border:none;"></span>
                    <input type="text" class="form-control" v-model="buscar" v-on:keyup.enter="listarAlumno(1,criterio,buscar)">
                    <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary">Buscar</button>
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
                            <th>Matricula</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Direccion</th>
                            <th>Carrera</th>
                            <th>Grupo</th>
                            <th>Opciones</th>                            
                        </thead>
                        <tr v-for="alumno in arrayAlumno" :key="alumno.id">
                            <td v-text="alumno.matricula"></td>
                            <td v-text="alumno.nombre"></td>
                            <td v-text="alumno.email"></td>
                            <td v-text="alumno.direccion"></td>
                            <td v-text="alumno.carrera"></td>
                            <td v-text="alumno.grupo"></td>
                            <td>
                            <button class="btn-small btn-info" @click="abrirModal('editar',alumno)"><i class="fa fa-pencil"></i></button>
                            <button class="btn-small btn-danger" @click="eliminarAlumno(alumno.id)"><i class="fa fa-trash"></i></button>
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
                  <span aria-hidden="true">&times;</span>
                </button> 
                <h1 class="modal-title" v-text="titulo"></h1>
              </div>
              <div class="modal-body">
                <form autocomplete="off">
                  <div class="form-group">
                    <label for="matricula" class="col-form-label">Matricula</label>
                    <input type="text" name="matricula" v-model="matricula" v-validate.initial="'required|numeric'" class="form-control">
                    <div v-show="errors.has('matricula')" class="help is-danger" v-text="errors.first('matricula') "></div>
                  </div>
                  <div class="form-group">
                    <label for="nombre" class="col-form-label">Nombre</label>
                    <input type="text" name="nombre" v-model="nombre" v-validate.initial="'required|alpha_spaces'" class="form-control">
                    <div v-show="errors.has('nombre')" class="help is-danger" v-text="errors.first('nombre') "></div>
                  </div>
                  <div class="form-group">
                    <label for="email" class="col-form-label">Email</label>
                    <input type="text" name="email" v-model="email" class="form-control" v-validate.initial="'email'" >
                    <div v-show="errors.has('email')" class="help is-danger" v-text="errors.first('email') "></div>
                  </div>
                  <div class="form-group">
                    <label for="direccion" class="col-form-label">Dirección</label>
                    <input type="text" name="direccion" v-model="direccion" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="carrera" class="col-form-label">Carrera</label>
                    <input type="text" name="carrera" v-model="carrera" class="form-control" v-validate.initial="'required|alpha_spaces'">
                    <div v-show="errors.has('carrera')" class="help is-danger" v-text="errors.first('carrera') "></div>
                  </div>
                  <div class="form-group">
                    <label for="grupo" class="col-form-label">Grupo</label>
                    <input type="text" name="grupo" v-model="grupo" class="form-control" v-validate.initial="'required|alpha_num'">
                    <div v-show="errors.has('grupo')" class="help is-danger" v-text="errors.first('grupo') "></div>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <h3 class="text-center" id="mensaje"></h3>
                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                <button v-if="opcion==1" v-bind:disabled="errors.any()" id="btnregistrar" class="btn btn-primary" @click="registrarAlumno()">Registrar</button>
                <button v-if="opcion==2" v-bind:disabled="errors.any()" id="btnactualizar" type="button" class="btn btn-primary" @click="actualizarAlumno()" >Editar</button>
              </div>
            </div>
          </div>
        </div>
    <!--fin modal registrar/actualizar-->

    <!--Inicio modal importar excel-->
    <div class="modal fade" id="modalexcel" tabindex="-1" role="dialog" aria-labelledby="modalregistrar" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header modal-header-primary">
                <button type="button" class="close" aria-label="Close" @click="cerrarModal('subir')">
                  <span aria-hidden="true">&times;</span>
                </button> 
                <h1 class="modal-title" v-text="titulo"></h1>
              </div>
              <div class="modal-body">
                <form autocomplete="off">
                  <div class="form-group">
                    <label for="nombre" class="col-form-label">Seleccione un archivo</label>
                    <input type="file" name="archivo" class="form-control" @change="getFile">
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="cerrarModal('subir')">Cerrar</button>
                <button  type="button" class="btn btn-primary" @click="importarAlumno()">Importar</button>
              </div>
            </div>
          </div>
        </div>
        <!--Fin de modal importar excel-->
    </div>
    
</template>

<script>
export default {
  data() {
    return {
      id: 0,
      matricula: "",
      nombre: "",
      email: "",
      direccion: "",
      carrera: "",
      grupo: "",
      opcion: 1,
      archivo: null,
      titulo: "",
      modal: "",
      criterio: "matricula",
      buscar: "",
      offset:2,
      arrayAlumno: [],
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

      var from = this.pagination.current_page - this.offset;

      if (from < 1) {
        from = 1;
      }

      var to = from + 2 * this.offset;

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
    listarAlumno(page, criterio, buscar) {
      let me = this;
      axios
        .get(
          "/alumno?page=" + page + "&criterio=" + criterio + "&buscar=" + buscar
        )
        .then(function(response) {
          var respuesta = response.data;
          me.arrayAlumno = respuesta.alumnos.data;
          me.pagination = respuesta.pagination;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    registrarAlumno() {
      let me = this;
      $("#mensaje").html("Registrando...");
      axios
        .post("/alumno/registrar", {
          matricula: this.matricula,
          nombre: this.nombre,
          email: this.email,
          direccion: this.direccion,
          carrera: this.carrera,
          grupo: this.grupo
        })
        .then(function(response) {
          me.listarAlumno(1, me.criterio, me.buscar);
          me.cerrarModal();
          $("#mensaje").html("");

        })
        .catch(function(error) {
          console.log(error);
        });
    },
    actualizarAlumno() {
      let me = this;+
      $("#mensaje").html("Editando...");
      axios
        .put("/alumno/actualizar", {
          id: this.id,
          matricula: this.matricula,
          nombre: this.nombre,
          email: this.email,
          direccion: this.direccion,
          carrera: this.carrera,
          grupo: this.grupo
        })
        .then(function(response) {
          me.listarAlumno(1, me.criterio, me.buscar);
          $("#mensaje").html("");
          me.cerrarModal();
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    eliminarAlumno(id) {
      swal({
        title: "Esta seguro de eliminar al alumno?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, eliminalo!"
      }).then(result => {
        if (result.value) {
          let me = this;
          axios
            .put("/alumno/eliminar", {
              id: id
            })
            .then(function(response) {
              swal("Eliminado!", "El alumno se ha eliminado.", "success");
              me.listarAlumno(1, me.criterio, me.buscar);
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
          this.titulo = "Registrar alumno";
          $('#modalregistrar').modal({backdrop: 'static', keyboard: false});
          break;
        case "editar":
          this.titulo = "Editar alumno";
          this.opcion = 2;
          this.id = data["id"];
          this.matricula = data["matricula"];
          this.nombre = data["nombre"];
          this.email = data["email"];
          this.direccion = data["direccion"];
          this.grupo = data["grupo"];
          this.carrera = data["carrera"];
          $('#modalregistrar').modal({backdrop: 'static', keyboard: false})
          break;
        case "subir":
          this.titulo = "Importar excel";
          $("#modalexcel").modal("show");
          break;
      }
    },
    cerrarModal(accion) {
      if (accion == "subir") {
        $("#modalexcel").modal("hide");
      } else {
        this.opcion = 1;
        this.matricula = "";
        this.nombre = "";
        this.email = "";
        this.direccion = "";
        this.carrera = "";
        this.grupo = "";
        $("#modalregistrar").modal("hide");
      }
    },
    cambiarPagina(page) {
      this.pagination.current_page = page;
      this.listarAlumno(page, this.criterio, this.buscar);
    },
    getFile(event) {
      this.archivo = event.target.files[0];
    },
    importarAlumno() {
      let me = this;
      var data = new FormData();
      data.append("archivo", this.archivo);
      axios
        .post("/alumno/importar", data)
        .then(function(response) {
          swal(
            "Archivo procesado!",
            "El archivo se ha procesado correctamente",
            "success"
          );
          me.listarAlumno(1, me.criterio, me.buscar);
          me.cerrarModal("subir");
        })
        .catch(function(error) {
          console.log(error);
        });
    }
  },
  mounted() {
    this.listarAlumno(1, this.criterio, this.buscar);
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