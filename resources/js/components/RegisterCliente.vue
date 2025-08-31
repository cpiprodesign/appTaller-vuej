<template>
    <el-row :gutter="20">
        <el-col :xs="24" :md="24" :span="24">
            <div class="">
                <label class="form-control-lasbel" for="text-input">Nombre</label>

                <div class="">
                    <el-input size="mini" placeholder="Nombre del cliente" v-model="nombre"></el-input>
                </div>
            </div>
        </el-col>
        <el-col :xs="24" :md="24" :span="24">
            <div class="">
                <label class=" form-control-label" for="text-input">Tipo documento</label>
                <div class="">
                    <el-select size="small" v-model="tipo_documento" placeholder="Select">
                        <el-option v-for="item in optionsCli" :key="item.value" :label="item.label"
                            :value="item.value"></el-option>
                    </el-select>

                </div>
            </div>
        </el-col>
        <el-col :xs="24" :md="16" :span="16">
            <div class="">
                <label class=" form-control-label" for="text-input">Numero</label>
                <div class="d-flex">
                    <el-input class="mr-2" size="mini" placeholder="Numero de documento"
                        v-model="num_documento"></el-input>
                    <!-- <input class="form-control" type="text" v-model="num_documento" placeholder="Numero de documento" > -->
                    <!-- <button @click="consultaDni()" :disabled="loading">Consultar</button> -->
                    <!-- <el-button size="mini" @click="consultaDni()" :disabled="loading" type="primary"
                        icon="el-icon-search">Search</el-button> -->
                    <!-- <el-button size="mini" plain @click="consultaDni()" type="primary"
                        icon="el-icon-search">Reniec.</el-button>
                    <div v-if="loading">Cargando...</div>
                    <div v-if="error" style="color: red;">{{ error }}</div>
                    <div v-if="successMessage" style="color: green;">{{ successMessage }}</div> -->


                </div>

            </div>
        </el-col>
        <el-col :xs="24" :md="24" :span="24">
            <div class="">
                <label class=" form-control-label" for="text-input">Direccion</label>
                <div class="">
                    <el-input size="mini" placeholder="Dirección" v-model="direccion"></el-input>
                </div>
            </div>
        </el-col>
        <el-col :xs="24" :md="16" :span="16">
            <div class=" ">
                <label class=" form-control-label" for="text-input">Telefono</label>
                <div class="">
                    <el-input size="mini" placeholder="Telefono" v-model="telefono"></el-input>
                </div>
            </div>
        </el-col>
        <el-col :xs="24" :md="24" :span="24">
            <div class=" ">
                <label class=" form-control-label" for="text-input">Email</label>
                <div class="mb-2">
                    <el-input size="mini" placeholder="Email@gmail.com" v-model="email"></el-input>
                </div>
            </div>
            <div v-show="errorCliente" class="form-group row div-error">
                <div class="text-center text-error">
                    <div v-for="error in errorMostrarMsjCliente" :key="error" v-text="error"></div>
                </div>
            </div>
            <!-- <button type="button" class="btn btn-primary" @click="registrarCliente()">
                Registrar cliente
            </button> -->
            <el-button @click="registrarCliente()" type="primary">Registrar</el-button>
            <!-- <el-button @click="open4()" type="primary">ejecutar</el-button> -->
        </el-col>


        <!-- <button type="button" class="btn btn-primary" @click="updateClient()">
            update
        </button> -->





    </el-row>
</template>
<script>

