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
                        <span>Listado de Articulos </span>
                    </div>
                    <div class="">
                        <div class="">
                            <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center">
                                <div class="flex-grow-1 mb-2 mb-md-0 ml-md-4">
                                    <i class=""></i>
                                </div>
                                <div class="ml-md-auto mr-md-4">
                                    <el-button plain type="primary" size="" icon="el-icon-circle-plus"
                                        @click="abrirModal('articulo', 'registrar')">Nuevo</el-button>
                                    <el-button class="mb-2" type="danger" icon="el-icon-document"
                                        @click="cargarPdf()">Reporte</el-button>
                                    <!-- <el-button type="success" @click="importarDialogVisible = true"> -->
                                    <!-- Subir -->
                                    <!-- <i class="el-icon-upload el-icon-right"></i> -->
                                    <!-- </el-button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
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
                                        <el-input @keyup.native.enter="listarArticulos(1, buscar, criterio)"
                                            placeholder="Texto a buscar" v-model="buscar"></el-input>
                                    </div>
                                    <div class="m-1">
                                        <el-button icon="el-icon-search" type="primary"
                                            @click="listarArticulos(1, buscar, criterio)">Buscar</el-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-2">
                            <el-table :data="arrayArticulo" style="width: 100%" border size="small">
                                <el-table-column label="Opciones" width="130">
                                    <template slot-scope="{ row }">
                                        <el-button type="warning" icon="el-icon-edit" size="mini"
                                            @click="abrirModal('articulo', 'actualizar', row)"></el-button>
                                        <el-button v-if="row.condicion" type="danger" icon="el-icon-delete" size="mini"
                                            @click="desactivarArticulo(row.id)"></el-button>
                                        <el-button v-else type="info" icon="el-icon-check" size="mini"
                                            @click="activarArticulo(row.id)"></el-button>
                                    </template>
                                </el-table-column>
                                <el-table-column prop="codigo" label="Código" width="100" />
                                <el-table-column prop="nombre" label="Nombre" />
                                <el-table-column prop="nombre_categoria" label="Categoría" />
                                <el-table-column prop="precio_venta" label="Precio Venta" width="120" />
                                <el-table-column prop="stock" label="Stock" width="80" />
                                <el-table-column prop="descripcion" label="Descripción" />
                                <el-table-column label="Estado" width="100">
                                    <template slot-scope="{ row }">
                                        <el-tag :type="row.condicion ? 'success' : 'danger'" effect="plain" size="mini">
                                            {{ row.condicion ? "Activo" : "Inactivo" }}
                                        </el-tag>
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
            <div class="modal-dialog modal-primary modal-md modal-dialog-scrollable" role="dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <!-- form -->
                            <div class="row">
                                <div class="col-md-4 col-6">
                                    <div>
                                        <label class for="text-input">Codigo barras</label>
                                        <div class>
                                            <el-input placeholder="codigo" size="mini" v-model="codigo"></el-input>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div>
                                        <label class for="text-input">Nombre</label>
                                        <div class>
                                            <el-input placeholder="Nombre del producto" size="mini"
                                                v-model="nombre"></el-input>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div>
                                        <label class for="text-input">Precio venta</label>
                                        <div class>
                                            <el-input placeholder="precio de venta" size="mini"
                                                v-model="precio_venta"></el-input>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div>
                                        <label class for="text-input">Precio compra</label>
                                        <div class>
                                            <el-input placeholder="precio de compra" size="mini"
                                                v-model="precio_compra"></el-input>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-6">
                                    <div>
                                        <label class for="text-input">Precio base</label>
                                        <div class>
                                            <el-input placeholder="precio base" size="mini"
                                                v-model="precio_base"></el-input>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-4">
                                    <div>
                                        <label class for="text-input">Stock</label>
                                        <div class>
                                            <el-input placeholder="stock" size="mini" v-model.number="stock"></el-input>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-8">
                                    <div>
                                        <label class for="text-input">Fecha de vencimiento</label>
                                        <div class>
                                            <!-- <el-input placeholder="fecha vencimiento" size="mini" v-model="fechaVencimiento"></el-input> -->

                                            <div class="block">
                                                <el-date-picker v-model="vencimiento" type="date"
                                                    placeholder="Escoge un día" format="yyyy/MM/dd"
                                                    value-format="yyyy-MM-dd" size="mini"></el-date-picker>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">
                                    <div>
                                        <label class for="text-input">Descripción</label>
                                        <div class>
                                            <el-input type="textarea" autosize placeholder="Descripcion del video"
                                                v-model="descripcion">
                                            </el-input>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <label class for="text-input">categoria</label>
                                        <div class>
                                            <template>
                                                <el-select filterable size="mini" v-model="idcategoria"
                                                    placeholder="Selecciona la categoria">
                                                    <el-option v-for="categoria in arrayCategoria" :key="categoria.id"
                                                        :label="categoria.nombre" :value="categoria.id"></el-option>
                                                </el-select>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-md-6"> -->
                                <!-- <div> -->
                                <!-- <label class for="text-input">Unidad de medida</label> -->
                                <!-- <div class> -->
                                <!-- <template> -->
                                <!-- <el-select filterable size="mini" v-model="idunidad" -->
                                <!-- placeholder="Selecciona la unidad"> -->
                                <!-- <el-option v-for="unidad in arrayUnidad" :key="unidad.id" -->
                                <!-- :label="unidad.nombre" :value="unidad.id"></el-option> -->
                                <!-- </el-select> -->
                                <!-- </template> -->
                                <!-- </div> -->
                                <!-- </div> -->
                                <!-- </div> -->
                                <div class="col-md-6">
                                    <div>
                                        <label class for="text-input">Marca</label>
                                        <div class>
                                            <template>
                                                <el-select filterable size="mini" v-model="idmarca"
                                                    placeholder="Selecciona la marca">
                                                    <el-option v-for="marca in arrayMarca" :key="marca.id"
                                                        :label="marca.nombre" :value="marca.id"></el-option>
                                                </el-select>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <label class for="text-input">Proveedor</label>
                                        <div class>
                                            <template>
                                                <el-select filterable size="mini" v-model="idproveedor"
                                                    placeholder="Selecciona el proveedor">
                                                    <el-option v-for="proveedor in arrayProveedor" :key="proveedor.id"
                                                        :label="proveedor.nombre" :value="proveedor.id"></el-option>
                                                </el-select>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div v-show="errorArticulo" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjArticulo" :key="error" v-text="error"></div>
                                </div>
                            </div>
                            <!-- aqui empieza controles -->
                        </form>
                    </div>
                    <div class="modal-footer">
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
                            @click="registrarArticulos()">Guardar</el-button>
                        <!-- <button
                            type="button"
                            v-if="tipoAccion == 2"
                            class="btn btn-primary"
                            @click="actualizarCategoria()"
                        >
                            Actualizar
                        </button> -->
                        <el-button type="primary" v-if="tipoAccion == 2"
                            @click="actualizarArticulo()">Actualizar</el-button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <el-dialog title="Importar Articulos" :visible.sync="importarDialogVisible" width="30%" center>
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
                    value: "Codigo",
                    label: "Codigo",
                },
                {
                    value: "Nombre",
                    label: "Nombre",
                },
                {
                    value: "Descripcion",
                    label: "Descripcion",
                },
                {
                    value: "stock",
                    label: "stock",
                },
            ],
            value: "",
            //fin select
            articulo_id: 0,
            idcategoria: "",
            nombre_categoria: "",
            idmarca: "",
            nombre_marca: "",
            idunidad: "",
            nombre_unidad: "",
            idproveedor: "",
            nombre_proveedor: "",
            codigo: "",
            nombre: "",
            precio_venta: 0,
            precio_compra: 0,
            precio_base: 0,
            stock: 0,
            vencimiento: "",
            imagen: "",
            descripcion: "",
            arrayArticulo: [],
            modal: 0,
            tituloModal: "",
            tipoAccion: 0,
            errorArticulo: 0,
            errorMostrarMsjArticulo: [],
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
            arrayCategoria: [],
            arrayMarca: [],
            arrayUnidad: [],
            arrayProveedor: [],
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
                .post("/articulo/importar", formData, {
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
                    this.listarArticulos(1, this.buscar, this.criterio);
                    this.file = "";
                })
                .catch((error) => {
                    this.$message.error("Oops, this is a error message." + error);
                    // console.error(error);
                });
        },
        //carga pdf products
        cargarPdf() {
            window.open("/articulo/listarPdf", "_blank");
        },
        guardar() {
            this.$message({
                message: "Articulo Guardado con éxito.",
                type: "success",
            });
        },
        editar() {
            this.$message({
                message: "Articulo Actualizado con éxito.",
                type: "success",
            });
        },
        listarArticulos(page, buscar, criterio) {
            let me = this;
            var url =
                "/articulo?page=" +
                page +
                "&buscar=" +
                buscar +
                "&criterio=" +
                criterio;
            axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayArticulo = respuesta.articulo.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        cambiarPagina(page, buscar, criterio) {
            let me = this;
            me.pagination.current_page = page;
            me.listarArticulos(page, buscar, criterio);
        },
        registrarArticulos() {
            //validando campos categoria
            if (this.validarArticulo()) {
                return;
            }

            let me = this;

            axios
                .post("/articulo/registrar", {
                    idcategoria: this.idcategoria,
                    idmarca: this.idmarca,
                    idunidad: this.idunidad,
                    idproveedor: this.idproveedor,
                    codigo: this.codigo,
                    nombre: this.nombre,
                    precio_venta: this.precio_venta,
                    precio_compra: this.precio_compra,
                    precio_base: this.precio_base,
                    stock: this.stock,
                    vencimiento: this.vencimiento,
                    imagen: this.imagen,
                    descripcion: this.descripcion,
                })
                .then(function (response) {
                    me.cerrarModal();
                    me.guardar();
                    me.listarArticulos(1, "", "nombre");
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        actualizarArticulo() {
            //validando campos categoria
            if (this.validarArticulo()) {
                return;
            }

            let me = this;
            axios
                .put("/articulo/actualizar", {
                    idcategoria: this.idcategoria,
                    idmarca: this.idmarca,
                    idunidad: this.idunidad,
                    idproveedor: this.idproveedor,
                    codigo: this.codigo,
                    nombre: this.nombre,
                    precio_venta: this.precio_venta,
                    precio_compra: this.precio_compra,
                    precio_base: this.precio_base,
                    stock: this.stock,
                    vencimiento: this.vencimiento,
                    imagen: this.imagen,
                    descripcion: this.descripcion,
                    id: this.articulo_id,
                })
                .then(function (response) {
                    me.cerrarModal();
                    me.editar();
                    me.listarArticulos(1, "", "nombre");
                    //me.editar();
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        desactivarArticulo(id) {
            Swal.fire({
                title: "Estas seguro de desactivar este articulo?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar",
            }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios
                        .put("/articulo/desactivar", {
                            id: id,
                        })
                        .then(function (response) {
                            me.listarArticulos(1, "", "nombre");
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            });
        },
        activarArticulo(id) {
            Swal.fire({
                title: "Estas seguro de activar este articulo?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar",
            }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios
                        .put("/articulo/activar", {
                            id: id,
                        })
                        .then(function (response) {
                            Swal.fire(
                                "Activado!",
                                "El registro ha sido desactivado con éxito.",
                                "success"
                            );
                            me.listarArticulos(1, "", "nombre");
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            });
        },
        validarArticulo() {
            this.errorArticulo = 0;
            this.errorMostrarMsjArticulo = [];

            if (!this.nombre)
                this.errorMostrarMsjArticulo.push(
                    "El nombre del articulo no puede estar vacío."
                );
            else if (!this.precio_compra)
                this.errorMostrarMsjArticulo.push(
                    "El precio compra del producto no puede estar vacío."
                );
            else if (!this.precio_venta)
                this.errorMostrarMsjArticulo.push(
                    "El precio venta del producto no puede estar vacío."
                );
            else if (!this.vencimiento)
                this.errorMostrarMsjArticulo.push(
                    "Seleccionar la fecha de vencimiento "
                );
            else if (!this.stock)
                this.errorMostrarMsjArticulo.push("Ingresa el stock ");
            else if (!this.idcategoria)
                this.errorMostrarMsjArticulo.push("Seleccionar la categoria ");
            else if (!this.idmarca)
                this.errorMostrarMsjArticulo.push("Seleccionar la marca ");

            if (this.errorMostrarMsjArticulo.length) this.errorArticulo = 1;

            return this.errorArticulo;
        },
        selectCategoria() {
            let me = this;
            var url = "/categoria/listar";

            axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayCategoria = respuesta.categorias;
                    //me.pagination = respuesta.pagination;
                    // console.log(arrayCategoria);
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        selectUnidad() {
            let me = this;
            var url = "/unidad/listar";

            axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayUnidad = respuesta.unidades;
                    //me.pagination = respuesta.pagination;
                    // console.log(arrayCategoria);
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        selectMarca() {
            let me = this;
            var url = "/marca/listar";

            axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayMarca = respuesta.marcas;
                    //me.pagination = respuesta.pagination;
                    // console.log(arrayCategoria);
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        selectproveedor() {
            let me = this;
            var url = "/proveedor/listar";

            axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayProveedor = respuesta.proveedores;
                    //me.pagination = respuesta.pagination;
                    console.log(arrayProveedor);
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        cerrarModal() {
            this.modal = 0;
            this.tituloModal = "";
            this.articulo_id = "";
            this.idcategoria = "";
            this.idmarca = "";
            this.idunidad = "";
            this.idproveedor = "";
            this.codigo = "";
            this.nombre = "";
            this.precio_venta = "";
            this.precio_compra = "";
            this.precio_base = "";
            this.stock = "";
            this.vencimiento = "";
            this.descripcion = "";
        },
        abrirModal(modelo, accion, data = []) {
            switch (modelo) {
                case "articulo":
                    {
                        switch (accion) {
                            case "registrar": {
                                this.modal = 1;
                                this.tituloModal = "Registrar Articulo";
                                this.articulo_id = "";
                                this.idcategoria = "";
                                this.idmarca = "";
                                //this.idunidad = "";
                                this.idproveedor = "";
                                this.codigo = "";
                                this.nombre = "";
                                this.precio_venta = "";
                                this.precio_compra = "";
                                this.precio_base = "";
                                this.stock = "";
                                this.vencimiento = "";
                                this.descripcion = "";
                                this.tipoAccion = 1;
                                break;
                            }
                            case "actualizar": {
                                this.modal = 1;
                                this.tituloModal = "Actualizar Articulo";
                                this.tipoAccion = 2;
                                this.articulo_id = data["id"];
                                this.idcategoria = data["idcategoria"];
                                this.idmarca = data["idmarca"];
                                //this.idunidad = data["idUnidad"];
                                this.idproveedor = data["idproveedor"];
                                this.codigo = data["codigo"];
                                this.nombre = data["nombre"];
                                this.precio_venta = data["precio_venta"];
                                this.precio_compra = data["precio_compra"];
                                this.precio_base = data["precio_base"];
                                this.stock = data["stock"];
                                this.vencimiento = data["vencimiento"];
                                this.descripcion = data["descripcion"];
                                break;
                            }
                        }
                    }
                    this.selectCategoria();
                    //this.selectUnidad();
                    this.selectMarca();
                    this.selectproveedor();
            }
        },
    },
    mounted() {
        this.listarArticulos(1, this.buscar, this.criterio);
    },
};
</script>

<style scoped>
.modal-content {
    width: 100% !important;
    border-radius: 6px;
    position: absolute !important;
}

.mostrar {
    display: list-item !important;
    opacity: 1 !important;
    position: absolute !important;
    background-color: #3c29297a !important;
    /* margin-top: 80px; */
}

.div-error {
    display: flex;
    justify-content: center;
}

.text-error {
    color: red !important;
    font-weight: bold;
}

.el-tag {
    font-size: 12px;
}
</style>
