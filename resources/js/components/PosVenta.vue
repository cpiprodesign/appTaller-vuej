<template>
    <div class="main">
        <div class="container-fluid mt-4">
            <el-card class="box-card">
                <div slot="header" class="clearfix">
                    <span>Post venta de articulos</span>
                </div>
                <el-tabs type="border-card">
                    <el-tab-pane label="Venta">
                        <el-row :gutter="20">
                            <el-col :sm="14" :xs="24" :md="14" :span="14">
                                <div class="">
                                    <el-card class="box-card">
                                        <div>
                                            <!-- Switch -->

                                            <div class="busqueda-toolbar">
                                                <span>Busqueda por:</span>

                                                <el-switch v-model="showCode" @change="handleSwitchChange"
                                                    active-text="Código" inactive-text="Nombre" />

                                                <el-radio-group v-model="isCollapse">
                                                    <el-radio-button :label="false">
                                                        <i class="el-icon-s-fold"></i>
                                                        Tablas
                                                    </el-radio-button>
                                                    <el-radio-button :label="true">
                                                        <i class="el-icon-menu"></i>
                                                        Card
                                                    </el-radio-button>
                                                </el-radio-group>
                                            </div>

                                            <!-- Input -->
                                            <el-input ref="myInput" @keyup.native.enter="
                                                listarArticulo(
                                                    buscar,
                                                    criterio
                                                );
                                            activobusqueda = true;
                                            " placeholder="Ingrese un valor a buscar" v-model="buscar" clearable>
                                                <template slot="prepend">
                                                    <i class="el-icon-search"></i>
                                                    {{ labelbusqueda }}
                                                </template>
                                            </el-input>
                                        </div>

                                        <!-- Tabla responsiva -->
                                        <el-table v-if="activobusqueda && !isCollapse" v-loading="loadingArticulos"
                                            :data="arrayArticulo" border size="mini"
                                            style="width: 100%; margin-top: 20px" :loading="loadingArticulos"
                                            element-loading-text="Cargando artículos...">
                                            <!-- Opciones -->
                                            <el-table-column label="Opciones" width="90">
                                                <template v-slot="scope">
                                                    <el-button type="primary" icon="el-icon-check" size="mini" @click="
                                                        agregarDetalleModal(
                                                            scope.row
                                                        )
                                                        " />
                                                </template>
                                            </el-table-column>

                                            <!-- Código (oculto en móviles) -->
                                            <el-table-column prop="codigo" label="Código" width="120"
                                                :class-name="'d-none d-sm-table-cell'" />

                                            <!-- Unidad (oculto en móviles) -->
                                            <!-- <el-table-column prop="Unidad" label="Unidad" width="100"
                                            :class-name="'d-none d-sm-table-cell'" /> -->

                                            <!-- Nombre -->
                                            <el-table-column prop="nombre" label="Nombre" />

                                            <!-- Categoría (oculto en móviles) -->
                                            <el-table-column prop="nombre_categoria" label="Categoría"
                                                :class-name="'d-none d-sm-table-cell'" />

                                            <!-- Precio Venta -->
                                            <el-table-column prop="precio_venta" label="Precio" width="100" />

                                            <!-- Stock (oculto en móviles) -->
                                            <el-table-column prop="stock" label="Stock" width="80"
                                                :class-name="'d-none d-sm-table-cell'" />

                                            <!-- Estado -->
                                            <el-table-column label="Estado" width="120">
                                                <template v-slot="scope">
                                                    <el-tag :type="scope.row.condicion
                                                        ? 'success'
                                                        : 'danger'
                                                        " disable-transitions>
                                                        {{
                                                            scope.row.condicion
                                                                ? "Activo"
                                                                : "Desactivado"
                                                        }}
                                                    </el-tag>
                                                </template>
                                            </el-table-column>
                                        </el-table>
                                        <!-- Mostrar mensaje si no hay datos (y no está cargando) -->
                                        <div v-if="
                                            !loadingArticulos &&
                                            arrayArticulo.length === 0
                                        " style="
                                            text-align: center;
                                            padding: 10px;
                                            color: #888;
                                        ">
                                            No se encontraron resultados
                                        </div>
                                        <div>
                                            <!-- muestra de datos en card -->
                                            <div v-if="activobusqueda && isCollapse" style="margin-top: 20px">
                                                <div class="card-grid">
                                                    <el-card v-for="item in arrayArticulo" :key="item.id"
                                                        class="card-item" shadow="hover">
                                                        <div class="card-content">
                                                            <div class="card-title">
                                                                {{ item.nombre }}
                                                            </div>
                                                            <div>
                                                                Código:
                                                                {{ item.codigo }}
                                                            </div>
                                                            <div>
                                                                Unidad:
                                                                {{ item.Unidad }}
                                                            </div>
                                                            <div>
                                                                Categoría:
                                                                {{
                                                                    item.nombre_categoria
                                                                }}
                                                            </div>
                                                            <div>
                                                                Precio: S/
                                                                {{
                                                                    item.precio_venta
                                                                }}
                                                            </div>
                                                            <div>
                                                                Stock:
                                                                {{ item.stock }}
                                                            </div>
                                                            <el-tag :type="item.condicion
                                                                ? 'success'
                                                                : 'danger'
                                                                " size="small">
                                                                {{
                                                                    item.condicion
                                                                        ? "Activo"
                                                                        : "Desactivado"
                                                                }}
                                                            </el-tag>
                                                        </div>
                                                        <div class="card-footer">
                                                            <el-button type="primary" icon="el-icon-check" size="mini"
                                                                @click="
                                                                    agregarDetalleModal(
                                                                        item
                                                                    )
                                                                    ">
                                                                Seleccionar
                                                            </el-button>
                                                        </div>
                                                    </el-card>
                                                </div>
                                            </div>
                                        </div>
                                    </el-card>
                                </div>
                            </el-col>
                            <el-col :sm="10" :xs="24" :md="10" :span="10">
                                <div class="">
                                    <el-card class="box-card">
                                        <div>
                                            <!-- Tabla de detalles -->
                                            <el-table v-if="arrayDetalle.length" :data="arrayDetalle" stripe size="mini"
                                                style="
                                                width: 100%;
                                                margin-bottom: 20px;
                                            ">
                                                <el-table-column label="Opciones" width="100">
                                                    <template v-slot="scope">
                                                        <el-button type="danger" icon="el-icon-close" size="mini"
                                                            @click="
                                                                eliminarDetalle(
                                                                    scope.$index
                                                                )
                                                                " />
                                                    </template>
                                                </el-table-column>

                                                <!-- <el-table-column prop="Unidad" label="Unidad" width="100" /> -->
                                                <el-table-column prop="articulo" label="Artículo" />

                                                <el-table-column label="Precio" width="120">
                                                    <template v-slot="scope">
                                                        <el-input v-model.number="scope.row.precio
                                                            " size="mini" type="number" />
                                                    </template>
                                                </el-table-column>

                                                <el-table-column label="Cantidad" width="120">
                                                    <template v-slot="scope">
                                                        <el-input v-model.number="scope.row.cantidad
                                                            " size="mini" type="number" />
                                                    </template>
                                                </el-table-column>

                                                <el-table-column label="Subtotal" width="140">
                                                    <template v-slot="scope">
                                                        {{
                                                            (
                                                                scope.row.precio *
                                                                scope.row.cantidad
                                                            ).toFixed(2)
                                                        }}
                                                    </template>
                                                </el-table-column>
                                            </el-table>

                                            <!-- Mensaje cuando no hay artículos -->
                                            <div v-else style="
                                                padding: 15px;
                                                text-align: center;
                                                color: #999;
                                            ">
                                                No hay artículos agregados
                                            </div>

                                            <!-- Totales -->
                                            <div v-if="arrayDetalle.length" style="
                                                margin-top: 10px;
                                                background: #ceecf5;
                                                padding: 16px;
                                                border-radius: 4px;
                                            ">
                                                <div style="
                                                    display: flex;
                                                    justify-content: flex-end;
                                                    flex-direction: column;
                                                    align-items: flex-end;
                                                    gap: 4px;
                                                ">
                                                    <div>
                                                        <strong>Total Parcial:</strong>
                                                        s/
                                                        {{
                                                            (totalParcial = (
                                                                total -
                                                                totalImpuesto
                                                            ).toFixed(2))
                                                        }}
                                                    </div>
                                                    <div>
                                                        <strong>Total Impuesto:</strong>
                                                        s/
                                                        {{
                                                            (totalImpuesto = (
                                                                (total * impuesto) /
                                                                (1 + impuesto)
                                                            ).toFixed(2))
                                                        }}
                                                    </div>
                                                    <div>
                                                        <strong>Total Neto:</strong>
                                                        s/
                                                        {{
                                                            (total =
                                                                calcularTotal).toFixed(
                                                                    2
                                                                )
                                                        }}
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Botón de pago -->
                                            <el-button type="primary" style="margin-top: 15px"
                                                v-if="arrayDetalle.length" @click="abrirprocesarpago()">
                                                Procesar pago
                                            </el-button>
                                        </div>
                                    </el-card>
                                </div>
                            </el-col>
                        </el-row>
                    </el-tab-pane>
                    <el-tab-pane label="Ventas registradas" @click="listarVenta(buscar, criterio)">
                        <template>
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-md-12 col-12">
                                        <div
                                            style="display: flex; align-items: center; justify-content: space-between;">

                                            <!-- Bloque izquierdo (filtros) -->
                                            <div style="display: flex; gap: 8px; align-items: center;">
                                                <el-select v-model="criterio" placeholder="Select"
                                                    style="width: 150px;">
                                                    <el-option v-for="item in options" :key="item.value"
                                                        :label="item.label" :value="item.value">
                                                    </el-option>
                                                </el-select>

                                                <el-input v-model="buscar" placeholder="Texto a buscar"
                                                    @keyup.native.enter="listarVenta(1, buscar, criterio)"
                                                    style="width: 200px;">
                                                </el-input>

                                                <el-button icon="el-icon-search" type="primary"
                                                    @click="listarVenta(1, buscar, criterio)">
                                                    Buscar
                                                </el-button>
                                            </div>

                                            <!-- Bloque derecho (Total General) -->
                                            <div>
                                                <!-- <el-tag type="success" effect="dark">Total General: {{
                                                totalGeneral
                                                }}</el-tag> -->
                                                <el-button type="warning">Total General s/. {{ totalGeneral
                                                }}</el-button>
                                                <!-- <el-card class="box-card" shadow="always">
                                                
                                            </el-card> -->
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="">
                                    <el-table :data="arrayVenta" size="mini" border stripe style="width: 100%">
                                        <!-- Opciones -->
                                        <el-table-column label="Opciones" width="120">
                                            <template slot-scope="scope">
                                                <el-row>
                                                    <el-button size="mini" type="success"
                                                        @click="pdfVenta(scope.row.id)">
                                                        <i class="icon-doc"></i>
                                                    </el-button>
                                                    <template v-if="scope.row.estado === 'Registrado'">

                                                    </template>
                                                </el-row>
                                            </template>
                                        </el-table-column>

                                        <!-- Usuario -->
                                        <el-table-column prop="usuario.usuario" label="Usuario" />

                                        <!-- Cliente -->
                                        <el-table-column prop="cliente.nombre" label="Cliente" />

                                        <!-- Tipo comprobante -->
                                        <el-table-column prop="tipo_comprobante" label="Tipo Comprobante" />

                                        <!-- Serie comprobante -->
                                        <el-table-column prop="serie_comprobante" label="Serie Comprobante" />

                                        <!-- Número comprobante -->
                                        <el-table-column prop="num_comprobante" label="Número Comprobante" />

                                        <!-- Fecha -->
                                        <el-table-column prop="fecha_hora" label="Fecha Hora" />

                                        <!-- Total -->
                                        <el-table-column prop="total" label="Total" />

                                        <!-- Impuesto -->
                                        <el-table-column prop="impuesto" label="Impuesto" />

                                        <!-- Estado -->
                                        <el-table-column label="Estado" width="150">
                                            <template slot-scope="scope">
                                                <el-tag :type="colorEstado(scope.row.estado)" effect="plain">
                                                    <i :class="iconoEstado(scope.row.estado)"
                                                        style="margin-right: 4px;"></i>
                                                    {{ scope.row.estado }}
                                                </el-tag>
                                            </template>
                                        </el-table-column>
                                    </el-table>


                                </div>
                                <nav class="mt-2 ">
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
                                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[
                                            page == isActived ? 'active' : '',
                                        ]">
                                            <a class="page-link" href="#" @click.prevent="
                                                cambiarPagina(
                                                    page,
                                                    buscar,
                                                    criterio
                                                )
                                                " v-text="page"></a>
                                        </li>

                                        <li class="page-item" v-if="
                                            pagination.current_page <
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
                            </div>
                        </template>
                    </el-tab-pane>
                </el-tabs>
            </el-card>

        </div>
        <!-- modal -->
        <!-- <el-button type="text" @click="centerDialogVisible = true">Click to open the Dialog</el-button> -->

        <el-dialog title="" class="dialog-cliente" :visible.sync="dialogFormVisible">
            <el-row :gutter="20">
                <el-col :xs="24" :md="8" :span="8">
                    <div class="">
                        <label>Tipo Comprobante(*)</label>
                        <template class="">
                            <el-select size="small" class="" @change="buscarComprobante(), actualizarSerie()"
                                v-model="tipo_comprobante" placeholder="Seleciona el tipo de comprobante">
                                <el-option v-for="item in optionsB" :key="item.value" :label="item.label"
                                    :value="item.value">
                                </el-option>
                            </el-select>
                        </template>
                    </div>
                </el-col>
                <el-col :xs="24" :md="8" :span="8">
                    <div class="">
                        <label>Serie Comprobante</label>
                        <!-- <input type="text" class="form-control" v-model="serie_comprobante" placeholder="000x" /> -->
                        <el-input size="small" placeholder="000x" v-model="serie_comprobante"></el-input>
                    </div>
                </el-col>
                <el-col :xs="24" :md="8" :span="8">
                    <div class="">
                        <label>Número Comprobante(*)</label>
                        <!-- <input type="text" class="form-control" v-model="num_comprobante" placeholder="000xx" /> -->
                        <el-input size="small" placeholder="000xx" :disabled="true"
                            v-model="num_comprobante"></el-input>
                    </div>
                </el-col>
            </el-row>
            <el-row :gutter="20">
                <div v-show="errorVenta" class="form-group row div-error">
                    <div class="text-center text-error">
                        <div v-for="error in errorMostrarMsjVenta" :key="error" v-text="error"></div>
                    </div>
                </div>
                <el-col :xs="24" :md="16" :span="16">
                    <div class="">
                        <label>Clientes(*)</label>
                        <!-- <v-select :on-search="selectCliente" label="nombre" :options="arrayCliente" -->
                        <!-- placeholder="Buscar clientes..." :onChange="getDatosCliente"> -->
                        <!-- </v-select> -->
                        <!-- <el-select v-model="value" filterable placeholder="Select"> -->
                        <!-- <el-option v-for="cliente in arrayCliente" :key="cliente.id" :label="cliente.nombre" -->
                        <!-- :value="cliente.id" :disabled="item.disabled"> -->
                        <!-- </el-option> -->
                        <!-- </el-select> -->

                        <el-select size="small" v-model="idcliente" filterable remote clearable
                            placeholder="Buscar clientes..." :remote-method="remoteBuscarCliente"
                            :loading="loadingClientes" @change="getDatosCliente" style="width: 100%">
                            <el-option v-for="cliente in arrayCliente" :key="cliente.id"
                                :label="`${cliente.nombre} - ${cliente.num_documento}`" :value="cliente.id" />
                        </el-select>
                    </div>
                    <div>
                        <el-button type="text" @click="centerDialogVisible = true">
                            nuevo</el-button>
                    </div>
                </el-col>
                <el-col :xs="24" :md="8" :span="8">
                    <div class="">
                        <label>Impuesto</label>
                        <el-input size="small" placeholder="0.18" v-model="impuesto"></el-input>
                    </div>
                </el-col>
            </el-row>

            <el-row :gutter="20">
                <el-col :xs="24" :md="8" :span="8">
                    <div class="">
                        <label>Ingrese monto a pagar</label>
                        <el-input @keyup.native.enter="calcularvuelt()" size="small" placeholder="Ingrese el monto "
                            v-model="efectivo">
                            <template slot="prepend">S/</template>
                        </el-input>
                    </div>
                </el-col>
                <el-col :xs="24" :md="16" :span="16">
                    <div class="">
                        <label>Montos rápidos</label>
                        <div class="d-flex flex-wrap gap-2">
                            <el-button v-for="monto in [5, 10, 20, 50, 100]" :key="monto" type="primary" plain
                                size="medium" @click="agregarMonto(monto)">
                                S/ {{ monto }}
                            </el-button>
                        </div>
                    </div>
                </el-col>
            </el-row>
            <el-row :gutter="20">
                <el-col :xs="24" :md="12" :span="12">
                    <div class="">
                        <label>vuelto</label>
                        <!-- <input type="text" class="form-control" v-model="serie_comprobante" placeholder="000x" /> -->
                        <el-input size="small" placeholder="0" v-model="vuelto"></el-input>
                    </div>
                </el-col>
                <el-col :xs="24" :md="12" :span="12">
                    <div class="">
                        <label>Total a Pagar</label><br />
                        <!-- <el-button size="small" type="success"> {{ (calcularTotal).toFixed(2)
              }}</el-button> -->
                        <!-- <button class="btn btn-info btn-lg"> -->
                        <!-- s/ {{ calcularTotal.toFixed(2) }} -->
                        <!-- </button> -->

                        <el-button type="success" size="medium">s/. {{ calcularTotal.toFixed(2) }}</el-button>
                        <!-- <el-input size="small" :disabled="true" placeholder="0">{{ (calcularTotal).toFixed(2)
              }}</el-input> -->
                    </div>
                </el-col>
            </el-row>
            <span slot="footer" class="dialog-footer">
                <!-- <el-button @click="dialogFormVisible = false">Cancel</el-button> -->
                <el-button :disabled="fullscreenLoading" class="mb-1" type="danger"
                    @click="cerrarmodal()">Cancelar</el-button>
                <el-button type="primary" v-loading.fullscreen.lock="fullscreenLoading"
                    @click="handleRegistrarVenta">Registrar
                    Venta</el-button>
                <!-- imprimirvisible = true; -->
                <!-- boton de imprimir -->
                <!-- <el-button type="text" @click="imprimirvisible = true, fetchPdf((10))">click para
                    imprimir</el-button> -->
            </span>
        </el-dialog>
        <!-- fin modal -->
        <!-- modal de imprimir -->

        <!-- abre imprimir -->
        <!-- <el-button type="text" @click="imprimirvisible = true">offf</el-button> -->
        <template>
            <!-- <el-button type="text" @click="outerVisible = true">o</el-button> -->

            <el-dialog class="dialog-cliente" title="Imprime tu documento" :visible.sync="imprimirvisible">
                <el-dialog width="30%" title="Inner Dialog" :visible.sync="innerVisible" append-to-body>
                </el-dialog>
                <!-- //aqui el pdf -->
                <!-- <button class="btn btn-primary" @click="fetchPdf(orden_id)">cargar pdf</button> -->
                <embed :src="pdfUrl" type="application/pdf" width="100%" height="500px" />
                <div>
                    <div class="container">
                        <el-form :model="form" label-position="top" label-width="auto">
                            <el-row :gutter="20">
                                <el-col :md="6" :sm="8" :xs="24">
                                    <el-form-item label="ID de Venta">
                                        <el-input v-model="form.idVenta" placeholder="Ingrese el ID" />
                                    </el-form-item>
                                </el-col>

                                <el-col :md="9" :sm="8" :xs="24">
                                    <el-form-item label="Teléfono (WhatsApp)">
                                        <el-input v-model="form.telefono" placeholder="Ej: 987654321" />
                                    </el-form-item>
                                </el-col>

                                <el-col :md="9" :sm="8" :xs="24">
                                    <el-form-item label=" ">
                                        <!-- espacio no rompible para mantener alineación -->
                                        <el-button type="primary" :loading="loadingenviar" @click="enviarComprobante"
                                            style="width: 100%; margin-top: 2px">
                                            Enviar comprobante
                                        </el-button>
                                    </el-form-item>
                                </el-col>
                            </el-row>
                        </el-form>
                    </div>
                </div>
                <div slot="footer" class="dialog-footer">
                    <el-button type="danger" @click="imprimirvisible = false">Cerrar la ventana</el-button>
                    <!-- <el-button @click="pdfOrden(id)">innmm</el-button> -->
                    <!-- <el-button type="primary" @click="innerVisible = true">open the inner Dialog</el-button> -->
                </div>
            </el-dialog>
        </template>

        <!-- nuevo cliente -->
        <el-dialog class="dialog-cliente" title="Registro de cliente.." :visible.sync="centerDialogVisible" width="30%"
            center>
            <!-- <cliente @escuchar=" selectCliente()"></cliente> -->
            <!-- pintamo el componete cliente -->
            <cliente @escuchar="selectCliente()"></cliente>
        </el-dialog>
        <!-- fin de nuevo cliente  -->

        <!-- practicando enviar json a nubefact -->
        <!--
        <template>
            <div>
                <button @click="enviarDatos()">Enviar Datos</button>
            </div>
        </template>


        <template>
            <div>

               <h2>Datos del Cliente</h2>
                <form @submit.prevent="enviarDatosNuevo()">
                    <input v-model="cliente.razon_social_nombres" placeholder="Razón Social / Nombres" required />
                    <input v-model="cliente.numero_documento" placeholder="Número de Documento" required />
                    <input v-model="cliente.cliente_direccion" placeholder="Dirección" required />


                    <h2>Productos</h2>
                    <div v-for="(item, index) in items" :key="index">
                        <input v-model="item.producto" placeholder="Producto" required />
                        <input v-model="item.cantidad" placeholder="Cantidad" type="number" required />
                        <input v-model="item.precio_base" placeholder="Precio Base" type="number" required />

                        <button type="button" @click="eliminarProducto(index)">Eliminar Producto</button>
                    </div>
                    <button type="button" @click="agregarProducto">Agregar Producto</button>

                    <button type="submit">Enviar Datos</button>
                </form>
            </div>
        </template> -->

        <!-- fin con api -->
    </div>
    <!-- practicandoku -->
