import { defineStore } from 'pinia'
import { createCrudStore } from './helpers/createCrudStore'

const store=createCrudStore('http://localhost:8000/api/paises')
export const usePaisesStore = defineStore('paises',store)