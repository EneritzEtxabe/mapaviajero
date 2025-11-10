import { defineStore } from 'pinia'
import { createCrudStore } from './helpers/createCrudStore'

const store = createCrudStore('http://localhost:8000/api/carroceriaCoches')
export const useCarroceriasCocheStore = defineStore('carroceriaCoches',store)