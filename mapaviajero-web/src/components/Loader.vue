<template>
    <div v-if="loading" class="loader">Cargando...</div>
    <div v-else-if="error" class="error">{{ error }}</div>
    <div v-else>
        <slot></slot>
    </div>
</template>

<script lang="ts">
import { defineComponent} from 'vue';
export default defineComponent({    
    props:{
        loading:{
            type:Boolean,
            required:true
        }, 
        error:{
            type:String,
            default:''
        }
    },
})
</script>
<style scoped>
.loader{
    text-align:center;
    font-weight:bold;
    padding: 1rem
}
.error{
    color:Red;
    padding:1rem
}
</style>