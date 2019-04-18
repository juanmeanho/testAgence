<template>
  <v-flex xs12 lg12 sm12 offset-lg0 >
    <v-card v-if="showChartPie==true">
      <v-layout row> 
        <v-card-title>
          <div>
            <h3 class="subheading "><v-icon color="indigo" left>mdi-finance</v-icon>Gráfico Nº 1</h3>
          </div>
        </v-card-title>
            <canvas id="grafico-chart"></canvas>
      </v-layout><!-- Fin Pizza-->
    </v-card>
  </v-flex>
</template>


<script>
    import Chart from 'chart.js'

    export default {
      props: ['consultores_seleccionados'],
        data () {
        return {
          receita_liquida: [],
          porcentaje: [],
          graficoChartData: {},
          seleccionados: [],
          colors: [],
          showChartPie: false,
          periodos: null
        }
      },
      methods: {
        createChart(chartId, chartData) {
          const ctx = document.getElementById(chartId);
          const myChart = new Chart(ctx, {
            type: this.graficoChartData.type,
            data: this.graficoChartData.data,
            options: this.graficoChartData.options,
          });
        },
        async getPorcentaje(meses) {
          let res = await axios
              .post('/grafico_data',{
                consultores: JSON.stringify(this.consultores_seleccionados),
                periodos: JSON.stringify(meses)
              })
              .then(response => {
                this.porcentaje = response.data.receitas
                this.promedio = response.data.promedio

              })
              .catch(error => {
                console.log(error)
                this.errored = true
              })

              return this.porcentaje
        },
         getRandomRgb() {
             var o = Math.round, r = Math.random, s = 255;
                return 'rgba(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ',' + r().toFixed(1) + ')';
          },
          showBar(meses, showChartPie){

            this.showChartPie = showChartPie

            if(showChartPie){
                this.consultores_seleccionados.forEach(v => {
                  this.seleccionados.push(v.no_usuario)
                  this.colors.push(this.getRandomRgb())
                });


                this.getPorcentaje(meses)
                  .then(res => {
                  this.porcentaje = res
                  this.graficoChartData = {
                        type: 'bar',
                        
                        data: {
                          datasets: [{
                            label: 'Custo Fixo Médio',
                            data: this.promedio,
                            backgroundColor: 'rgb(255, 174, 0)',
                            type: 'line',
                            fill: false
                            
                        },{
                            label: 'Receitas',
                            data: this.porcentaje,
                            backgroundColor: 'rgb(51, 85, 255)'

                        }],
                        labels: this.seleccionados

                        },
                        options: {
                          responsive: true,
                          /*scales: {
                            yAxes: [{
                              display:true,
                              ticks: {
                                max: 32000
                              }
                            }]
                          }*/
                        }
                      }
                this.createChart('grafico-chart', this.graficoChartData)

                this.porcentaje = []
                this.colors = []
                this.seleccionados = []
                

                }) 
            }

          }
      }
    }
</script>
