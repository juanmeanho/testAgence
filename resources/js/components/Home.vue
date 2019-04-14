<template>
  <div>
    <toolbar></toolbar>
    <v-container>
      <v-layout row wrap>
        <v-flex xs12 lg12 sm12 offset-lg0>
          <v-card>
            <v-card-title>
              <v-flex xs2 >
                <v-chip label color="pink" text-color="white">
                  <v-icon left>mdi-calendar-clock</v-icon>Período de consulta
                </v-chip>  
              </v-flex>
              <v-flex xs2 align-start > <!-- Desde -->
                    <v-menu
                      :close-on-content-click="true"
                      :nudge-right="40"
                      lazy
                      transition="scale-transition"
                      offset-y
                      full-width
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on }">
                        <v-text-field
                          v-model="date_desde"
                          label="Desde"
                          prepend-icon="event"
                          readonly
                          v-on="on"
                          width="80px"

                        ></v-text-field>
                      </template>
                      <v-date-picker v-model="date_desde" type="month"></v-date-picker>
                    </v-menu>
              </v-flex>
              <v-flex xs2 > <!-- Hasta -->
                    <v-menu
                      :close-on-content-click="true"
                      :nudge-right="40"
                      lazy
                      transition="scale-transition"
                      offset-y
                      full-width
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on }">
                        <v-text-field
                          v-model="date_hasta"
                          label="Hasta"
                          prepend-icon="event"
                          readonly
                          v-on="on"
                          width="80px"

                        ></v-text-field>
                      </template>
                      <v-date-picker v-model="date_hasta" type="month"></v-date-picker>

                    </v-menu>
              </v-flex>
            </v-card-title>
            <template>
              <v-container fill-height fluid>
                <v-layout row wrap>
                  <v-flex xs5 sm5> <!-- Lista 1 -->
                    <v-card height="290px">
                      <v-toolbar color="indigo" dark height="40%">
                        <v-toolbar-title >Consultores ({{ consultores.length }})</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-btn icon>
                          <v-icon>mdi-account-box-multiple</v-icon>
                        </v-btn>
                      </v-toolbar>
                      <v-list style="max-height: 250px" class="scroll-y">
                        <v-list-tile
                          v-for="(item, index) in consultores"
                          :key="item.no_usuario"
                          @click="passLeft(item.co_usuario, item.no_usuario, index)"
                        >
                          <v-list-tile-avatar>
                            <v-icon>mdi-square-small</v-icon>
                          </v-list-tile-avatar>
                          <v-list-tile-content>
                            <v-list-tile-title v-text="item.no_usuario"></v-list-tile-title>
                          </v-list-tile-content>

                        </v-list-tile>
                      </v-list>
                    </v-card>
                  </v-flex>
                  <v-flex xs2 sm2> <!-- Botones de seleccion -->
                    <template><br><br>
                      <div class="text-xs-center mt-4" >
                        <v-btn color="indigo" dark @click="todosLeft()">
                          Todos
                              <v-icon right>mdi-arrow-right-bold-circle-outline</v-icon>
                        </v-btn>
                        <v-btn color="indigo" dark @click="todosRight()">
                              <v-icon left light>mdi-arrow-left-bold-circle-outline</v-icon>
                          Todos
                        </v-btn>
                      </div>
                    </template>
                  </v-flex>
                  <v-flex xs5 sm5> <!-- Lista 2 -->
                    <v-card height="290px">
                      <v-toolbar color="indigo" dark height="40%">
                        <v-toolbar-title>Seleccionados ({{ consultores_seleccionados.length }})</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-btn icon>
                          <v-icon>mdi-account-box-multiple</v-icon>
                        </v-btn>
                      </v-toolbar>
                       <v-list style="max-height: 250px" class="scroll-y">
                        <v-list-tile
                          v-for="(item, index) in consultores_seleccionados"
                          :key="item.no_usuario"
                          @click="passRight(item.co_usuario, item.no_usuario, index)"
                        >
                          <v-list-tile-avatar>
                            <v-icon>mdi-square-small</v-icon>
                          </v-list-tile-avatar>
                          <v-list-tile-content>
                            <v-list-tile-title v-text="item.no_usuario"></v-list-tile-title>
                          </v-list-tile-content>
                        </v-list-tile>
                      </v-list>
                    </v-card>
                  </v-flex>
                </v-layout>
              </v-container>              
            </template>
            <v-card-actions> <!-- Botones de acciones -->
              <v-btn color="success" dark @click="showRelatorio()">
                  Relatorio
                <v-icon right>mdi-clipboard-check-outline</v-icon>
              </v-btn>
              <v-btn color="success" dark @click="">
                  Gráfico
                <v-icon right>mdi-chart-areaspline</v-icon>
              </v-btn>
              <v-btn color="success" dark @click="showPizza()">
                  Pizza
                <v-icon right>mdi-chart-pie</v-icon>
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-flex>
      </v-layout>
    </v-container>
    <v-container >
      <template ><!-- Inicio Tablas-->
        <v-layout row v-for="(item, index) in relatorio_total" :key="index"> 
          <v-flex xs12 lg12 sm12 offset-lg0>
            <v-card v-show="showTable" class="mb-4">
              <v-card-title>
                <div>
                  <h3 class="subheading "><v-icon small left>mdi-account</v-icon>{{ item.no_usuario }}</h3>
                </div>
                </v-card-title>
              <div>
                <!--Table-->
                <table id="tablePreview" class="table table-hover table-striped table-sm table-bordered">
                <!--Table head-->
                  <thead>
                    <tr>
                      <th width="20%">Periodo</th>
                      <th width="20%">Receita Líquida</th>
                      <th width="20%">Custo Fixo</th>
                      <th width="20%">Comissao</th>
                      <th width="20%">Lucro</th>
                    </tr>
                  </thead>
                    <!--Table head-->
                    <!--Table body-->
                  <tbody>
                  <tr v-for="(itemMes, i) in periodos" :key="i">
                    <td >{{ formatDate(itemMes.periodo_num) }}</td>
                    <td align="right" > R$ {{ receita_l[index][i] }}</td>
                    <td align="right" > R$ {{ custo_fixo[index][i] }}</td>
                    <td align="right" > R$ {{ comissao[index][i] }}</td>
                    <td align="right" > R$ {{ lucro[index][i] }}</td>
                  </tr>
                  <tr>
                    <td align="left">Totales</td>
                    <td align="right">{{  suma(receita_l[index]) }}</td>
                    <td align="right">{{  suma(custo_fixo[index]) }}</td>
                    <td align="right">{{  suma(comissao[index]) }}</td>
                    <td align="right">{{  suma(lucro[index]) }}</td>
                  </tr>
                 </tbody>
                  <!--Table body-->
                </table>
                <!--Table-->
              </div>
            </v-card>
          </v-flex>
        </v-layout>
      </template><!-- Fin Tablas Tablas-->
            <pizza :consultores_seleccionados="consultores_seleccionados" ref="pizza">
            </pizza>
    </v-container>
  </div>

