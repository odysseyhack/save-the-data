<template>
<div class="row">
    <div class="col-sm-6 ml-3 mr-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="title font-weight-bold"><i class="fire-icons icon-button-power"></i>Output</h4>
                <hr>
            </div>
            <div class="card-body">

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
                          <img style="" src="@/assets/img/test_2.jpg">
                          <p class='undertext normal'>Normal picture</p>
                        </a>

                    <a href="javascript:void(0)">
                          <img style="" src="@/assets/img/test2_predictions.png">
                            <p class='undertext machine-learning'>Augmented</p>
                          
                        </a>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    name: "demo-result"
};
</script>
