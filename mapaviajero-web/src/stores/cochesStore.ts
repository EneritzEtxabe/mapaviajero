import { defineStore } from 'pinia'
import { createCrudStore } from './helpers/createCrudStore'

const store=createCrudStore('http://localhost:8000/api/coches')
export const useCochesStore = defineStore('coches',store)