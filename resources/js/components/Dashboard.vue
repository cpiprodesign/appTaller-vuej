<template>
    <main class="main ">
        <!-- Breadcrumb -->
        <!-- <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
        </ol> -->
        <div class="container-fluid mt-4 ">
            <el-row :gutter="20">
                <el-col class="" :sm="6" :xs="12" :span="6">
                    <el-card shadow="always">
                        <div class="text-center">
                            <p>Dispositivos no entregados</p>
                        </div>
                        <div class="">
                            <div class="">
                                <div class="aling">
                                    <i class="icon fas fa-mobile-alt"></i>
                                </div>
                            </div>
                            <div class="data">
                                <h4 class="mt-2"> {{ totalDispositivosNoEntregado }} </h4>
                            </div>
                        </div>
                    </el-card>
                </el-col>

                <el-col :sm="6" :xs="12" :span="6">
                    <el-card shadow="always">
                        <div class="titulo text-center">
                            <p>Dispositivos en reparación</p>
                        </div>
                        <div class="">
                            <div class="text-center">
                                <div class="aling">
                                    <i class="icon1 fas fa-mobile"></i>
                                </div>
                            </div>
                            <div class="data">
                                <h4 class="mt-2">{{ totalDispositivosEnReparaciones }}</h4>
                            </div>
                        </div>
                    </el-card>
                </el-col>

                <el-col class="" :xs="12" :span="6">
                    <el-card shadow="always">
                        <div class="titulo text-center">
                            <p>Total Servicio</p>
                        </div>
                        <div class="">
                            <div class="text-center">
                                <div class="aling">
                                    <i class="icon2 fas fa-donate"></i>
                                </div>
                            </div>
                            <div class="data">
                                <h4 class="mt-2">s/. {{ TotalService }}</h4>
                            </div>
                        </div>
                    </el-card>
                </el-col>

                <el-col :xs="12" :span="6">
                    <el-card shadow="always">
                        <div class="titulo text-center">
                            <p>Total cuenta a cobrar</p>
                        </div>
                        <div class="">
                            <div class="text-center">
                                <div class="aling">
                                    <i class="icon3 fas fa-money-check-alt"></i>
                                </div>
                            </div>
                            <div class="data">
                                <h4 class="mt-2">s/. {{ TotalCuentaCobrar }}</h4>
                            </div>
                        </div>
                    </el-card>
                </el-col>
            </el-row>
            <div class="mt-4">
                <div class=" ">
                    <el-row :gutter="20">
                        <el-col :sm="12" :xs="24" :span="12">
                            <el-card shadow="always">
                                <div class="text-center">
                                    <p>Ordenes de ultimos meses</p>
                                </div>
                                <canvas id="ventas"> </canvas>
                            </el-card>
                        </el-col>
                        <el-col :sm="12" :xs="24" :span="12">
                            <el-card shadow="always">
                                <div class="text-center">
                                    <h3>Listado de ordenes </h3>
                                </div>
                                <div class="row">
                                    <div>
                                        <el-table :data="arrayOrden" border stripe style="width: 100%" size="mini">
                                            <el-table-column prop="id" label="Nro Orden" width="100"></el-table-column>
                                            <el-table-column prop="Cliente" label="Cliente"></el-table-column>
                                            <el-table-column prop="Tecnico" label="Técnico"></el-table-column>
                                            <el-table-column prop="marca" label="Marca"></el-table-column>
                                            <!-- Si luego quieres mostrar serial o clave, puedes descomentar y añadir columnas aquí -->

                                            <el-table-column prop="fechaEntrega"
                                                label="Fecha Entrega"></el-table-column>
                                            <el-table-column prop="adelanto" label="Adelanto"
                                                width="100"></el-table-column>
                                            <el-table-column prop="totalPagar" label="Total a Pagar"
                                                width="120"></el-table-column>

                                            <!-- Estado -->
                                            <el-table-column label="Estado" width="140">
                                                <template slot-scope="scope">
                                                    <el-tag :class="estadoColor(scope.row.estado)" effect="dark">
                                                        {{ scope.row.estado }}
                                                    </el-tag>
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
                                    </div>
                                </div>

                            </el-card>
                        </el-col>

                    </el-row>

                </div>
            </div>

        </div>
    </main>
</template>

