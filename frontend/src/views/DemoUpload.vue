<template>
<div class="container-fluid">
    <div class="align-items">
        <div class="image-uploader-wrapper">
            <div class="display-box">
                <div class="icon-text-box">
                    <div class="upload-icon"><i class="fire-icons icon-camera-18" aria-hidden="true"></i></div>
                    <div class="upload-text">
                        <div>
                            <h4>Make a picture</h4>
                        </div>
                    </div>
                </div>
                <div><input @click="goResults($event)" type="file" id="upload-image-input" class="upload-image-input" accept="image/*"></div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class='title' style="margin-bottom:0;"><i class="fire-icons icon-check-2"></i> Please help us</h4>
            </div>
            <div class="card-body">
                Make a picture of the current situation and make sure that the whole building is on it if this is possible.</br>

                <br>
                    Your information helps us to save lives !
                </div>
            </div>
        </div>
</template>

<script>
export default {
    name: "demo-upload",
    methods: {
        goResults(event) {
            event.preventDefault()
            this.$router.push({
                'name': 'demo-results'
            })
        }
    }
};
</script>