</template>

<script>
    import moment from 'moment'
    import Chart from 'chart.js'

    import 'moment/locale/es'  
    moment.locale('es')

    export default {
        mounted () {
            axios
              .get('/consultores')
              .then(response => {
                this.consultores = response.data.consultores
              })
              .catch(error => {
                console.log(error)
                this.errored = true
              })

        },
        data () {
        return {
          consultores: [],
          consultores_seleccionados: [],
          date: new Date().toISOString().substr(0, 10),
          showTable : false,
          date_desde: '',
          date_hasta: '',
          mes_desde: '',
          anio_desde: '',
          mes_hasta: '',
          anio_hasta: '',
          meses: [],
          relatorio: [],
          myData: [],
          value: null,
          relatorio_total: [],
          receita_l: [],
          periodos: [],
          custo_fixo: [],
          comissao: [],
          lucro: [],

        }
      },
      methods: {
        showPizza(){
          this.meses = []
          if(this.consultores_seleccionados != 0){
            if(this.date_desde != '' && this.date_hasta != ''){
              var startDate = moment(this.date_desde);
              var endDate = moment(this.date_hasta);

              endDate.add(1,'month')

              while (startDate.isBefore(endDate)) {
                this.meses.push({'periodo_num' : startDate.format("YYYY-MM")});
                startDate.add(1, 'month');
              }
              
              if (endDate.isBefore(startDate)) {
                  alert('La fecha final no puede ser mayor que la inicial')
              }
              else{
                  this.$refs.pizza.showPie(this.meses, true)
                  this.showTable = false

              }
            }else{
              alert("Debe seleccionar un periodo de consulta")
            }

          }else
            alert('Debe seleccionar un consultor')
        },
        passLeft(co_usuario, no_usuario, index){
          this.consultores.splice(index, 1);
          this.consultores_seleccionados.unshift({co_usuario: co_usuario, no_usuario: no_usuario})
        },
        passRight(co_usuario, no_usuario, index){
          this.consultores_seleccionados.splice(index, 1)
          this.consultores.unshift({co_usuario: co_usuario, no_usuario: no_usuario})
        },
        todosLeft(){
          if(this.consultores_seleccionados.length === 0){
            this.consultores_seleccionados = this.consultores
            this.consultores = []
          }
          else{
            this.consultores_seleccionados = [].concat(this.consultores, this.consultores_seleccionados)
            this.consultores = []
          }
        },
        todosRight(){
          if(this.consultores.length === 0){
            this.consultores = this.consultores_seleccionados
            this.consultores_seleccionados = []
          }
          else{
            this.consultores = [].concat(this.consultores_seleccionados, this.consultores)
            this.consultores_seleccionados = []
          }
        },
        showRelatorio(){

          this.meses = []
          this.showPie = false
          this.$refs.pizza.showPie(null, false)


          if(this.consultores_seleccionados != 0){
            if(this.date_desde != '' && this.date_hasta != ''){

              var startDate = moment(this.date_desde);
              var endDate = moment(this.date_hasta);

              endDate.add(1,'month')
            
              while (startDate.isBefore(endDate)) {
                this.meses.push({'periodo_num' : startDate.format("YYYY-MM")});
                startDate.add(1, 'month');
              }

              if (endDate.isBefore(startDate)) {
                alert('La fecha final no puede ser mayor que la inicial')
              }else{

                axios
              .post('/get_relatorio',{
                consultores: JSON.stringify(this.consultores_seleccionados),
                periodos: JSON.stringify(this.meses)
              })
              .then(response => {
                this.relatorio_total = response.data.datos_relatorio
                this.receita_l = response.data.receita_liquida
                this.periodos = response.data.periodos
                this.custo_fixo = response.data.custo_fixo
                this.comissao = response.data.comissao
                this.lucro = response.data.lucro
              })
              .catch(error => {
                console.log(error)
              })

                if(this.showTable == false){
                  this.showTable = true
                }
              }
            }
            else
              alert("Debe seleccionar un periodo de consulta")
          }
          else
            alert("Debe Seleccionar un consultor")
        },
        formatDate(fecha){
            return moment(fecha).format('MMMM-YYYY').toUpperCase()
        },
        suma(arreglo){
          const sum = arreglo.reduce(add);

          function add(accumulator, a) {
              return parseFloat(accumulator) + parseFloat(a);
          }

          return sum.toFixed(2)
        }
      }
    }
</script>