<script>
// import Chart from "chart.min.js";
export default {
    data() {
        return {
            arrayDispositivosNoEntregados: [],
            totalDispositivosNoEntregados: 0,
            arrayDispositivosEnReparacion: [],
            totalDispositivoEnReparacion: 0,
            arrayTotalServicio: [],
            totalServicio: 0,
            sumarTotalAdelanto: 0,
            totalCuentaCobrar: 0,
            //grafico
            varVenta: null,
            charVenta: null,
            ventas: [],
            varTotalVenta: [],
            varMesVenta: [],
            //listado 
            arrayOrden: [],
            criterio: "id",
            buscar: "",
            pagination: {
                total: 0,
                current_page: 0,
                per_page: 0,
                last_page: 0,
                from: 0,
                to: 0,
            },
            offset: 3,
            //para estados
            estados: [
                {
                    value: "Ingresado",
                    label: "Ingresado",
                },
                {
                    value: "Reparando",
                    label: "Reparando",
                },
                {
                    value: "Reparacion finalizado",
                    label: "Reparacion finalizado",
                },
                {
                    value: "Entregado",
                    label: "Entregado",
                },

            ],

        };
    },
    methods: {
        cambiarPagina(page, buscar, criterio) {
            let me = this;
            me.pagination.current_page = page;
            me.listarOrden(page, buscar, criterio);
        },
        estadoColor(estado) {
            // Devuelve una clase según el valor del estado
            switch (estado) {
                case 'Ingresado':
                    return 'azul';
                case 'Reparando':
                    return 'amarillo';
                case 'Reparacion finalizado':
                    return 'verde';
                case 'Entregado':
                    return 'celeste';
                default:
                    return '';
            }
        },
        listarOrden(page, buscar, criterio) {
            let me = this;
            var url =
                "/orden?page=" +
                page +
                "&buscar=" +
                buscar +
                "&criterio=" +
                criterio;
            axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayOrden = respuesta.ordenes.data;
                    //console.log(me.arrayOrden);
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },


        getDispositivosNoEntregados() {
            let me = this;
            var url = "/dashboard";
            axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayDispositivosNoEntregados = respuesta.dispositivosNoEntregados;
                    //console.log(me.arrayDispositivosNoEntregados);
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        getDispositivosEnReparacion() {
            let me = this;
            var url = "/dashboard";
            axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayDispositivosEnReparacion = respuesta.dispositivosEnReparacion;
                    //console.log(me.arrayDispositivosNoEntregados);
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        getTotalServicio() {
            let me = this;
            var url = "/dashboard";
            axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayTotalServicio = respuesta.totalServicio;
                    //console.log(me.arrayTotalServicio);
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        getVentas() {
            let me = this;
            var url = "/dashboard";
            axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.ventas = respuesta.totalServicioGrafico;
                    //cargamos los datos del chart
                    me.loadVentas();
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        loadVentas() {
            let me = this;
            me.ventas.map(function (x) {
                me.varMesVenta.push(x.mes);
                me.varTotalVenta.push(x.total);
            });
            me.varVenta = document.getElementById("ventas").getContext("2d");

            me.charVenta = new Chart(me.varVenta, {
                type: "line",
                data: {
                    labels: me.varMesVenta,
                    datasets: [
                        {
                            label: "Ventas",
                            data: me.varTotalVenta,
                            backgroundColor: "rgba(249, 255, 250, 0.2)",
                            borderColor: "rgba(253, 96, 172 )",
                            borderWidth: 3
                        }
                    ]
                },
                options: {
                    scales: {
                        yAxes: [
                            {
                                ticks: {
                                    beginAtZero: true
                                }
                            }
                        ]
                    }
                }
            });
        }
    },
    mounted() {

        this.getDispositivosNoEntregados();
        this.getDispositivosEnReparacion();
        this.getTotalServicio();
        //this.totalizarVentadia();
        this.getVentas();
        this.listarOrden(1, this.buscar, this.criterio);


    },
    computed: {
        totalDispositivosNoEntregado() {
            //let totalDispositivosNoEntregados = 0;
            this.totalDispositivosNoEntregados = this.arrayDispositivosNoEntregados.length;

            return (this.totalDispositivosNoEntregados);
        },
        totalDispositivosEnReparaciones() {
            //this.totalDispositivosNoEntregados = 0;
            this.totalDispositivosEnReparacion = this.arrayDispositivosEnReparacion.length;

            return (this.totalDispositivosEnReparacion);
        },
        TotalService() {
            this.totalServicio = 0;

            for (let item of this.arrayTotalServicio) {
                this.totalServicio = this.totalServicio + parseFloat(item.totalPagar);
            }
            return (this.totalServicio.toFixed(2));
        },
        TotalCuentaCobrar() {
            this.sumarTotalAdelanto = 0;

            for (let item of this.arrayTotalServicio) {

                //sumCuentaCobrar=(this.sumarTotal)-(this.sumarTotalAdelanto);
                this.sumarTotalAdelanto = this.sumarTotalAdelanto + parseFloat(item.adelanto);
                let sumCuentaCobrar = 0;
                this.totalCuentaCobrar = (this.TotalService) - (this.sumarTotalAdelanto);
            }
            return (this.totalCuentaCobrar.toFixed(2));
        },
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
    }

}
</script>

<style>
.el-tag.azul {
    background-color: #0b64d9;
    color: #fff;
}

.el-tag.amarillo {
    background-color: #f1c40f;
    color: #fff;
}

.el-tag.verde {
    background-color: #2ecc3b;
    color: #fff;
}

.el-tag.celeste {
    background-color: #409EFF;
    color: #fff;
}


.margintop {
    margin-top: 80px;
}

.aling {
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>