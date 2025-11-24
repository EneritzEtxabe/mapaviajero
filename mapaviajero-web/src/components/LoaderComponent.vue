<template>
    <div v-if="loading" class="loader">Cargando...</div>
    <div v-else-if="error">
        <ErrorModal :error="error"/>
    </div>
    <div v-else>
        <slot></slot>
    </div>
</template>

<script lang="ts">
import { defineComponent} from 'vue';
import type {PropType} from 'vue';
import ErrorModal from './error/ErrorModal.vue';
export default defineComponent({    
    components:{
        ErrorModal
    },
    props:{
        loading:{
            type:Boolean,
            required:true
        }, 
        error:{
            type:String as PropType<string | null>,
            default:null
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