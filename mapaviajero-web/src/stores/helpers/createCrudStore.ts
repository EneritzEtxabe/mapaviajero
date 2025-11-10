import { useCrud } from "@/components/Admin/adminBasic/BaseCrud"

export function createCrudStore(apiUrl:string){
    const crud = useCrud(apiUrl)
    function manejarError(e: any) {
        const mensaje = e?.response?.data?.message || e.message || 'Error al cargar los datos'
        this.error = mensaje
        throw e
    }
    return {
        state: () => ({
            items: [],
            item: {},
            loading: false,
            error: null,
        }),
        actions: {
            async fetchAll() {
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
            async getItem(id: number) {
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
            async createItem(data: any) {
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
                    // this.items.push(res.data.data)
                    // return res
                } catch (e) {
                    this.items = this.items.filter(i =>i.id !==idTemporal)
                    manejarError.call(this,e)
                } finally {
                    this.loading = false
                }
            },
            async updateItem(data: any, optimista=false) {
                this.loading = true
                this.error = null
                let index = -1
                let copiaItem:any=null

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
            async deleteItem(id: number) {
                this.loading = true
                this.error = null
                const copiaItems =[...this.items]
                this.items=this.items.filter(i=>i.id!==id)
                try {
                    await crud.deleteItem(id)
                    // this.items = this.items.filter(i => i.id !== id)
                } catch (e) {
                    this.items = copiaItems
                    manejarError.call(this,e)
                } finally {
                    this.loading = false
                }
            }
        }
    }
}