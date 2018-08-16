<template>
    <div id="app">
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-default pull-right" type="button" @click="abrirModal('registrar')"><i class="fa fa-plus-square"></i>Nuevo</button>
            </div>
            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10" style="margin-bottom:20px;">
                <h1>Listado de grupos</h1>
                <div class="input-group" >
                    <span class="input-group-addon">Buscar</span>
                    <select class="form-control" v-model="criterio">
                        <option value="num_empleado">Nombre</option>
                        <option value="nombre">Descripcion</option>
                    </select>
                    <span class="input-group-addon" style="width:0px; padding-left:0px; padding-right:0px; border:none;"></span>
                    <input type="text" class="form-control" v-model="buscar" v-on:keyup.enter="listarGrupo(1,criterio,buscar)">
                    <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary" @clik="listarGrupo(1,criterio,buscar)">Buscar</button>
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
                            <th>Nombre</th>
                            <th>Carrera</th>
                            <th>Opciones</th>                            
                        </thead>
                        <tr v-for="grupo in arrayGrupo" :key="grupo.id">
                            <td v-text="grupo.grupo"></td>
                            <td v-text="grupo.carrera"></td>
                            <td>
                            <button class="btn-small btn-info" @click="abrirModal('editar',grupo)"><i class="fa fa-pencil"></i></button>
                            <button class="btn-small btn-danger" @click="eliminarGrupo(grupo.id)"><i class="fa fa-trash"></i></button>
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
                    <label for="matricula" class="col-form-label">Carrera</label>
                    <select class="form-control" v-model="idcarrera">
                      <option v-for="carrera in arrayCarrera" :key="carrera.id" :value="carrera.id" v-text="carrera.nombre"></option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="matricula" class="col-form-label">Nombre</label>
                    <input type="text" name="nombre" v-model="nombre" v-validate.initial="'required|alpha_num'" class="form-control">
                    <div v-show="errors.has('nombre')" class="help is-danger" v-text="errors.first('nombre') "></div>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <h3 class="text-center" id="mensaje"></h3>
                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                <button v-if="opcion==1" v-bind:disabled="errors.any()" id="btnregistrar" class="btn btn-primary" @click="registrarGrupo()">Registrar</button>
                <button v-if="opcion==2" id="btnactualizar" type="button" class="btn btn-primary" @click="actualizarGrupo()" v-bind:disabled="errors.any()">Editar</button>
              </div>
            </div>
          </div>
        </div>
    <!--fin modal registrar/actualizar-->
    </div>
    
</template>

<script>
    export default {
        data(){
            return{
            id:0,
            idcarrera:1,
            nombre:'',
            opcion:1,
            titulo:'',
            modal:'',
            criterio:'nombre',
            buscar:'',
            arrayGrupo:[],
            arrayCarrera:[],
            pagination:[]
            }
        },
        computed:{
            isActived(){
                return this.pagination.current_page;
            },
            pagesNumber(){

                if (!this.pagination.to) {

                    return [];
                }

                var from = this.pagination.current_page - 2;//TODO

                if (from < 1) {

                    from = 1;
                }

                var to = from + (2 * 2);//TODO

                if(to >= this.pagination.last_page) {

                    to = this.pagination.last_page;
                }

                var pagesArray = [];

                while(from <= to){
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
        },
        methods:{
            listarGrupo(page,criterio,buscar){
                let me = this;
                axios.get('/grupo?page='+page+'&criterio='+criterio+'&buscar='+buscar)
                  .then(function (response) {
                    var respuesta = response.data;
                    me.arrayGrupo = respuesta.grupos.data;
                    me.pagination = respuesta.pagination;
                  })
                  .catch(function (error) {
                    console.log(error);
                  });
            },
            registrarGrupo(){
                let me = this;
                $("#mensaje").html('Registrando...');
                axios.post('/grupo/registrar', {
                    'nombre': this.nombre,
                    'idcarrera': this.idcarrera
                  })
                  .then(function (response) {
                    $("#mensaje").html('');
                    me.listarGrupo(1,me.criterio,me.buscar);
                    me.cerrarModal();
                  })
                  .catch(function (error) {
                    console.log(error);
                  });
            },
            actualizarGrupo(){
                let me = this;
                $("#mensaje").html('Editando...');
                axios.put('/grupo/actualizar', {
                    'nombre': this.nombre,
                    'idcarrera': this.idcarrera,
                    'id': this.id
                  })
                  .then(function (response) {
                    me.listarGrupo(1,me.criterio,me.buscar);
                    me.cerrarModal();
                    $("#mensaje").html('');
                  })
                  .catch(function (error) {
                    console.log(error);
                  });
            },
            eliminarGrupo(id){
                swal({
                  title: 'Esta seguro de eliminar el grupo?',
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, eliminalo!'
                }).then((result) => {
                  if (result.value) {
                    let me = this;
                    axios.put('/grupo/eliminar', {
                        'id':id
                      })
                      .then(function (response) {
                        swal(
                          'Eliminado!',
                          'El grupo se ha eliminado.',
                          'success'
                        )
                        me.listarGrupo(1,me.criterio,me.buscar);
                      })
                      .catch(function (error) {
                        console.log(error);
                      });
                  }
                })
            },
            abrirModal(accion,data){
                switch(accion){
                    case 'registrar':
                        this.titulo = "Registrar grupo";
                        $('#modalregistrar').modal({backdrop: 'static', keyboard: false})
                    break;
                    case 'editar':
                         this.titulo = "Editar grupo";
                         this.opcion = 2;
                         this.id = data['id'];
                         this.nombre = data['grupo'];
                        $('#modalregistrar').modal({backdrop: 'static', keyboard: false});
                    break;
                }
                this.getCarrera();

            },
            cerrarModal(){
               this.opcion=1;
               this.id=0;
               this.idcarrera=1;
               this.nombre = '';
               $("#modalregistrar").modal('hide');

            },
            cambiarPagina(page){
                this.pagination.current_page = page;
                this.listarGrupo(page,this.criterio,this.buscar);
            } ,
            getCarrera(){
              let me = this;
              axios.get('/getCarrera')
                  .then(function (response) {
                    me.arrayCarrera = response.data.carreras;
                  })
                  .catch(function (error) {
                    console.log(error);
                  });
            }
        },
        mounted() {
            this.listarGrupo(1,this.criterio,this.buscar);
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
