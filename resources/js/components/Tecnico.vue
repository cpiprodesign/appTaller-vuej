<template>
    <main class="main">
        <!-- Breadcrumb -->
        <!-- <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
    </ol>-->
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class=" mt-4">
                <el-card class="box-card">
                    <div slot="header" class="clearfix">
                        <span>Listado de Tecnicos</span>
                    </div>
                    <div class="mb-2 d-flex flex-row-reverse">
                        <el-button size="small" plain type="primary" icon="el-icon-circle-plus"
                            @click="abrirModal('tecnico', 'registrar')">Nuevo</el-button>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <div class="mr-1 mb-2">
                                    <el-select size="small" v-model="criterio" placeholder="Select">
                                        <el-option v-for="item in valores" :key="item.value" :label="item.label"
                                            :value="item.value"></el-option>
                                    </el-select>
                                </div>
                                <div class="mr-1">
                                    <el-input size="small" @keyup.native.enter="
                                        listarTecnico(1, buscar, criterio)
                                        " placeholder="Texto a buscar" v-model="buscar"></el-input>
                                </div>

                                <div>
                                    <el-button size="small" icon="el-icon-search" type="primary" @click="
                                        listarTecnico(1, buscar, criterio)
                                        ">Buscar</el-button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <el-table :data="arrayTecnico" border stripe style="width: 100%" size="small">
                        <!-- Opciones -->
                        <el-table-column label="Opciones" width="160">
                            <template slot-scope="scope">
                                <el-button type="warning" size="mini" icon="el-icon-edit"
                                    @click="abrirModal('tecnico', 'actualizar', scope.row)"></el-button>

                                <template v-if="scope.row.condicion">
                                    <el-button type="danger" size="mini" icon="el-icon-delete"
                                        @click="desactivarTecnico(scope.row.id)"></el-button>
                                </template>
                                <template v-else>
                                    <el-button type="success" size="mini" icon="el-icon-check"
                                        @click="activarTecnico(scope.row.id)"></el-button>
                                </template>
                            </template>
                        </el-table-column>

                        <!-- Campos -->
                        <el-table-column prop="nombre" label="Nombre"></el-table-column>
                        <el-table-column prop="tipo_documento" label="Tipo Documento"></el-table-column>
                        <el-table-column prop="num_documento" label="Número"></el-table-column>
                        <el-table-column prop="direccion" label="Dirección"></el-table-column>
                        <el-table-column prop="telefono" label="Teléfono"></el-table-column>
                        <el-table-column prop="email" label="Email"></el-table-column>

                        <!-- Estado -->
                        <el-table-column label="Estado" width="120">
                            <template slot-scope="scope">
                                <el-tag type="success" v-if="scope.row.condicion">Activo</el-tag>
                                <el-tag type="danger" v-else>Desactivado</el-tag>
                            </template>
                        </el-table-column>
                    </el-table>
                    <nav class="mt-2">
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="
                                    cambiarPagina(
                                        pagination.current_page - 1,
                                        buscar,
                                        criterio
                                    )
                                    ">Ant</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page"
                                :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="
                                    cambiarPagina(page, buscar, criterio)
                                    " v-text="page"></a>
                            </li>

                            <li class="page-item" v-if="pagination.current_page <
                                pagination.last_page
                            ">
                                <a class="page-link" href="#" @click.prevent="
                                    cambiarPagina(
                                        pagination.current_page + 1,
                                        buscar,
                                        criterio
                                    )
                                    ">Sig</a>
                            </li>
                        </ul>
                    </nav>
                </el-card>


            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
        <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade " tabindex="-1" :class="{ mostrar: modal }" role="dialog" aria-labelledby="myModalLabel"
            style="display: none" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-scrollable  " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" v-text="tituloModal"></h6>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                <div class="col-md-9">
                                    <el-input size="small" placeholder="Nombre del tecnico" v-model="nombre"></el-input>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Tipo documento</label>
                                <div class="col-md-9">
                                    <el-select v-model="tipo_documento" size="small" placeholder="Select">
                                        <el-option v-for="item in options" :key="item.value" :label="item.label"
                                            :value="item.value"></el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Numero</label>
                                <div class="col-md-9">
                                    <el-input placeholder="Numero de documento" size="small"
                                        v-model="num_documento"></el-input>
                                    <!-- <input class="form-control" type="text" v-model="num_documento" placeholder="Numero de documento" > -->
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Direccion</label>
                                <div class="col-md-9">
                                    <el-input placeholder="Dirección" size="small" v-model="direccion"></el-input>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Telefono</label>
                                <div class="col-md-9">
                                    <el-input placeholder="Telefono" size="small" v-model="telefono"></el-input>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Email</label>
                                <div class="col-md-9">
                                    <el-input placeholder="Email@gmail.com" size="small" v-model="email"></el-input>
                                </div>
                            </div>

                            <div v-show="errorTecnico" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjTecnico" :key="error" v-text="error"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" @click="cerrarModal()">
                            Cerrar
                        </button>
                        <button type="button" v-if="tipoAccion == 1" class="btn btn-primary"
                            @click="registrarTecnico()">
                            Guardar
                        </button>
                        <button type="button" v-if="tipoAccion == 2" class="btn btn-primary"
                            @click="actualizarTecnico()">
                            Actualizar
                        </button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </main>
</template>

