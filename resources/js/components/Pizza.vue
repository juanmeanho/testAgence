<template>
  <v-flex xs12 lg12 sm12 offset-lg0 >
    <v-card v-if="showChart==true">
      <v-layout row> 
        <v-card-title>
          <div>
            <h3 class="subheading "><v-icon color="indigo" right>mdi-chart-pie</v-icon>Gráfico Nº 2</h3>
          </div>
        </v-card-title>
          <canvas id="planet-chart"></canvas>
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
          planetChartData: {},
          seleccionados: [],
          colors: [],
          showChart: false,
          periodos: null
        }
      },
      methods: {
        createChart(chartId, chartData) {
          const ctx = document.getElementById(chartId);
          const myChart = new Chart(ctx, {
            type: this.planetChartData.type,
            data: this.planetChartData.data,
            options: this.planetChartData.options,
          });
        },
        async getPorcentaje(meses) {
          let res = await axios
              .post('/pizza_data',{
                consultores: JSON.stringify(this.consultores_seleccionados),
                periodos: JSON.stringify(meses)
              })
              .then(response => {
                this.porcentaje = response.data.porcentaje
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
          showPie(meses, showChart){
          console.log('length',meses)

            this.showChart = showChart

            if(showChart){
                this.consultores_seleccionados.forEach(v => {
                  this.seleccionados.push(v.no_usuario)
                  this.colors.push(this.getRandomRgb())
                });


                this.getPorcentaje(meses)
                  .then(res => {
                  this.porcentaje = res
                  this.planetChartData = {
                        type: 'pie',
                        data: {
                          labels: this.seleccionados,
                          datasets: [
                            {
                            data: this.porcentaje,
                            backgroundColor: this.colors
                        }
                          ]
                        },
                        options: {
                          responsive: true,
                          legend: {
                            position: 'left'
                          }
                        }
                      }
                this.createChart('planet-chart', this.planetChartData)

                this.porcentaje = []
                this.colors = []
                this.seleccionados = []
                

                }) 
            }

          }
      }
    }
</script>
