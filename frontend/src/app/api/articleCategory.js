import apiClient from './client/client'

export const getArticleCategoriesCollectionApi = async() => {
    const client = await apiClient()
    
    // return client.getArticleCategoriesCollection();
    return client.get('/article-categories')
}