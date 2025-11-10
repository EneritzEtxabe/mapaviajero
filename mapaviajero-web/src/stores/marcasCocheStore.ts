import { defineStore } from 'pinia'
import { createCrudStore } from './helpers/createCrudStore'

const store= createCrudStore('http://localhost:8000/api/marcaCoches')
export const useMarcasCocheStore = defineStore('marcaCoches',store)