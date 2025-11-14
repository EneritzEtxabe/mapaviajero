import { useCrud } from "@/components/Admin/adminBasic/BaseCrud"
import { type Store, defineStore } from 'pinia'
interface CrudState<T> {
  items: T[]
  item: T | null
  loading: boolean
  error: string | null
}

export function createCrudStore<T extends {id:number}>(storeName:string, apiUrl:string){
    const crud = useCrud(apiUrl)
    function manejarError(this: Store<string, CrudState<T>>, e:any) {
        const mensaje = e?.response?.data?.message || e.message || 'Error al cargar los datos'
        this.error = mensaje
        throw e
    }
    return defineStore (storeName, {
        state: (): CrudState<T> => ({
            items: [],
            item: null,
            loading: false,
            error: null,
        }),
        actions: {
            async fetchAll(this: Store<string, CrudState<T>>) {
                this.loading = true
                this.error = null
                try {
                    const res = await crud.fetchAll()
                    this.items = res.data.data
                    return res.data.data
                } catch (e) {
                    manejarError.call(this,e)
                } finally {
                    this.loading = false
                }
            },
            async getItem(this: Store<string, CrudState<T>>,id: number) {
                this.loading = true
                this.error = null
                try {
                    const res = await crud.getItem(id)
                    this.item = res.data.data
                    return res.data.data
                } catch (e) {
                    manejarError.call(this,e)
                } finally {
                    this.loading = false
                }
            },
            async createItem(this: Store<string, CrudState<T>>, data: T) {
                this.loading = true
                this.error = null
                const idTemporal=Date.now()
                const nuevoItem={...data, id:idTemporal}
                this.items.push(nuevoItem)
                try {
                    const res = await crud.createItem(data)
                    const index = this.items.findIndex(i => i.id === idTemporal)
                    if(index!==-1){
                        this.items.splice(index,1,res.data.data)
                    }
                } catch (e) {
                    this.items = this.items.filter(i =>i.id !==idTemporal)
                    manejarError.call(this,e)
                } finally {
                    this.loading = false
                }
            },
            async updateItem(this: Store<string, CrudState<T>>, data: T, optimista=false) {
                this.loading = true
                this.error = null
                let index = -1
                let copiaItem: T | null=null

                if(optimista){
                    index=this.items.findIndex(i=>i.id === data.id)
                    if(index===-1) return
                    copiaItem={...this.items[index]}
                    this.items.splice(index, 1, {...copiaItem,...data})
                }

                try {
                    const res = await crud.updateItem(data)

                    if(!optimista){
                        index = this.items.findIndex(i => i.id === res.data.data.id)
                    }

                    if(index!==-1){
                        this.items.splice(index, 1, res.data.data)
                    }else{
                        this.items.push(res.data.data)
                    }
                    
                } catch (e) {
                    if(optimista &&index!==-1&&copiaItem){
                        this.items.splice(index, 1, copiaItem)
                    }

                    manejarError.call(this,e)
                } finally {
                    this.loading = false
                }
            },
            async deleteItem(this: Store<string, CrudState<T>>, id: number) {
                this.loading = true
                this.error = null
                const copiaItems =[...this.items]
                this.items=this.items.filter(i=>i.id!==id)
                try {
                    await crud.deleteItem(id)
                } catch (e) {
                    this.items = copiaItems
                    manejarError.call(this,e)
                } finally {
                    this.loading = false
                }
            }
        }
    })
}