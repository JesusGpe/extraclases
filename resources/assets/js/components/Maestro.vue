<template>
    <div id="app">
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-default pull-right" type="button" @click="abrirModal('registrar')"><i class="fa fa-plus-square"></i>Nuevo</button>
            </div>
            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10" style="margin-bottom:20px;">
                <h1>Listado de Maestros</h1>
                <div class="input-group" >
                    <span class="input-group-addon">Buscar</span>
                    <select class="form-control" v-model="criterio">
                        <option value="num_empleado">N. de empleado</option>
                        <option value="nombre">Nombre</option>
                    </select>
                    <span class="input-group-addon" style="width:0px; padding-left:0px; padding-right:0px; border:none;"></span>
                    <input type="text" class="form-control" v-model="buscar" v-on:keyup.enter="listarMaestro(1,criterio,buscar)">
                    <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary" @clik="listarMaestro(1,criterio,buscar)">Buscar</button>
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
                            <th>N. Empledo</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Direccion</th>
                            <th>Tipo</th>
                            <th>Opciones</th>                            
                        </thead>
                        <tr v-for="maestro in arrayMaestro" :key="maestro.id">
                            <td v-text="maestro.num_empleado"></td>
                            <td v-text="maestro.nombre"></td>
                            <td v-text="maestro.email"></td>
                            <td v-text="maestro.direccion"></td>
                            <td v-text="maestro.tipo"></td>
                            <td>
                            <button class="btn-small btn-info" @click="abrirModal('editar',maestro)"><i class="fa fa-pencil"></i></button>
                            <button class="btn-small btn-danger" @click="eliminarMaestro(maestro.id)"><i class="fa fa-trash"></i></button>
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
                    <label for="matricula" class="col-form-label">N. Empleado</label>
                    <input type="text" name="N Empleado" v-model="num_empleado" v-validate.initial="'required|numeric'" class="form-control">
                    <div v-show="errors.has('N Empleado')" class="help is-danger" v-text="errors.first('N Empleado') "></div>
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
                    <label for="grupo" class="col-form-label">Tipo</label>
                    <select v-model="tipo" class="form-control">
                    	<option disabled value="">Seleccione un tipo</option>
                    	<option value="PTC">PTC</option>
                    	<option value="PTA">PTA</option>
                    	<option value="PTN">PTN</option>
                    </select>
                  </div>
                </form>
              </div>
              <div class="modal-footer">
                <h3 class="text-center" id="mensaje"></h3>
                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                <button v-if="opcion==1" v-bind:disabled="errors.any()" id="btnregistrar" class="btn btn-primary" @click="registrarMaestro()">Registrar</button>
                <button v-if="opcion==2" id="btnactualizar" type="button" class="btn btn-primary" @click="actualizarMaestro()" v-bind:disabled="errors.any()">Editar</button>

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
            num_empleado:'',
            nombre:'',
            email:'',
            direccion:'',
            tipo:'',
            opcion:1,
            titulo:'',
            modal:'',
            criterio:'num_empleado',
            buscar:'',
            arrayMaestro:[],
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
            listarMaestro(page,criterio,buscar){
                let me = this;
                var url='/alumno';
                axios.get('/maestro?page='+page+'&criterio='+criterio+'&buscar='+buscar)
                  .then(function (response) {
                    var respuesta = response.data;
                    me.arrayMaestro = respuesta.maestros.data;
                    me.pagination = respuesta.pagination;
                  })
                  .catch(function (error) {
                    console.log(error);
                  });
            },
            registrarMaestro(){
                let me = this;
                $("#mensaje").html('Registrando...');
                axios.post('/maestro/registrar', {
                    'num_empleado': this.num_empleado,
                    'nombre': this.nombre,
                    'email': this.email,
                    'direccion': this.direccion,
                    'tipo': this.tipo
                  })
                  .then(function (response) {
                    $("#mensaje").html('');
                    me.listarMaestro(1,me.criterio,me.buscar);
                    me.cerrarModal();
                  })
                  .catch(function (error) {
                    console.log(error);
                  });
            },
            actualizarMaestro(){
                let me = this;
                axios.put('/maestro/actualizar', {
                    'id': this.id,
                    'num_empleado': this.num_empleado,
                    'nombre': this.nombre,
                    'email': this.email,
                    'direccion': this.direccion,
                    'tipo': this.tipo
                  })
                  .then(function (response) {
                    me.listarMaestro(1,me.criterio,me.buscar);
                    me.cerrarModal();
                  })
                  .catch(function (error) {
                    console.log(error);
                  });
            },
            eliminarMaestro(id){
                swal({
                  title: 'Esta seguro de eliminar al maestro?',
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, eliminalo!'
                }).then((result) => {
                  if (result.value) {
                    let me = this;
                    axios.put('/maestro/eliminar', {
                        'id':id
                      })
                      .then(function (response) {
                        swal(
                          'Eliminado!',
                          'El maestro se ha eliminado.',
                          'success'
                        )
                        me.listarMaestro(1,me.criterio,me.buscar);
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
                        this.titulo = "Registrar maestro";
                        $('#modalregistrar').modal({backdrop: 'static', keyboard: false})
                    break;
                    case 'editar':
                         this.titulo = "Editar maestro";
                         this.opcion = 2;
                         this.id = data['id'];
                         this.num_empleado = data['num_empleado'];
                         this.nombre = data['nombre'];
                         this.email = data['email'];
                         this.direccion = data['direccion'];
                         this.tipo = data['tipo'];
                        $('#modalregistrar').modal({backdrop: 'static', keyboard: false})
                    break;
                }
            },
            cerrarModal(){
               this.opcion=1;
               this.num_empleado = '';
               this.nombre = '';
               this.email = '';
               this.direccion = '';
               this.tipo = '';
               $("#modalregistrar").modal('hide');

            },
            cambiarPagina(page){
                this.pagination.current_page = page;
                this.listarMaestro(page,this.criterio,this.buscar);
            } 
        },
        mounted() {
            this.listarMaestro(1,this.criterio,this.buscar);
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
