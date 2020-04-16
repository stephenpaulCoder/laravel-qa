<template>
    <div>
        <span class="text-muted" style="font-size:small">
            {{ postDate }}
        </span>
        <div class="media mt-2">
            <a :href="user.url" class="pr-2">
                <!-- <img
                    width="30px"
                    height="30px"
                    style="border-radius: 50%;"
                    src="Gravatar::src(user.email)"
                    alt=""
                /> -->
                <v-gravatar
                    style="width:40px; border-radius:50%;"
                    :email="user.email"
                />
            </a>
            <div class="media-body mt-1">
                <a href="user.url">
                    {{ user.name }}
                </a>
            </div>
        </div>
    </div>
</template>

<script>
import Vue from "vue";
import Gravatar from "vue-gravatar";

Vue.component("v-gravatar", Gravatar);

export default {
    //the mode and label came from questions/show.blade.php and answers/answer.blade.php
    props: ["model", "label"],
    data() {
        return {
            user: this.model.user
        };
    },
    computed: {
        postDate() {
            return this.label + " " + this.model.created_date;
        }
    }
};
</script>
