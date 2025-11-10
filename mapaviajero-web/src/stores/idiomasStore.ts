import { defineStore } from 'pinia'
import { createCrudStore } from './helpers/createCrudStore'

const store=createCrudStore('http://localhost:8000/api/idiomas')
export const useIdiomasStore = defineStore('idiomas',store)