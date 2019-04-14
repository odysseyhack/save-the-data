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
                <div><input @change='upload($event)' ref="file"  type="file" id="upload-image-input" class="upload-image-input" name="photo" accept="image/*"></div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class='title' style="margin-bottom:0;"><i class="fire-icons icon-check-2"></i> Text Message:</h4>
            </div>
            <div class="card-body">
                Thank you for calling the emergency-center.
                
                    <br>
                To help us verify and analyse the current situation , please make a picture of the whole situation and including the sky and building if this is possible.</br>
                <br>


                <br>
                    Your information helps us to save lives !
                </div>
            </div>
        </div>
</template>

<script>
import api from '@/shared/services/api'
import {
  SET_DEMO_FIRE,
  SET_DEMO_SMOKE,
  SET_DEMO_QUADRANT,
  SET_DEMO_URL
} from "@/shared/store/demo/mutations.types";

import {
  TOGGLE_LOADING
} from "@/shared/store/general/mutations.types";

export default {
    name: "demo-upload",
    data() {
        return {
            file: ''
        }
    },
    methods: {
        upload(event) {
            this.file = this.$refs.file.files[0];
            this.$store.commit(TOGGLE_LOADING,true)
            api.upload(this.file).then((res) => {
                this.$store.commit(SET_DEMO_URL,res.data.url)
                this.$store.commit(SET_DEMO_SMOKE,res.data.data.dark_smoke > 0)
                this.$store.commit(SET_DEMO_FIRE,res.data.data.high_brightness > 0)
                this.$store.commit(TOGGLE_LOADING,false)
                this.$router.push({
                    'name': 'demo-results'
                })
            }).catch((res)=>{
                this.$store.commit(TOGGLE_LOADING,false)
            })
        }
    }
};
</script>
