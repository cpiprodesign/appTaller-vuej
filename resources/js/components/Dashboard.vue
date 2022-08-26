<template>
  <main class="main ">
        <!-- Breadcrumb -->
        <!-- <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
        </ol> -->
        <div class="container-fluid ">
            <div class="card mt-4 ">
                <!-- <div class="card-header">
                
            </div> -->
                <div class="card-body my-20">
                    <div class="row ">
                        <div class="col-md-3 col-12 .col-sm-12 ">
                            <div class="cards mt-20">
                                <div class="cards-title">
                                    <div class="">
                                        <p class="py-3">Dispositivos no entregados</p>
                                    </div>
                                </div>
                                <div class="cards-body">
                                    <div class="icon mr-4">
                                        <div>
                                            <i class="fa fa-laptop" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <div  class="data">
                                        <h1 >{{totalDispositivosNoEntregado}} </h1>
                                        
                                    </div>
                                </div>
                                <div class="cards-footer"></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-12  .col-sm-12">
                            <div class="cards">
                                <div class="cards-title1">
                                    <div class="">
                                        <p class="py-3">Dispositivos en reparación</p>
                                    </div>
                                </div>
                                <div class="cards-body">
                                    <div class="icon1 mr-4">
                                        <div>
                                            <i class="fa fa-mobile" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div><h1> {{ totalDispositivosEnReparaciones}}</h1></div>
                                    </div>
                                </div>
                                <div class="cards-footer"></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-12 .col-sm-12">
                            <div class="cards">
                                <div class="cards-title2">
                                    <div class="titulo">
                                        <p class="py-3">Total Servicio</p>
                                    </div>
                                </div>
                                <div class="cards-body">
                                    <div class="icon2">
                                        <div>
                                            <i class="fas fa-donate"></i>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div><h2>s/. {{TotalService}}</h2></div>
                                    </div>
                                </div>
                                <div class="cards-footer"></div>
                            </div>
                        </div>
                        <div class="col-md-3 col-12 .col-sm-12 ">
                            <div class="cards">
                                <div class="cards-title3">
                                    <div class="titulo">
                                       <p class="py-3">Total cuenta a cobrar</p>                                                                                                                                                                                                                                                    ">Total cuenta a cobrar</p>
                                    </div>
                                </div>
                                <div class="cards-body">
                                    <div class="icon3">
                                        <div>
                                            <i class="fas fa-money-check-alt"></i>
                                        </div>
                                    </div>
                                    <div class="data">
                                        <div><h2>s/. {{TotalCuentaCobrar}}</h2></div>
                                    </div>
                                </div>
                                <div class="cards-footer"></div>
                            </div>
                        </div>
                        <!-- canva grafico -->
                        <div class="col-md-6 ">
                            <div class="card card-chart">
                                <div class="card-header">
                                    <h5>Servicios</h5>
                                </div>
                                <div class="card-content">
                                    <div class="ct-chart">
                                        <canvas id="ventas"> </canvas>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <p>Servicios de los últimos meses.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class="card ">
                                <div class="card-header">
                                    <h5>Nueva función quizas le interesa</h5>
                                </div>
                                <div class="">
                                    <div class="row">
                                        <div class="img col-md-6">
                                            <img class="img-fluid rounded-circle" src="img/5326050.jpg" alt="">
                                            
                                        </div>
                                        <div class=" col-md-6">
                                            <h4 class="mt-4 p-2">Sistema de gestión para administrar tu taller</h4>
                                            
                                            <div class="ml-2">
                                                <p class=""> sistema para administrar tu taller de celulares desarrollado con tecnologias del momento. Genera tu orden y imprime el ticket con codigo Qr. Sistema robusto y amigable accesible para todos.</p></div>
                                            <a class=" ml-2 btn btn-primary mb-4" href="https://wa.link/hkx244">Mas información</a>  
                                    </div>
                                            </div>
                                    
                                </div>
                                <!-- <div class="card-footer">
                                    <p>Servicios de los últimos meses.</p>
                                </div> -->
                            </div>
                            <!-- <a class="btn btn-danger" href="https://wa.link/hkx244">Mas información</a> -->
                        </div>
                    </div>
                    
                    <!-- <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card card-chart">
                                <div class="card-header">
                                    <h4>Compras</h4>
                                </div>
                                <div class="card-content">
                                    <div class="ct-chart">
                                        <canvas id="ingresos"> </canvas>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <p>Compras de los últimos meses.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-chart">
                                <div class="card-header">
                                    <h4>Ventas</h4>
                                </div>
                                <div class="card-content">
                                    <div class="ct-chart">
                                        <canvas id="ventas"> </canvas>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <p>Ventas de los últimos meses.</p>
                                </div>
                            </div>
                        </div>
                    </div> -->
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
           arrayDispositivosNoEntregados: [] ,
           totalDispositivosNoEntregados: 0,
           arrayDispositivosEnReparacion:[],
            totalDispositivoEnReparacion: 0  ,       
           arrayTotalServicio:[],
            totalServicio: 0 ,
            sumarTotalAdelanto:0,
            totalCuentaCobrar:0,
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
                .then(function(response) {
                    var respuesta = response.data;
                    me.arrayDispositivosNoEntregados = respuesta.dispositivosNoEntregados;
                   console.log(me.arrayDispositivosNoEntregados);
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        getDispositivosEnReparacion() {
            let me = this;
            var url = "/dashboard";
            axios
                .get(url)
                .then(function(response) {
                    var respuesta = response.data;
                    me.arrayDispositivosEnReparacion = respuesta.dispositivosEnReparacion;
                   //console.log(me.arrayDispositivosNoEntregados);
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
         getTotalServicio() {
            let me = this;
            var url = "/dashboard";
            axios
                .get(url)
                .then(function(response) {
                    var respuesta = response.data;
                    me.arrayTotalServicio = respuesta.totalServicio;
                   console.log(me.arrayTotalServicio);
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        getVentas() {
            let me = this;
            var url = "/dashboard";
            axios
                .get(url)
                .then(function(response) {
                    var respuesta = response.data;
                    me.ventas = respuesta.totalServicioGrafico;
                    //cargamos los datos del chart
                    me.loadVentas();
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        loadVentas() {
            let me = this;
            me.ventas.map(function(x) {
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
     computed:{
            totalDispositivosNoEntregado(){
                //let totalDispositivosNoEntregados = 0;
                this.totalDispositivosNoEntregados=this.arrayDispositivosNoEntregados.length;
                
                return (this.totalDispositivosNoEntregados);   
            },
            totalDispositivosEnReparaciones(){
                //this.totalDispositivosNoEntregados = 0;
                this.totalDispositivosEnReparacion=this.arrayDispositivosEnReparacion.length;
                
                return (this.totalDispositivosEnReparacion);   
            },
            TotalService(){
                this.totalServicio = 0;
                
                for(let item of this.arrayTotalServicio){
                    this.totalServicio = this.totalServicio + parseFloat(item.totalPagar);
                }
                return (this.totalServicio.toFixed(2));   
            },
            TotalCuentaCobrar(){
               this.sumarTotalAdelanto = 0;
                
                for(let item of this.arrayTotalServicio){

                    //sumCuentaCobrar=(this.sumarTotal)-(this.sumarTotalAdelanto);
                    this.sumarTotalAdelanto= this.sumarTotalAdelanto + parseFloat(item.adelanto);
                     let sumCuentaCobrar = 0;
                this.totalCuentaCobrar=(this.TotalService)-(this.sumarTotalAdelanto);
                }
                return (this.totalCuentaCobrar.toFixed(2));   
            }
     }

}
</script>

<style>

</style>