export default {
    props: {


    },

    data() {
        return {
            //consulta de cliente
            // Almacena el valor del input para el DNI
            loading: false, // Indicador de carga
            error: null,   // Mensaje de error
            response: null,// Almacena la respuesta de la API
            visible: true,
            successMessage: null,// Mensaje de éxito
            token: null,
            //propiedades de cliente
            cliente_id: 0,
            nombre: "",
            tipo_documento: "DNI",
            num_documento: "",
            direccion: "",
            telefono: "",
            email: "",
            //para select
            optionsCli: [
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
            errorCliente: 0,
            errorMostrarMsjCliente: [],
            mensageerror: '',
            arrayDocumentos: "",
            iddocumentoidentidad: ""
        }
    },
    created() {
        this.getToken();
        this.selectDocumentos();
    },
    methods: {
        capturaeeror() {
            this.$message.error(this.mensageerror);
        },
        limpiar() {
            this.cliente_id = "";
            this.nombre = "";
            this.iddocumentoidentidad = "";
            this.tipo_documento = "DNI"
            this.num_documento = "";
            this.direccion = "";
            this.telefono = "";
            this.email = "";
        },
        updateClient() {
            this.$emit('escuchar');

        },

        guardar() {
            this.$message({
                message: "Cliente Guardado con éxito.",
                type: "success",

            });
        },
        selectDocumentos() {
            let me = this;
            var url = "/documentos/listar";
            return axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayDocumentos = respuesta.documentos;
                    console.log(me.arrayDocumentos)
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        cerrarModal() {
            this.modal = 0;
            this.tituloModal = "";
            this.nombre = "";
            this.tipo_documento = "";
            this.iddocumentoidentidad = "";
            this.num_documento = "";
            this.direccion = "";
            this.telefono = "";
            this.email = "";
            this.errorCliente = 0;
        },
        registrarCliente() {
            //validando campos categoria
            if (this.validarCliente()) {
                return;
            }
            let me = this;
            axios
                .post("/cliente/registrar", {
                    nombre: this.nombre,
                    tipo_documento: this.tipo_documento,
                    num_documento: this.num_documento,
                    direccion: this.direccion,
                    telefono: this.telefono,
                    email: this.email,
                })
                .then(function (response) {
                    me.cerrarModal();
                    //me.listarCliente(1, "", "nombre");
                    me.guardar();
                    //me.mensajedeeeror();
                    me.updateClient();//chancando para actualizar en select
                    me.limpiar();//limpia los controles
                    //alert(response.data.message);
                })
                .catch(function (error) {
                    //console.log(error);
                    if (error.response.status === 422) {
                        let errors = error.response.data.errors;
                        let errorMessage = Object.values(errors).flat().join(', ');
                        // this.$message.error('Errores de validación: ');
                        me.mensageerror = errorMessage;
                        me.capturaeeror();
                        me.limpiar();
                    } else {
                        this.$message.error('Error: ' + error.response.data.message);
                        let e = error.response.data.message
                        me.mensageerror = e
                        me.capturaeeror();
                        me.limpiar();
                        // me.open4();
                    }

                });
        },
        validarCliente() {
            this.errorCliente = 0;
            this.errorMostrarMsjCliente = [];

            if (!this.nombre)
                this.errorMostrarMsjCliente.push(
                    "El nombre deL cliente no puede estar vacío."
                );

            if (this.errorMostrarMsjCliente.length) this.errorCliente = 1;

            return this.errorCliente;
        },
        getToken() {
            axios.get('/api/token')
                .then(response => {
                    this.token = response.data.token;
                    //console.log(this.token);
                })
                .catch(error => {
                    console.error('Error al obtener el token:', error);
                });
        },
        consultaDni() {
            // Validar el DNI (ejemplo: debe tener 8 dígitos)
            if (!/^\d{8}$/.test(this.num_documento)) {
                this.error = "DNI inválido. Debe tener 8 dígitos.";
                return;
            }

            this.loading = true;
            this.error = null;
            this.response = null;

            const url = 'https://apiperu.dev/api/dni';
            const data = {
                // Tus datos aquí
                dni: this.num_documento
                //key2: 'value2'
            };
            const token = this.token; // Reemplaza con tu token

            axios.post(url, data, {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            })
                .then(response => {
                    const respuesta = response.data;
                    console.log(respuesta);
                    const nombre = respuesta.data.nombres;
                    const numero = respuesta.data.numero;
                    const apellidopaterno = respuesta.data.apellido_paterno;
                    const apellidomaterno = respuesta.data.apellido_materno;
                    // console.log(apellidopaterno + apellidomaterno);
                    //this.nombre = nombre+''+apellido_paterno+''+apellidomaterno;
                    this.nombre = [nombre, apellidopaterno, apellidomaterno]
                        .filter(Boolean)       // Elimina null, undefined o strings vacíos
                        .join(' ');            // Une con espacios

                    this.num_documento = numero;



                })
                .catch(error => {
                    this.error = 'Error al realizar la consulta. Inténtalo de nuevo.';
                    console.error(error);
                })
                .finally(() => {
                    this.loading = false;
                });
        },

    }
}
</script>
