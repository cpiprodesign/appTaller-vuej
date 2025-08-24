<template>
    <main class="main mt-4">
        <!-- Breadcrumb -->
        <!-- <ol class="breadcrumb"> -->
        <!-- <li class="breadcrumb-item"><a href="/">Escritorio</a></li> -->
        <!-- </ol> -->
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="">
                <el-card class="box-card">
                    <div slot="header" class="clearfix">
                        <span>Listado de Proveedores </span>
                    </div>
                    <div class="mb-2 d-flex flex-row-reverse">
                        <div class="">
                            <el-button size="" plain type="primary" icon="el-icon-circle-plus"
                                @click="abrirModal('proveedor', 'registrar')">Nuevo</el-button>
                            <!-- <el-button type="success" @click="importarDialogVisible = true">Importar</el-button> -->
                            <!-- <el-button size="" type="success" @click="importarDialogVisible = true">Subir<i -->
                            <!-- class="el-icon-upload el-icon-right"></i></el-button> -->
                        </div>
                    </div>
                    <div class="">
                        <div class="form-group row">
                            <div class="col-md-12 col-12">
                                <div class="input-group">
                                    <div class="mr-1 m-1">
                                        <template>
                                            <el-select v-model="criterio" placeholder="Select">
                                                <el-option v-for="item in options" :key="item.value" :label="item.label"
                                                    :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </template>
                                    </div>
                                    <div class="mr-1 m-1">
                                        <el-input @keyup.native.enter="listarProveedor(1, buscar, criterio)"
                                            placeholder="Texto a buscar" v-model="buscar"></el-input>
                                    </div>
                                    <div class="m-1">
                                        <el-button icon="el-icon-search" type="primary"
                                            @click="listarProveedor(1, buscar, criterio)">Buscar</el-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-2">

                            <el-table :data="arrayProveedor" style="width: 100%" size="small" highlight-current-row
                                border>
                                <!-- Columna de opciones -->
                                <el-table-column label="Opciones" width="160">
                                    <template slot-scope="{ row }">
                                        <el-button type="warning" size="mini" icon="el-icon-edit"
                                            @click="abrirModal('proveedor', 'actualizar', row)"></el-button>
                                        <el-button v-if="row.condicion" type="danger" size="mini" icon="el-icon-delete"
                                            @click="desactivarProveedor(row.id)"></el-button>
                                        <el-button v-else type="info" size="mini" icon="el-icon-check"
                                            @click="activarProveedor(row.id)"></el-button>
                                    </template>
                                </el-table-column>

                                <!-- Columna nombre -->
                                <!-- <el-table-column label="id" prop="id"></el-table-column> -->
                                <el-table-column label="Nombre" prop="nombre"></el-table-column>

                                <!-- Columna descripción -->
                                <el-table-column label="tipo_documento" prop="tipo_documento"></el-table-column>
                                <el-table-column label="num_documento" prop="num_documento"></el-table-column>
                                <el-table-column label="direccion" prop="direccion"></el-table-column>
                                <el-table-column label="telefono" prop="telefono"></el-table-column>
                                <el-table-column label="email" prop="email"></el-table-column>

                                <!-- Columna estado -->
                                <el-table-column label="Estado" width="120">
                                    <template slot-scope="{ row }">
                                        <el-tag type="success" v-if="row.condicion">Activo</el-tag>
                                        <el-tag type="danger" v-else>Desactivado</el-tag>
                                    </template>
                                </el-table-column>
                            </el-table>











































                        </div>
                        <nav>
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
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, criterio)"
                                        v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
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
                    </div>
                </el-card>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
        <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" tabindex="-1" :class="{ mostrar: modal }" role="dialog" aria-labelledby="myModalLabel"
            style="display: none" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombre" class="form-control"
                                        placeholder="Nombre de proveedor" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Tipo de documento</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="tipo_documento" class="form-control"
                                        placeholder="Ingrese el tipo de dni " />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Numero documento</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="num_documento" class="form-control"
                                        placeholder="Ingrese numero de documento" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">direccion</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="direccion" class="form-control"
                                        placeholder="Ingrese la direcion" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">telefono</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="telefono" class="form-control"
                                        placeholder="Ingrese el telefono" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Correo</label>
                                <div class="col-md-9">
                                    <input type="email" v-model="email" class="form-control"
                                        placeholder="Ingrese el correo" />
                                </div>
                            </div>
                            <div v-show="errorProveedor" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjProveedor" :key="error" v-text="error"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <!-- <button
                            type="button"
                            class="btn btn-secondary"
                            @click="cerrarModal()"
                        >
                            Cerrar
                        </button> -->
                        <el-button type="info" @click="cerrarModal()">Cerrar</el-button>
                        <!-- <button
                            type="button"
                            v-if="tipoAccion == 1"
                            class="btn btn-primary"
                            @click="registrarCategoria()"
                        >
                            Guardar
                        </button> -->
                        <el-button type="primary" v-if="tipoAccion == 1"
                            @click="registrarCategoria()">Guardar</el-button>
                        <!-- <button
                            type="button"
                            v-if="tipoAccion == 2"
                            class="btn btn-primary"
                            @click="actualizarProveedor()"
                        >
                            Actualizar
                        </button> -->
                        <el-button type="primary" v-if="tipoAccion == 2"
                            @click="actualizarProveedor()">Actualizar</el-button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <el-dialog title="Importar categorias" :visible.sync="importarDialogVisible" width="30%" center>
            <div class="input-group mb-3">
                <input type="file" class="form-control" @change="handleFileUpload" />
            </div>

            <!-- <div class="mb-2">
                <input type="file" class="btn btn-primary" @change="handleFileUpload" />
            </div> -->
            <el-button size="small" type="success" @click="submitFile()">Cargar al servidor</el-button>

            <!-- // -->

            <span slot="footer" class="dialog-footer">
                <!-- <el-button @click="importarDialogVisible = false">Cancel</el-button> -->
                <el-button type="primary" @click="importarDialogVisible = false">Cerrar</el-button>
            </span>
        </el-dialog>
    </main>