</template>

<script>
import vSelect from "vue-select";
import swal from "sweetalert";
//import cliente from './Cliente.vue'
import cliente from "./RegisterCliente.vue";

export default {
    components: { cliente, vSelect },
    data() {
        return {
            options: [
                { value: "fecha_hora", label: "Fecha de Venta" },
                { value: "tipo_comprobante", label: "Tipo Comprobante" },
                { value: "num_comprobante", label: "Número Comprobante" },
                { value: "cliente", label: "Cliente" },
                { value: "usuario", label: "Usuario" },
            ],
            isCollapse: false, // false = tabla, true = card
            //select ckiente
            clienteSeleccionado: null,
            loadingClientes: false,
            //enviar whatsapp

            form: {
                idVenta: "",
                telefono: "",
            },
            loadingenviar: false,

            //nubefact
            cliente: {
                razon_social_nombres: "",
                numero_documento: "",
                cliente_direccion: "",
            },
            items: [
                {
                    producto: "",
                    cantidad: "",
                    precio_base: "",
                    // Agrega más campos si es necesario
                },
            ],

            response: null,

            //switch
            labelbusqueda: "Nombre",
            value1: "true",
            showCode: false,
            option: {
                codigo: "001",
                nombre: "Opción 1",
            },
            //nueno cliente
            centerDialogVisible: false,

            //

            pdfUrl: "",
            imprimirvisible: false, ///en modo prueba es true desactivar ojo a falso
            innerVisible: false,
            //
            efectivo: 0,
            vuelto: 0,
            codigo: "",
            activo: false,
            value: "",
            venta_id: 0,
            idcliente: null,
            cliente: "",
            tipo_comprobante: "Boleta",
            serie_comprobante: "",
            num_comprobante: "",
            impuesto: 0.18,
            total: 0.0,
            totalImpuesto: 0.0,
            totalParcial: 0.0,
            arrayVenta: [],
            arrayCliente: [],
            arrayDetalle: [],
            tipoAccion: 0,
            errorVenta: 0,
            errorMostrarMsjVenta: [],
            pagination: {
                total: 0,
                current_page: 0,
                per_page: 0,
                last_page: 0,
                from: 0,
                to: 0,
            },
            offset: 3,
            criterio: "cliente",
            buscar: "",
            criterioA: "nombre",
            buscarA: "",
            arrayArticulo: [],
            idarticulo: 0,
            codigo: "",
            articulo: "",
            precio: 0,
            cantidad: 0,
            descuento: 0,
            stock: 0,
            //
            arraydocumento: [],
            tipoDocumento: "",
            codigoGenerado: "",
            //aqui de modal procesar
            dialogFormVisible: false,
            formLabelWidth: "120px",
            //select comprobante
            optionsB: [
                { value: "Boleta", label: "Boleta" },
                { value: "Factura", label: "Factura" },
                { value: "Ticket", label: "Ticket" },
            ],
            series: {
                Boleta: { serie: "B001", numero: "2" },
                Factura: { serie: "F001", numero: "1" },
                Ticket: { serie: "T001", numero: "3" },
            },

            numerodocumentosunat: "",
            fullscreenLoading: false,
            loadingArticulos: false,
            activobusqueda: false,
            loading: true,
            telefonocliente: "",
        };
    },

    methods: {
        colorEstado(estado) {
            switch (estado) {
                case "Registrado":
                    return "primary"; // naranja
                case "Aceptado":
                    return "success"; // verde
                case "Anulado":
                    return "danger"; // rojo
                default:
                    return "info";
            }
        },
        tooltipEstado(estado) {
            switch (estado) {
                case "Registrado":
                    return "Registrado localmente, pendiente de enviar a SUNAT";
                case "Aceptado":
                    return "Enviado correctamente a SUNAT";
                case "Anulado":
                    return "Venta anulada";
                default:
                    return "Estado desconocido";
            }
        },
        iconoEstado(estado) {
            switch (estado) {
                case "Registrado":
                    return "el-icon-time";
                case "Aceptado":
                    return "el-icon-check";
                case "Anulado":
                    return "el-icon-close";
                default:
                    return "el-icon-info";
            }
        },
        listarVenta(page, buscar, criterio) {
            let me = this;
            var url =
                "/venta?page=" +
                page +
                "&buscar=" +
                buscar +
                "&criterio=" +
                criterio;
            axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayVenta = respuesta.ventas.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        abrirprocesarpago() {
            // this.tipo_comprobante = 'Tiket';
            this.dialogFormVisible = true;
            // this.getDatosCliente();
            this.buscarComprobante(this.tipo_comprobante);
            this.actualizarSerie();
        },
        // Método para búsqueda remota
        remoteBuscarCliente(query) {
            if (!query) return;
            this.loadingClientes = true;
            axios
                .get(`/cliente/selectCliente?filtro=${query}`)
                .then((response) => {
                    this.arrayCliente = response.data.clientes;
                    this.loadingClientes = false;
                    //console.log(this.arrayCliente)
                })
                .catch((error) => {
                    console.error(error);
                    this.loadingClientes = false;
                });
        },
        // Obtener datos del cliente al seleccionar ID
        getDatosCliente(clienteId) {
            const cliente = this.arrayCliente.find((c) => c.id === clienteId);
            if (cliente) {
                this.form.telefono = cliente.telefono;
            }
        },
        async enviarComprobante() {
            if (!this.form.idVenta || !this.form.telefono) {
                this.$message.error("Debe ingresar el ID de venta y teléfono");
                return;
            }

            this.loadingenviar = true;
            try {
                const response = await axios.get(
                    `/venta/pdfimprimir/${this.form.idVenta}`,
                    {
                        params: {
                            telefono: this.form.telefono,
                        }, // envía por query string
                    }
                );

                this.$message.success("Comprobante enviado correctamente");
                this.form.idVenta = "";
                this.form.telefono = "";
                this.imprimirvisible = false;
            } catch (error) {
                console.error(error);
                this.$message.error(
                    "Ocurrió un error al enviar el comprobante"
                );
            } finally {
                this.loadingenviar = false;
            }
        },

        agregarMonto(monto) {
            // Si efectivo ya tiene algo, suma el nuevo monto
            // Puedes cambiar esta lógica si prefieres reemplazar en lugar de sumar
            const actual = parseFloat(this.efectivo) || 0;
            this.efectivo = (actual + monto).toFixed(2);
            this.calcularvuelt(); // opcional: recalcular vuelto automáticamente
        },
        actualizarSerie() {
            const datos = this.series[this.tipo_comprobante] || {
                serie: "",
                numero: 0,
            };
            this.serie_comprobante = datos.serie;
            this.numerodocumentosunat = datos.numero;

            console.log("Serie:", this.serie_comprobante);
            console.log("Número:", this.numerodocumentosunat);
        },
        focusInput() {
            this.$refs.myInput.$el.querySelector("input").focus();
        },
        handleSwitchChange(value) {
            this.criterio = "nombre";
            //console.log('Switch cambiado:', value);
            // Aquí puedes ejecutar el código que desees al cambiar el switch
            if (value) {
                this.criterio = "codigo";
                this.labelbusqueda = "Codigo";
                this.buscar = "";
                this.focusInput();
                // console.log('Mostrando Código:', this.option.codigo);
            } else {
                this.criterio = "nombre";
                this.labelbusqueda = "Nombre";
                this.buscar = "";
                this.focusInput();
                //console.log('Mostrando Nombre:', this.option.nombre);
            }
        },
        fetchPdf(id) {
            // Hacer la solicitud GET a la API de Laravel
            axios
                .get("/venta/pdfimprimir/" + id, {
                    responseType: "arraybuffer",
                })
                .then((response) => {
                    // Crear un Blob con la respuesta para convertirla en una URL de objeto
                    const blob = new Blob([response.data], {
                        type: "application/pdf",
                    });
                    this.pdfUrl = URL.createObjectURL(blob);
                    this.showModal = true;
                })
                .catch((error) => {
                    console.error("Error fetching PDF:", error);
                });
        },
        cerrarmodal() {
            (this.dialogFormVisible = false),
                (this.efectivo = 0),
                (this.vuelto = 0),
                (this.idcliente = 0);
            this.tipo_comprobante = "Boleta";
            this.serie_comprobante = "";
            this.num_comprobante = "";
        },
        calcularvuelt() {
            let monto = 0.0,
                vuelto = 0.0;
            // let efectivo = this.efectivo;
            if (this.efectivo > 0) {
                //mensajevuelto();
                monto = this.total;
                vuelto = this.efectivo - monto;
                this.vuelto = vuelto.toFixed(2);
            } else {
                this.vuelto = 0;
            }
        },
        validarVenta() {
            let me = this;
            me.errorVenta = 0;
            me.errorMostrarMsjVenta = [];
            var art;

            me.arrayDetalle.map(function (x) {
                if (x.cantidad > x.stock) {
                    art = x.articulo + " con stock insuficiente";
                    me.errorMostrarMsjVenta.push(art);
                }
            });

            if (me.idcliente == 0)
                me.errorMostrarMsjVenta.push("Seleccione un Cliente");
            if (me.tipo_comprobante == 0)
                me.errorMostrarMsjVenta.push("Seleccione el comprobante");
            if (!me.num_comprobante)
                me.errorMostrarMsjVenta.push(
                    "Ingrese el número de comprobante"
                );
            if (!me.impuesto)
                me.errorMostrarMsjVenta.push("Ingrese el impuesto de compra");
            if (me.arrayDetalle.length <= 0)
                me.errorMostrarMsjVenta.push("Ingrese detalles");

            if (me.errorMostrarMsjVenta.length) me.errorVenta = 1;

            return me.errorVenta;
        },
        guardar(mensaje) {
            this.$message({
                message: "Venta Registrado con éxito." + mensaje,
                type: "success",
            });
        },

        async handleRegistrarVenta() {
            const fueRegistrado = await this.registrarVenta();

            if (fueRegistrado) {
                this.dialogFormVisible = false;
                this.imprimirvisible = true;
            }
        },

        async registrarVenta() {
            if (this.validarVenta()) {
                return false;
            }

            this.fullscreenLoading = true;

            try {
                const response = await axios.post("/venta/registrar", {
                    idcliente: this.idcliente,
                    tipo_comprobante: this.tipo_comprobante,
                    serie_comprobante: this.serie_comprobante,
                    id_documento: this.numerodocumentosunat,
                    num_comprobante: this.num_comprobante,
                    impuesto: this.impuesto,
                    subTotal: this.totalParcial,
                    Igv: this.totalImpuesto,
                    total: this.total,
                    data: this.arrayDetalle,
                });

                // Mostrar mensaje de SUNAT
                let m = response.data.message;
                this.guardar(m);

                // Limpiar formulario
                this.idcliente = null;
                this.cliente = "";
                this.pdfUrl = "";
                this.tipo_comprobante = "";
                this.numerodocumentosunat = "";
                this.impuesto = 0.18;
                this.total = 0.0;
                this.idarticulo = 0;
                this.articulo = "";
                this.cantidad = 0;
                this.precio = 0;
                this.stock = 0;
                this.codigo = "";
                this.descuento = 0;
                this.efectivo = 0;
                this.vuelto = 0;
                this.arrayDetalle = [];
                this.buscar = "";

                this.actualizarSerie();
                this.focusInput();

                // Obtener PDF
                this.fetchPdf(response.data.id);
                this.form.idVenta = response.data.id;
                return true; // <-- Marca éxito
            } catch (error) {
                const mensaje =
                    error.response?.data?.message ||
                    "Error inesperado al registrar la venta.";
                this.$message.error(mensaje);
                //alert("Error SUNAT: " + mensaje);

                return false;
            } finally {
                this.fullscreenLoading = false;
            }
        },

        selectCliente(search, loading) {
            let me = this;
            loading(true);

            var url = "/cliente/selectCliente?filtro=" + search;
            axios
                .get(url)
                .then(function (response) {
                    let respuesta = response.data;
                    q: search;
                    me.arrayCliente = respuesta.clientes;
                    loading(false);
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        /* getDatosCliente(val1) {
                     let me = this;
                     me.loadingClientes = true;
                     me.idcliente = val1.id;
                     console.log = val1.telefono
                     me.form.telefono = val1.telefono;
                 },*/

        async listarArticulo(buscar, criterio) {
            this.loadingArticulos = true;
            try {
                const url = `/articulo/listarArticuloVenta?buscar=${buscar}&criterio=${criterio}`;
                const response = await axios.get(url);
                // await new Promise(resolve => setTimeout(resolve, 1000));
                this.arrayArticulo = response.data.articulo.data;
                console.log(this.arrayArticulo);
            } catch (error) {
                console.error(error);
                this.$message.error("Error al cargar los artículos");
            } finally {
                this.loadingArticulos = false;
            }
        },

        encuentra(id) {
            var sw = 0;
            for (var i = 0; i < this.arrayDetalle.length; i++) {
                if (this.arrayDetalle[i].idarticulo == id) {
                    sw = true;
                }
            }
            return sw;
        },
        pdfVenta(id) {
            window.open("/venta/pdf/" + id, "_blank");
        },

        agregarDetalle() {
            let me = this;
            if (me.idarticulo == 0 || me.cantidad == 0 || me.precio == 0) {
            } else {
                if (me.encuentra(me.idarticulo)) {
                    swal({
                        type: "error",
                        title: "Error...",
                        text: "Ese Producto ya se encuentra agregado!",
                    });
                } else {
                    if (me.cantidad > me.stock) {
                        swal({
                            type: "error",
                            title: "Error...",
                            text: "NO hay stock disponible!",
                        });
                    } else {
                        me.arrayDetalle.push({
                            idarticulo: me.idarticulo,
                            articulo: me.articulo,
                            cantidad: me.cantidad,
                            precio: me.precio,
                            descuento: me.descuento,
                            stock: me.stock,
                        });
                        me.codigo = "";
                        me.idarticulo = 0;
                        me.articulo = "";
                        me.cantidad = 0;
                        me.precio = 0;
                        me.descuento = 0;
                        me.stock = 0;
                        me.activobusqueda = false;
                    }
                }
            }
        },
        agregarDetalleModal(data = []) {
            let me = this;
            if (me.encuentra(data["id"])) {
                swal({
                    type: "error",
                    title: "Error...",
                    text: "Ese producto ya se encuentra agregado!",
                });
            } else {
                me.arrayDetalle.push({
                    idarticulo: data["id"],
                    Unidad: data["Unidad"],
                    articulo: data["nombre"],
                    cantidad: 1,
                    precio: data["precio_venta"],
                    descuento: 0,
                    stock: data["stock"],
                });
                (me.activobusqueda = false), this.focusInput();
                this.buscar = "";
            }
        },
        eliminarDetalle(index) {
            let me = this;
            me.arrayDetalle.splice(index, 1);
        },
        buscarComprobante() {
            //console.log("Tipo comprobante:", this.tipo_comprobante);
            let me = this;
            var url =
                "/venta/buscarComprobanteVenta?filtro=" + this.tipo_comprobante;

            axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    //console.log(respuesta);
                    me.arraydocumento = respuesta.ventas;
                    console.log(me.arraydocumento);

                    if (me.arraydocumento.length > 0) {
                        me.num_comprobante = me.arraydocumento[0]["numero"];
                        //console.log(me.codigoGenerado);
                    } else {
                        me.codigoGenerado = "No existe el codigo";
                        //me.idarticulo=0;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        //mi api

        //aqui metodo de add

        calcularTotales() {
            // Calcula el total de la venta y el IGV basado en los productos
            let totalGravada = 0;
            this.items.forEach((item) => {
                totalGravada += item.cantidad * item.precio_base;
            });
            this.venta.total_gravada = totalGravada;
            this.venta.total_igv = totalGravada * 0.18; // Ejemplo de cálculo de IGV (18%)
        },
    },
    mounted() {
        this.focusInput();
        this.actualizarSerie();
        this.listarVenta(1, this.buscar, this.criterio);
        //this.buscarComprobante(this.tipo_comprobante);
        // this.listarArticulo(this.buscar, this.criterio);
    },
    computed: {
        totalGeneral() {
            return this.arrayVenta.reduce((sum, venta) => sum + Number(venta.total), 0)
        },
        isActived: function () {
            return this.pagination.current_page;
        },
        //Calcula los elementos de la paginación
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
        calcularTotal: function () {
            var resultado = 0.0;
            for (var i = 0; i < this.arrayDetalle.length; i++) {
                resultado =
                    resultado +
                    (this.arrayDetalle[i].precio *
                        this.arrayDetalle[i].cantidad -
                        this.arrayDetalle[i].descuento);
            }
            return resultado;
        },
        calcularVuento: function () {
            let monto = 0.0,
                vuelto = 0.0;
            monto = this.total;
            vuelto = this.efectivo - monto;
            return vuelto;
        },
    },
    watch: {
        buscar(newVal) {
            if (newVal.trim() === "") {
                this.activobusqueda = false;
                this.arrayArticulo = [];
                this.loadingArticulos = false;
            }
        },
    },
};
</script>

<style scoped>
.busqueda-toolbar {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 10px;
    margin-bottom: 15px;
}

@media (max-width: 576px) {
    .busqueda-toolbar {
        flex-direction: column;
        align-items: flex-start;
    }
}

.card-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.card-item {
    width: calc(100% / 2 - 10px);
    /* 2 columnas en móvil */
    margin-bottom: 10px;
}

@media (min-width: 768px) {
    .card-item {
        width: calc(100% / 3 - 10px);
        /* 3 columnas en tablet */
    }
}

@media (min-width: 992px) {
    .card-item {
        width: calc(100% / 4 - 10px);
        /* 4 columnas en escritorio */
    }
}

.card-content {
    font-size: 13px;
    margin-bottom: 10px;
}

.card-title {
    font-weight: bold;
    font-size: 14px;
    margin-bottom: 5px;
    color: #0d6efd;
}

.card-footer {
    text-align: right;
}

@media (max-width: 768px) {
    .dialog-cliente ::v-deep(.el-dialog) {
        width: 95% !important;
        margin: 20px auto !important;
        /* Espacio arriba y abajo */
        padding: 10px !important;
    }

    .dialog-cliente ::v-deep(.el-dialog__body) {
        padding: 10px !important;
    }

    .dialog-cliente ::v-deep(.el-dialog__footer) {
        text-align: center;
    }
}
</style>
