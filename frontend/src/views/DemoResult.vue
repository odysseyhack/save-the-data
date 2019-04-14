<template>
<div class="row">
    <div class="col-sm-6 ml-3 mr-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="title font-weight-bold"><i class="fire-icons icon-button-power"></i>Output</h4>
                <hr>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead class='thead-dark'>
                        <tr>
                            <th scope="col">Variable</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Smoke</th>
                            <td><span v-if='smoke'>Yes</span><span v-else>No</span></td>
                        </tr>
                        <tr>
                            <th scope="row">Fire</th>
                            <td><span v-if='fire'>Yes</span><span v-else>No</span></td>
                        </tr>
    
                    </tbody>
                </table>
                <div id="quadrant" style="height:450px;width:600px;"></div>
            </div>
        </div>
    </div>
    <div class="col-md-5 mr-3">
        <div class="card card-user">
            <div class="card-header">
                <h4 class="title font-weight-bold"><i class="fire-icons icon-puzzle-10"></i>Input</h4>
                <hr>
            </div>
            <div class="card-body">
                <div class="author">
                    <div class="block block-one"></div>
                    <div class="block block-two"></div>
                    <div class="block block-three"></div>
                    <div class="block block-four"></div>
                    <a href="javascript:void(0)">
                          <img style="" :src="image">
                          <p class='undertext normal'>Normal picture</p>
                        </a>

                    <a href="javascript:void(0)">
                          <img style="" :src="image">
                            <p class='undertext machine-learning'>Augmented</p>
                          
                        </a>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import Highcharts from "highcharts";
export default {
    name: "demo-result",
    computed : {
        image() {
            return this.$store.state.demo.url
        },
        smoke() {
            return this.$store.state.demo.smoke
        },
        fire() {
            return this.$store.state.demo.fire
        }
    },
    mounted() {
        let data = [{
            x: 100,
            y: 50
        }];

        let chart = new Highcharts.Chart({
                chart: {
                    renderTo: "quadrant",
                    defaultSeriesType: "scatter",
                    borderWidth: 1,
                    borderColor: "#ccc",
                    marginLeft: 90,
                    marginRight: 50,
                    backgroundColor: "#eee",
                    plotBackgroundColor: "#fff"
                },
                credits: {
                    enabled: false
                },
                title: {
                    text: "<b>Quadrantmodel</b><br>For fighting building fires"
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    formatter: function () {
                        let name = "Offensief binneninzet";

                        if (this.x > 0 && this.y > 0) {
                            name = "Offensief buiteninzet";
                        } else if (this.x < 0 && this.y > 0) {
                            name = "Defensief buiteninzet";
                        } else if (this.x < 0 && this.y < 0) {
                            name = "Defensief binneninzet";
                        } else if (this.x > 0 && this.y < 0) {
                            name = "Offensief binneninzet";
                        }

                        return "<b>" + name + "</b>";
                    }
                },
                plotOptions: {
                    series: {
                        shadow: false
                    }
                },
                xAxis: {
                    title: {
                        text: "<strong><- Defensief | Offensief ->"
                    },
                    min: -100,
                    max: 100,
                    tickInterval: 5,
                    tickLength: 0,
                    minorTickLength: 0,
                    gridLineWidth: 1,
                    showLastLabel: true,
                    showFirstLabel: false,
                    lineColor: "#ccc",
                    lineWidth: 1
                },
                yAxis: {
                    title: {
                        text: "<strong>Binnen   |   Buiten</strong>",
                        rotation: 270,
                        margin: 0
                    },
                    min: -100,
                    max: 100,
                    tickInterval: 5,
                    tickLength: 3,
                    minorTickLength: 0,
                    lineColor: "#ccc",
                    lineWidth: 1
                },
                series: [{
                    color: "#185aa9",
                    data: data
                }]
            },
            function (chart) {
                // on complete

                var width = chart.plotBox.width / 2.0;
                var height = chart.plotBox.height / 2.0 + 1;

                chart.renderer
                    .rect(chart.plotBox.x, chart.plotBox.y, width, height, 1)
                    .attr({
                        fill: "#ee4a55",
                        zIndex: 0
                    })
                    .add();

                chart.renderer
                    .rect(chart.plotBox.x + width, chart.plotBox.y, width, height, 1)
                    .attr({
                        fill: "#fff",
                        zIndex: 0
                    })
                    .add();

                chart.renderer
                    .rect(chart.plotBox.x, chart.plotBox.y + height, width, height, 1)
                    .attr({
                        fill: "#fff",
                        zIndex: 0
                    })
                    .add();

                chart.renderer
                    .rect(
                        chart.plotBox.x + width,
                        chart.plotBox.y + height,
                        width,
                        height,
                        1
                    )
                    .attr({
                        fill: "#ee4a55",
                        zIndex: 0
                    })
                    .add();
            }
        );
    }
};
</script>