</template>

<script>
export default {
    data() {
        return {
            importarDialogVisible: false,
            file: null,
            input: "",
            //para select
            options: [
                {
                    value: "Nombre",
                    label: "Nombre",
                },
                {
                    value: "tipo_documento",
                    label: "tipo_documento",
                },
            ],
            value: "",
            //fin select
            proveedor_id: 0,
            nombre: "",
            descripcion: "",
            tipo_documento: "",
            num_documento: "",
            direccion: "",
            telefono: "",
            email: "",
            arrayProveedor: [],
            modal: 0,
            tituloModal: "",
            tipoAccion: 0,
            errorProveedor: 0,
            errorMostrarMsjProveedor: [],
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
        handleFileUpload(event) {
            this.file = event.target.files[0];
            //this.$refs.upload.submit();
        },
        submitFile() {
            let formData = new FormData();
            formData.append("excel", this.file);

            axios
                .post("/proveedor/importar", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then((response) => {
                    this.importarDialogVisible = false;

                    this.$message({
                        message: response.data.message,
                        type: "success",
                    });

                    //alert(response.data.message);
                    this.listarProveedor(1, this.buscar, this.criterio);
                    this.file = "";
                })
                .catch((error) => {
                    this.$message.error("Oops, this is a error message." + error);
                    // console.error(error);
                });
        },
        guardar() {
            this.$message({
                message: "Categoria Guardado con éxito.",
                type: "success",
            });
        },
        editar() {
            this.$message({
                message: "Categoria Actualizado con éxito.",
                type: "success",
            });
        },
        listarProveedor(page, buscar, criterio) {
            let me = this;
            var url =
                "/proveedor?page=" +
                page +
                "&buscar=" +
                buscar +
                "&criterio=" +
                criterio;
            axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayProveedor = respuesta.proveedores.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        cambiarPagina(page, buscar, criterio) {
            let me = this;
            me.pagination.current_page = page;
            me.listarProveedor(page, buscar, criterio);
        },
        registrarCategoria() {
            //validando campos proveedor
            if (this.validarProveedor()) {
                return;
            }

            let me = this;

            axios
                .post("/proveedor/registrar", {
                    nombre: this.nombre,
                    tipo_documento: this.tipo_documento,
                    num_documento: this.num_documento,
                    direccion: this.direccion,
                    telefono: this.telefono,
                    email: this.email,
                })
                .then(function (response) {
                    me.cerrarModal();
                    me.guardar();
                    me.listarProveedor(1, "", "nombre");
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        actualizarProveedor() {
            //validando campos proveedor
            if (this.validarProveedor()) {
                return;
            }

            let me = this;
            axios
                .put("/proveedor/actualizar", {
                    nombre: this.nombre,
                    tipo_documento: this.tipo_documento,
                    num_documento: this.num_documento,
                    direccion: this.direccion,
                    telefono: this.telefono,
                    email: this.email,
                    id: this.proveedor_id,
                })
                .then(function (response) {
                    me.cerrarModal();
                    me.editar();
                    me.listarProveedor(1, "", "nombre");
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        desactivarProveedor(id) {
            Swal.fire({
                title: "Estas seguro de desactivar esta proveedor?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar",
            }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios
                        .put("/proveedor/desactivar", {
                            id: id,
                        })
                        .then(function (response) {
                            me.listarProveedor(1, "", "nombre");
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            });
        },
        activarProveedor(id) {
            Swal.fire({
                title: "Estas seguro de activar esta proveedor?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar",
            }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios
                        .put("/proveedor/activar", {
                            id: id,
                        })
                        .then(function (response) {
                            Swal.fire(
                                "Activado!",
                                "El registro ha sido desactivado con éxito.",
                                "success"
                            );
                            me.listarProveedor(1, "", "nombre");
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            });
        },
        validarProveedor() {
            this.errorProveedor = 0;
            this.errorMostrarMsjProveedor = [];

            if (!this.nombre)
                this.errorMostrarMsjProveedor.push(
                    "El nombre del proveedor no puede estar vacío."
                );

            if (this.errorMostrarMsjProveedor.length) this.errorProveedor = 1;

            return this.errorProveedor;
        },
        cerrarModal() {
            this.modal = 0;
            this.tituloModal = "";
            this.nombre = "";
            this.descripcion = "";
        },
        abrirModal(modelo, accion, data = []) {
            switch (modelo) {
                case "proveedor": {
                    switch (accion) {
                        case "registrar": {
                            this.modal = 1;
                            this.tituloModal = "Registrar Proveedor";
                            this.nombre = "";
                            this.tipo_documento = "";
                            this.num_documento = "";
                            this.direccion = "";
                            this.telefono = "";
                            this.email = "";
                            this.tipoAccion = 1;
                            break;
                        }
                        case "actualizar": {
                            this.modal = 1;
                            this.tituloModal = "Actualizar proveedor";
                            this.tipoAccion = 2;
                            this.proveedor_id = data["id"];
                            this.nombre = data["nombre"];
                            this.tipo_documento = data["tipo_documento"];
                            this.num_documento = data["num_documento"];
                            this.direccion = data["direccion"];
                            this.telefono = data["telefono"]
                            this.email = data["email"];
                            console.log(this.proveedor_id);
                            break;
                        }
                    }
                }
            }
        },
    },
    mounted() {
        this.listarProveedor(1, this.buscar, this.criterio);
    },
};
</script>
<style>
.modal-content {
    width: 100% !important;
    border-radius: 6px;
    position: absolute !important;
    /* margin-top: 60px; */
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

/* .modal-primary .modal-content {
    border-color: #9e9d9d7a;
    margin-top: 40px;
    z-index: 999999;
} */
</style>
