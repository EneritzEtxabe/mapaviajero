import api from "@/axios/axios"

export function useCrud(apiUrl: string) {
  return {
    async fetchAll() {
      try{
        const res = await api.get(apiUrl)
        return res
      }catch(error){
        console.log("La consulta ha fallado:", error)
        throw error
      }
    },

    async createItem(item: any) {
      try{
        const res = await api.post(apiUrl, item)
        return res
      }catch(error){
        console.log("La consulta ha fallado:", error)
        throw error
      }
    },

    async getItem(id: number) {
      try{
        const res = await api.get(`${apiUrl}/${id}`)
        return res
      }catch(error){
        console.log("La consulta ha fallado:", error)
        throw error
      }
    },

    async updateItem(item: any) {
      try{
        const res = await api.put(`${apiUrl}/${item.id}`, item)
        return res
      }catch(error){
        console.log("La consulta ha fallado:", error)
        throw error
      }
    },

    async deleteItem(id: number) {
      try{
        const res = await api.delete(`${apiUrl}/${id}`)
        return res
      }catch(error){
        console.log("La consulta ha fallado:", error)
        throw error
      }
    }
  }
}