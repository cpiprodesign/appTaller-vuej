<template>
    <main class="main ">
        <!-- Breadcrumb -->
        <!-- <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
        </ol> -->
        <div class="container-fluid mt-4 ">
            <el-row gutter="20">
                <el-col :sm="6" :xs="12" :span="6">
                    <el-card shadow="always">
                        <div class="text-center">
                            <p>Dispositivos no entregados</p>
                        </div>
                        <div class="">
                            <div class="">
                                <div class="aling">
                                    <i class="icon fas fa-shopping-cart"></i>
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
                                    <i class="icon1 fas fa-shopping-basket"></i>
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
                    <el-row gutter="20">
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
                                    <p>Nueva función quizas le interesa</p>
                                </div>
                                <div class="row">
                                    <div class="img col-md-6">
                                        <img class="img-fluid rounded-circle" src="img/5326050.jpg" alt="">

                                    </div>
                                    <div class=" col-md-6">
                                        <h4 class="mt-4 p-2">Sistema de gestión para administrar tu taller</h4>

                                        <div class="ml-2">
                                            <p class=""> sistema para administrar tu taller de celulares
                                                desarrollado con tecnologias del momento. Genera tu orden y imprime
                                                el ticket con codigo Qr. Sistema robusto y amigable accesible para
                                                todos.</p>
                                        </div>
                                        <a class=" ml-2 btn btn-primary " href="https://wa.link/hkx244">Mas
                                            información targe</a>
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
            varMesVenta: []

        };
    },
    methods: {
        getDispositivosNoEntregados() {
            let me = this;
            var url = "/dashboard";
            axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayDispositivosNoEntregados = respuesta.dispositivosNoEntregados;
                    console.log(me.arrayDispositivosNoEntregados);
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
                    console.log(me.arrayTotalServicio);
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
        }
    }

}
</script>

<style>
.margintop {
    margin-top: 80px;
}

.aling {
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>