<script>
export default {
    data() {
        return {
            input: "",
            //para select
            options: [
                {
                    value: "DNI",
                    label: "DNI",
                },
                {
                    value: "RUC",
                    label: "RUC",
                },
                {
                    value: "PASS",
                    label: "PASS",
                },
            ],
            valores: [
                {
                    value: "nombre",
                    label: "Nombre",
                },
                {
                    value: "num_documento",
                    label: "Documento",
                },
                {
                    value: "Email",
                    label: "Email",
                },
                {
                    value: "telefono",
                    label: "Telefono",
                },
            ],
            tecnico_id: 0,
            nombre: "",
            tipo_documento: "DNI",
            num_documento: "",
            direccion: "",
            telefono: "",
            email: "",
            arrayTecnico: [],
            modal: 0,
            tituloModal: "",
            tipoAccion: 0,
            errorTecnico: 0,
            errorMostrarMsjTecnico: [],
            pagination: {
                total: 0,
                current_page: 0,
                per_page: 0,
                last_page: 0,
                from: 0,
                to: 0,
            },
            offset: 3,
            criterio: "nombre",
            buscar: "",
        };
    },
    computed: {
        isActived: function () {
            return this.pagination.current_page;
        },
        pagesNumber: function () {
            if (!this.pagination.to) {
                return [];
            }
            var from = this.pagination.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + this.offset * 2;
            if (to >= this.pagination.last_page) {
                to = this.pagination.last_page;
            }
            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        },
    },
    methods: {
        guardar() {
            this.$message({
                message: "Tecnico Guardado con éxito.",
                type: "success",
            });
        },
        editar() {
            this.$message({
                message: "Tecnico Actualizado con éxito.",
                type: "success",
            });
        },
        //carga pdf clientes
        cargarPdf() {
            window.open("/tecnico/listarPdf", "_blank");
        },
        listarTecnico(page, buscar, criterio) {
            let me = this;
            var url =
                "/tecnico?page=" +
                page +
                "&buscar=" +
                buscar +
                "&criterio=" +
                criterio;
            axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayTecnico = respuesta.tecnicos.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        cambiarPagina(page, buscar, criterio) {
            let me = this;
            me.pagination.current_page = page;
            me.listarTecnico(page, buscar, criterio);
        },
        registrarTecnico() {
            //validando campos tecnico
            if (this.validarTecnico()) {
                return;
            }

            let me = this;

            axios
                .post("/tecnico/registrar", {
                    nombre: this.nombre,
                    tipo_documento: this.tipo_documento,
                    num_documento: this.num_documento,
                    direccion: this.direccion,
                    telefono: this.telefono,
                    email: this.email,
                })
                .then(function (response) {
                    me.cerrarModal();
                    me.listarTecnico(1, "", "nombre");
                    me.guardar();
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        actualizarTecnico() {
            //validando campos categoria
            if (this.validarTecnico()) {
                return;
            }

            let me = this;
            axios
                .put("/tecnico/actualizar", {
                    nombre: this.nombre,
                    tipo_documento: this.tipo_documento,
                    num_documento: this.num_documento,
                    direccion: this.direccion,
                    telefono: this.telefono,
                    email: this.email,
                    id: this.tecnico_id,
                })
                .then(function (response) {
                    me.cerrarModal();
                    me.listarTecnico(1, "", "nombre");
                    me.editar();
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        desactivarTecnico(id) {
            Swal.fire({
                title: "Estas seguro de desactivar este tecnico..?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar",
            }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios
                        .put("/tecnico/desactivar", {
                            id: id,
                        })
                        .then(function (response) {
                            me.listarTecnico(1, "", "nombre");
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            });
        },
        activarTecnico(id) {
            Swal.fire({
                title: "Estas seguro de activar este tecnico.?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar",
            }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios
                        .put("/tecnico/activar", {
                            id: id,
                        })
                        .then(function (response) {
                            Swal.fire(
                                "Activado!",
                                "El registro ha sido desactivado con éxito.",
                                "success"
                            );
                            me.listarTecnico(1, "", "nombre");
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            });
        },

        validarTecnico() {
            this.errorTecnico = 0;
            this.errorMostrarMsjTecnico = [];

            if (!this.nombre)
                this.errorMostrarMsjTecnico.push(
                    "El nombre del tecnico no puede estar vacío."
                );

            if (this.errorMostrarMsjTecnico.length) this.errorTecnico = 1;

            return this.errorTecnico;
        },
        cerrarModal() {
            this.modal = 0;
            this.tituloModal = "";
            this.nombre = "";
            this.tipo_documento = "";
            this.num_documento = "";
            this.direccion = "";
            this.telefono = "";
            this.email = "";
            this.errorTecnico = 0;
        },
        abrirModal(modelo, accion, data = []) {
            switch (modelo) {
                case "tecnico": {
                    switch (accion) {
                        case "registrar": {
                            this.modal = 1;
                            this.tituloModal = "Registrar tecnico";
                            this.nombre = "";
                            this.tipo_documento = "DNI";
                            this.num_documento = "";
                            this.direccion = "";
                            this.telefono = "";
                            this.email = "";
                            this.tipoAccion = 1;
                            break;
                        }
                        case "actualizar": {
                            this.modal = 1;
                            this.tituloModal = "Actualizar tecnico";
                            this.tipoAccion = 2;
                            this.tecnico_id = data["id"];
                            this.nombre = data["nombre"];
                            this.tipo_documento = data["tipo_documento"];
                            this.num_documento = data["num_documento"];
                            this.direccion = data["direccion"];
                            this.telefono = data["telefono"];
                            this.email = data["email"];

                            break;
                        }
                    }
                }
            }
        },
    },
    mounted() {
        this.listarTecnico(1, this.buscar, this.criterio);
    },
};
</script>
<style>
.modal-content {
    width: 100% !important;

    border-radius: 10px;
    margin-top: 20px;
    position: absolute !important;
}

.mostrar {
    display: list-item !important;
    opacity: 1 !important;
    position: absolute !important;
    background-color: #3c29297a !important;

}

.div-error {
    display: flex;
    justify-content: center;
}

.text-error {
    color: red !important;
    font-weight: bold;
}
</style>
