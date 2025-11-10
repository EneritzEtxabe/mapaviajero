<template>
    <div class="bg--white rounded-lg shadow p-6 text-center">
        <router-link :to="{ name: ruta }" class="hover:underline px-3 py-2 rounded">
            <h3 class="text-md font-semibold mb-2">{{ titulo }}</h3>
        </router-link>
    </div>
</template>
<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
    props:{
        titulo:{type:String, required:true},
        ruta:{type:String, required:true}
    }
})
</script>